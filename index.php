<?php
ob_start();
session_start();
define('IN_MEDIA',true);
include('inc/_config.php');
function is_mobile(){	
	if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
	return true;
	if(preg_match('/wap.|.wap/i',$_SERVER['HTTP_ACCEPT']))
	return true;
	
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		$user_agents = array(
		'midp', 'j2me', 'avantg', 'docomo', 'novarra', 'palmos', 
		'palmsource', '240x320', 'opwv', 'chtml', 'pda', 
		'mmp\/', 'blackberry', 'mib\/', 'symbian', 'wireless', 'nokia', 
		'cdm', 'up.b', 'audio', 'SIE-', 'SEC-', 
		'samsung', 'mot-', 'mitsu', 'sagem', 'sony', 'alcatel', 
		'lg', 'erics', 'vx', 'NEC', 'philips', 'mmm', 'xx', 'panasonic', 
		'sharp', 'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt', 
		'pg', 'vox', 'amoi', 'bird', 'compal', 'kg', 'voda', 'sany', 
		'kdd', 'dbt', 'sendo', 'sgh', 'gradi', 'jb', 'dddi', 'moto', 'ipad', 'iphone', 'Opera Mobi', 'android'
		);
		$user_agents = implode('|', $user_agents);
		if (preg_match("/$user_agents/i", $_SERVER['HTTP_USER_AGENT']))
		return true;
	}
	
	return false;
}
#######################################
# GET COOKIE
#######################################
if (isset($_SERVER['HTTP_REFERER'])) {$visit= $_SERVER['HTTP_REFERER'];
	if ((preg_match('#login.ht(.*?)#s', $visit))||(preg_match('#logout.ht(.*?)#s', $visit))||(preg_match('#register.ht(.*?)#s', $visit))){
		$lastvisit=$_SESSION['last_visit'];
	}else{
		$lastvisit=$visit;
		$_SESSION['last_visit']=$lastvisit;
	}}

if ($web_protect!=0) include('protect.php');
include('inc/_functions.php');
include('inc/_main.php');
include('inc/_string.php');
include('inc/_grab.php');
include('inc/_temp.php');
include('inc/_pages.php');
include('inc/_players.php');
include('inc/play_mobile.php');
$temp = new temp;
#######################################
# GET SKIN
#######################################
$skin_folder = get_data('skin_folder','skin','skin_id',get_data('cf_skin_default','config','cf_id',1));
if (is_mobile()) {
	$_SESSION['skin_folder'] = 'skin/mobile';
}else{
	$_SESSION['skin_folder'] = 'skin/'.$skin_folder;
}
#######################################
# SITE OFF
#######################################
if (get_data('cf_site_off','config','cf_id',1) == 1) {
	echo get_data('cf_announcement','config','cf_id',1);
	exit();
}
$isLoggedIn = m_checkLogin();
#######################################
# GET FILE
#######################################
if ($_GET['request']) {
	//$security 		= 	intval($_GET['sec_num']);
	$request_content 	= 	urldecode($_GET['request_content']);
	/*if (!$security || $security != $_SESSION['antifloodimage'] || !$_SESSION['antifloodimage']) {
		echo ('Mã bảo vệ không đúng.');exit();
	}*/
	if ($request_content){
		$mysql->query("INSERT INTO ".$tb_prefix."request (request_content,request_time)
													VALUES ('$request_content','".NOW."')");
		unset($_SESSION['antifloodimage']);
		echo 1;
	}
	exit();
}
if ($_POST['showcomment']) {
	$showcomment = write_comment($num,$film_id,$page);
	$temp->print_htm($showcomment);
	exit();
}
if ($_POST['showfilm']) {
	if ($num == 1) $type = 'new';
	elseif ($num == 2) $type = 'top';
	elseif ($num == 4) $type = 'rate';
	elseif ($num == 5) $type = 'relate';
	elseif ($num == 6) $type = 'phimle';
	elseif ($num == 7) $type = 'phimbo';
	elseif ($num == 8) $type = 'dangchieurap'; 
	elseif ($num == 9) $type = 'sapchieurap';
	elseif ($num == 10) $type = 'decu'; 
	$showfilm = film($type,intval($number),intval($apr),intval($cat_id),intval($page));
	$temp->print_htm($showfilm);
	exit();
}
if ($_POST['tooltip'] || $_POST['dienvien'] ||$_POST['filmdienvien'] || $_POST['rating'] || $_POST['comment'] || $_POST['request'] || $_POST['broken']) {
	include('inc/php/post.php');
	exit();
}
if ($_POST['watch'])
{
	include('inc/php/film.php');
	exit();
}
//Members
if (($_POST['reg']) || ($_POST['login']) || ($_POST['forgot'])|| ($_POST['user_edit'])) {
	include('user.php');
}
if($_POST['nextmovie']) {
	$e_id	=	intval($_POST['e_id']);
	$r		=	$mysql->fetch_array($mysql->query("SELECT episode_id,episode_film,episode_url,episode_urlsub,episode_type FROM ".$tb_prefix."episode WHERE episode_id = '$e_id'"));
	$film_id	=	$r['episode_film'];
	$url		=	$r['episode_url'];
	$type		=	$r['episode_type'];
	$width		=	'675';
	$height		=	'480';
	$film_sub	=	$r['episode_urlsub'];
	$nvID		=	$r['episode_id'];
	$phihung	=	$mysql->fetch_array($mysql->query("SELECT film_name_ascii FROM ".$tb_prefix."film WHERE film_id = '$film_id'"));
	$next		=	$mysql->fetch_array($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_id > $nvID AND episode_film = '$film_id' AND episode_type = '$type' ORDER BY episode_id ASC LIMIT 1"));
	if($next) $link_next	=	$web_link.'/xem-phim-'.replace($phihung['film_name_ascii']).'.vc'.replace($next['episode_id']).'.html';
	echo players($url,$film_id,$e_id,$type,$width,$height,$sv=0,$film_sub,$postajax=1,$link_next);
	exit();
}
if($_POST['download']) {
	$e_id =	intval($_POST['e_id']);
	$r = $mysql->fetch_array($mysql->query("SELECT episode_url FROM ".$tb_prefix."episode WHERE episode_id = '$e_id'"));
	$url = $r['episode_url'];
	$data = file_get_contents($web_link.'/video/player.php?url='.urlencode($url));
	$array = json_decode($data, true);
	$text = '';
	if($array[360]) $text .= '<li class="episode"><a title="360p" class="btn-episode" href="'.$array[360].'">480×360</a></li>';
	if($array[480]) $text .= '<li class="episode"><a title="480p" class="btn-episode" href="'.$array[480].'">640×480</a></li>';
	if($array[720])	$text .= '<li class="episode"><a title="720p" class="btn-episode" href="'.$array[720].'">1280×720</a></li>';
	if($array[1080]) $text .= '<li class="episode"><a title="1080p" class="btn-episode" href="'.$array[1080].'">1920x1080</a></li>';
	echo '<ul class="list-episode">'.$text.'</ul>';
	exit();
}
if($_POST['filmBox']) {
	if($_SESSION["user_id"]){
		$userid = $_SESSION['user_id'];
		$film_id	=	intval($_POST['film_id']);
		$phimcheck = ','.$film_id.',';
		$check_id = $mysql->query("SELECT user_id,user_filmbox FROM ".$tb_prefix."user WHERE user_filmbox LIKE '%".$phimcheck."%' AND user_id = '".$userid."' ORDER BY user_id ASC");
		$phimadd = $film_id.",";	
		if($mysql->num_rows($check_id)){ 
			$r = $mysql->fetch_array($check_id);
			$re_add = str_replace($phimadd,"", $r['user_filmbox']);
			$mysql->query("UPDATE ".$tb_prefix."user SET user_filmbox = '".$re_add."' WHERE user_id = $userid");
			echo 2;
		}else{
			$add_get = $mysql->query("SELECT user_id,user_filmbox FROM ".$tb_prefix."user WHERE user_id = '".$userid."' ORDER BY user_id ASC");
			$rs = $mysql->fetch_array($add_get);
			$addphim = $rs['user_filmbox'].''.$phimadd;
			$mysql->query("UPDATE ".$tb_prefix."user SET user_filmbox = '".$addphim."' WHERE user_id = $userid");
			echo 3;
		}
	}else{
		echo 1;
	}
	
	exit();
}
if($_POST['error']) {
	$film_id	=	intval($_POST['film_id']);
	$episode_id	=	intval($_POST['episode_id']);
	$mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 1 WHERE episode_id = $episode_id");
	$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 1 WHERE film_id = $film_id");
	echo 1;
	exit();
}
#######################################
# SET TOP OF DAY
#######################################
$day = date('d',NOW);
$current_day = get_data('cf_current_day','config','cf_id',1);
if ($day != $current_day) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed_day = 0");
	$mysql->query("UPDATE ".$tb_prefix."config SET cf_current_day = ".$day." WHERE cf_id = 1");
}
$week = date('W',NOW);
$current_week = get_data('cf_current_w','config','cf_id',1);
if ($week != $current_week) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed_w = 0");
	$mysql->query("UPDATE ".$tb_prefix."config SET cf_current_w = ".$week." WHERE cf_id = 1");
}
$month = date('m',NOW);
$current_month = get_data('cf_current_m','config','cf_id',1);
if ($month != $current_month) {
	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed_m = 0");
	$mysql->query("UPDATE ".$tb_prefix."config SET cf_current_m = ".$month." WHERE cf_id = 1");
}
#######################################
# GET VALUE
#######################################
if (in_array($value[1],array('sitemap','the-loai','watch','xem-full','list','tim-kiem','dao-dien','year','tag','quick_search','thong-tin','quoc-gia','trailer')))
include('inc/php/film.php');
elseif (in_array($value[1],array('video','vplay')))
include('inc/php/video.php');
elseif ($value[1] == 'dien-vien')
include('inc/php/dien-vien.php');
elseif ($value[1] == 'news')
include('inc/php/news.php');
elseif ($value[1] == 'error')
include('inc/php/error.php');
elseif ($value[1] == 'user')
include('inc/php/user.php');
elseif ($value[1] == 'login' || $value[1] == 'register' || $value[1] == 'forget' || $value[1] == 'repass'|| $value[1] == 'logout'|| $value[1] == 'tu-phim')
include('inc/php/userlog.php');
elseif ($value[1] == 'zchannel')
include('inc/php/zchannel.php');
elseif ($value[1] == 'request')
include('inc/php/request.php');
elseif ($value[1] == 'bxh')
include('inc/php/bxh.php');
elseif ($value[1] == 'menu'){
	include('inc/php/creatmenu.php');	
	exit();
}
#######################################
# GET HTML
#######################################
if (in_array($value[1],array('the-loai','list','tim-kiem','dao-dien','year','tag','quick_search','quoc-gia','news','request','error')))
$html = $temp->get_htm('home_search');
else if (in_array($value[1],array('video','vplay')))
$html = $temp->get_htm('home_video');
else if (($value[1]=='thong-tin'))
$html = $temp->get_htm('home_info');
else if (($value[1]=='bxh'))
$html = $temp->get_htm('home_bxh');
else if (($value[1]=='sitemap'))		
$html = $temp->get_htm('home_sitemap');
else if (($value[1]=='dien-vien'))
$html = $temp->get_htm('home_dien_vien');
else if (($value[1]=='watch') || ($value[1]=='xem-full')|| ($value[1]=='trailer'))
$html = $temp->get_htm('home_watch');
else if  (($value[1]=='user') || ($value[1]=='news') || ($value[1]=='zchannel') || ($value[1]=='login') || ($value[1]=='register')|| ($value[1]=='forget')|| ($value[1]=='repass')|| ($value[1]=='logout') || ($value[1]=='tu-phim'))
$html = $temp->get_htm('home_register');
else if  (($value[1]=='phimle'))
$html = $temp->get_htm('home_le');
else $html = $temp->get_htm('home');
$html = $temp->replace_value($html,array(
'web.TITLES'		=>	$web_title,
'web.TITLE'			=>	$web_title_main,
'web.NOKEY'			=>	$web_nokey,
'web.PHIMMOI'		=>	$web_phimmoi,
'web.PHIMMOI1'		=>	$web_phimmoi1,
'web.DES'		    =>	$web_des_main,
'web.KEYWORDS'		=>	$web_keywords_main,
'web.LIST'		    =>	$web_list,
'web.LIST1'		    =>	$web_list1,
'web.CAT'		    =>	$web_cat,
'web.CAT1'		    =>	$web_cat1,
'web.COUN'		    =>	$web_coun,
'web.COUN1'		    =>	$web_coun1,
'web.WATCH'		    =>	$web_watch_main,
'link.URL'			=>	$link_film,
'link.IMG'			=>	$link_img,
'Vote_Menu'			=> 	$vote_menu,
'web.SEO'			=> 	$meta_seo,
'key.SEO'			=> 	$meta_seo,
'web.MOBILE'		=> 	$web_mobile,
'web.email'			=>	$web_email,
'web.TIMKIEM'		=>	$web_timkiem,
'web.TIMKIEM1'		=>	$web_timkiem1,
'web.TAG'			=>	$web_tag,
'web.CATID'			=>	$web_catid,
'web.TAG1'			=>	$web_tag1,
)
);
$html = $temp->replace_blocks_into_htm($html,array(
'main'		=>	$main,
)
);
$temp->print_htm($html);
exit();
?>