<?php
/**
* Http class use curl, fsockopen
*
* This class is fake a browser, you can using it for read web content or upload file to server. It using two functions: curl and fsockopen
*
* @name:		c_Http
* @version: 	2.3
* @license:		free
* @author: 		chiplove.9xpro
* @contact:		chiplove.9xpro@gmail.com
*/ 

/**
 c_Http 2.3: (2/2/2012)
 + Update for picasa API
 
 c_Http 2.2: (31/1/2012)
 + Add RawPost var to post request (upload image to picasa)
 + Shortcut request c_Http::request()
 
 c_Http 2.1: (23/12/2011)
 + Fixed know bugs
 
 c_Http 2.0: (26/6/2011)
 + Rewrite class to easy use
 + Fixed some bugs
 
 c_Http 1.2: (19-04-2011)
 + Mine type on upload file fixed 
 
 c_Http 1.1:
 + Upload multi file
 + Fix bug parse url in fsockopen_execute
 
 c_Http 1.0:
 + Cookie
 + Referer
 + Proxy (only useCurl)
 + Server authentication
 + Upload file

 c_Http Example:
 
 	Read web content:
		$http = new c_Http();
		$http->setTarget("http://www.yourwebsite.com/");
		$http->execute();
		echo $http->getResult();
		
 	Submit form:
 		$http = new c_Http();
		$http->setTarget("http://www.yourwebsite.com/");
		$http->setParams(array("fieldname"=> $value)); // or $http->setParams("fieldname=$value");
		$http->setMethod('POST');
		$http->execute();
		echo $http->getResult();
		
	Using Proxy: only useCurl
		$http = new c_Http();
		$http->setTarget("http://www.yourwebsite.com/");
		$http->setProxy('proxy_ip:proxy_port');
		$http->execute();
		echo $http->getResult();
	
	Upload file:
		$filePath = getcwd().'/abc.jpg';
		$http = new c_Http();
		$http->setTarget("http://www.yourwebsite.com/");
		$http->setSubmitMultipart();
		$http->setParams(array('fileupload'=>"@$filePath"));
		$http->execute();
		echo $http->getResult();
		

*/

class c_Http{
	
	/**
	 * Target url
	 *
	 * @var string
	*/
	var $target;
	
	/**
	 * Target schema
	 *
	 * @var string 
	*/
	var $schema;
	
	/**
	 * Target host
	 *
	 * @var string
	*/
	var $host;
	
	/**
	 * Target port
	 *
	 * @var integer
	*/
	var $port;
	
	/**
	 * Target Path
	 *
	 * @var string
	*/
	var $path;
	
	/**
	 * @var string (POST or GET)
	*/
	var $method;
	
	/**
	 * Cookie request
	 *
	 * @var string
	*/
	var $cookie;
	
	/**
	 * Cookies retrieved from response
	 *
	 * @var string
	*/
	var $_cookie;
	
	/**
	 * Referer url
	 *
	 * @var string
	*/	
	var $referer;
	
	/**
	 * Headers request
	 *
	 * @var array
	*/
	var $headers;
	
	/**
	 * Header response
	 *
	 * @var array
	*/
	var $_headers;
	
	/**
	 * Parameters request
	 *
	 * @var array
	*/
	var $params;
	
	/**
	 * Raw post data
	 * @var mixed
	*/
	var $rawPost;
	/**
	 * User Agent - Browser
	 *
	 * @var string
	*/
	var $userAgent;
	
	/**
	 * Number of second to timeout
	 *
	 * @var integer
	*/
	var $timeout;
	
	/**
	 * Status code received
	 *
	 * @var integer
	*/
	var $status;
	/**
	 * Fetched from source
	 *
	 * @var string
	*/
	var $_result;
	
	/**
	 * Errors occurred
	 * 
	 * @var string
	*/
	var $_errors;

	/**
	 * Use curl to send request. If no, fsockopen will be used to do it
	 *
	 * @var boolean
	*/
	var $useCurl;
	
	/**
	 * Authentication user
	 *
	 * @var string 
	*/
	var $auth_user;
	
	/**
	 * Authentication password
	 *
	 * @var string 
	*/
	var $auth_password;
	
	/**
	 * Can use when you used curl ( useCurl = true) 
	*/
	/**
	 * Proxy IP
	 *
	 * @var string
	*/
	var $proxy;
	
	/**
	 * Proxy user
	 *
	 * @var string
	*/
	var $proxy_user;
	
	/**
	 * Proxy password
	 *
	 * @var string
	*/
	var $proxy_password;
	
	/**
	* Enctype (application/x-www-form-urlencoded)
	*
	* @var string 
	*/
	var $mimeContentType;
	
	/**
	 * boundary name (used when upload file)
	 *
	 * @var string 
	*/
	var $boundary;
	
	/**
	 * is submit multipart (send data)
	 *
	 * @var boolean
	*/
	var $isSubmitMultipart;
	
	/**
	 * is submit normal
	 *
	 * @var boolean
	*/
	var $isSubmitNormal;
	
	function __construct()
	{
		$this->clear();
	}
	/**
	 * Reset
	*/	
	function clear()
	{
		$this->target 				= "";
		$this->schema				= "http";
		$this->host					= "";
		$this->port					= 0;
		$this->path					= "";
		$this->method				= "GET";
		$this->referer 				= "";
		$this->params				= array();
		$this->rawPost				= "";
		$this->cookie				= "";
		$this->_cookie				= "";
		$this->headers				= array();
		$this->_headers				= array();
		$this->_result 				= "";
			
		$this->useCurl				= false;		
		$this->timeout 				= 10;	
		$this->_errors				= array();
		//$this->userAgent			= $_SERVER['HTTP_USER_AGENT'];
		$this->userAgent			= "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1";
		
		$this->mimeContentType				= "application/x-www-form-urlencoded";
		$this->boundary				= "chiplove.9xpro";
		
		$this->proxy				= "";
		$this->proxy_user			= "";
		$this->proxy_password		= "";
		
		$this->auth_user			= "";
		$this->auth_password		= "";
	}
	
	/**
	 * Set url target
	 *
	 * @param string
	*/
	function setTarget($target)
	{
		if($target)
		{
			$this->target = trim($target);
		}
	}
	
	/**
	 * Set url referer
	 *
	 * @param string
	*/
	function setReferer($referer)
	{
		if($referer)
		{
			$this->referer = trim($referer);
		}
	}
	
	/**
	 * Use cUrl or not
	 *
	 * @param boolean
	*/
	function useCurl($useCurl)
	{
		$this->useCurl = (boolean)$useCurl;
	}
	
	/**
	 * Call this function if you want submit form to upload file
	*/
	function setSubmitMultipart($type = 'form-data')
	{
		$this->isSubmitMultipart = true;
		$this->isSubmitNormal = false;
		$this->mimeContentType = "multipart/" . $type;
		$this->setMethod('POST');
	}
	/**
	 * Change mimeContentType to normal request 
	*/
	function setSubmitNormal()
	{
		$this->isSubmitMultipart = false;
		$this->isSubmitNormal = true;
		$this->mimeContentType = "application/x-www-form-urlencoded";
	}
	
	function setMimeContentType($mimeType)
	{
		$this->mimeContentType = $mimeType;
	}
	
	/**
	 * Set user agent 
	 *
	 * @param string Browser info: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/4.0
	*/
	function setUserAgent($agent)
    {
        if ($agent)
        {
            $this->userAgent = $agent;
        }   
    }
	
	/**
	 * Set number of seconds to time out
	 *
	 * @param integer seconds to time out
	*/
	function setTimeout($seconds)
    {
        if ($seconds > 0)
        {
            $this->timeout = $seconds;
        }   
    }
	
	/**
	 * Set parameters to send
	 *
	 * @param mixed array or query string you want to send
	*/
	function setParams($data)
    {
		if(is_string($data))
		{
			parse_str($data, $temp);
			$this->params = array_merge($this->params, $temp);
		}
		else if(is_array($data))
        {
            $this->params = array_merge($this->params, $data);
        }
    }
	
	function setRawPost($post)
	{
		$this->rawPost = $post;
	}

	/**
	 * Request method
	 *
	 * @param string POST or GET
	*/
	function setMethod($method)
    {
        if ($method)
        {
            $this->method = strtoupper($method);
        }   
    }
	
	/**
	 * set Header request
	 *
	 * @param array
	*/
	function setHeader($value)
	{
		if(is_array($value))
		{
			foreach($value as $line)
			{
				$this->headers[] = $line;
			}
		}
		else if(is_string($value))
		{
			$this->headers[] = $value;
		}
	}
	
	/**
	 * Set cookie request
	 *
	 * @param mixed cookie string or array (key => value)
	*/
	function setCookie($cookie)
	{
		if(is_string($cookie))
		{
			$this->cookie = $cookie;
		}
		else if(is_array($cookie))
		{
			$this->cookie = implode(';', $cookie);
		}
	}
	
	/**
	*/
	function setProxy($proxy, $username = "", $password = "")
	{
		$this->proxy 		  	= $proxy;
		$this->proxy_user     	= $username;
		$this->proxy_password 	= $password;
	}
	
	function setAuth($username, $password)
	{
		$this->auth_user 		= $username;
		$this->auth_password 	= $password;
	}
	
	/**
	 * Send request 
	 *
	 * @param string target url 
	 * @param string request method
	 * @param string referer url
	*/	
	function execute($target = '', $method = '', $referer = '')
	{
		$this->target = $target ? $target : $this->target;
		$this->method = $method ? strtoupper($method) : $this->method;
		$this->referer = $referer ? $referer : $this->referer;

		if($this->target == "")
		{
			$this->setError('Url target not found');
		}
		if($this->params && $this->method == "GET")
		{
			$this->target .= ($this->method == 'GET' ? (strpos($this->target, '?') ? '&' : '?') . http_build_query($this->params) : '');
		}
		
		$urlParsed = parse_url($this->target);
		
		if ($urlParsed['scheme'] == 'https')
        {
            $this->host = 'ssl://' . $urlParsed['host'];
            $this->port = ($this->port != 0) ? $this->port : 443;
        }
        else
        {
            $this->host = $urlParsed['host'];
            $this->port = ($this->port != 0) ? $this->port : 80;
        }
        $this->path   = (isset($urlParsed['path']) ? $urlParsed['path'] : '/') . (isset($urlParsed['query']) ? '?' . $urlParsed['query'] : '');
        $this->schema = $urlParsed['scheme'];

		//use curl to send request
		if($this->useCurl)
		{
			if($this->isSubmitMultipart)
			{
				foreach((array)$this->params as $key => $value)
				{
					if(substr($value, 0, 1) == '@')
					{
						$this->params[$key] = $value . ';type=' . self::mimeType(substr($value, 1));
					}
				}
			}
			$ch = curl_init();
			curl_setopt($ch,	CURLOPT_URL, 				$this->target);
																
			if($this->isSubmitMultipart)
			{
				$this->headers[] = "Content-Type: " . $this->mimeContentType;
			}
			if($this->method == 'POST')
			{
				curl_setopt($ch, CURLOPT_POST, 				true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, 		$this->params);
			}	
			if($this->referer)
			{
				curl_setopt($ch, CURLOPT_REFERER, 			$this->referer);
			}
			if($this->cookie)	
			{
				curl_setopt($ch, CURLOPT_COOKIE, 			$this->cookie);
			}
			
			if($this->headers)
			{
				curl_setopt($ch, CURLOPT_HTTPHEADER, 		$this->headers);
			}
			if($this->timeout)
			{
				curl_setopt($ch, CURLOPT_TIMEOUT, 			$this->timeout); 
			}
			if ($this->auth_user && $this->auth_password)
			{
				curl_setopt($ch, CURLOPT_HTTPAUTH, 			CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, 			$this->auth_user . ':' . $this->auth_password);
			}
			if($this->proxy)
			{
				curl_setopt($ch, CURLOPT_PROXY, 			$this->proxy);	
				curl_setopt($ch, CURLOPT_PROXYTYPE, 		CURLPROXY_SOCKS5); 		
				if($this->proxy_user && $this->proxy_password)
				{
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, 	$this->proxy_user . ':' . $this->proxy_password);
				}
			}
			curl_setopt($ch, 	CURLOPT_USERAGENT,			$this->userAgent);
			curl_setopt($ch, 	CURLOPT_HEADER,				true);	
			curl_setopt($ch,	CURLOPT_NOBODY, 			false);
			
			curl_setopt($ch, 	CURLOPT_RETURNTRANSFER, 	true);
			curl_setopt($ch, 	CURLOPT_SSL_VERIFYPEER, 	false);
			curl_setopt($ch, 	CURLOPT_ENCODING, 			'gzip,deflate');	
			
			$content = curl_exec($ch);
			$contentArray = explode("\r\n\r\n", $content, 2);
			
			$this->_parseHeader($contentArray[0]);
			$this->_result = $contentArray[1];
			$this->setError(curl_error($ch));
			curl_close($ch);
		}
		//use fsockopen to send request
		else
		{
			
			$postData = "";
			if($this->rawPost)
			{
				$postData 	.= $this->isSubmitMultipart ? "--" . $this->boundary . "\r\n" : "";
				$postData	.= $this->rawPost . "\r\n";
			}
			//for upload file
			if($this->isSubmitMultipart)
			{
				foreach($this->params as $key => $value)
				{
					if(substr($value, 0, 1) == '@')
					{
						$upload_files_path 		= substr($value, 1);
						$upload_fields_name  	= $key;
						
						if(file_exists($upload_files_path))
						{
							$postData 	.= "--" . $this->boundary . "\r\n";
							$postData  	.= "Content-disposition: form-data; name=\"" . $upload_fields_name . "\"; filename=\"" . basename($upload_files_path) . "\"\r\n";
							$postData	.= "Content-Type: " . self::mimeType($upload_files_path) . "\r\n";
							$postData	.= "Content-Transfer-Encoding: binary\r\n\r\n";
							$postData	.= self::readBinary($upload_files_path) . "\r\n";
						}			
					}
					else
					{
						$postData 	.= "--" . $this->boundary . "\r\n";
						$postData   .= "Content-Disposition: form-data; name=\"" . $key . "\"\r\n";
						$postData   .= "\r\n";
						$postData	.= $value . "\r\n";
					}
				}
				$postData 	.= "--" . $this->boundary . "--\r\n";
			}
			//submit normal
			else
			{
				$postData .= urldecode(http_build_query($this->params));
			}
			//open connection
			$filePointer = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout); 
			
			if (!$filePointer)
            {
                $this->setError($errstr . ': ' . $errno);
                return false;
            }
			$requestHeader  = $this->method . " " . $this->path . " HTTP/1.1\r\n";
			$requestHeader .= "Host: " . $urlParsed['host'] . "\r\n";
			$requestHeader .= "User-Agent: " . $this->userAgent . "\r\n";
			if($this->headers)
			{
				$requestHeader .= implode("\r\n", $this->headers) . "\r\n";
			}
			if($this->mimeContentType)
			{
				$requestHeader .= "Content-Type: " . $this->mimeContentType . ($this->isSubmitMultipart ? "; boundary=" . $this->boundary : "") . "\r\n";
			}
			if($this->auth_user && $this->auth_password)
			{
				$requestHeader .= "Authorization: Basic " . base64_encode($this->auth_user . ":" . $this->auth_password) . "\r\n";
			}
			if($this->cookie)	
			{
				$requestHeader .= "Cookie: " . $this->cookie . "\r\n";
			}
			if($this->referer)	
			{
				$requestHeader .= "Referer: " . $this->referer . "\r\n";
			}		
			$requestHeader .= "Content-length: " . strlen($postData) . "\r\n";
		
			$requestHeader .= "Connection: close\r\n\r\n";
			
			if($postData && $this->method == "POST")
			{
				$requestHeader .= $postData;
			}
			$requestHeader .=  "\r\n\r\n";
			
			//send request
			fwrite($filePointer, $requestHeader);
			
			$responseHeader = '';
			$responseContent = '';
			do{
				$responseHeader .= fgets($filePointer, 128);
			}
			while(strpos($responseHeader, "\r\n\r\n") === false);

			$this->_parseHeader($responseHeader);
			
			while (!feof($filePointer))
			{
				$responseContent .= fgets($filePointer, 128);
			}
			if (@$this->_headers['transfer-encoding'] == 'chunked')
			{
				$data = $responseContent;
				$pos = 0;
				$len = strlen($data);
				$outData = "";
				while ($pos < $len) 
				{
					$rawnum = substr($data, $pos, strpos(substr($data, $pos), "\r\n") + 2);
					$num = hexdec(trim($rawnum));
					$pos += strlen($rawnum);
					$chunk = substr($data, $pos, $num);
					$outData .= $chunk;
					$pos += strlen($chunk);
				}
				$responseContent = $outData;
			}
			$this->_result = rtrim($responseContent);
			fclose($filePointer);
		}
		return $this;
	}

	private function _parseHeader($header)
	{
		$lines = explode("\n", $header);
		foreach($lines as $line)
		{
			if($line = trim($line))
			{
				//parse headers to array
				if(!$this->_headers)
				{
					$this->_headers['status'] = $line;
				}
				else
				{
					list($key, $value) = explode(": ", $line);
					$key = strtolower($key);
					//parse cookie
					if($key == 'set-cookie')
					{
						$this->_cookie .= $value.';';
					}
					if(in_array($key, array_keys($this->_headers)))
					{
						if(!is_array($this->_headers[$key]))
						{
							$temp = $this->_headers[$key];
							unset($this->_headers[$key]);
							$this->_headers[$key][] = $temp;
							$this->_headers[$key][] = $value;
						}
						else
						{
							$this->_headers[$key][] = $value;
						}
					}
					else
					{
						$this->_headers[$key] = $value;
					}
				}
			}
		}
	}
	
	function getResult()
	{
		return $this->_result;
	}
	
	function getHeader($name = null)
	{
		if($name)
		{
			return $this->_headers[$name];
		}
		return $this->_headers;
	}
	
	function setError($error)
	{
		$this->_errors[] = $error;
	}
	
	public static function cutString($source, $begin, $end = '') 
	{		
		$element = explode((!$begin ? $end : $begin), $source, 2);
		@$element[0] = !$begin ? $element[0] : $element[1];
		if($end && $begin) 
		{		
			@$element = explode($end, $element[1], 2);
		}
		return @$element[0];
	}
	
	public static function readBinary($filePath)
	{
		$binarydata = '';
		if(file_exists($filePath))
		{
			$handle = fopen($filePath, "rb");
			while ($buff = fread($handle, 128))
			{
				$binarydata .= $buff;
			}
			fclose($handle);
		}
		return $binarydata;
	}
	
	public static function mimeType($filePath)
	{
		$filename = realpath($filePath);

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		if (preg_match('/^(?:jpe?g|png|[gt]if|bmp|swf)$/', $extension))
		{
			$file = getimagesize($filename);

			if (isset($file['mime']))
				return $file['mime'];
		}

		if (class_exists('finfo', FALSE))
		{
			if ($info = new finfo(defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME))
			{
				return $info->file($filename);
			}
		}

		if (ini_get('mime_magic.magicfile') AND function_exists('mime_content_type'))
		{
			return mime_content_type($filename);
		}
		return FALSE;
	}
	
	########### SHORTCUT FUNCTIONS ##################
	/**
	 * @param cookie - mixed (string, array)
	 * @param params - mixed (query string, array)
	*/
	public static function request($target, $method = 'GET', $params = null, $referer = null, $cookie = null, array $headers = array(), $upload = false, $useCurl = false)
	{
		$ob = new c_Http();
		$ob->setTarget($target);
		$ob->useCurl($useCurl);
		$ob->setMethod($method);
		if($upload)
		{
			$ob->setSubmitMultipart();
		}
		$ob->setReferer($referer);
		$ob->setParams($params);
		$ob->setCookie($cookie);
		$ob->setHeader($headers);
		$ob->execute();
		return $ob;
	}
}
