<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$id = $_GET['id'];
if (!$id) {
?>
<form enctype="multipart/form-data" method="get">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td class=title align=center>EDIT EPISODES</td></tr>
<tr>
<td align=center>Nhập ID của phần cần sửa
<br>
<input type="hidden" value="edit_episode" name="act" id="act">
<input class=title type="text" id="id" name="id">
</td></tr>
<tr><td class=fr align=center><input type="submit" name="submit" class="submit" value="SUBMIT"></td></tr>
</table>
</form>
<?php
}
else 
{
$q = $mysql->query("SELECT episode_name, episode_type, episode_url,episode_urlsub,episode_order FROM ".$tb_prefix."episode WHERE episode_id='".$id."'");
$r = $mysql->fetch_array($q);
?>
<form enctype="multipart/form-data" method=post>
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td class=title align=center>EDIT EPISODES</td></tr>
<tr>
<td align=center>Name: 
<input style="width: 80%" type="text" id="na" name="na" value="<?php echo $r['episode_name']; ?>">
</td></tr>
<tr>
<td align=center>Type: 
<input style="width: 80%" type="text" id="type" name="type" value="<?php echo $r['episode_type']; ?>">
</td></tr>
<tr>
<td align=center>Link: 
<input style="width: 80%" type="text" id="link" name="link" value="<?php echo $r['episode_url']; ?>">
</td></tr>
<tr>
<td align=center>Sub: 
<input style="width: 80%" type="text" id="link" name="sub" value="<?php echo $r['episode_urlsub']; ?>">
<input type="hidden" value="edit_episode" name="act" id="act">
<input type="hidden" value="<?php echo $id; ?>" name="id" id="id"></td></tr>
<tr>
<td align=center>Message: 
<input style="width: 80%" type="text" id="link" name="message" value="<?php echo $r['episode_message']; ?>">
<input type="hidden" value="edit_episode" name="act" id="act">
<input type="hidden" value="<?php echo $id; ?>" name="id" id="id"></td></tr>
<tr><td class=fr align=center><input type="submit" name="submit" class="submit" value="SUBMIT"></td></tr>
</table>
</form>
<?php
	}
if ($_POST['link'] && $_POST['type'] && $_POST['id'] && $_POST['na']){
	$mysql->query("UPDATE ".$tb_prefix."episode SET episode_urlsub='".$_POST['sub']."',episode_url='".$_POST['link']."',episode_name='".$_POST['na']."',episode_type='".$_POST['type']."' WHERE episode_id='".$_POST['id']."'");
	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=index.php?act=film&mode=edit'>";
}
?>