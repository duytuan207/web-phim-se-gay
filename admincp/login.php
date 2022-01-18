<?php
define('IN_MEDIA', true);
session_start();
@include("../inc/_config.php");
include("../inc/_functions.php");
if (isset($_POST["submit"])) {
	setcookie("cech_cache", "1", "0");
	$name = trim($_POST['name']);
	$name = str_replace( '|', '&#124;', $name);
	$password = md5(stripslashes($_POST['password']));
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_name = '".$name."' AND user_password = '".$password."' AND (user_level = 2 OR user_level = 3)");
	if ($mysql->num_rows($q)) {
		$r = $mysql->fetch_array($q);
		$_SESSION['admin_id'] = $r['user_id'];
		$_SESSION['admin_level'] = $r['user_level'];
		header("Location: ./");
		}else {header("Location: ./index.php?error=u");}
}
?>
