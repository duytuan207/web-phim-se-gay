<?php
/**
 * ImageShack Uploader, used to upload/ transfer an image to imageshack.us
 * 
 * @project		Image Uploader
 * @class		ImageShack Uploader
 * @author		Phan Thanh Cong <chiplove.9xpro@gmail.com>
 * @since		June 17, 2010
 * @version		3.1
 * @since		March 8, 2012
 * @copyright	chiplove.9xpro
*/

if( ! class_exists('c_Image_Uploader'))
{
	die('c_Image_Uploader must be required');
}

class c_Image_Uploader_ImageShack extends c_Image_Uploader
{ 
	// set name of plugin
	public $plugin_name = 'imageshack';

	/**
	 * API key đăng ký với imageshack. Nếu ko đăng nhập và ko dùng api key thì code tự get free key của imageshack
	 * 
	 * @var string
	*/
	public $api_key;

	/**
	 * API key đăng ký với imageshack: http://stream.imageshack.us/api/
	 * Dùng API upload/transload sẽ nhanh hơn
	 * 
	 * @param	$api_key	mixed	api key or array api keys
	 * @return void
	*/
	public function set_api($api_key)
	{
		if( is_array($api_key))
		{
			$api_key = $api_key[array_rand($api_key)];
		}
		$this->api_key = $api_key;
	}


	// login method
	protected function _login($username, $password)
	{
		if( ! $this->session('login' . $username))
		{
			$ob = c_Http::request('http://imageshack.us/auth.php', 'POST', array(
				'username'			=> $username,
				'password'			=> $password,
				'stay_logged_in'	=>'true',
				'format'			=> 'json',
			));
			$login = json_decode($ob->getResult(), TRUE);
			if( $login['status'] == 1)
			{
				preg_match_all('#(ulevel|myimages|isUSER|myid)[^;]+#i', $ob->_cookie, $m);
				$cookie = implode(';', $m[0]);
				$this->session('login' . $username, $cookie);
			}
			else
			{
				throw new Exception('Login falied. Please check your username/password again');
			}
		}
		$this->cookie = $this->session('login' . $username);
		
		if(strpos($this->cookie, 'isUSER') !== FALSE)
		{
			$this->loggedin = TRUE;
		}
		return $this->loggedin;
	}

	/**
	 * Method get free key (upload ko cần đăng nhập hoặc ko cần đăng ký API key với imageshack)
	 * Nên tham khảo quy định về sử dụng hình ảnh với free account tại đây: http://imageshack.us/p/rules/
	*/
	protected function get_freekey()
	{
		if( ! $this->session('key'))
		{
			$this->http->clear();	
			$this->http->useCurl(true);
			$this->http->execute('http://imageshack.us/?no_flash=y');	
	
			$key = $this->http->cutString($this->http->getResult(), 'name="key" value="', '"');
			$this->session('key', $key);
		}
		return $this->session('key');
	}
	
	/**
	 * Upload file on server to imageshack.us
	 *
	 * @param 	$filepath	string 	full file path
	 * @param	$api_key	string	api key use to uploading
	 * @return 	string 	image url received from imageshack after uploaded successfull
	*/
	public function upload($filepath, $api_key = NULL)
	{			
		if($api_key !== NULL)
		{
			$this->api_key	= $api_key;
		}
		
		/*
		This for imageshack denied free uploaded (March 7, 2012)
		if( ! $this->cookie)
		{
			throw new Exception('$this->cookie must be required. You must be login or set cookie value before uploading');
		}*/
		
		$this->http->clear();	
		$this->http->useCurl(false);
		$this->http->setSubmitMultipart();
		
		// Nếu ko dùng API thì upload theo kiểu free
		if($this->api_key === NULL)
		{
			$target	= 'http://imageshack.us/';
			if( ! $this->loggedin)
			{
				$this->api_key	= $this->get_freekey();
			}
		}
		else
		{
			$target = 'http://www.imageshack.us/upload_api.php';
			/*$this->http->setParams(array(
				'a_username'	=> $this->username,
				'a_password'	=> $this->password,
			));*/
		}
		
		$this->http->setCookie($this->cookie);
		$this->http->setParams( array(
			'fileupload' 	=> '@' . $filepath, 
			'xml' 			=> 'yes', 
			'key'			=> $this->api_key,
		));
		$this->http->execute($target, 'POST');		

		$this->parse_image();
		
		if(!@$this->image['image_link'])
		{
			return __METHOD__ . ': Errors!';
		}
		return $this->image['image_link'];
	}
	
	/**
	 * Transload url
	 *
	 * @param 	$url		string image url need transload
	 * @param	$api_key	string	api key use to uploading
	 * @return string image url after transfered successfull
	*/
	function transload($url, $api_key = NULL)
	{
		$this->http->clear();	
		$this->http->useCurl(false);

		if($this->api_key === NULL)
		{
			$target = 'http://post.imageshack.us/transload.php';
			if( ! $this->loggedin)
			{
				$this->api_key	= $this->get_freekey();
			}
		}
		else
		{
			$target = 'http://www.imageshack.us/upload_api.php';
		}
		
		$this->http->setCookie($this->cookie);
		$this->http->setParams(array(
			'url' 		=> $url, 
			'xml' 		=> 'yes',
			'key'		=> $this->api_key,
		));
		$this->http->execute($target, 'POST');
		$this->parse_image();
		
		if(!@$this->image['image_link'])
		{
			return __METHOD__ . ': Errors!';
		}
		return $this->image['image_link'];
	}
	
	/**
	 * Parse image form source to array
	 *
	 * $this->image array
	 * image_link:  		http://img402.imageshack.us/img402/909/chiplovebiz01923.jpg
	 * thumb_link: 			http://img402.imageshack.us/img402/909/chiplovebiz01923.th.jpg
	 * image_location:		img402/909/chiplovebiz01923.jpg
	 * thumb_location		img402/909/chiplovebiz01923.th.jpg
	 * server				img402
	 * image_name			chiplovebiz01923.jpg
	 * done_page			http://img402.imageshack.us/content.php?page=done&amp;l=img402/909/chiplovebiz01923.jpg
	 * resolution			320x240
	 * filesize				22034
	*/
	private $image;
	
	private function parse_image()
	{
		$body = $this->http->cutString($this->http->getResult(), "<links>", "</links>");
		preg_match_all('#<([\w_][^>]+)>([^<]+?)</([\w_][^>]+)>#', $body, $m);
		$count = count($m[1]);
		for($i = 0; $i < $count; $i ++)
		{
			$this->image[$m[1][$i]] = $m[2][$i];
		}
	}
}
