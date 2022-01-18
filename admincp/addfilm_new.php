<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Content</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="../styles/jquery.js"></script>
<script type="text/javascript" src="../openwysiwyg/wysiwyg.js"></script>
<script type="text/javascript" src="../styles/admin.js"></script>
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
		    <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding: 20px;">
<?php
function htmltxt($document){
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
	);
	$text = preg_replace($search, '', $document);
	return $text;
} 
function xem_web($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
function grabzzzzz($url) {
if (preg_match("#http://phim.clip.vn/watch/(.*?)/(.*?)#s",$url,$id_sr)){
    	$id 	= 	$id_sr[1];
		$id = explode(',', $id);
		$url	=	'http://clip.vn/embed/'.$id[1];		
	}
return $url;
}
if ($_POST['webgrab'] == 'clipvn') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play = explode('<a href="http://phim.clip.vn/wa', $info_url_html);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_img = explode('width="216" height="306" src="', $info_url_html);
	$info_img = explode('?v=', $info_img[1]);
	$info_name = explode('<meta property="og:title" content="', $info_url_html);
	$info_name = explode('" />', $info_name[1]);
	$info_name_en = explode('<div class = \'originaltitle\'>', $info_url_html);
	$info_name_en = explode('</div></h1>', $info_name_en[1]);
	$info_daodien = explode('Đạo diễn: <strong>', $info_url_html);
	$info_daodien = explode('</strong></li>', $info_daodien[1]);
	$info_dienvien = explode('Diễn viên: <strong>', $info_url_html);
	$info_dienvien = explode('</strong></li>', $info_dienvien[1]);
	$info_nam = explode('Phát hành: <strong>', $info_url_html);
	$info_nam = explode('</strong></li>', $info_nam[1]);
	$info_sx = explode('Sản xuất: <strong>', $info_url_html);
	$info_sx = explode('</strong></li>', $info_sx[1]);
	$info_time = explode('Thời lượng: <strong>', $info_url_html);
	$info_time = explode('</strong></li>', $info_time[1]);
	$info_tt = explode('<div class="filmdescription" itemprop="description">', $info_url_html);
	$info_tt = explode('</p>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('itemprop="image" width="216" height="306" src="', $info_url_html);
	$info_img = explode('?v=', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);	
}
elseif ($_POST['webgrab'] == 'phimletvn') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play = explode('<a rel="nofollow" href="/xem-ph', $info_url_html);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_img = explode('width="216" height="306" src="', $info_url_html);
	$info_img = explode('?v=', $info_img[1]);
	$info_name = explode('<meta property="og:title" content="', $info_url_html);
	$info_name = explode(' -', $info_name[1]);
	$info_name_en = explode('" />', $info_name[1]);
	$info_daodien = explode('<div class="grid_2 omega label">Đạo diễn:</div><div class="grid_7 alpha">', $info_url_html);
	$info_daodien = explode('</div></div>', $info_daodien[1]);
	$info_dienvien = explode('<div class="grid_2 omega label">Diễn viên:</div><div class="grid_7 alpha">', $info_url_html);
	$info_dienvien = explode('</div></div>', $info_dienvien[1]);
	$info_nam = explode('<div class="grid_2 omega label">Năm:</div><div class="grid_7 alpha">', $info_url_html);
	$info_nam = explode('</div></div>', $info_nam[1]);
	$info_time = explode('<div class="grid_2 omega label">Tập:</div><div class="grid_7 alpha">', $info_url_html);
	$info_time = explode('</div></div>', $info_time[1]);
	$info_tt = explode('Giới thiệu:</div><div class="grid_7 alpha">', $info_url_html);
	$info_tt = explode('</div></div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<meta property="og:image" content="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
}
elseif ($_POST['webgrab'] == 'Phimhdhay') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<dt><a href="xem-phim/', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = "http://phimhdhay.vn/xem-phim/".$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="xem-', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<dt>Tên phim:</dt>

        <dd>', $info_url_html);
	$info_name = explode(' - ', $info_name[1]);
	//$info_name_en = explode('</dd>', $info_name[1]);
	$info_name_en = explode('</dd>', $info_name[1]);
	$info_daodien = explode('<dt>Đạo diễn:</dt>

        <dd>', $info_url_html);
	$info_daodien = explode('</dd>', $info_daodien[1]);
	$info_dienvien = explode('<dt>Diễn viên:</dt>

        <dd>', $info_url_html);
	$info_dienvien = explode('</dd>', $info_dienvien[1]);
	$info_nam = explode('title="Phim năm ', $info_url_html);
	$info_nam = explode('">', $info_nam[1]);
	$info_time = explode('<dt>Thời lượng:</dt>

        <dd>', $info_url_html);
	$info_time = explode('</dd>', $info_time[1]);
	$info_tt = explode('<table width=100%>', $info_url_html);
	$info_tt = explode('</table>', $info_tt[1]);
	$info_tt = str_replace('<a href="javascript:void(0)" onclick="$(this).remove();$(\'#movie_description\').removeClass(\'movie_description\')" style="float:right;padding:10px 0">Xem thêm...</a>',"",$info_tt[0]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
	$info_img = explode('<div class="thumbnail"><img src="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
}
elseif ($_POST['webgrab'] == 'phimphim') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode(' <a title="poster" href="./xem-phim', $info_url_html);
	$url_play_phim = explode('"><img alt="', $url_play_phim[1]);
	$url_play_html_phim = 'http://phimphim.com/xem-phim'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="xem-', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<p>Tên phim:	<span>', $info_url_html);
	$info_name = explode(' - ', $info_name[1]);
	$info_name_en = explode('<p>Tên phim:	<span>', $info_url_html);
	$info_name_en = explode(' - ', $info_name_en[1]);
	$info_daodien = explode('<p>Đạo diễn: 	<span>', $info_url_html);
	$info_daodien = explode('</span></p>', $info_daodien[1]);
	$info_dienvien = explode('<p>Diễn viên: 	<span>', $info_url_html);
	$info_dienvien = explode('</span></p>', $info_dienvien[1]);
	$info_nam = explode('<p>Năm phát hành: 	<span>', $info_url_html);
	$info_nam = explode('</span></p>', $info_nam[1]);
	$info_sx = explode('<p>Sản xuất: 	<span>', $info_url_html);
	$info_sx = explode('</span></p>', $info_sx[1]);
	$info_time = explode('<p>Thời lượng: 	<span>', $info_url_html);
	$info_time = explode('</span></p>', $info_time[1]);
	$info_tt = explode('</a></noscript>', $info_url_html);
	$info_tt = explode('<p class="name">Từ khóa:', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
	$info_img = explode('<img alt="free image hosting" src="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
}
elseif ($_POST['webgrab'] == 'phimtrangcom') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<p class="play"><a class="btn btn-primaryplay" href="', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = $url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a id="play_', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<h2 title="Phim ', $info_url_html);
	$info_name = explode('">', $info_name[1]);
	$info_name_en = explode('<h3>', $info_url_html);
	$info_name_en = explode('</h3>', $info_name_en[1]);
	$info_daodien = explode('<p class="bt">Đạo diễn: <span>', $info_url_html);
	$info_daodien = explode('</span></p>', $info_daodien[1]);
	$info_dienvien = explode('<p class="bt">Diễn viên: <span>', $info_url_html);
	$info_dienvien = explode('</span></p>', $info_dienvien[1]);
	$info_nam = explode('<p class="bt">Năm phát hành: <span>', $info_url_html);
	$info_nam = explode('</span></p>', $info_nam[1]);
	$info_sx = explode('<p>Sản xuất: 	<span>', $info_url_html);
	$info_sx = explode('</span></p>', $info_sx[1]);
	$info_time = explode('<p class="bt">Thời lượng: <span>', $info_url_html);
	$info_time = explode('</span></p>', $info_time[1]);
	$info_tt = explode('<div id="content2" class="html"> <span>', $info_url_html);
	$info_tt = explode('</span> </div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
	$info_img = explode('<link rel="image_src" href="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
}
elseif ($_POST['webgrab'] == 'phimccc') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<a class="xem w-bt" href="', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = $url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('id="play_', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<div class="name-info">
						<h2>', $info_url_html);
	$info_name = explode('</h2>', $info_name[1]);
	$info_name_en = explode('</strong><h3>', $info_url_html);
	$info_name_en = explode('</h3>', $info_name_en[1]);
	$info_daodien = explode('<p>Đạo diễn: <span>', $info_url_html);
	$info_daodien = explode('</span></p>', $info_daodien[1]);
	$info_dienvien = explode('<p>Diễn viên: <span>', $info_url_html);
	$info_dienvien = explode('</span></p>', $info_dienvien[1]);
	$info_nam = explode('title="Phim Năm ', $info_url_html);
	$info_nam = explode('"', $info_nam[1]);
	$info_sx = explode('<p>Sản xuất: 	<span>', $info_url_html);
	$info_sx = explode('</span></p>', $info_sx[1]);
	$info_time = explode('<p>Thời lượng: <span>', $info_url_html);
	$info_time = explode('</span></p>', $info_time[1]);
	$info_tt = explode('<div id="movie_description" class="entry movie_description">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
	$info_img = explode('<link href="', $info_url_html);
	$info_img = explode('" rel="image_src" />', $info_img[1]);
}
elseif ($_POST['webgrab'] == 'phim8') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<a href="http://phim8.info/xem-phim/', $info_url_html);
	$url_play_phim = explode('" alt="Xem phim trực tuyến"', $url_play_phim[1]);
	$url_play_html_phim = 'http://phim8.info/xem-phim/'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="xem-', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<h3>Thông tin phim   ', $info_url_html);
	$info_name = explode(' - ', $info_name[1]);
	$info_name_en = explode('</font></h3>', $info_name[1]);
	$info_daodien = explode('<dt>Đạo diễn:</dt>
        <dd>', $info_url_html);
	$info_daodien = explode('</dd>', $info_daodien[1]);
	$info_dienvien = explode('<dt>Diễn viên:</dt>
        <dd>', $info_url_html);
	$info_dienvien = explode('</dd>', $info_dienvien[1]);
	$info_nam = explode('<dt>Năm phát hành:</dt>
        <dd><a href="year/', $info_url_html);
	$info_nam = explode('.html', $info_nam[1]);
	$info_sx = explode('<dt>Sản xuất:</dt>', $info_url_html);
	$info_sx = explode('</dd>', $info_sx[1]);
	$info_time = explode('<dt>Thời lượng:</dt>
        <dd>', $info_url_html);
	$info_time = explode('</dd>', $info_time[1]);
	$info_tt = explode('<div class="message">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
}
elseif ($_POST['webgrab'] == 'phim85') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<dt><a href="http://www.phim85.com/xem-phim/', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = 'http://www.phim85.com/xem-phim/'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<li class="">', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<title>Xem Phim ', $info_url_html);
	$info_name = explode(' | ', $info_name[1]);
	$info_name_en = explode(' (', $info_name[1]);
	$info_daodien = explode('<dt>Đạo diễn - Director:</dt>
        <dd>', $info_url_html);
	$info_daodien = explode('</dd>', $info_daodien[1]);
	$info_dienvien = explode('<dt>Diễn viên - Stars:</dt>
        <dd>', $info_url_html);
	$info_dienvien = explode('</dd>', $info_dienvien[1]);
	$info_nam = explode('<dd><a href="year/', $info_url_html);
	$info_nam = explode('.html"', $info_nam[1]);
	$info_time = explode('<dt>Thời lượng - Runtime:</dt>
        <dd>', $info_url_html);
	$info_time = explode('</dd>', $info_time[1]);
	$info_tt = explode('<div style="margin-top:5px;" class="title hr"><span>NỘI DUNG PHIM</span></div>
</br>
        <div class="message">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
}
elseif ($_POST['webgrab'] == 'themxua') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<p class="w_now"><a href="', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = $url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href=\'./Phi', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<title>', $info_url_html);
	$info_name = explode('</title>', $info_name[1]);
	//$info_name_en = explode('', $info_name[1]);
	$info_daodien = explode('<p><strong>Đạo Diễn: </strong>', $info_url_html);
	$info_daodien = explode('</p>', $info_daodien[1]);
	$info_dienvien = explode('<p><strong>Diễn Viên: </strong>', $info_url_html);
	$info_dienvien = explode('</p>', $info_dienvien[1]);
	$info_nam = explode('<p><strong>Năm Phát Hành: </strong> ', $info_url_html);
	$info_nam = explode('</p>', $info_nam[1]);
	$info_time = explode('<p> <strong>Thời Lượng: </strong><b> ', $info_url_html);
	$info_time = explode('</p>', $info_time[1]);
	$info_tt = explode('<hr />', $info_url_html);
	$info_tt = explode('<div class="clear"></div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<img src="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
}
elseif ($_POST['webgrab'] == 'phimhayhot') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<span class="key"><a onclick="this.style.behavior=\'url(#default#homepage)\';this.setHomePage(\'http://phimhayhot.net\');" href="', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = $url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="http://phimhayhot.net/xem-phim/', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<title>Xem phim ', $info_url_html);
	$info_name = explode(' | ', $info_name[1]);
	//$info_name_en = explode('<p class="tt-en">» ', $info_url_html);
	$info_name_en = explode(' | ', $info_name[1]);
	$info_daodien = explode('<span class="key">Đạo diễn:</span><span class="value">', $info_url_html);
	$info_daodien = explode('</span>', $info_daodien[1]);
	$info_dienvien = explode('<span class="key">Diễn viên:</span><span class="value">', $info_url_html);
	$info_dienvien = explode('</span>', $info_dienvien[1]);
	$info_nam = explode('<span class="key">Năm phát hành:</span><span class="value">', $info_url_html);
	$info_nam = explode('</span>', $info_nam[1]);
	$info_time = explode('<span class="key">Thời lượng:</span><span class="value">', $info_url_html);
	$info_time = explode('</span>', $info_time[1]);
	$info_tt = explode('<div id="gach_ngang" class="box_des">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<link rel="image_src" href="', $info_url_html);
	$info_img = explode('" />', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);
}
elseif ($_POST['webgrab'] == 'nuiphimcom') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<a href="http://nuiphim.com/xem-phim-online', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = 'http://nuiphim.com/xem-phim-online'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="http://nuiphim.com/xem-phim-', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<h2 class="title-film">', $info_url_html);
	$info_name = explode(' - ', $info_name[1]);
	$info_name_en = explode('</h2>', $info_name[1]);
	$info_daodien = explode('<p>Đạo diễn: <b>', $info_url_html);
	$info_daodien = explode('</b></p>', $info_daodien[1]);
	$info_dienvien = explode('<p>Diễn viên: <b>', $info_url_html);
	$info_dienvien = explode('</b></p>', $info_dienvien[1]);
	$info_nam = explode('title="Phim Năm ', $info_url_html);
	$info_nam = explode('"', $info_nam[1]);
	$info_time = explode('<p class="col2 fl">Thời lượng: <b>', $info_url_html);
	$info_time = explode('</b></p>', $info_time[1]);
	$info_tt = explode('<div class="movie movie-content fl cl">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<meta property="og:image" content="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);

}
elseif ($_POST['webgrab'] == 'phimdao') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<a href="./xem-phim/', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = 'http://phimdao.net/xem-phim/'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a data-type="watch" data-episode-id', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<h2 class="title fr">', $info_url_html);
	$info_name = explode('</h2>', $info_name[1]);
	$info_name_en = explode('<div class="name2 fr">', $info_url_html);
	$info_name_en = explode('<span', $info_name_en[1]);
	$info_daodien = explode('<dt>Đạo diễn: </dt><dd>', $info_url_html);
	$info_daodien = explode('</dd>', $info_daodien[1]);
	$info_dienvien = explode('<dt>Diễn viên:</dt><dd>', $info_url_html);
	$info_dienvien = explode('</dd>', $info_dienvien[1]);
	$info_nam = explode('class="year">(', $info_url_html);
	$info_nam = explode(')', $info_nam[1]);
	$info_time = explode('<dt>Thời lượng:</dt><dd>', $info_url_html);
	$info_time = explode('</dd>', $info_time[1]);
	$info_tt = explode('<div class="tab text">', $info_url_html);
	$info_tt = explode('</div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<meta property="og:url" content="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);

}elseif ($_POST['webgrab'] == 'phim1biz') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<a href="http://phim1.biz/xem-phim/online/', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = 'http://phim1.biz/xem-phim/online/'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<li><a href="http://phim1.biz/xem-phim/', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<title>Xem Phim ', $info_url_html);
	$info_name = explode(' | ', $info_name[1]);
	//$info_name_en = explode('', $info_url_html);
	//$info_name_en = explode('', $info_name_en[1]);
	$info_daodien = explode('<dt>Đạo diễn:</dt> <dd>', $info_url_html);
	$info_daodien = explode('</dd>', $info_daodien[1]);
	$info_dienvien = explode('<dt>Diễn viên:</dt> <dd>', $info_url_html);
	$info_dienvien = explode('</dd>', $info_dienvien[1]);
	$info_nam = explode('<span class="year">(', $info_url_html);
	$info_nam = explode(')</span>', $info_nam[1]);
	$info_time = explode('<dt>Thời lượng:</dt> <dd>', $info_url_html);
	$info_time = explode('</dd>', $info_time[1]);
	$info_tt = explode('<div class="tabs-content" id="info-film"> <div class="tab text">', $info_url_html);
	$info_tt = explode('</div> </div>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<img class="photo" src="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);

}elseif ($_POST['webgrab'] == 'phimvang') {
	$info_url_html = xem_web($_POST['urlgrab']);
	$url_play_phim = explode('<p><a href="/xem-phim/', $info_url_html);
	$url_play_phim = explode('"', $url_play_phim[1]);
	$url_play_html_phim = 'http://phimvang.org/xem-phim/'.$url_play_phim[0];
	$url_play_phim = xem_web($url_play_html_phim);
	$url_play = explode('<a href="/xem-p', $url_play_phim);
	$total_play = count($url_play);
	$total_plays = $total_play-1;

	$info_name = explode('<p>Tên phim:	<span class="fn">', $info_url_html);
	$info_name = explode(' - ', $info_name[1]);
	$info_name_en = explode('</span></p>', $info_name[1]);
	$info_daodien = explode('<p>Đạo diễn: 	<span class="author">', $info_url_html);
	$info_daodien = explode('</span></p>', $info_daodien[1]);
	$info_dienvien = explode('<p>Diễn viên: 	<span class="ingredient">', $info_url_html);
	$info_dienvien = explode('</span></p>', $info_dienvien[1]);
	$info_nam = explode('<p>Năm sản xuất: 	<span>', $info_url_html);
	$info_nam = explode('</span></p>', $info_nam[1]);
	$info_time = explode('<p>Thời lượng: 	<span>', $info_url_html);
	$info_time = explode('</span></p>', $info_time[1]);
	$info_tt = explode('<p style="padding-bottom:20px">Tag: 	<span>', $info_url_html);
	$info_tt = explode('</span></p>', $info_tt[1]);
	$info_tt = $info_tt[0];
	$info_img = explode('<link rel="image_src" href="', $info_url_html);
	$info_img = explode('"', $info_img[1]);
	$info_tag	=	get_ascii($info_name[0].", ".$info_name_en[0]);

}
$begin = $_POST['episode_begin'];
$end = $_POST['episode_end'];
////BEGIN CHECK EPISODE
if(!is_numeric($begin) && !is_numeric($end)){
$episode_begin = 1;
$episode_end = $total_plays;
}elseif(!is_numeric($begin) && !is_numeric($end)){
$episode_begin = 1;
$episode_end = 10;
}elseif(!is_numeric($begin)){
$episode_begin = $episode_end = $end;
}else{
$episode_begin = $begin; $episode_end = $end;
}
////END CHECK EPISODE
if (!$_POST['submit']) {
?>
<script>
var total = <?=$total_links?>;
<?php for ($z=1; $z<=$total_sv; $z++) { ?>
    function check_local_<?=$z?>(status){
        for(i=1;i<=total;i++)
            document.getElementById("local_url_<?=$z?>_"+i).checked=status;
    }
<?php } ?>
</script>
<form enctype="multipart/form-data" method=post>
<table cellpadding=2 cellspacing=2 width=100% >
<tr>
	<td class=fr width=20%>
		<b>Tên phim</b>
		</td>
	<td class=fr_2>
		<input name="new_phim" value="<?=htmltxt($info_name[0])?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Tên tiếng anh</b>
		</td>
	<td class=fr_2>
		<input name="tienganh" value="<?=htmltxt($info_name_en[0])?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Đạo diễn</b>
	<td class=fr_2>
		<input name="phim_daodien" value="<?=htmltxt($info_daodien[0])?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Diễn viên</b>
	<td class=fr_2>
		<input name="phim_dienvien" value="<?=htmltxt($info_dienvien[0])?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Trailer</b>
	<td class=fr_2>
		<input name="trailer" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Nhà Sản Xuất</b>
	<td class=fr_2>
		<input name="nhasx" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Thời lượng</b>
	<td class=fr_2>
		<input name="phim_thoigian" value="<?=htmltxt($info_time[0])?>" size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Năm Phát Hành</b>
	<td class=fr_2>
		<input name="phim_nam" value="<?=htmltxt($info_nam[0])?>" size=50>
	</td>
</tr>
<tr><td class=fr width=100px><font color="red"><b>Tag Seo Google</b></td><td class=fr_2><textarea name="tagseo" style="height: 120px; width: 600px;"><?=$info_tag;?></textarea></td></tr>
<tr>
	<td class=fr width=20%>
		<b>Quốc gia</b>
	<td class=fr_2>
		<?=acp_country()?>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Phim Bộ/Lẻ</b></td>
	<td class=fr_2><select name="phimbole"><option value=0>- Phim Lẻ</option><option value=1>- PhimBộ</option></select></td>
    </tr>
<tr>
<tr>
	<td class=fr width=20%>
		<b>Tập Phim</b>
	<td class=fr_2>
		<input name="tapphim" value="HD"size=50>
	</td>
</tr>
<tr>
	<td class=fr width=20%>
		<b>Img phim</b></td>
	<td class=fr_2>
	<input type=text name="phim_imgz" size=60 value="<?=$info_img[0];?>"></td>
</tr>
<tr>
	<td class=fr width=20%><b>Thể loại</b></td>
	<td class=fr_2><?=acp_cat()?></td>
</tr>
<tr>
	<td class=fr width=20%><b>Thông tin: </b></td>
	<td class=fr_2>
		<textarea name="phim_info" id="phim_info" cols="100" rows="15"><?=$info_tt;?></textarea>
		<script language="JavaScript">generate_wysiwyg('phim_info');</script>
	</td>
</tr>
					<?php
                    for ($i=$episode_begin;$i<=$episode_end;$i++) {
						if ($_POST['webgrab'] == 'clipvn') {
							$play_url = explode('tch/', $url_play[$i]);
							$play_url = explode('" title="', $play_url[1]);
							$name = explode('" >', $url_play[$i]);
							$name = explode('</a>', $name[1]);
							$name = str_replace('Xem phim','',$name[0]);
							$play_url = $play_url[0];
							$play_embed[$i] = grabzzzzz('http://phim.clip.vn/watch/'.$play_url);
						}
						elseif ($_POST['webgrab'] == 'phimletvn') {
							$play_url = explode('im-', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = "http://phim.let.vn/xem-phim-".$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('<span>', $url_play[$i]);
							$name = explode('</span>', $name[1]);
							$name = str_replace("Tập ","",$name[0]);
						}
						elseif ($_POST['webgrab'] == 'Phimhdhay') {
							$play_url = explode('phim/', $url_play[$i]);
							$play_url = explode('">', $play_url[1]);
							$play_url1 = 'http://phimhdhay.vn/xem-phim/'.$play_url[0];
							$html_link_play = xem_web($play_url1);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode(' - Tập ', $html_link_play);
							$name = explode(' OnlinePhimHDHay', $name[1]);
							$name = $name[0];
						
						}
						elseif ($_POST['webgrab'] == 'phimphim') {
							$play_url = explode('phim-', $url_play[$i]);
							$play_url = explode('">', $play_url[1]);
							$play_url = 'http://phimphim.com/xem-phim-'.$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('font-weight: bold">&nbsp;', $url_play[$i]);
							$name = explode('&nbsp;</font>', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'phimtrangcom') {
							$play_url = explode('href="', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = $play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('| Tập ', $html_link_play);
							$name = explode(' |', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'phimccc') {
							$play_url = explode('href="', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = $play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('"proxy.link": "', $html_link_play);
							$link_phim = explode('",', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('Tập ', $html_link_play);
							$name = explode('</title>', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'phim8') {
							$play_url = explode('phim/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = 'http://phim8.info/xem-phim/'.$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('<font size="4" color="red"><b>[', $html_link_play);
							$name = explode(']</b></font>', $name[1]);
							$name = $name[0];
							}
						elseif ($_POST['webgrab'] == 'phim85') {
							$play_url = explode('<a href="xem-phim/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = 'http://www.phim85.com/xem-phim/'.$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode(') - Tập ', $html_link_play);
							$name = explode(' |', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'themxua') {
							$play_url = explode('m-', $url_play[$i]);
							$play_url = explode("'", $play_url[1]);
							$play_url = 'http://www.themxua.com/Xem-Phim/Phim-'.$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('  - Tập ', $html_link_play);
							$name = explode(',', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'phimhayhot') {
							$play_url = explode('online/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = 'http://phimhayhot.com/xem-phim/online/'.$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('Tap ', $html_link_play);
							$name = explode(' sv ', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'nuiphimcom') {
							$play_url = explode('online/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = "http://nuiphim.com/xem-phim-online/".$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('TẬP ', $html_link_play);
							$name = explode('">', $name[1]);
							$name = $name[0];
						}
						elseif ($_POST['webgrab'] == 'phimdao') {
							$play_url = explode('href="./xem-phim/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = "http://phimdao.net/xem-phim/".$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('proxy.link=', $html_link_play);
							$link_phim = explode('&', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('Tập ', $html_link_play);
							$name = explode(' Sever', $name[1]);
							$name = $name[0];
						}elseif ($_POST['webgrab'] == 'phim1biz') {
							$play_url = explode('online/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = "http://phim1.biz/xem-phim/online/".$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode('"proxy.link": "', $html_link_play);
							$link_phim = explode('",', $link_phim[1]);
							$link_phim = $link_phim[0];
							$play_embed[$i] = $link_phim;
							$name = explode('| Tập ', $html_link_play);
							$name = explode('</title>', $name[1]);
							$name = $name[0];
						}elseif ($_POST['webgrab'] == 'phimvang') {
							$play_url = explode('him/', $url_play[$i]);
							$play_url = explode('"', $play_url[1]);
							$play_url = "http://phimvang.org/xem-phim/".$play_url[0];
							$html_link_play = xem_web($play_url);
							$link_phim = explode("{'link':'", $html_link_play);
							$link_phim = explode("'}", $link_phim[1]);
							$play_embed[$i] = $link_phim[0];
							$name = explode('class="waiting">', $url_play[$i]);
							$name = explode('</a>', $name[1]);
							$name = $name[0];
						}
                    ?>			
					<tr>
					<td class=fr width='20%'><b>Tập <input onclick="this.select();" type=text name=name[<?=$i?>] size=4 value="<?=$name?>" style="text-align:center;"></b></td>
					<td class='fr_2'> Link <input type=text name=url[<?=$i?>] size=60 value="<?=$play_embed[$i]?>">
					</td>
					</tr>
                    <?php
                    }
                    ?>
					<tr>
					<td class=fr colspan=2 align=center>
					<input type="hidden" name="episode_begin" value="<?=$episode_begin?>">
                    <input type="hidden" name="episode_end" value="<?=$episode_end?>">
					<input type=hidden name=ok value=Submit>
					<input type=submit name=submit class="sutm" value="Send">
					</td>
					</tr>
					</table>
					</form>
<?php
}
else {
	$actor			= $_POST['phim_dienvien'];
	$cat			= join_value($_POST['selectcat']);
	//$cat		 	= implode(',',$_POST['cat']);
	$new_film   	= $_POST['new_phim'];
	$name_real   	= $_POST['tienganh'];
	$trailer	   	= $_POST['trailer'];
	$info		  	= $_POST['phim_info'];
	$time		    = $_POST['phim_thoigian'];
	$year		   	= $_POST['phim_nam'];
	$director	    = $_POST['phim_daodien'];
	$country		= $_POST['country'];
	$tapphim		= $_POST['tapphim'];
	$imdb		= $_POST['imdb'];
	$gioithieu		= $_POST['gioithieu'];
	$hoanthanh		= $_POST['hoanthanh'];
	$tag			= $_POST['tagseo'];
	$bo_le			= $_POST['phimbole'];
	$t_singer   	= $actor;
	$area			= $_POST['nhasx'];
	$trang_thai = "";
	// add film

	if ($new_film) {
		$new_film_img = $_POST['phim_imgz'];
		$film_id =  acp_quick_add_film2($new_film,$name_real,$tapphim,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info,$country,$file_type,$bo_le,$key,$des,$imgbn,$tag,$trang_thai,$imdb,$hoanthanh,$gioithieu);
			}
	$t_film = $film_id;
	for ($i=$episode_begin;$i<=$episode_end;$i++){
		$t_url = $_POST['url'][$i];
		$t_name = $_POST['name'][$i];
		$t_sub = $_POST['sub'][$i];
		$t_message = $_POST['message'][$i];
		$t_type = acp_type($t_url);

		//lech sub
		if ($t_url && $t_name) {
		$mysql->query("INSERT INTO ".$tb_prefix."episode (episode_film,episode_url,episode_type,episode_name) VALUES ('".$t_film."','".$t_url."','".$t_type."','".$t_name."')");
		$mysql->query("UPDATE ".$tb_prefix."film SET film_date = '".NOW."' WHERE film_id = ".$t_film."");
		

		}

	}
	header("Location: index.php?act=clipvn");
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