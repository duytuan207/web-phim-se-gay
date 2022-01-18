<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {
	echo "Bạn không có quyền vào trang này.";
	exit();
}
if ($_POST['submit']) {
	$link 		= $_POST['player_link'];
	$skin 		= $_POST['player_skin'];
	$img 		= $_POST['player_img'];
	$h 			= $_POST['player_h'];
	$w 			= $_POST['player_w'];
	$logo 		= $_POST['player_logo'];
	$logo_pos 	= $_POST['player_logo_pos'];
	$allow_embed = $_POST['player_embed'];
	$plugins 	= $_POST['player_plugins'];
	$message 	= $_POST['player_mess'];
	$messagetime 	= $_POST['player_messtime'];
	$player_link_no_embed = $_POST['player_link_no_embed'];
	$player_ads_img 	= $_POST['player_ads_img'];
	$player_ads_link 	= $_POST['player_ads_link'];
	$player_ads_swf 	= $_POST['player_ads_swf'];
	$sql =  "UPDATE ".$tb_prefix."players SET player_link = '$link', player_skin = '$skin', player_img = '$img', player_h = '$h', player_w = '$w', player_logo = '$logo', player_logo_pos = '$logo_pos', player_allow_embed = '$allow_embed', player_link_no_embed = '$player_link_no_embed', player_plugins='$plugins' , player_ads_img='$player_ads_img' , player_ads_link='$player_ads_link', player_ads_swf='$player_ads_swf', player_message='$message', player_messagetime='$messagetime'  WHERE player_id = 1";
	$mysql->query($sql);
	echo "EDIT FINISH! <meta http-equiv='refresh' content='0;url=?act=player'>";
}
else{
$q = $mysql->query("SELECT * FROM ".$tb_prefix."players WHERE player_id = 1");
$rs = $mysql->fetch_array($q);
?>
<form method="post" name= "configures" action="">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td colspan=2 class=title align=center>CẤU HÌNH PLAYER</td></tr>
<tr>
	<td class=fr width=30%><b>Link Player</b></td>
	<td class=fr_2>
		<input name=player_link size=50 value="<?php echo $rs['player_link']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
		<b>Link giao diện player(chấp nhận swf, xml, zip)</b>
		</td>
	<td class=fr_2>
		<input name=player_skin size=50 value="<?php echo $rs['player_skin']?>">
		</td>
</tr>
<tr>
	<td class=fr width=30%><b>Link ảnh nền</b></td>
	<td class=fr_2>
		<input name=player_img size=50 value="<?php echo $rs['player_img']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Link logo hiển thị trên player</b></td>
	<td class=fr_2>
		<input name=player_logo size=50 value="<?php echo $rs['player_logo']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Link plugins</b></td>
	<td class=fr_2>
		<input name=player_plugins size=50 value="<?php echo $rs['player_plugins']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Vị trí hiển thị logo</b></td>
	<td class=fr_2>
	    <select name=player_logo_pos>
		<?php
		echo "<option value=1".(($rs['player_logo_pos']==1)?' selected':'').">Top - Left</option>".
		"<option value=2".(($rs['player_logo_pos']==2)?' selected':'').">Top - Right</option>".
		"<option value=3".(($rs['player_logo_pos']==3)?' selected':'').">Bottom - Left</option>".
		"<option value=4".(($rs['player_logo_pos']==4)?' selected':'').">Bottom - Right</option>";
		?>
		</select>
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Chiều cao</b></td>
	<td class=fr_2>
	<input name=player_h size=50 value="<?php echo $rs['player_h']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Chiều rộng</b></td>
	<td class=fr_2>
	<input name=player_w size=50 value="<?php echo $rs['player_w']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Cho phép nhúng vào site khác:</b></td>
	<td class=fr_2>
	<select name=player_embed>
		<?php
		echo "<option value=1".(($rs['player_allow_embed']==1)?' selected':'').">Có</option>".
		"<option value=0".(($rs['player_allow_embed']==0)?' selected':'').">Không</option>";
		?>
		</select>
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Link ảnh nền/video khi không cho embed:</b></td>
	<td class=fr_2>
	<input name=player_link_no_embed size=50 value="<?php echo $rs['player_link_no_embed']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Link plugins ads trên Player:</b></td>
	<td class=fr_2>
	<input name=player_ads_swf size=50 value="<?php echo $rs['player_ads_swf']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Link ảnh quảng cáo trên Player:</b></td>
	<td class=fr_2>
	<input name=player_ads_img size=50 value="<?php echo $rs['player_ads_img']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Link liên kết khi click ảnh:</b></td>
	<td class=fr_2>
	<input name=player_ads_link size=50 value="<?php echo $rs['player_ads_link']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Thông báo trên player(html):</b></td>
	<td class=fr_2>
	<input name=player_mess size=50 value="<?php echo $rs['player_message']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>Thời gian hiển thị (mặc định : 10s):</b></td>
	<td class=fr_2>
	<input name=player_messtime size=50 value="<?php echo $rs['player_messagetime']?>">
	</td>
</tr>
<tr><td class=fr colspan=2 align=center>
<input type=submit name=submit class=submit value=SUBMIT></td></tr>
</table>
</form>
<?php
}
?>