<?php
define('IN_MEDIA',true);
include_once("../inc/_config.php");
require 'src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => FBAPPID,
  'secret' => FBSECRET,
));
$user = $facebook->getUser();
if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
	$email = $user_profile["id"];
	$username = $user_profile["name"];
	$fullname =	$user_profile["last_name"]." ".$user_profile["first_name"];
	$check_user = $mysql->query("SELECT user_id,user_identifier FROM ".$tb_prefix."user WHERE user_name = '".$username."' ORDER BY user_id ASC");
	$check_email = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_email = '".$email."' ORDER BY user_id ASC");
	$chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
	$i = 0;
	$pass = '' ;
	while ($i <= 8) {
		$num = mt_rand(0,61);
		$tmp = substr($chars, $num, 1);
		$pass = $pass . $tmp;
		$i++;
	}
	$cookie = md5(stripslashes($username.$secret_key.$pass));
	$password1 = md5(stripslashes($pass));
	if (!$mysql->num_rows($check_user) && !$mysql->num_rows($check_email)) {
		$sql = $mysql->query("INSERT INTO ".$tb_prefix."user (user_name,user_password,user_email,user_identifier,user_fullname) VALUES ('".$username."','".$password1."','".$email."','".$cookie."','".$fullname."')");
		$check_user = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_name = '".$username."' ORDER BY user_id ASC");
		$r = $mysql->fetch_array($check_user);
		$id = $r['user_id'];
		$_SESSION["user_id"] = $id;
		setcookie('user', $cookie, time() + (86400 * 30 * 12), "/");
	} else {
		$r = $mysql->fetch_array($check_user);
		$id = $r['user_id'];
		$cookie = $r['user_identifier'];
		$_SESSION["user_id"] = $id;
		setcookie('user', $cookie, time() + (86400 * 30 * 12), "/");
	}
	header("Location: /");
} else {
	$args = array('scope' => 'email');
  $loginUrl = $facebook->getLoginUrl();
  header("Location: ".$loginUrl);
}
?>