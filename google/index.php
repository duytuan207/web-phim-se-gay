<?php
define('IN_MEDIA',true);
include_once("../inc/_config.php");
require_once 'lib/Google_Client.php';
require_once 'lib/Google_Oauth2Service.php';

$client = new Google_Client();
$client->setApplicationName("Google UserInfo PHP Starter Application");

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setApprovalPrompt(APPROVAL_PROMPT);
$client->setAccessType(ACCESS_TYPE);

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
	$user = $oauth2->userinfo->get();
	$email = $user['email'];
	$username	= $user['name'];
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
		$sql = $mysql->query("INSERT INTO ".$tb_prefix."user (user_name,user_password,user_email,user_identifier,user_fullname) VALUES ('".$username."','".$password1."','".$email."','".$cookie."','".$username."')");
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
	$authUrl = $client->createAuthUrl();
	header("Location: ".$authUrl);
}

?>