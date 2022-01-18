<?php
function xem_web($url) {
	$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, 'Googlebot/2.1 (+http://www.google.com/bot.html)');
  curl_setopt($ch, CURLOPT_HEADER, true );
  curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
  curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
  curl_setopt($ch, CURLOPT_AUTOREFERER, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);

		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Leech Diễn Viên Từ Xemphimon.Com</title>

<style>
.left { float: left;}.right { float: right; }.clr { clear: both;}
</style>
</head>
<script language="JavaScript" type="text/JavaScript">
<!--
function onover(obj,cls){obj.className=cls;}
function onout(obj,cls){obj.className=cls;}
function ondown(obj,url,cls){obj.className=cls; window.location=url;}
//-->
</script>
<body topmargin="0" leftmargin="0">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="style_border" width="7" >&nbsp;</td>
    <td valign="top" class="style"><table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td valign="top" class="style_bg">
				
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
<?php
if ((!$_POST['ok']) AND (!$_POST['submit'])) {
?>
<form method=post>
<table class=border cellpadding=2 cellspacing=0 width=30%>
<tr><td class=title align=center>Leech Diễn Viên Từ Xemphimon.Com</td></tr>
<tr>
	<td class=fr width=10% align=center>
	<input name="total_songs" size=100 value="" style="text-align:center">
<p style="color:red;font-size:10">+ Link post: http://xemphimon.com/dien-vien/phim-ta-dinh-phong.html</p>
</td>
</tr>
<tr><td class=fr align=center><input type="submit" name="ok" class="sutm" value="Submit"></td></tr>
</table>
</form>
<?php
}else{
$total_links = $_POST['total_songs'];
if (!$_POST['submit']) {
    $url = xem_web($total_links);
	$name = explode('<p>Tên khai sinh: <span>', $url);
	$name = explode('</span></p>', $name[1]);
	$tenkhac = explode('<p>Tên Khác: <span>', $url);
	$tenkhac = explode('</span></p>', $tenkhac[1]);
	$ngaysinh = explode('<p>Ngày sinh: <span>', $url);
	$ngaysinh = explode('</span></p>', $ngaysinh[1]);
	$noisinh = explode('<p>Nơi sinh: <span>', $url);
	$noisinh = explode('</span></p>', $noisinh[1]);
	$chieucao = explode('<p>Chiều cao: <span>', $url);
	$chieucao = explode('</span></p>', $chieucao[1]);
	$vaidien = explode('<p>Vai diễn đáng chú ý: <span>', $url);
	$vaidien = explode('</span></p>', $vaidien[1]);
	$hinhanh = explode('<link rel="image_src" href="', $url);
	$hinhanh = explode('"', $hinhanh[1]);
	$info = explode('<div id="movie_description" class="entry movie_description">', $url);
	$info = explode('</div>	</div></div><div class="movie-box">', $info[1]);

?>
<form enctype="multipart/form-data" method=post>
<tr><td class=title align=center>Thêm Diễn Viên <?=$name[0]?> Vào Data</td></tr>
<table cellpadding=2 cellspacing=2 width=100% >
<tr>
	<td class=fr width=20%>
		<b>Tên Diễn Viên</b>
		</td>
	<td class=fr_2>
		<input name="dienvien" value="<?=$name[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Tên Khác</b>
		</td>
	<td class=fr_2>
		<input name="tenkhac" value="<?=$tenkhac[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Ngày Sinh</b>
		</td>
	<td class=fr_2>
		<input name="ngaysinh" value="<?=$ngaysinh[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Nơi Sinh</b>
		</td>
	<td class=fr_2>
		<input name="noisinh" value="<?=$noisinh[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Chiều Cao</b>
		</td>
	<td class=fr_2>
		<input name="chieucao" value="<?=$chieucao[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Vai Diễn Hay</b>
		</td>
	<td class=fr_2>
		<input name="vaidien" value="<?=$vaidien[0]?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Img phim</b></td>
	<td class=fr_2>
	<input type=text name="hinhanh" size=60 value="<?=$hinhanh[0];?>"></td>
</tr>
<tr>
	<td class=fr width=20%><b>Thông tin: </b></td>
	<td class=fr_2>
		<textarea name="info" id="info" cols="100" rows="15"><?=$info[0];?></textarea>
		<script language="JavaScript">generate_wysiwyg('info');</script>
	</td>
</tr>
<tr>
					<td class=fr colspan=2 align=center>
					<input type=hidden name=ok value=Submit>
					<input type=submit name=submit class="sutm" value="Send">
					</td>
					</tr>
					</table>
					</form>
<?php
}
else {
	$dienvien = $_POST['dienvien'];
	$tenkhac = $_POST['tenkhac'];
	$ngaysinh = $_POST['ngaysinh'];
	$noisinh = $_POST['noisinh'];
	$chieucao = $_POST['chieucao'];
	$vaidien = $_POST['vaidien'];
	$hinhanh = $_POST['hinhanh'];
	$info = $_POST['info'];
    $mysql->query("INSERT INTO ".$tb_prefix."dienvien (actor_name_kd,actor_name,actor_name1,actor_birthday,actor_location,actor_height,actor_movie,actor_img,actor_info) VALUES ('".replace($dienvien)."','".$dienvien."','".$tenkhac."','".$ngaysinh."','".$noisinh."','".$chieucao."','".$vaidien."','".$hinhanh."','".$info."')");
	header("Location: index.php?act=lech_dienvien");
}
}
?>
                </td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>