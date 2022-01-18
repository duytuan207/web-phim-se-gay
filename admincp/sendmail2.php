<?php
$link = 'index.php?act=sendmail2';
function m_build_mail_headerzz($to_email, $from_email) {
	$CRLF = "\n";
	$headers = 'MIME-Version: 1.0'.$CRLF;
	$headers .= 'Content-Type: text/html; charset=UTF-8'.$CRLF;
	$headers .= 'Date: ' . gmdate('D, d M Y H:i:s Z', NOW) . $CRLF;
	$headers .= 'From: <'. $from_email .'>'. $CRLF;
	$headers .= 'Reply-To: <'. $from_email .'>'. $CRLF;
	$headers .= 'Auto-Submitted: auto-generated'. $CRLF;
	$headers .= 'Return-Path: <'. $from_email .'>'. $CRLF;
	$headers .= 'X-Sender: <'. $from_email .'>'. $CRLF; 
	$headers .= 'X-Priority: 3'. $CRLF;
	$headers .= 'X-MSMail-Priority: Normal'. $CRLF;
	$headers .= 'X-MimeOLE: Produced By NetHung'. $CRLF;
	$headers .= 'X-Mailer: PHP/ '. phpversion() . $CRLF;
	return $headers;
}
?>
		    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
              <tr>
               <td align="center" width="100%">
<?php
if ((!$_POST['ok']) AND (!$_POST['submit'])) {
?>
<form method=post>
<table class="border" cellpadding="2" cellspacing="0" width="50%">
<tr><td class=title align=center>Auto Send Mail SEO</td></tr>
<tr>
	<td class=fr width=10% align=center>
	<select name="server">
	  <option value="1">Tin Tức</option>
	  <option value="2">Giải Trí</option>
	</select>
	<br/><br/>
</td>
</tr>
<tr><td class=fr align=center><input type="submit" name="ok" class="sutm" value="Submit"></td></tr>
</table>
</form>
<?php
}else{
if (!$_POST['submit']) {
if($_POST['server']==1){
$class ="Tin Tức";
}else{
$class ="Giải Trí";
}
?>
<table cellspacing="0" align="center" cellpadding="0" width="100%">
<tr>
<td align="center" width="100%">

<form enctype="multipart/form-data" method=post>
<table class=border cellpadding=2 cellspacing=0 width=90%>
<tr><td colspan=2 class=title align=center>Gửi email đến website cần seo</td></tr>
<tr>
	<td class=fr width=15%><b>Tiêu đề <?=$class;?></b></td>
	<td class=fr_2><input type=text name="title" size=70 value=""></td>
</tr>
<tr>
	<td class=fr width="15%"><b>Thể Loại</b></td>
	<td class=fr_2><?=acp_webmail(0,$_POST['server'])?></td>
</tr>
<tr>
	<td class=fr width=15%><b>Nội dung</b></td>
	<td class=fr_2><textarea rows=8 cols=70 id="content" name="content"></textarea>
	<script>CKEDITOR.replace( 'content',{skin : 'v2',language: 'vi'});</script>
	</td>
</tr>
<!--<tr>
	<td class=fr width=20%><b>Thông tin: </b></td>
	<td class=fr_2>
		<textarea name="content" id="content" cols="100" rows="15"></textarea>
		<script language="JavaScript">generate_wysiwyg('content');</script>
	</td>
</tr>-->
<tr>
	<td class=fr colspan=2 align=center>
	<input type=submit name=submit class=submit value=Submit>
	</td>
</tr>
</table>
</form>
</td>
</tr>
</table>

<?php
}
else{
	if ($_POST['submit']) {
		$send_mail = add_send_mail($_POST['content']);
		$qqq = $mysql->query("SELECT * FROM ".$tb_prefix."sendmail WHERE sendmail_id = $send_mail");
		$cff = $mysql->fetch_array($qqq);
		$content 		= 	$cff['sendmail_info'];
		$cat			= join_value($_POST['selectcat']);
		$text_link 	= array("<a href='http://phimoke.com' title='xem phim'><b>Xem Phim</b></a>","<a href='http://phimoke.com/phim-18.html' title='phim 18+'><b>Phim 18+</b></a>","<a href='http://phimoke.com/phim-cap-3.html' title='phim cap 3'><b>Phim cap 3</b></a>","<a href='http://phimoke.com/phim-phim-sex-chon-loc-tren-may-tinh-2014.oke25.html' title='phim sex'><b>Phim sex</b></a>","<a href='http://phimoke.com/phim-sex-co-trang-thoi-xua-hay-va-chat-luong.oke152.html' title='phim sex co trang'><b>Phim sex co trang</b></a>");
		$qq = $mysql->query("SELECT * FROM ".$tb_prefix."config WHERE cf_id = 1");
		$cf = $mysql->fetch_array($qq);
		$from 		= 	$cf['cf_web_email'];
		$mail_content = $_POST['title']."<br />".$content."<br>".$text_link[array_rand($text_link)];
		$mail_title = get_ascii($_POST['title']);
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."webmail WHERE webmail_id IN (".$cat.")");
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
		$to = $r['webmail_name_email'];
		$header = m_build_mail_headerzz($to,$from);
		$i++;
		mail($to,$mail_title,$mail_content,$header);
		}
		echo "Đã thực hiện xong <meta http-equiv='refresh' content='0;url=$linkz'>";
		$mysql->query("DELETE FROM ".$tb_prefix."sendmail WHERE sendmail_id IN (".$send_mail.")");
		exit();
	}
}
}
?>
                </td>
              </tr>
            </table>
