<?
define('IN_MEDIA', true);
define('IN_MEDIA_ADMIN', true);
include("../inc/_config.php");
include("../inc/_form.php");
include("../inc/_functions.php");
include("../inc/_string.php");

define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include_once(DIR . "./upload/inc/class_image.php");
include_once(DIR . "./upload/inc/class_image_uploader.php");
$imgtranload	=	'http://k14.vcmedia.vn/k:0AKshGBhRvTUXJb7CUPrPO2MGrVZe/Image/2012/12/130104starcbiz9-86968/nhung-hinh-anh-dep-de-doi-cua-my-nhan-cbiz.jpg';
// picasa
$service 	= 'picasa';
$uploader 	= c_Image_Uploader::factory($service);
$uploader->login(GNAME,GPASS);
$uploader->setAlbumID(ABUMID);
$new_film_img	= $uploader->upload($imgtranload);
echo $new_film_img;
//$new_film_img   = explode('.com/',$new_film_img);
//$new_film_img	=	'http://2.bp.blogspot.com/'.$new_film_img[1];
?>