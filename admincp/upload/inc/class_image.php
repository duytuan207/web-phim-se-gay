<?php
/**
 * Image Process & Image Uploader Classess
 *
 * @version:		1.0
 * @lastupdate:		5/11/2011
 * @author: 		chiplove.9xpro
 * @email:			chiplove.9xpro@gmail.com
*/
if( ! session_id()) 
{
	session_start();
}

define('C_IMAGE_PATH', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once(C_IMAGE_PATH . 'phpThumb/ThumbLib.inc.php');

class c_Image
{
	public static function crop($imagePath, $startX, $startY, $cropWidth, $cropHeight)
	{		
		try
		{
			$thumb = PhpThumbFactory::create($imagePath);
			$thumb->crop($imagePath, $startX, $startY, $cropWidth, $cropHeight);
			$thumb->save($imagePath);
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	public static function cropFromCenter($imagePath, $cropWidth, $cropHeight = null)
	{	
		try
		{
			$thumb = PhpThumbFactory::create($imagePath);
			$thumb->cropFromCenter($cropWidth, $cropHeight);
			$thumb->save($imagePath);
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	//resize theo phần trăm
	public static function resizePercent($imagePath, $percent = 0)
	{
		try
		{
			$thumb = PhpThumbFactory::create($imagePath);
			$thumb->resizePercent($percent);
			$thumb->save($imagePath);
			return true;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	public static function resize($imagePath, $width, $height, $resize_mod = 'basic')
	{
		$width 	= intval($width);
		$height = intval($height);
		try
		{	
			$thumb = PhpThumbFactory::create($imagePath);
			//resize tự crop thích nghi
			if($resize_mod == 'adaptive')
			{
				$thumb->adaptiveResize($width, $height);
			}
			else
			{
				//resize bình thường
				$thumb->resize($width, $height);
			}
			$thumb->save($imagePath);
			return true;
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	//hàm đóng dấu ảnh
	public static function watermark($imagePath, $logoPath, $position = 'rb', $padding = 0)
	{
		try
		{
			$thumb = PhpThumbFactory::create($imagePath);
			$thumb->resize(0, 0)->createWatermark($logoPath, $position, $padding);
			$thumb->save($imagePath);
		}
		catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	public static function leech($imageUrl, $imagePath)
	{
		$imageUrl = trim(urldecode($imageUrl));
		$imageUrl = str_replace(' ', '%20', $imageUrl);
		$imageUrl = preg_replace('#img[\d]+\.imageshack\.us#i', 'a.imageshack.us', $imageUrl);
		
		if($data = @fopen($imageUrl, "rb")) 
		{
			$newfile = fopen($imagePath, "w");
			while ($buff = fread($data, 1024*8))
			{
				fwrite($newfile, $buff);
			}
			fclose($data);
			fclose($newfile);	
			return true;
		}	
		return false;
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
}
