<?php
if (!defined('IN_MEDIA')) die("Hack");
//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler');
//else ob_start();
@session_start();
@header("Content-Type: text/html; charset=UTF-8");
//error_reporting(E_ALL ^ E_NOTICE);
if (!ini_get('register_globals')) {
	//@$_GET = $HTTP_GET_VARS;
	//@$_POST = $HTTP_POST_VARS;
	//@$_COOKIE = $HTTP_COOKIE_VARS;
	extract($_GET);
	extract($_POST);
}
define('NOW',time());
define('IP',$_SERVER['REMOTE_ADDR']);
define('USER_AGENT',$_SERVER['HTTP_USER_AGENT']);
define('URL_NOW',$_SERVER["REQUEST_URI"]);
include('_dbconnect.php');
$mysql = new mysql;
$mysql->connect($config['db_host'],$config['db_user'],$config['db_pass'],$config['db_name']);
#######################################
# GET DATABASE
#######################################
function get_data($f1,$table,$f2,$f2_value){
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT $f1 FROM ".$tb_prefix.$table." WHERE $f2='".$f2_value."'");
	$rs = $mysql->fetch_array($q);
	$f1_value = $rs[$f1];
	return $f1_value;
}
#######################################
# GET CONFIG
#######################################
$q = $mysql->query("SELECT * FROM ".$tb_prefix."config WHERE cf_id = 1");
$cf = $mysql->fetch_array($q);
$web_title 		= 	$cf['cf_web_name'];
$web_link 		= 	$cf['cf_web_link'];
$web_protect 	= 	$cf['cf_protect'];
if ($web_link[strlen($web_link)-1] == '/') $web_link = substr($web_link,0,-1);
$web_keywords 	= 	$cf['cf_web_keywords'];
$web_keyle 		= 	$cf['cf_web_keyle'];
$web_desle 		= 	$cf['cf_web_desle'];
$web_keybo 		= 	$cf['cf_web_keybo'];
$web_desbo 		= 	$cf['cf_web_desbo'];
$web_email 		= 	$cf['cf_web_email'];
$per_page 		= 	$cf['cf_per_page'];
$per_pagez 		= 	$cf['cf_sitemap_p'];
$cachedir		= 	'cache/'; // Directory to cache files in (keep outside web root)
$cacheext 		= 	'cache'; // Extension to give cached files (usually cache, htm, txt)
$link_href 		= 	"?movie=";
if(isset($_GET['movie'])){ $url_load 		= 	$_GET['movie'];$url 			= 	strtolower($url_load);$value 			= 	array();
if ($url) $value = 	explode('/',$url);}


$img_ads_folder  = 	"images/ads";
?>
