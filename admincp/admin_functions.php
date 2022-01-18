<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

// danh sách server khi post = 0 tự động
function set_server($file_type=0) {
	$html = "<select name=server_post>".
		"<option value=0".(($file_type==0)?' selected':'').">Tự động</option>".
		        "<option value=1".(($file_type==1)?' selected':'').">1 - OTHER</option>".
		        "<option value=2".(($file_type==2)?' selected':'').">2 - FLASH</option>".
		        "<option value=3".(($file_type==3)?' selected':'').">3 - VIDEO</option>".
		        "<option value=5".(($file_type==5)?' selected':'').">5 - FLV - MP4</option>".
		        "<option value=6".(($file_type==6)?' selected':'').">6 - VK</option>".
		        "<option value=8".(($file_type==8)?' selected':'').">8 - NCT</option>".
                "<option value=10".(($file_type==10)?' selected':'').">10 - YouTuBe</option>".
		        "<option value=11".(($file_type==11)?' selected':'').">11 - CLIP.VN</option>".
		        "<option value=31".(($file_type==31)?' selected':'').">31 - Dailymotion</option>".
		        "<option value=32".(($file_type==32)?' selected':'').">32 - Youtube</option>".
		        "<option value=33".(($file_type==33)?' selected':'').">33 - Veoh</option>".
                "<option value=34".(($file_type==34)?' selected':'').">34 - Video Zing</option>".	
		        "<option value=38".(($file_type==38)?' selected':'').">38 - Youku</option>".	
                "<option value=47".(($file_type==47)?' selected':'').">47 - 4share</option>".
		        "<option value=53".(($file_type==53)?' selected':'').">53 - GoClip</option>".
                "<option value=55".(($file_type==55)?' selected':'').">55 - Cyworld</option>".
                "<option value=63".(($file_type==63)?' selected':'').">63 - Clip1</option>".
                "<option value=64".(($file_type==64)?' selected':'').">64 - Clip2</option>".
                "<option value=65".(($file_type==65)?' selected':'').">65 - Gdata</option>".
                "<option value=72".(($file_type==72)?' selected':'').">72 - vn2</option>".
                "<option value=79".(($file_type==79)?' selected':'').">79 - google</option>".
                "<option value=81".(($file_type==81)?' selected':'').">81 - tudou</option>".
                "<option value=83".(($file_type==83)?' selected':'').">83 - vimeo</option>".
                "<option value=84".(($file_type==84)?' selected':'').">84 - clipvn</option>".
                "<option value=107".(($file_type==107)?' selected':'').">107 - videogg</option>".
                "<option value=109".(($file_type==109)?' selected':'').">109 - truongxua</option>".
                "<option value=112".(($file_type==112)?' selected':'').">112 - XVIDEO</option>".
                "<option value=124".(($file_type==124)?' selected':'').">124 - flashx</option>".
                "<option value=147".(($file_type==147)?' selected':'').">147 - ZingTV</option>".
                "<option value=150".(($file_type==150)?' selected':'').">150 - BANGVN</option>".
                "<option value=151".(($file_type==151)?' selected':'').">151 - Fliiby</option>".
                "<option value=152".(($file_type==152)?' selected':'').">152 - DOCGOOGLE</option>".
                "<option value=153".(($file_type==153)?' selected':'').">153 - ZING TV</option>".
                "<option value=154".(($file_type==154)?' selected':'').">154 - vidbull</option>".
                "<option value=155".(($file_type==155)?' selected':'').">155 - Picasa1</option>";
		"</select>";
	return $html;
}
function trang_thai($trang_thai) {
	$html = "<select name=trang_thai>".
		"<option value=1".(($trang_thai==1)?' selected':'').">Thuyết Minh</option>".
		        "<option value=2".(($trang_thai==2)?' selected':'').">Lồng Tiếng</option>".
		        "<option value=3".(($trang_thai==3)?' selected':'').">ViệtSub</option>".
		        "<option value=4".(($trang_thai==4)?' selected':'').">Nosub</option>".
		"</select>";
	return $html;
}
function chatluong($trang_thai) {
	$html = "<select name=chatluong>".
		"<option value=".(($trang_thai=='')?'':'').">None</option>".
		"<option value=CAM".(($trang_thai=='CAM')?' selected':'').">CAM</option>".
		        "<option value=SD".(($trang_thai=='SD')?' selected':'').">SD</option>".
		        "<option value=HD".(($trang_thai=='HD')?' selected':'').">HD</option>".
		"</select>";
	return $html;
}
function uplaidate($uplaidate) {
	$html = "<input type=\"radio\" value=\"1\" checked name=\"uplaidate\"> Ko Up
			<input type=\"radio\" value=\"2\" name=\"uplaidate\"> Up Lại";
	return $html;
}
function getExt($filename){
	return $ext = strtolower(substr(strrchr($filename,'.'),1));
}

function acp_type(&$url) {
	$t_url = strtolower($url);
	$ext = explode('.',$t_url);
	$ext = $ext[count($ext)-1];
	$ext = explode('?',$ext);
	$ext = $ext[0];
	$movie_arr = array(
		'wmv',
		'avi',
		'asf',
		'mpg',
		'mpe',
		'mpeg',
		'asx',
		'm1v',
		'mp2',
		'mpa',
		'ifo',
		'vob',
		'smi',
	);
	
	$extra_swf_arr = array(
		//'www.dailymotion.com',
		//'www.metacafe.com',
		'www.livevideo.com',
	);
	
	for ($i=0;$i<count($extra_swf_arr);$i++){
		if (preg_match("#^http://".$extra_swf_arr[$i]."/(.*?)#s",$url)) {
			$type = 2;
			break;
		}
	}
	$is_viikii = (preg_match("#http://www.viikii.net/viewer/viikiiplayer2.swf(.*?)#s",$url));
	    $is_vk = (preg_match("#http://vk.com/(.*?)#s",$url));	
	    $is_youku = (preg_match("#(.*?)youku.com(.*?)#s",$url));	
	    $is_video_zing = (preg_match("#http://video.zing.vn/(.*?)#s",$url));
	    $is_dailymotion = (preg_match("#http://www.dailymotion.com/(.*)#",$url,$id_dailymotion)); 
	    $is_youtube = (preg_match("#(.*?).youtube.com/(.*?)#s",$url));
        $is_youtube1 = (preg_match("#http://www.youtube.com/v/(.*?)#s",$url));
        $is_youtube2 = (preg_match("#http://www.youtube.com/embed/(.*?)#s",$url));
	    $is_clipvn = (preg_match("#http://clip.vn/(.*?)#s",$url));
	    $is_clipvn1 = (preg_match("#http://phim.clip.vn/watch/(.*?)#s",$url));			
	    $is_clipvn_url1 = (preg_match("#http://clip.vn/(.*)#",$url));
	    $is_veoh = (preg_match("#http://www.veoh.com/(.*?)#s",$url));
	    $is_vtv = preg_match("/^mms:\/\/+[a-zA-Z0-9\.]+(.*?)(VTV|VTC|HTV|dn1|dn2)+(.*?)/i",$url);
	    $is_nct = (preg_match("#http://www.nhaccuatui.com/(.*)#s",$url));
	    $is_4shared = (preg_match("#www.4shared.com/(.*?)#s",$url));
	    $is_rtmp = (preg_match("#rtmp://(.*?)#s",$url));
	    $is_goclip = (preg_match("#clips.goonline.vn(.*?)#s",$url));
        $is_cyworld = (preg_match("#http://kine.cyworld.vn/detail/(.*?)#s",$url));
	    $is_cyworld1 = (preg_match("#http://www.cyworld.vn/v2/myhome/video/detail/homeid/(.*?)#s",$url));
	    $is_cyworld2 = (preg_match("#http://www.cyworld.vn/myhome/(.*?)#s",$url));
        $is_goclip = (preg_match("#http://clips.go.vn/xem/(.*?)#s",$url));
        $is_goclipvn = (preg_match("#http://content.go.vn/maytinh/item/(.*?)#s",$url));
        $is_goclip1 = (preg_match("#http://clips.go.vn/xem-clips/(.*?)#s",$url));
        $is_goclip2 = (preg_match("#http://clips.go.vn/xem-play-list/(.*?)#s",$url));
        $is_gdata = (preg_match("#http://gdata.youtube.com/feeds/api/playlists/(.*?)#s",$url));
        $is_mediafire = (preg_match("#http://www.mediafire.com/(.*?)#s",$url));
		$is_google = (preg_match("#https://picasaweb.google.com/(.*?)#s",$url));
		$is_google1 = (preg_match("#http://picasaweb.google.com/(.*?)#s",$url));
		$is_tudou = (preg_match("#http://www.tudou.com/playlist/p/(.*?)#s",$url));
		$is_tudou1 = (preg_match("#http://www.tudou.com/programs/view/(.*?)#s",$url));
		$is_content = (preg_match("#http://content.go.vn/(.*?)#s",$url));
		$is_truongxua = (preg_match("#http://www.truongxua.vn/(.*?)#s",$url));
		$is_truongxua1 = (preg_match("#http://truongxua.vn/(.*?)#s",$url));
	    $is_googleVideo = (preg_match("#http://video.google.com/videoplay\?docid=(.*?)#s",$url));
	    $is_googleVideo1 = (preg_match("#http://video.google.com/googleplayer.swf?docId=(.*?)#s",$url));
		$is_vimeo = (preg_match("#http://www.vimeo.com/(.*?)#s",$url));
		$is_vimeo1 = (preg_match("#http://vimeo.com/(.*?)#s",$url));
		$is_xvideo = (preg_match("#http://www.xvideos.com/(.*?)#s",$url));
		$is_flashx = (preg_match("#http://flashx.tv/(.*?)#s",$url));
		$is_zingtv = (preg_match("#http://mp3.zing.vn/tv/media/(.*?)#s",$url));
		$is_zingtv1 = (preg_match("#http://tv.zing.vn/(.*?)#s",$url));
		$is_bangvn = (preg_match("#http://bang.vn/Du_Lieu/View/Video/(.*?)#s",$url));
		$is_fliiby = (preg_match("#http://fliiby.com/(.*?)#s",$url));
		$is_docgg = (preg_match("#https://docs.google.com/(.*?)#s",$url));
		$is_xxxstash = (preg_match("#http://xxxstash.com/(.*?)#s",$url));
		$is_vidbull = (preg_match("#http://vidbull.com/(.*?)#s",$url));

	if ($ext == 'swf' || $is_googleVideo || $is_baamboo || $is_megavideo_url) $type = 2;
	elseif (in_array($ext,$movie_arr) || $is_vtv) $type = 3;
	elseif ($is_2shared1) $type = 4;
	elseif ($ext == 'flv' || $ext == 'mp4') $type = 5;
	elseif ($is_vk) $type = 6;
	elseif ($is_nct) $type = 8;
	elseif ($ext == 'divx') $type = 9;
	elseif ($is_youtube1) $type = 10;
	elseif ($is_clipvn_url1) $type = 11;
	elseif ($is_Twitclips || $is_Twitclips1) $type = 16;
	elseif ($is_rtmp) $type = 17;
	elseif ($is_dailymotion ||$is_dailymotion1) $type = 31;	
	elseif ($is_youtube) $type = 32;	
	elseif ($is_veoh) $type = 33;
	elseif ($is_video_zing) $type = 34;
	elseif ($is_youku) $type = 38;	
	elseif ($is_content) $type = 42;
	elseif ($is_4shared) $type = 47;
	elseif ($is_goclip || $is_goclipvn) $type = 53;
	elseif ($is_cyworld || $is_cyworld1 || $is_cyworld2) $type = 55;
    elseif ($is_goclip1) $type = 63;
    elseif ($is_goclip2) $type = 64;
    elseif ($is_gdata) $type = 65;
    elseif ($is_mediafire) $type = 66;
    elseif ($is_youtube2) $type = 71;
    elseif ($is_vn2) $type = 72;
	elseif ($is_google) $type = 79;
	elseif ($is_tudou || $is_tudou1) $type = 81;
	elseif ($is_vimeo || $is_vimeo1) $type = 83;
	elseif ($is_clipvn || $is_clipvn1) $type = 84;
	elseif ($is_googleVideo || $is_googleVideo1) $type = 107;
	elseif ($is_truongxua || $is_truongxua1) $type = 109;
	elseif ($is_xvideo || $is_xxxstash) $type = 112;
	elseif ($is_flashx) $type = 124;
	elseif ($is_zingtv) $type = 147;
	elseif ($is_bangvn) $type = 150;
	elseif ($is_fliiby) $type = 151;
	elseif ($is_docgg) $type = 152;
	elseif ($is_zingtv1) $type = 153;
	elseif ($is_vidbull) $type = 154;
	elseif ($is_google1) $type = 155;
	elseif (!$type) $type = 1;
    return $type;
}


function set_type($file_type=0) {
	$html = "<select name=file_type>".
		"<option value=0".(($file_type==0)?' selected':'').">0 - DEFAULT</option>".
		        "<option value=1".(($file_type==1)?' selected':'').">1 - OTHER</option>".
		        "<option value=2".(($file_type==2)?' selected':'').">2 - FLASH</option>".
		        "<option value=3".(($file_type==3)?' selected':'').">3 - VIDEO</option>".
		        "<option value=5".(($file_type==5)?' selected':'').">5 - FLV - MP4</option>".
		        "<option value=6".(($file_type==6)?' selected':'').">6 - VK</option>".
		        "<option value=8".(($file_type==8)?' selected':'').">8 - NCT</option>".
                "<option value=10".(($file_type==10)?' selected':'').">10 - YouTuBe</option>".
		        "<option value=11".(($file_type==11)?' selected':'').">11 - CLIP.VN</option>".
		        "<option value=31".(($file_type==31)?' selected':'').">31 - Dailymotion</option>".
		        "<option value=32".(($file_type==32)?' selected':'').">32 - Youtube</option>".
		        "<option value=33".(($file_type==33)?' selected':'').">33 - Veoh</option>".
                "<option value=34".(($file_type==34)?' selected':'').">34 - Video Zing</option>".	
		        "<option value=38".(($file_type==38)?' selected':'').">38 - Youku</option>".	
                "<option value=47".(($file_type==47)?' selected':'').">47 - 4share</option>".
		        "<option value=53".(($file_type==53)?' selected':'').">53 - GoClip</option>".
                "<option value=55".(($file_type==55)?' selected':'').">55 - Cyworld</option>".
                "<option value=63".(($file_type==63)?' selected':'').">63 - Clip1</option>".
                "<option value=64".(($file_type==64)?' selected':'').">64 - Clip2</option>".
                "<option value=65".(($file_type==65)?' selected':'').">65 - Gdata</option>".
                "<option value=66".(($file_type==66)?' selected':'').">66 - Download</option>".
                "<option value=79".(($file_type==79)?' selected':'').">79 - google</option>".
                "<option value=81".(($file_type==81)?' selected':'').">81 - tudou</option>".
                "<option value=83".(($file_type==83)?' selected':'').">83 - vimeo</option>".
                "<option value=84".(($file_type==84)?' selected':'').">84 - clipvn</option>".
                "<option value=107".(($file_type==107)?' selected':'').">107 - videogg</option>".
                "<option value=109".(($file_type==109)?' selected':'').">109 - truongxua</option>".
                "<option value=112".(($file_type==112)?' selected':'').">112 - XVIDEO</option>".
                "<option value=124".(($file_type==124)?' selected':'').">124 - flashx</option>".
                "<option value=147".(($file_type==147)?' selected':'').">147 - ZingTV</option>".
                "<option value=150".(($file_type==150)?' selected':'').">150 - BANGVN</option>".
                "<option value=151".(($file_type==151)?' selected':'').">151 - Fliiby</option>".
                "<option value=152".(($file_type==152)?' selected':'').">152 - DOCGOOGLE</option>".
                "<option value=153".(($file_type==153)?' selected':'').">153 - ZING TV</option>".
                "<option value=155".(($file_type==155)?' selected':'').">155 - Picasa1</option>";
		"</select>";
	return $html;
}


function acp_local($local = 0, $other = false,$server=0) {
    global $mysql, $tb_prefix;
    if($other) {
        if ($other == 'main') $other = ' onchange="check_local(this.value)"';
        elseif(is_numeric($other)){
			if ($server!=0) $other = '['.$other.']['.$server.'] id=local_url['.$other.']['.$server.']';
			else $other = '['.$other.'] id=local_url['.$other.']';
		}
    }
    $html = "<select name=local_url".$other.">".
	$html .= "<option value=0".(($local == 0 && !$other)?" selected":'').">NO LOCAL</option>";
    $q = $mysql->query("SELECT * FROM ".$tb_prefix."local ORDER BY local_id ASC");
    while ($r = $mysql->fetch_array($q)) { 
    $html.= "<option value=".$r['local_id']."".(($local==$r['local_id'])?' selected':'').">".$r['local_name']."</option>";
    }
   	$html .= "</select>";
    return $html;
}  

function admin_emotions_replace($s) {
	$emotions = emotions_array();
	foreach ($emotions as $a => $b) {
		$x = array();
		if (is_array($b)) {
			for ($i=0;$i<count($b);$i++) {
				$b[$i] = htmlchars($b[$i]);
				$x[] = $b[$i];
				$v = strtolower($b[$i]);
				if ($v != $b[$i]) $x[] = $v;
				}
		}
		else {
			$b = htmlchars($b);
			$x[] = $b;
			$v = strtolower($b);
			if ($v != $b) $x[] = $v;
			}
		$p = '';
		for ($u=0;$u<strlen($x[0]);$u++) {
			$ord = ord($x[0][$u]);
			if ($ord < 65 && $ord > 90) $p .= '&#'.$ord.';';
			else $p .= $x[0][$u];
		}
		$s = str_replace($x,'<img src=../images/emoticons/'.$a.'.gif>',$s);  
	}
	return $s;
}

function admin_viewpages($ttrow,$n,$pg){
global $link;
$div=ceil($ttrow/$n);
$link = preg_replace("#&pg=([0-9]{1,})#si","",$link);
$html="<table valign=bottom cellpadding=2 cellspacing=2 align=center>";
$html.="<tr><td align=justify>";
$pgt = $pg-1;
if ($pg<>1) $html.="<a class=pagelink href=$link onfocus=this.blur() title ='Xem trang đầu'><b>&laquo;&laquo;</b></a> <a class=pagelink href=$link&pg=$pgt onfocus=this.blur() title='Xem trang trước'><b>&laquo;</b></a> ";
	for($l = 0; $l < $div; $l++) {
		if ($l < $pg - 5 || $l > $pg + 10) 
		continue;
		$m = $l+1;
		if($m == $pg) $html .= "<a onfocus=this.blur() class=pagecurrent>$m</a> ";
		else $html .= "<a onfocus=this.blur() href=$link&pg=$m title='Xem trang $m' class=pagelink>$m</a> ";
	}
	$pgs = $pg+1;
	if ($pg<>$m) $html.="<a class=pagelink href=$link&pg=$pgs onfocus=this.blur() title='Xem trang kế tiếp'><b>&raquo;</b></a> <a class=pagelink href=$link&pg=$m onfocus=this.blur() title='Xem trang cuối'><b>&raquo;&raquo;</b></a> ";
	$html.="</td></tr></table>";
return $html;
}

function acp_quick_add_film_form() {
	$html = "TEXT";
	return $html;
}

function acp_quick_add_film1($new_film,$name_real,$tapphim,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info,$country,$file_type,$bo_le,$key,$des,$imgbn,$tag) {
	global $mysql, $tb_prefix;
		$mysql->query("UPDATE ".$tb_prefix."user SET user_point = user_point + 1 WHERE user_id = '".$_SESSION['admin_id']."'");
	    $mysql->query("INSERT INTO ".$tb_prefix."film (film_name,film_name_real,film_tapphim,film_name_ascii,film_img,film_actor,film_actor_ascii,film_year,film_time,film_area,film_director,film_director_ascii,film_cat,film_info,film_country,film_server,film_lb,film_key,film_des,film_imgbn,film_upload,film_tag,film_tag_ascii) VALUES ('".check_name($new_film)."','".check_name($name_real)."','".$tapphim."','".strtolower(get_ascii(check_name($new_film)))."','".$new_film_img."','".check_name($actor)."','".strtolower(get_ascii(check_name($actor)))."','".$year."','".$time."','".$area."','".check_name($director)."','".strtolower(get_ascii(check_name($director)))."','".$cat."','".queryspecail($info)."','".$country."','".$file_type."','".$bo_le."','".$keyw."','".$des."','".$imgbn."','".$_SESSION['admin_id']."','".$tag."','".strtolower(get_ascii($tag))."')");
		$film = $mysql->insert_id();
	return $film;
}
function add_send_mail($info) {
	global $mysql, $tb_prefix;
	    $mysql->query("INSERT INTO ".$tb_prefix."sendmail (sendmail_info) VALUES ('".$info."')");
		$film = $mysql->insert_id();
	return $film;
}
function acp_quick_add_film2($new_film,$name_real,$tapphim,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info,$country,$file_type,$bo_le,$key,$des,$imgbn,$tag,$trang_thai,$imdb,$hoanthanh,$gioithieu) {
	global $mysql, $tb_prefix;

	$q = $mysql->query("SELECT film_id FROM ".$tb_prefix."film WHERE film_name = '".UNIstr($new_film)."'");
	if ($mysql->num_rows($q)) {
		$r = $mysql->fetch_array($q);
		$film = $r[0];
		if($r['film_img'] == ' ')
	    $mysql->query("UPDATE ".$tb_prefix."film SET film_img = '".$new_film_img."' WHERE film_name = '".UNIstr($new_film)."'");
        elseif($r['film_name_real'] == ' ')
	    $mysql->query("UPDATE ".$tb_prefix."film SET film_name_real = '".$name_real."' WHERE film_name = '".UNIstr($new_film)."'");
	}
	else {
		$mysql->query("UPDATE ".$tb_prefix."user SET user_point = user_point + 1 WHERE user_id = '".$_SESSION['admin_id']."'");
	    $mysql->query("INSERT INTO ".$tb_prefix."film (film_name,film_name_real,film_tapphim,film_name_ascii,film_img,film_actor,film_actor_ascii,film_year,film_time,film_area,film_director,film_director_ascii,film_cat,film_info,film_country,film_server,film_lb,film_key,film_des,film_imgbn,film_upload,film_tag,film_tag_ascii,film_trangthai,film_imdb,film_hoanthanh,film_gioithieu) VALUES ('".check_name($new_film)."','".check_name($name_real)."','".$tapphim."','".strtolower(get_ascii(check_name($new_film)))."','".$new_film_img."','".check_name($actor)."','".strtolower(get_ascii(check_name($actor)))."','".$year."','".$time."','".$area."','".check_name($director)."','".strtolower(get_ascii(check_name($director)))."','".$cat."','".queryspecail($info)."','".$country."','".$file_type."','".$bo_le."','".$keyw."','".$des."','".$imgbn."','".$_SESSION['admin_id']."','".$tag."','".strtolower(get_ascii($tag))."','".$trang_thai."','".$imdb."','".$hoanthanh."','".$gioithieu."')");
		$film = $mysql->insert_id();
	}
	return $film;
}

function acp_film($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film ORDER BY film_name_ascii ASC");
	$html = "<select name=film>";
	if ($add) $html .= "<option value=dont_edit".(($id == 0)?" selected":'').">Không sửa</option>";
	while ($r = $mysql->fetch_array($q)) {
		$html .= "<option value=".$r['film_id'].(($id == $r['film_id'])?" selected":'').">".$r['film_name']."</option>";
	}
	$html .= "</select>";
	return $html;
}

function join_value($str){
	$num=count($str);
	$max=$num-1;
	$string="";
	for ($i=0; $i<$num;$i++){
		if ($i<$max) $string .=$str[$i].',';
		else $string .=$str[$i];
	}
return $string;
}
function acp_cat($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."cat ORDER BY cat_order ASC");
	$cat=explode(',',$id);
	$num=count($cat);
	$html="<table><tbody><tr><td>";
	while ($r = $mysql->fetch_array($q)) {
		for ($i=0; $i<$num;$i++) if ($cat[$i]==$r['cat_id']) $checked='checked="checked"';
		if ($is>3){ $html.="</td><td>";$is=0;}
		$html .= '<input type="checkbox" id="selectcat" name="selectcat[]" value="'.$r['cat_id'].'" '.$checked.'> '.$r['cat_name']."<br/>";
		$checked="";
		$is++;
		}
	$html .="</td><tr></tbody></table>";
	return $html;
}
function acp_webmail($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."webmail WHERE webmail_name_type = ".$add." ");
	$cat=explode(',',$id);
	$num=count($cat);
	$html="<table><tbody><tr><td>";
	while ($r = $mysql->fetch_array($q)) {
		for ($i=0; $i<$num;$i++) if ($cat[$i]==$r['webmail_id']) $checked='checked="checked"';
		if ($is>3){ $html.="</td><td>";$is=0;}
		$html .= '<input type="checkbox" id="selectcat" name="selectcat[]" value="'.$r['webmail_id'].'" '.$checked.'> '.$r['webmail_name']."<br/>";
		$checked="";
		$is++;
		}
	$html .="</td><tr></tbody></table>";
	return $html;
}
function acp_ads_type($id = 0) {
	$html = "<select name=ads_type>".
	    "<option value=0".(($id==0)?' selected':'').">Text</option>".
		"<option value=1".(($id==1)?' selected':'').">Images</option>".
		"<option value=2".(($id==2)?' selected':'').">Flash</option>".
		"<option value=3".(($id==3)?' selected':'').">HTML CODE</option>".
	"</select>";
	return $html;
}
function acp_ads_pos($id = 4) {
	$html = "<select name=pos>".
	    "<option value=0".(($id==0)?' selected':'').">Header Banner</option>".
		"<option value=1".(($id==1)?' selected':'').">Footer Banner</option>".
		"<option value=2".(($id==2)?' selected':'').">Top Center Banner</option>".
		"<option value=3".(($id==3)?' selected':'').">Center Banner</option>".
		"<option value=4".(($id==4)?' selected':'').">Right Banner1</option>".
		"<option value=5".(($id==5)?' selected':'').">Trên Player1</option>".
		"<option value=6".(($id==6)?' selected':'').">Trên Player2</option>".
		"<option value=7".(($id==7)?' selected':'').">Dưới Player1</option>".
		"<option value=8".(($id==8)?' selected':'').">Dưới Player2</option>".
		"<option value=9".(($id==9)?' selected':'').">Right2</option>".
		"<option value=10".(($id==10)?' selected':'').">Right3</option>".
		"<option value=11".(($id==11)?' selected':'').">Right4</option>".
		"<option value=12".(($id==12)?' selected':'').">HTML CODE</option>".
		"<option value=13".(($id==13)?' selected':'').">PreLoad COde</option>".
	"</select>";
	return $html;
}

function acp_country($id = 0, $add = false) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."country ORDER BY country_order ASC");
	$html = "<select name=country>";
	if ($add) $html .= "<option value=dont_edit".(($id == 0)?" selected":'').">Không sửa</option>";
		while ($r = $mysql->fetch_array($q)) {
		$html .= "<option value=".$r['country_id'].(($id == $r['country_id'])?" selected":'').">- ".$r['country_name']."</option>";
		}
	$html .= "</select>";
	return $html;
}
function acp_user_ban($lv) {
	$html = "<select name=ban>".
	    "<option value=0".(($lv==0)?' selected':'').">No</option>".
		"<option value=1".(($lv==1)?' selected':'').">Yes</option>".
	"</select>";
	return $html;
}
function acp_user_level($lv=0) {
	global $mysql,$tb_prefix;
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."user_level ORDER BY user_level_type ASC");
	$html = "<select name=level>";
	while ($r = $mysql->fetch_array($q)) {
		$html .= "<option value=".$r['user_level_type'].(($lv == $r['user_level_type'])?" selected":'').">- ".$r['user_level_name']."</option>";
		}
	$html .= "</select>";
	return $html;
}

function acp_get_mod_permission($lv) {
	global $mysql, $tb_prefix;	
	$permission_list = array(
		'add_cat',		
		'edit_cat',
		'del_cat',		
		'add_film',
		'add_film1',
		'edit_film',		
		'del_film',
		'add_link',
		'edit_link',		
		'del_link',
		'add_country',
		'add_dienvien',
		'edit_dienvien',
		'edit_country',
		'del_country',
		'add_news',
		'edit_news',
		'del_news',
		'add_webmail',
		'edit_webmail',
		
	);	
	$per = get_data('user_permission','user_level','user_level_type',$lv);
	$len = count($permission_list);
	$len=strlen($per);
	while (strlen($per) < $len) $per = '0'.$per;
	for ($i=0;$i<=$len;$i++) $arr[$permission_list[$i]] = $per[$i];
	return $arr;
	
}
function acp_check_permission_mod($name,$lv=0){
	global $level;
	$mod_permission = acp_get_mod_permission($level);
	if ($mod_permission[$name]==0) die('<center>BẠN KHÔNG ĐỦ QUYỀN TRUY CẬP VÀO TRANG NÀY</center>');
}
?>