<?php
define('IN_MEDIA',true);
include('inc/_config.php');
$id = $_GET['id'];
		$query = $mysql->query("SELECT episode_url,episode_name FROM ".$tb_prefix."episode WHERE episode_film = $id ORDER BY episode_id ASC");
		$i = 0;
		while ($rs = $mysql->fetch_array($query)) {
			$j = $j +1;
			echo $rs['episode_name'].'|'.$rs['episode_url'];
			echo "<br>";
		}
?>
