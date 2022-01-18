<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {
	echo "Bạn không có quyền vào trang này.";
	exit();
}
if ($_POST['submit']) {
	$web_name = $_POST['web_name'];
	$web_link = $_POST['web_link'];
	$web_key = $_POST['web_key'];
	$web_email = $_POST['web_email'];
	$site_off = $_POST['site_off'];
	$web_keywords = $_POST['web_keywords'];	
	$per_page = $_POST['per_page'];
	$announcement = $_POST['announcement'];
	$protect=$_POST['protect'];
	$s_user=$_POST['server_user'];
	$s_inv=$_POST['server_inv'];
	$key_le=$_POST['key_le'];
	$des_le=$_POST['des_le'];
	$key_bo=$_POST['key_bo'];
	$des_bo=$_POST['des_bo'];
	$send_mail_seo=$_POST['send_mail_seo'];
	$download=$_POST['download'];
	$cf_sitemap_p	=	$_POST['cf_sitemap_p'];
	$sql =  "UPDATE ".$tb_prefix."config SET cf_web_name = '$web_name', send_mail_seo = '$send_mail_seo', cf_web_link = '$web_link', cf_web_keywords = '$web_key', cf_web_email = '$web_email', cf_site_off = '$site_off', cf_web_keywords = '$web_keywords', cf_per_page = '$per_page', cf_announcement = '$announcement', cf_protect = '$protect', cf_server_user = '$s_user', cf_server_inv = '$s_inv', cf_download = '$download', cf_sitemap_p = '$cf_sitemap_p', cf_web_keyle = '$key_le', cf_web_desle = '$des_le', cf_web_keybo = '$key_bo', cf_web_desbo = '$des_bo' WHERE cf_id = 1";
	$mysql->query($sql);
	echo "EDIT FINISH! <meta http-equiv='refresh' content='0;url=?act=config'>";
}
else{
$q = $mysql->query("SELECT * FROM ".$tb_prefix."config WHERE cf_id = 1");
$rs = $mysql->fetch_array($q);
?>
<form method="post" name= "configures" action="?act=config&id=1">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td colspan=2 class=title align=center>CẤU HÌNH HỆ THỐNG</td></tr>
<tr>
	<td class=fr width=30%><b>Tên Website site</b></td>
	<td class=fr_2>
		<input name=web_name size=50 value="<?=$rs['cf_web_name']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
		<b>Đường dẫn đến Web</b>
		</td>
	<td class=fr_2>
		<input name=web_link size=50 value="<?=$rs['cf_web_link']?>">
		</td>
</tr>
<tr>
	<td class=fr width=30%><b>WEB KEYWORDS</b></td>
	<td class=fr_2>
		<input name=web_keywords size=50 value="<?=$rs['cf_web_keywords']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Key Phim Lẻ</b></td>
	<td class=fr_2>
		<input name=key_le size=50 value="<?=$rs['cf_web_keyle']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>DES Phim lẻ</b></td>
	<td class=fr_2>
		<input name=des_le size=50 value="<?=$rs['cf_web_desle']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Key Phim bộ</b></td>
	<td class=fr_2>
		<input name=key_bo size=50 value="<?=$rs['cf_web_keybo']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>DES Phim Bộ</b></td>
	<td class=fr_2>
		<input name=des_bo size=50 value="<?=$rs['cf_web_desbo']?>">
	</td>
</tr>
<tr>
	<td class=fr width=30%>
	<b>WEB EMAIL</b></td>
	<td class=fr_2>
	<input name=web_email size=50 value=<?=$rs['cf_web_email']?>>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Ngừng hoạt động</b></td>
	<td class=fr_2>
	    <select name=site_off>
		<?php
		echo "<option value=0".(($rs['cf_site_off']==0)?' selected':'').">Không</option>".
		"<option value=1".(($rs['cf_site_off']==1)?' selected':'').">Có</option>";
		?>
		</select>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Bảo vệ Website</b></td>
	<td class=fr_2>
	    <select name=protect>
		<?php	
		echo "<option value=0".(($rs['cf_protect']==0)?' selected':'').">Không</option>".
		"<option value=1".(($rs['cf_protect']==1)?' selected':'').">Kiểm tra Cookie</option>".
		"<option value=2".(($rs['cf_protect']==2)?' selected':'').">Kiểm tra trình duyệt web</option>";
		?>
		</select>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Đăng nhập để download phim</b></td>
	<td class=fr_2>
	<select name=download>
		<?php	
		echo "<option value=1".(($rs['cf_download']==1)?' selected':'').">Có</option>".
		"<option value=2".(($rs['cf_download']==2)?' selected':'').">Không</option>";
		?>
		</select>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Server lỗi</b></td>
	<td class=fr_2>
	<input name=server_inv size=20 value=<?=$rs['cf_server_inv']?>> ID Server :<?=set_type()?>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Server cho thành viên</b></td>
	<td class=fr_2>
	<input name=server_user size=20 value=<?=$rs['cf_server_user']?>> ID Server :<?=set_type()?>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Số kết quả hiển thị</b></td>
	<td class=fr_2>
	<input name=per_page size=10 value=<?=$rs['cf_per_page']?>>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Số link sitemap</b></td>
	<td class=fr_2>
	<input name=cf_sitemap_p size=10 value=<?=$rs['cf_sitemap_p']?>>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Send Mail Sep</b></td>
	<td class=fr_2>
	<textarea name="send_mail_seo" style="height: 120px; width: 600px;"><?=$rs['send_mail_seo']?></textarea>
	</td>
</tr>
<tr>
	<td class=fr width=30%><b>Thông báo</b></td>
	<td class=fr_2>
	<textarea class="ckeditor" cols=60 rows=10 name="announcement" id="announcement"><?=$rs['cf_announcement']?></textarea>
	<script>CKEDITOR.replace( 'editor1',{skin : 'v2',language: 'vi'});</script>
	</td>
</tr>
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script>
<tr><td class=fr colspan=2 align=center>
<input type=submit name=submit class=submit value=SUBMIT></td></tr>
</table>
</form>
<?php
}
?>