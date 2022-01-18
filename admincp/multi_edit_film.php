<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if (!$_GET['id']) die('ERROR');
$id = $_GET['id'];
if (!$_POST['submit']) {
?>
<form method="post">
<table class="border" cellpadding="2" cellspacing="0" width="95%">
<tr><td colspan="2" class="title" align="center">Sửa nhiều Phim</td></tr>
<tr>
	<td class="fr" width="30%"><b>Các Phim sẽ sửa</b></td>
	<td class="fr_2">
	<?php
	$in_sql = $id;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id IN (".$in_sql.")");
	while ($r = $mysql->fetch_array($q)) {
		echo '+ <b>'.$r['film_name'].'</b><br>';
	}
	?>
	</td>
</tr>
<tr>
	<td class="fr" width="30%"><b>Thể loại</b></td>
	<td class="fr_2"><?=acp_cat(NULL,1)?></td>
</tr>
<tr><td class="fr" colspan="2" align="center"><input type="submit" name="submit" class="submit" value="Sửa"></td></tr>
</table>
</form>
<?php
}
else {
	$in_sql = $id;
	$t_cat = $cat;
	$sql = '';
	if ($t_cat != 'dont_edit') $sql .= "film_cat = '".$t_cat."',";
	$sql = substr($sql,0,-1);
	if ($sql) $mysql->query("UPDATE ".$tb_prefix."film SET ".$sql." WHERE film_id IN (".$in_sql.")");
	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=index.php?act=film&mode=edit'>";
}
?>