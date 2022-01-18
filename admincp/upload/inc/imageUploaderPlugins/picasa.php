<?php
/**
 * Picasa Uploader, used to upload an image to picasa
 * 
 * @project		Image Uploader
 * @class		Picasa Uploader
 * @author		Phan Thanh Cong <chiplove.9xpro@gmail.com>
 * @version		2.0
 * @since		January 31, 2012
 * @copyright	chiplove.9xpro
*/

if(!class_exists('c_Image_Uploader'))
{
	die('c_Image_Uploader must be required');
}
class c_Image_Uploader_Picasa extends c_Image_Uploader
{
	// set name of plugin
	public $plugin_name = 'picasa';
	
	/*
	 * Album chứa ảnh được upload lên. Mỗi album chỉ chứa đc 1000 ảnh. Nếu ko set thì mặc định sẽ up lên album default
 	*/
	private $albumId = 'default';

	
	public function login($username, $password)
	{
		$username = preg_replace('#@.*?$#', '', $username);
		return parent::login($username, $password);
	}
	
	protected function _login($username, $password)
	{
		if( ! $this->session('login' . $username) OR $this->session('loggedTime') + 60*5 < time())
		{
			$this->http->clear();	
			$this->http->useCurl(false);
			$this->http->setParams(array(
				'accountType' => 'HOSTED_OR_GOOGLE',  
				'Email' 	=> $username,  
				'Passwd' 	=> $password,  
				'source'	=> __CLASS__,  
				'service'	=> 'lh2'
			));
			$this->http->execute('https://www.google.com/accounts/ClientLogin', 'POST');
			
			preg_match("/Auth=([a-z0-9_\-]+)/i", $this->http->getResult(), $matches);
			$cookie = $matches[1];
			
			if($cookie == '')
			{
				throw new Exception('Login falied. Please check your username/password again');
			}
			$this->session('login' . $username, $cookie);
			$this->session('loggedTime', time());
		}

		$this->cookie = $this->session('login' . $username);
		
		return $this->cookie != '';	
	}
	
	/**
	 * Xóa album
	*/
	public function deleteAlbum($albumId)
	{
		if( ! $this->cookie)
		{
			throw new Exception('$this->cookie must be required. You must be login or set cookie value before call the deleteAlbum() method');
		}
		
		$this->http->setHeader(array(
			"Authorization: GoogleLogin auth=" . $this->cookie,
			"MIME-Version: 1.0",
			"GData-Version: 3.0",
			"If-Match: *"
		));
		$this->http->execute('https://picasaweb.google.com/data/entry/api/user/' . $this->username. '/albumid/' . $albumId, 'DELETE');
		
		return (strpos($this->http->getHeader('status'), '200') !== false);
		
	}
	public function addAlbum($title, $access = 'public', $description = '')
	{
		if( ! $this->cookie)
		{
			throw new Exception('$this->cookie must be required. You must be login or set cookie value before call the addAlbum() method');
		}
		
		$this->http->setHeader(array(
			"Authorization: GoogleLogin auth=" . $this->cookie,
			"MIME-Version: 1.0",	
		));
		$this->http->setMimeContentType("application/atom+xml");
		$this->http->setRawPost("<entry xmlns='http://www.w3.org/2005/Atom'
				xmlns:media='http://search.yahoo.com/mrss/'
				xmlns:gphoto='http://schemas.google.com/photos/2007'>
		  <title type='text'>" . $title. "</title>
		  <summary type='text'>" . $description . "</summary>
		  <gphoto:access>" . $access . "</gphoto:access>
		  <category scheme='http://schemas.google.com/g/2005#kind'
			term='http://schemas.google.com/photos/2007#album'></category>
		</entry>");
		$this->http->execute('https://picasaweb.google.com/data/feed/api/user/' . $this->realusername, 'POST');
		
		return c_Http::cutString($this->http->getResult(), '<id>', '</id>');
		
	}
	
	/**
	 * Set albumid để upload ảnh vào album đó. Mặc định là labum default.
	 * Mỗi album chỉ chứa đc 1000 ảnh (theo quy định của picasa)
	*/
	public function setAlbumId($albumId)
	{
		if( is_array($albumId))
		{
			$albumId = $albumId[array_rand($albumId)];
		}
		$this->albumId = $albumId;
	}
	
	/**
	 * Method upload ảnh lên picasa
	 * @param	@filePath 	string	đường dẫn vật lý đến file ảnh trên server
	 * @param	$title		string	Title/ tên của file ảnh sau khi upload lên. Mặc định dùng tên file ảnh
	 * @param	$albumId	string	Albumid sẽ upload ảnh lên. Nếu set ở đây thì sẽ dùng album này
	 * @param	$s			integer	Max chiều dài hoặc rộng của ảnh sẽ đc resize theo
	 * @return	url của ảnh sau khi upload xong	
	*/
	public function upload($filePath, $title = NULL, $albumId = NULL, $s = NULL)
	{
		if( ! $this->cookie)
		{
			throw new Exception('$this->cookie must be required. You must be login or set cookie value before call the upload() method');
		}
		
		if($albumId)
		{
			$this->setAlbumID($albumId);
		}
		if( ! $this->albumId)
		{
			throw new Exception('Missing albumId to uploading');
		}
		
		$this->http->clear();	
		$this->http->useCurl(false);
		$this->http->setSubmitMultipart('related');
		
		$this->http->setHeader(array(
			"Authorization: GoogleLogin auth=" . $this->cookie,
			"MIME-Version: 1.0",
		));
		$this->http->setRawPost("Content-Type: application/atom+xml\r\n
			<entry xmlns='http://www.w3.org/2005/Atom'>
			<title>".($title ? $title : preg_replace('#\..*?$#i', '', basename($filePath)))."</title>
			<category scheme=\"http://schemas.google.com/g/2005#kind\" term=\"http://schemas.google.com/photos/2007#photo\"/>
			</entry>
		"); 
		$this->http->setParams(array(
			'data' => '@' . $filePath
		));
		$this->http->execute('https://picasaweb.google.com/data/feed/api/user/'.$this->username.'/albumid/' . $this->albumId);
		
		$result = $this->http->getResult(); 
		
		//upload failed
		if(strpos($this->http->getHeader('status'), '201') === false) //201  Created
		{
			return __METHOD__ . ': ' . $result;
		}
		
		$width = $this->http->cutString($result, '<gphoto:width>', '</gphoto:width>');
		$height = $this->http->cutString($result, '<gphoto:height>', '</gphoto:height>');
		
		if($s === NULL)
		{
			$s = max($width, $height);
		}
		$url = $this->http->cutString($result, "src='", "'");	
		
		$url = str_replace(basename($url), 's' . $s . '/' . basename($url), $url);

		return $url;
	}
}
