<?php
// Tao header, dinh dang file anh la file png
header("content-type: image/png");
session_start();
//Tao chuoi so phat sinh ngau nhien
	mt_srand((double) microtime()*1000000);

	$num = mt_rand(100000,999999);
//Set randnum to host
$_SESSION['comment_img_pass']=$num;
// Hien chuoi so do ra
$w = 10 * strlen($num);
$h = 22;
$im = imagecreate($w, $h);
$bg = imagecolorallocate($im, 200, 170, 85);
$textcolor = imagecolorallocate($im, 10, 80, 10);
imagestring($im, 5, 4, 5, $num, $textcolor);
imagepng($im);
imagedestroy($im);
?>