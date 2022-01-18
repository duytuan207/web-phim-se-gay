<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if (!$_GET['id']) die('ERROR');
$id = $_GET['id'];
if (!$_POST['submit']) {
?>
<form enctype="multipart/form-data" method=post>
<table class="border" cellpadding="2" cellspacing="0" width="95%">
<tr><td colspan="2" class="title" align="center">Sửa nhiều Phim</td></tr>
<tr>
	<td class="fr" width="30%"><b>Các Phim sẽ sửa</b></td>
	<td class="fr_2">
	<?php
	$in_sql = $id;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_id IN (".$in_sql.")");
	while ($r = $mysql->fetch_array($q)) {
		echo '+ <b>'.$r['episode_name'].'</b> - <b><font color=red>'.check_data(get_data('film_name','film','film_id',$r['episode_film'])).'</font><br>';
	}
	?>
	</td>
</tr>
<tr>
	<td class="fr" width="30%"><b>Lựa Chọn</b></td>
	<td class="fr_2"><?php echo acp_film(NULL,1);?></td>
</tr>

<tr>
	<td class="fr" width="30%">
		<b>Thêm Nhanh</b>
		</td>
	<td class="fr_2">
	<?php echo acp_quick_add_film_form();?>
	</td>
</tr>

<tr><td class="fr" colspan="2" align="center">
<input type="submit" name="submit" class="submit" value="SUBMIT">
</td></tr>
</table>
</form>
<?php
}
else {
	if ($new_film) {
	     if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))
				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];
				else $new_film_img = $_POST['url_img'];
				$film = acp_quick_add_film($new_film,$name_real,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info);
	}	
    $in_sql = $id;
	$t_film = $film;
	$sql = '';
	if ($t_film != 'dont_edit') $sql .= "episode_film = '".$t_film."',";
	$sql = substr($sql,0,-1);
	if ($sql) $mysql->query("UPDATE ".$tb_prefix."episode SET ".$sql." WHERE episode_id IN (".$in_sql.")");
	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=index.php?act=film&mode=edit'>";
}
?>