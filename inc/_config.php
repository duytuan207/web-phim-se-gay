<?php
// cau hinh upload anh --> ftp
define('FTP_HOST',		'');	// FTP host
define('FTP_USER',		'');	// FTP username
define('FTP_PASS',		'');	// fack you
define('FTP_HTDOC',		'/domains/..../public_html');	// FTP htdoc
define('FTP_URL',		'http://zess.xyz/demo/');	// FTP domain and folder
/* Cấu hình upload picasa */
define('GNAME',		'hnguyen1998@gmail.com');	// Tài khoản gmail google
define('GPASS',		'Huyneknha');	// mật khẩu google
define('ABUMID',	'6081381724239267329');	// Album ID
/* Cấu hình upload imageshack */
define('INAME',		'');	// Tài khoản imageshack
define('IPASS',		'');	// mật khẩu imageshack
define('IKEY',		'api key');	// key API imageshack
define('UPLOAD_TB',		'phim6v.com/demo');	// tiền tố đứng trước file ảnh
/* Cấu hình login with facebook */
define('FBAPPID',	'787366027980021');
define('FBSECRET',	'bc6ccddea3c30e856ca47b0dfae98681');
/* Cấu hình login with google */
$base_url= filter_var('http://phim.ngocsu.xyz/', FILTER_SANITIZE_URL);
define('CLIENT_ID','558231053748-htgl215omamd6mikud1c5ft9304gqjls.apps.googleusercontent.com');
define('CLIENT_SECRET','9oFVrQWeDyQIXH5Qg4schAAO');
define('REDIRECT_URI','http://phim.ngocsu.xyz/google/');
define('APPROVAL_PROMPT','auto');
define('ACCESS_TYPE','offline');
// Cấu hình Database
$config['db_host']	= 'localhost';
$config['db_name'] 	= 'zess_data';
$config['db_user']	= 'zess';
$config['db_pass']	= 'ngocsu';
$tb_prefix			= 'table_';
$page_actor			= 30;	// so dien vien trong 1 trang 
$secret_key 		= 'GET$ALAMXJA(!nAS(*#$@#()!#*()@!*';       //Key để hash cookie
include("init.php");
?>