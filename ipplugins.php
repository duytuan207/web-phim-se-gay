<?php
define('IN_MEDIA',true);
include('./inc/_config.php');
	

if ($_POST['epid']) {
	$epid 	= $_POST['epid'];
	$episode = $mysql->fetch_array($mysql->query("SELECT episode_id,episode_name,episode_url FROM ".$tb_prefix."episode WHERE episode_id = '".$epid."' "));
	echo "plugins|".$episode["episode_url"]."|picasa|2345678|";
	exit();
}
?>