<?php
/**
 * Image Uploader Classes, used to upload an image to some services. Ex: Picasa, Imgur, ImageShack ...
 * 
 * @project		Image Uploader
 * @author		Phan Thanh Cong <chiplove.9xpro@gmail.com>
 * @since		June 17, 2010
 * @version		3.1
 * @since		March 8, 2012
 * @copyright	chiplove.9xpro
*/
define('C_IMG_UPLOADER', realpath(dirname(__FILE__)). DIRECTORY_SEPARATOR);

if( ! class_exists('c_Http'))
{
	if(file_exists(C_IMG_UPLOADER . 'class_http.php'))
	{
		require_once(C_IMG_UPLOADER . 'class_http.php');
	}
	else
	{
		throw new Exception('Class c_Http must be required');
	}
}

/**
 * Use session to stored loggedin cookie
*/
if( ! session_id())
{
	session_start();
}
		
abstract class c_Image_Uploader {
	
	/**
	 * The folder contain all plugins. Default is "imageUploaderPlugins"
	 * @var string
	*/
	public static $plugin_dir = NULL;
	
	/**
	 * Plugins loaded
	 * @var array
	*/
	public static $loaded = array();

	/**
	 * The Http Client used to uploading, its similar a web browser
	*/
	public $http;
	
	/**
	 * Khi đăng nhập thành công thì dịch vụ upload trả về cookie. 
	 * Các Plugins sẽ sử dụng cookie để upload mà ko phải đăng nhập lại nhiều lần
	*/
	public $cookie;
	
	/**
	 * Trạng thái đã đăng nhập hay chưa
	 * 
	 * @var boolean
	*/
	public $loggedin = FALSE;
	
	/**
	 * Username để đăng nhập
	*/
	public $username;
	
	/**
	 * Password để đăng nhập
	*/
	public $password;
	

	public function __construct()
	{
		$this->http = new c_Http();
	}
	/**
	 * Factory an uploader (Picasa, ImageShack, Imgur...etc)
	 * 
	 * @param	$plugin_name	string	file name of plugin classes
	 * @return	object		instance of uploader
	*/
	public static function factory($plugin_name)
	{
		self::load_plugin($plugin_name);
		$class = __CLASS__ . '_' . ucfirst($plugin_name);
		return new $class();
	}
	
	/**
	 * Load a plugin
	 * 
	 * @param $plugin_name	string (name of class file, have no .php)
	 * @return void
	 *
	*/
	protected static function load_plugin($plugin_name)
	{
		$plugin_name = strtolower($plugin_name);
		if(self::$plugin_dir === NULL)
		{
			self::$plugin_dir = C_IMG_UPLOADER . 'imageUploaderPlugins' . DIRECTORY_SEPARATOR;
		}
		
		if( ! isset(self::$loaded[$plugin_name]))
		{
			if( file_exists(self::$plugin_dir . $plugin_name . '.php'))
			{
				require_once(self::$plugin_dir . $plugin_name . '.php');
			}
			else
			{
				throw new Exception('Plugin ' . ucfirst($plugin_name) . ' does not exists');
			}	
			self::$loaded[$plugin_name] = TRUE;
		}
	}
	
	/**
	 * Use to get/ set session in class
	*/
	public function session($name, $value = NULL)
	{
		if(func_num_args() == 1)
		{
			if(isset($_SESSION[$this->plugin_name . $name]))
			{
				return $_SESSION[$this->plugin_name . $name];
			}
			return NULL;
		}
		else
		{
			$_SESSION[$this->plugin_name . $name] = $value;
		}
	}
	
	public function login($username, $password)
	{
		$this->username = $username;
		$this->password = $password;	
		return $this->_login($username, $password);
	}
	abstract protected function _login($username, $password);
	
	abstract public function upload($filepath);

}