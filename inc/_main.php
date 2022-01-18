<?php
if (!defined('IN_MEDIA')) die("Hack");
function textlink() {
	global $temp;
	$main = $temp->get_htm('textlink');
	return $main;
} 
function vote($id=1) {
	global $temp;
	$main = $temp->get_htm('vote'.$id);
	return $main;
} 
function box_header() {
	$html="";
	$header_file = file_get_contents('../header.html');
	$html=$header_file."<script>kgtmenu_selectfunc(13);</script>";
	return $html;
}
function box_footer() {
	$html="";
	$header_file = file_get_contents('../footer.html');
	$html=$header_file;
	return $html;
}
function box_chat() {
	global $temp;
	$main = $temp->get_htm('chatbox');
	return $main;
}
function top_menu() {
	global $temp;
	$main = $temp->get_htm('top_menu');
	return $main;
}
function footer() {
	global $temp;
	$main = $temp->get_htm('footerbox');
	return $main;
}
function box_menu() {
	global $temp;
	$main = $temp->get_htm('menubox');
	return $main;
}
function nav_bar() {
	global $temp;
	$main = $temp->get_htm('navbar');
	return $main;
}
function right_menu() {
	global $temp;
	$main = $temp->get_htm('menuright');
	return $main;
}
function search() {
	global $temp;
	$main = $temp->get_htm('search');
	return $main;
}
function box_ads($file = 'ads',$pos_text= 'right' ){
	global $mysql,$temp,$tb_prefix,$link_href;
	if ($pos_text=='header')      $pos=0;
	if ($pos_text=='footer')      $pos=1;
	if ($pos_text=='topc')        $pos=2;
	if ($pos_text=='center')      $pos=3;
	if ($pos_text=='right1')      $pos=4;//qc Cột phải
	if ($pos_text=='playertren1') $pos=5;//qc trên player1
	if ($pos_text=='playertren2') $pos=6;//qc trên player2
	if ($pos_text=='playerduoi1') $pos=7;//qc dưới player1
	if ($pos_text=='playerduoi2') $pos=8;//qc dưới player2
	if ($pos_text=='right2')      $pos=9;//qc Cột phải
	if ($pos_text=='right3')      $pos=10;//qc Cột phải
	if ($pos_text=='right4')      $pos=11;//qc Cột phải
	if ($pos_text=='htmlcode')    $pos=12;//qc html code
	if ($pos_text=='preload')    $pos=13;//Preload Info 
	$htm = $temp->get_htm($file);
	
	$time_now	=	NOW;
	$time_where	=	"AND ads_time > $time_now";
	
	//Select ADS TEXT
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_pos=".$pos." AND ads_type=0 $time_where ORDER BY ads_id DESC");
	$h['row'] = $temp->get_block_from_htm($htm,$pos_text.'ads.row.text',1);
	if ($mysql->num_rows($q)){
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'ads.URL'  => $r['ads_url'],
			'ads.NAME' => $r['ads_name'],
			'ads.ABOUT' => $r['ads_about'],
			)
			);
			$i++;
		}
	}
	//Select ADS IMG
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_pos=".$pos." AND ads_type=1 $time_where ORDER BY ads_id DESC");
	$h['row'] = $temp->get_block_from_htm($htm,$pos_text.'ads.row.img',1);	
	if ($mysql->num_rows($q)){ 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'ads.URL'  => $r['ads_url'],
			'ads.NAME' => $r['ads_name'],
			'ads.IMG' => $r['ads_img'],
			'ads.ABOUT' => $r['ads_about'],
			'ads.HEIGHT' => $r['ads_height'],
			'ads.WIDTH' => $r['ads_width'],
			)
			);
			$i++;
		}
	}
	//Select ADS SWF
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_pos=".$pos." AND ads_type=2 $time_where ORDER BY ads_id DESC");
	$h['row'] = $temp->get_block_from_htm($htm,$pos_text.'ads.row.swf',1);	
	if ($mysql->num_rows($q)){ 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'ads.URL'  => $r['ads_url'],
			'ads.NAME' => $r['ads_name'],
			'ads.IMG' => $r['ads_img'],
			'ads.ABOUT' => $r['ads_about'],
			'ads.HEIGHT' => $r['ads_height'],
			'ads.WIDTH' => $r['ads_width'],
			)
			);
			$i++;
		}
	}
	//Select ADS HTML
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_pos=".$pos." AND ads_type=3 $time_where ORDER BY ads_id DESC");
	$h['row'] = $temp->get_block_from_htm($htm,$pos_text.'ads.row.embed',1);	
	if ($mysql->num_rows($q)){ 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'ads.EMBED' => text_htmlcode($r['ads_embed']),
			)
			);
			$i++;
		}
	}
	
	$main = $temp->replace_blocks_into_htm($htm,array(
	'ads' 		=> $main
	)
	);
	return $main;
}
#######################################
# HTML TEXT
#######################################
function text_htmlcode($str) {
	return str_replace(array("&amp;", "'", "&quot;", "&lt;", "&gt;"), array("&", "'", '"', "<", ">"), $str);
}
#######################################
# HTML TEXT
#######################################
function top_tags($limit=20) {
	global $mysql,$temp,$tb_prefix,$link_href,$cachedir, $cacheext;
	$link_href=".";
	$cachefile = $cachedir.'cache_tags.'.$cacheext;
	$main = cache_begin($cachefile,7*24*60*60);
	if (!$main)  
	{
		$q = $mysql->query("SELECT tag_name,tag_size FROM ".$tb_prefix."tags ORDER BY tag_view DESC limit $limit");
		$htm = $temp->get_htm('tags');
		$h['row'] = $temp->get_block_from_htm($htm,'tag_menu.row',1);	
		if (!$mysql->num_rows($q)) return ''; 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$tag_size	=	$r['tag_size'];
			if($tag_size >0) {
				$tag_name	=	'<span style="font-size: '.$tag_size.'px">'.$r['tag_name'].'</span>';	
			}else {
				$tag_name	=	$r['tag_name'];	
			}
			$main .= $temp->replace_value($h['row'],
			array(
			'tag.URL' 	=> $web_link.'/tag/'.replace(strtolower($r['tag_name'])).'.html',
			'tag.NAME1' => $r['tag_name'],
			'tag.NAME' 	=> $tag_name
			)
			);
			$i++;
		}
		$main = $temp->replace_blocks_into_htm($htm,array(
		'tag_menu' 		=> $main
		)
		);
		cache_end ($cachefile,$main);
	}
	//echo $list;
	return $main;
}
function cat() {
	global $mysql,$temp,$tb_prefix,$link_href,$cachedir, $cacheext;
	$link_href=".";
	$cachefile = $cachedir.'cache_cat.'.$cacheext;
	$main = cache_begin($cachefile,7*24*60*60);
	if (!$main)  
	{
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."cat ORDER BY cat_order ASC");
		$htm = $temp->get_htm('cat_menu');
		$h['row'] = $temp->get_block_from_htm($htm,'cat_menu.row',1);	
		if (!$mysql->num_rows($q)) return ''; 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'cat.URL' 		=> $web_link.'/'.replace($r['cat_name_ascii']).'.html',
			'cat.NAME'	 	=> $r['cat_name'],
			)
			);
			$i++;
		}
		$main = $temp->replace_blocks_into_htm($htm,array(
		'cat_menu' 		=> $main
		)
		);
		cache_end ($cachefile,$main);
	}
	//echo $list;
	return $main;
}
function user_login() {
	global $mysql,$temp,$tb_prefix,$link_href;
	
	$link_href=".";
	$isLoggedIn=m_checkLogin();
	if ($isLoggedIn) {
		$q = $mysql->query("SELECT user_name,user_fullname,user_avatar FROM ".$tb_prefix."user WHERE user_id = '".$_SESSION['user_id']."'");
		$r = $mysql->fetch_array($q);
		if ($r['user_avatar']=="") $avatar="./no-avatar.gif";
		else $avatar=$r['user_avatar'];
		$htm = $temp->get_htm('user_login');
		$main = $temp->replace_value($htm,array(
		'name' 		=> $r['user_name'],
		'fullname' 		=> $r['user_fullname'],
		'avatar' 		=> $avatar,
		)
		);
	}else{
		$main = $temp->get_htm('user_notlogin');
	}
	return $main;
}
function country() {
	global $mysql,$temp,$tb_prefix,$link_href,$cachedir, $cacheext;
	$link_href=".";
	$cachefile = $cachedir.'cache_country.'.$cacheext;
	$main = cache_begin($cachefile,7*24*60*60);
	if (!$main)  
	{
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."country ORDER BY country_order ASC");
		$htm = $temp->get_htm('country_menu');
		$h['row'] = $temp->get_block_from_htm($htm,'country_menu.row',1);	
		if (!$mysql->num_rows($q)) return ''; 
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$main .= $temp->replace_value($h['row'],
			array(
			'country.URL'  => $web_link.'/phim-'.replace($r['country_name_ascii']).'.html',
			'country.NAME' => $r['country_name'],
			'country.FLAG' => $r['country_flag'],
			'country.TOTAL_FILM' => get_total('film','film_id',"WHERE film_country = '".$r['country_id']."'"),
			)
			);
			$i++;
		}
		$main = $temp->replace_blocks_into_htm($htm,array(
		'country_menu' 		=> $main
		)
		);
		cache_end ($cachefile,$main);
	}
	return $main;
}
function navbar($catzs){
	global $mysql, $temp, $tb_prefix, $link_href, $r_s_img, $value,$cachedir, $cacheext,$film_id;
	$catzs = explode(",",$catzs);
	$breadcrumbs = '<div class="breadcrumbs fjx-top">';
	$breadcrumbs .= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" style="display: inline-block;">';
	$breadcrumbs .= '<a href="'.$web_link.'" title="Xem Phim Online Hay Nhất" itemprop="url"><span itemprop="title">Xem Phim</span></a></div>';
	//$breadcrumbs .= ($film_lb==0?$film_le:$film_bo);
	for ($i=0; $i<count($catz);$i++) {
		$cat_namez	  =	check_year(get_data('cat_name','cat','cat_id',$catz[$i]));
		$breadcrumbs .= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_namez))).'.html" title="'.$cat_namez.'" itemprop="url"><span itemprop="title">'.$cat_namez.'</span></a></div>';
	}
	$breadcrumbs .= '<div class="item last-child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$link_film.'" title="Xem Phim '.$r['film_name'].'" itemprop="url"><span itemprop="title">Phim '.$r['film_name'].'</span></a></div>';
	$breadcrumbs .= '</div>';
	return $breadcrumbs;
}
function film($type, $number = 5, $apr = 1, $cat_id = '', $page = 1) {
	global $mysql, $temp, $tb_prefix, $link_href, $r_s_img, $value,$cachedir, $cacheext,$film_id;
	$link_href=".";
	if (!$page) $page = 1;
	$limit = ($page-1)*$number;
	$cachefile = $cachedir.'cache_'.$type.'_p'.$page.'.'.$cacheext;
	$file_name='list_movie';
	$more_link="";
	if ($type == 'new') {
		$where_sql = ""; $order_sql = "ORDER BY film_date";
		$num = 1; $file_name = 'new_film';
		$more_link=$link_href.'/list/new';
	}
	elseif ($type == 'top') {
		$where_sql = "WHERE film_viewed_day > 0 AND film_cat NOT LIKE \"%16%\" "; $order_sql = "ORDER BY film_viewed_day";
		$num = 2; $file_name = 'top_film';
	}
	elseif ($type == 'bxh-day') {
		$where_sql = "WHERE film_viewed_day > 0 AND film_cat NOT LIKE \"%16%\""; 
		$order_sql = "ORDER BY film_viewed_day";
		$file_name = 'bxh_day';
	}
	elseif ($type == 'bxh-week') {
		$where_sql = "WHERE film_viewed_w > 0 AND film_cat NOT LIKE \"%16%\""; 
		$order_sql = "ORDER BY film_viewed_w";
		$file_name = 'bxh_week';
	}
	elseif ($type == 'bxh-month') {
		$where_sql = "WHERE film_viewed_m > 0 AND film_cat NOT LIKE \"%16%\""; 
		$order_sql = "ORDER BY film_viewed_m";
		$file_name = 'bxh_month';
	}
	elseif ($type == 'rand') {
		$where_sql = "WHERE film_lb = 1"; $order_sql = "ORDER BY RAND()";
		$file_name = 'rand_film';
	}
	elseif ($type == 'rate') {
		$where_sql = "WHERE film_rating_total >= 1"; $order_sql = "ORDER BY film_rating_total";
		$num = 4; $file_name = 'rate_film';
	}
	elseif ($type == 'relate') {
		$cat_id		=	explode(',',$cat_id);
		$cat_id		=	$cat_id[0];
		$where_sql = "WHERE film_cat = $cat_id"; $order_sql = "ORDER BY RAND()";
		$num = 5; $file_name = 'relate_film';
	}
	elseif ($type == 'phimle') {
		$where_sql = "WHERE film_lb = 0"; $order_sql = "ORDER BY film_date";
		$num = 6; $file_name = 'phim_le';
	}
	elseif ($type == 'phimbo') {
		$where_sql = "WHERE film_lb = 1"; $order_sql = "ORDER BY film_date";
		$num = 7; $file_name = 'phim_bo';
	}
	elseif ($type == 'dangchieurap') {
		$where_sql = "WHERE film_type = 2"; $order_sql = "ORDER BY film_date";
		$num = 8; $file_name = 'phim_dang_chieu_rap';
	}
	elseif ($type == 'sapchieurap') {
		$where_sql = "WHERE film_type = 3"; $order_sql = "ORDER BY film_date";
		$num = 9; $file_name = 'phim_sap_chieu_rap';
	}	
	elseif ($type == 'decu') {
		$where_sql = "WHERE film_type = 1"; $order_sql = "ORDER BY film_date";
		$num = 10; $file_name = 'phim_de_cu';
	}
	elseif ($type == 'filmrequest') {
		$where_sql = "WHERE film_request = 1"; $order_sql = "ORDER BY film_date";
		$num = 13; $file_name = 'phim_yeu_cau';
		$file_title = 'PHIM YÊU CẦU';
	}
	elseif ($type == 'phimcap3') {
		$where_sql = "WHERE film_type = 4"; $order_sql = "ORDER BY film_date";
		$num = 14; $file_name = 'phim_cap3';
	}
	elseif ($type == 'phimbovietnam') {
		$where_sql = "WHERE film_country = 1 AND film_lb = 1"; $order_sql = "ORDER BY film_date";
		$num = 15; $file_name = 'phim_bo_vietnam';
	}
	elseif ($type == 'phimbohanquoc') {
		$where_sql = "WHERE film_country = 3 AND film_lb = 1"; $order_sql = "ORDER BY film_date";
		$num = 16; $file_name = 'phim_bo_hanquoc';
	}
	elseif ($type == 'phimbomyaa') {
		$where_sql = "WHERE film_country = 5 AND film_lb = 1"; $order_sql = "ORDER BY film_date";
		$num = 17; $file_name = 'phim_bo_my';
	}
	elseif ($type == 'phimbotrungquoc') {
		$where_sql = "WHERE film_country = 2 AND film_lb = 1"; $order_sql = "ORDER BY film_date";
		$num = 18; $file_name = 'phim_bo_trungquoc';
	}
	elseif ($type == 'topphimbo') {
		$where_sql = "WHERE film_country = $cat_id AND film_lb = $apr"; $order_sql = "ORDER BY film_date";
		$num = 19; $file_name = 'topphimbo';
	}
	if ($type == 'top') $main = cache_begin($cachefile,5*60);
	else $main = cache_begin($cachefile,10*60);
	if (!$main)  
	{
		$htm = $temp->get_htm($file_name);
		$h['end_tag'] = $temp->get_block_from_htm($htm,$file_name.'.end_tag',1);
		$h['row'] = $temp->get_block_from_htm($htm,$file_name.'.row',1);
		$query = $mysql->query("SELECT * FROM ".$tb_prefix."film $where_sql $order_sql DESC LIMIT ".$limit.",$number");
		$total = get_total("film","film_id","$where_sql $order_sql");
		if (!$mysql->num_rows($query) || ($type == 'dangchieurap' && $value[1]!='')  || ($type == 'sapchieurap' && $value[1]!='') || ($type == 'rate' && $value[1]!='')) return ''; 
		$i = 0;
		while ($rs = $mysql->fetch_array($query)) {
			$j = $j +1;
			$film_img = check_img(replaceimg($rs['film_img']));
			$film_year = check_data($rs['film_year']);
			$film_time = check_data($rs['film_time']);
			$film_imgbn = check_data($rs['film_imgbn']);
			$film_area = check_data($rs['film_area']);
			$film_tapphim = check_data($rs['film_tapphim']);
			$film_like = check_data($rs['film_like']);
			$film_director = check_data($rs['film_director']);
			$film_actor = check_data($rs['film_actor']);
			$film_name_real = check_data($rs['film_name_real']);
			$cat=$rs['film_cat'];
			$film_cat="";
			for ($i=0; $i<count($cat);$i++) {
				$cat_name1= check_data(get_data('cat_name','cat','cat_id',$cat[$i]));
				$cat_name = check_data(get_data('cat_name','cat','cat_id',$rs['film_cat']));
				$film_cat .= '<a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_name))).'.html'.'" >'.$cat_name.'</a>,';
			}
			// film tap
			$film_tapphim = $rs['film_tapphim'];
			if ((strlen($film_tapphim)) > 1){
				$tapphim = $film_tapphim;
			}else{
				$tapphim = 'SD';
			}
			// film tap
			// film film_name_real
			$gach = '';
			$knam = $film_year;
			if ((strlen($film_name_real)) > 1){
				$gach = ' - ';
				$knam = replace(strtolower($rs['film_name_real']));
			}
			// film film_name_real
			$str_url = text_tidy( $rs['film_info']);
			$str_url = strip_tags($str_url);
			$info_cut = get_words($str_url,50);
			$info_cut2 = get_words($str_url,8);
			$namefilm_cut = get_words($rs['film_name'],6);
			rating_img($rs['film_rating'],$rs['film_rating_total']);
			$rater_stars_img = $r_s_img;
			rating_img($rs['film_rating'],$rs['film_rating_total'],3);
			$rater_stars_img1 = $r_s_img;
			if ($h['start_tag'] && fmod($i,$apr) == 0) $main .= $h['start_tag'];
			++$z;
			$class_top	=	$class_bxh1	=	$class_bxh2	=	'';
			if(($z%2)==1) {
				$class_top	=	'class="o"';
			}
			if($z==1) {
				$class_bxh1	=	'f';
			}
			if($z==1||$z==2||$z==3) {
				$class_bxh2	=	't';
			}
			$main .= $temp->replace_value($h['row'],
			array(
			'class'				=>	$class_top,
			'class_bxh1'		=>	$class_bxh1,
			'class_bxh2'		=>	$class_bxh2,
			'film.ID'			=> $rs['film_id'],
			'film.URL'			=> $web_link.'/phim-'.replace($rs['film_name_ascii']).'.vc'.replace($rs['film_id']).'.html',
			'film.NAMEVN'		=> get_words($rs['film_name'],20),
			'film.CUT_NAME'		=> get_words($rs['film_name'],6),
			'film.CUT_NAME2'	=> get_words($rs['film_name'],20),
			'film.NAMEEN'		=> get_words($rs['film_name_real'],20),
			'film.VN'			=> $rs['film_name'],
			'film.EN'			=> $rs['film_name_real'],
			'film.NAME'			=> $rs['film_name'].''.$gach.''.$rs['film_name_real'],
			'film.ACTOR'		=> $film_actor,
			'film.DIRECTOR'		=> $film_director,
			'film.IMGBN'		=> $film_imgbn,
			'film.INFO'			=>   $info_cut,
			'film.INFO2'		=>   $info_cut2,
			'film.YEAR'			=> $film_year,
			'film.HD'			=> $tapphim,
			'film.CHATLUONG'	=> $chatluong,
			'film.TAP'			=> $tapphim,
			'film.TAPPHIM'		=> $tapphim,
			'film.THUMB'		=> check_img($rs['film_thumb']),
			'film.TIME'			=> $film_time,
			'film.AREA'			=> $film_area,
			'film.CAT'			=>  $cat_name,
			'film.STT'			=>  $z,
			'film.LIKE'			=>  $film_like,
			'film.VIEWED' 		=> $rs['film_viewed'],
			'film.VIEWED_DAY' 	=> $rs['film_viewed_day'],
			'film.VIEWED_WEEK'	=>	$rs['film_viewed_w'],
			'film.VIEWED_MONTH'	=>	$rs['film_viewed_m'],
			'film.IMG'			=> check_img(replaceimg($rs['film_img'])),
			'rate.IMG'			=>	$rater_stars_img,
			'rate.IMG1'			=>	$rater_stars_img1,
			'rate.VIEWED'		=>	$rs['film_rating_total'],
			)
			);
			if ($h['end_tag'] && fmod($i,$apr) == $apr - 1) $main .= $h['end_tag'];
			$i++;
		}
		if ($h['end_tag'] && fmod($i,$apr) != $apr - 1) $main .= $h['end_tag'];
		$main = $temp->replace_blocks_into_htm($htm,array(
		'film_menu' 		=> $main,
		)
		);
		$main = $temp->replace_value($main,array(
		'Top.FILM'			=> $file_title,
		'TOTAL'				=> $total,
		'film.ID'			=> $film_id,
		'cat.ID'			=> $cat_id,
		'film.MORE_LINK'	=> $more_link,
		'value1'				=> 'relate',
		'pages.FILM'		=> view_pages('film',$total,$number,$page,$num,$apr,$cat_id),
		)
		);
		cache_end ($cachefile,$main);
	}
	return $main;
}
function news($num=10,$apr=1) {
	global $mysql, $temp, $tb_prefix,$link_href;
	$link_href=".";
	$file_name = 'news';
	$htm = $temp->get_htm($file_name.'_menu');
	$h['end_tag'] = $temp->get_block_from_htm($htm,'news_menu.end_tag',1);
	$h['row'] = $temp->get_block_from_htm($htm,'news_menu.row',1);
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."news ORDER BY news_id DESC LIMIT $num");
	$i = 0;
	while ($rs = $mysql->fetch_array($q)) {
		if ($h['start_tag'] && fmod($i,$apr) == 0) $main .= $h['start_tag'];
		$main .= $temp->replace_value($h['row'],
		array(
		'news.ID'			=> $rs['news_id'],
		'news.URL'			=> $link_href."/tin-tuc/".replace($rs['news_name_ascii'])."/".$rs['news_id'].'.html',
		'news.CUT_NAME'		=> $rs['news_name'],
		'news.NAME'		=> $rs['news_name'],
		'news.IMG'			=> check_img($rs['news_img']),
		)
		);
		if ($h['end_tag'] && fmod($i,$apr) == $apr - 1) $main .= $h['end_tag'];
		$i++;
	}
	if ($h['end_tag'] && fmod($i,$apr) != $apr - 1) $main .= $h['end_tag'];
	$main = $temp->replace_blocks_into_htm($htm,array(
	'news_menu' 		=> $main
	)
	);
	return $main;
}
function announcement() {
	global $mysql, $temp, $tb_prefix,$cachedir, $cacheext;
	$cachefile = $cachedir.'cache_announcement.'.$cacheext;
	$main = cache_begin($cachefile,7*24*60*60);
	if (!$main)  
	{
		$htm = $temp->get_htm('announcement');
		$contents = get_data('cf_announcement','config','cf_id',1);
		$contents = text_tidy($contents);
		if (!$contents) return '';
		$main .= $temp->replace_value($htm,
		array(
		'ann.CONTENT'	=>	$contents,
		)
		);
		cache_end ($cachefile,$main);
	}
	return $main;
}
function comment($number,$file_name = 'new_comment') {
	global $mysql, $temp, $tb_prefix,$link_href;
	$result = $mysql->query("SELECT *  FROM ".$tb_prefix."comment ORDER BY comment_id DESC");
	$main = $temp->get_htm($file_name);
	$t['link'] = $temp->get_block_from_htm($main,$file_name.'.row',1);
	$n = 0;
	$num = 0;
	$limit = $mysql->num_rows($result);
	if (!$mysql->num_rows($result))  return ''; 
	else
	while ($n < $limit) {
		$r = $mysql->fetch_array($result);
		$n++;
		$comment_film_id_now = " ".$r['comment_film']." ";
		if (!ereg("$comment_film_id_now","$list_comment_film_id_pre")) {
			$result2 = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = '".$r['comment_film']."' ORDER BY film_id ASC");
			$r2 = $mysql->fetch_array($result2);
			$film_cut_name = get_words($r2['film_name'],5);
			$film_name = $r2['film_name'];
			$film_name_ascii = replace($r2['film_name_ascii']);
			
			$content = emotions_replace(bad_words(un_htmlchars(del_HTML(text_tidy($r['comment_content'], 500, 1)))));  if ($content) {
				$num++;
				$comment_film_id_pre = $r['comment_film'];
				$list_comment_film_id_pre = $list_comment_film_id_pre." ".$r['comment_film']." ";
				$level="";
				$color="";
				$group="";
				$level=get_data('user_level','user','user_name',$r['comment_poster']);
				$avatar=get_data('user_avatar','user','user_name',$r['comment_poster']);
				if ($avatar=="") $avatar='./no-avatar.gif';
				if ($level){ 	
					$level_name=get_data('user_level_name','user_level','user_level_type',$level);
					$color=get_data('user_level_color','user_level','user_level_type',$level);
					$group=get_data('user_level_group','user_level','user_level_type',$level);
					$url=$link_href.'/members/home/'.$r['comment_poster'].'.html';
				}else{//Non Member
					$color = '#FFF';
					$group='http://xemphimon.com/group/nomem.gif';
					$url="javascript:alert('Không phải thành viên site')";
				}
				$html .= $temp->replace_value($t['link'],
				array(			
				'film.URL'		=> $link_href."/phim-".$film_name_ascii."-".replace($r['comment_film']).'.html',
				'comment.POSTER'	=>	trim(bad_words(htmlspecialchars_decode($r['comment_poster']))),
				'comment.CONTENT'	=>	$content,
				'comment.ID'	=>	$r['comment_id'],
				'comment.COLOR'	=>	$color,
				'comment.GROUP'	=>	$group,
				'comment.AVATAR'	=>	$avatar,
				'comment.URL'	=>	$url,
				'film.CUT_NAME'	=>	$film_cut_name,
				'film.NAME'	=>	$film_name,
				)
				);
				if ( $number - 1 < $num ) $n = $limit + 10;
			}
			
		}
	}
	$main = $temp->replace_blocks_into_htm($main,array(
	$file_name	=>	$html
	)
	
	);
	return $main;
}
function write_comment($num=10,$film_id,$page){
	global $mysql,$tb_prefix,$temp,$isLoggedIn, $web_link; 
	if (!$page) $page = 1;
	$limit = ($page-1)*$num;
	$main = $temp->get_htm('comment');	
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."comment WHERE comment_film = $film_id ORDER BY comment_time DESC LIMIT ".$limit.",$num");
	$total = get_total("comment","comment_id","WHERE comment_film = $film_id");
	if ($total) {
		$comment_block = $temp->get_block_from_htm($main,'comment_block');
		$comment = $temp->get_block_from_htm($comment_block,'comment',1);		
		$html = '';
		$unset = false;
		$i = 0;
		while ($r = $mysql->fetch_array($q)) {
			$i++;
			$level="";
			$color="";
			$group="";
			$content = emotions_replace(un_htmlchars(text_tidy(del_HTML(bad_words($r['comment_content'])))));
			$level=get_data('user_level','user','user_name',$r['comment_poster']);
			$avatar=get_data('user_avatar','user','user_name',$r['comment_poster']);
			if ($avatar=="") $avatar='./no-avatar.gif';
			if ($level){
				$level_name=get_data('user_level_name','user_level','user_level_type',$level);
				$color=get_data('user_level_color','user_level','user_level_type',$level);
				$group=get_data('user_level_group','user_level','user_level_type',$level);
				$url=$link_href.'/members/home/'.$r['comment_poster'].'.html';
			}
			else{//Non Member
				$color = '#FFF';
				$group='http://xemphimon.com/group/nomem.gif';
				$url="javascript:alert('Không phải thành viên site')";
			}
			$html .= $temp->replace_value($comment,
			array(
			'comment.POSTER'	=>	trim(bad_words(htmlspecialchars_decode($r['comment_poster']))),
			'comment.TIME'		=>	date('d-m-Y',$r['comment_time']),
			'comment.CONTENT'	=>	$content,
			'comment.COLOR'	=>	$color,
			'comment.GROUP'	=>	$group,
			'comment.AVATAR'	=>	$avatar,
			'comment.URL'	=>	$url,
			'comment.ID'	=>	$r['comment_id'],
			)
			);
		}
	}
	else $html = '&nbsp;&nbsp;Chưa có cảm nhận nào. Cảm nhận của bạn sẽ là <b>cảm nhận đầu tiên</b> đấy nhé!';
	if (!$isLoggedIn){
		$check_login_value="<div id='comments'>
<p class='warn'>Bạn cần đăng nhập mới có thể viết được cảm nhận. <a href='./members/login.html'>Nhấn vào đây để đăng nhập</a> hoặc <a href='./members/register.html'>nhấn vào đây để đăng kí thành viên</a>.</p><br/></div>";
		$check_login_name="Tên của bạn";
		$show='';
	}else{
		$check_login_name=$_SESSION['user_name'];
		$show='none';
	}
	$main = $temp->replace_blocks_into_htm($main,
	array(
	'comment_block'	=>	$html,
	)
	);
	$main = $temp->replace_value($main,
	array(
	'film.ID'	=>	$film_id,
	'film.NAME' => get_data("film_name","film","film_id","$film_id"),
	'limit.COMMENT'	=>	$num,
	'check_value' =>$check_login_value,
	'check_name' =>$check_login_name,
	'show' =>$show,
	'pages.COMMENT' => view_pages('comment',$total,$num,$page,$film_id),
	)
	);
	return $main;
} 
function dienvien($page=1) {
	global $mysql, $temp,$page_actor, $tb_prefix,$link_href;
	$limit 		= ($page-1)*$page_actor;
	$htm 		= $temp->get_htm('dien_vien_box');
	$h['row'] 	= $temp->get_block_from_htm($htm,'dien_vien_box.row',1);
	
	$q 			= $mysql->query("SELECT actor_name,actor_name1,actor_name_kd,actor_birthday,actor_location,actor_img,actor_info 
						FROM ".$tb_prefix."dienvien ORDER BY actor_id ASC LIMIT ".$limit.",".$page_actor);
	$ttrow 		= get_total("dienvien","actor_id","ORDER BY actor_id ASC");
	$nump 		= ceil($ttrow/$page_actor);
	if($nump>$page)
	$pages	=	'{***}<a class="btn btn-primary" href="javascript:dienvien('.($page+1).')" id="show-actor-click">Xem Thêm</a>';
	
	while ($rs = $mysql->fetch_array($q)) {
		$main .= $temp->replace_value($h['row'],
		array(
		'actor_name'			=> $rs['actor_name'],
		'actor_name1'			=> $rs['actor_name1'],
		'actor_birthday'		=> $rs['actor_birthday'],
		'actor_location'		=> $rs['actor_location'],
		'actor_img'				=> $rs['actor_img'],
		'actor_info'			=> $rs['actor_info'],
		'actor_url'				=> 'dien-vien/phim-'.$rs['actor_name_kd'].'.html',
		)
		);
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
	'dien_vien_box' 		=> $main
	)
	);
	$main = $temp->replace_value($main,
	array(
	'pages_number'		=> $pages
	)
	);
	return $main;
}
function film_dienvien($key='',$page=1,$number=15) {
	global $mysql, $temp, $tb_prefix, $link_href;
	if (!$page) $page = 1;
	$limit = ($page-1)*$number;
	$htm = $temp->get_htm("dien_vien_film");
	$h['row'] = $temp->get_block_from_htm($htm,'dien_vien_film.row',1);
	$keyz	=	str_replace("-"," ",$key);	
	$keyz	=	htmlchars(stripslashes($keyz));
	$where_sql	=	"WHERE film_actor_ascii LIKE '%$keyz%'  OR film_tag_ascii LIKE '%$keyz%'";
	$order_sql	=	"ORDER BY film_id DESC";
	$q		 	= $mysql->query("SELECT * FROM ".$tb_prefix."film $where_sql $order_sql LIMIT ".$limit.",$number");
	$ttrow 		= get_total("film","film_id", "$where_sql $order_sql");
	$nump 		= ceil($ttrow/$number);
	if($nump>$page) {
		$pagesA	=	'<a class="btn btn-primary" onclick="return filmdienvien(\''.$key.'\','.($page+1).');" href="#" id="show-film-click">Xem Thêm</a>';
	}
	while ($rs = $mysql->fetch_array($q)) {
		$cat		=	$rs['film_cat'];
		$film_cat	=	",";
		for ($i=0; $i<count($cat);$i++) {
			$cat_name1= check_data(get_data('cat_name','cat','cat_id',$cat[$i]));
			$cat_name = check_data(get_data('cat_name','cat','cat_id',$rs['film_cat']));
			$film_cat .= '<a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_name))).'/.html'.'" >'.$cat_name.'</a>,';
		}
		$film_cat	=	substr($film_cat,0,-1);
		$knam = $film_year;
		if ((strlen($rs['film_name_real'])) > 1){
			$knam = replace(strtolower($rs['film_name_real']));
		}
		// film tap
		$tapphim = '';
		$film_tapphim 	= 	$rs['film_tapphim'];
		$film_year		=	$rs['film_year'];	
		if ((strlen($film_tapphim)) > 1){
			$tapphim = $film_tapphim;
		}else{
			$tapphim = 'SD';
		}
		$main .= $temp->replace_value($h['row'],
		array(
		'film.HD'		=> $tapphim,
		'film.TAPPHIM'		=> $tapphim,
		'film.YEAR'		=> $film_year,
		'film.VIEWD'	=> $rs['film_viewed'],
		'film.CUT_NAME'		=> get_words($rs['film_name'],8),
		'film.CUT_NAME1'	=> get_words($rs['film_name_real'],10),
		'film.CUT_NAME2'	=> get_words($rs['film_name'],3),
		'film.CAT'			=> $cat_name,
		'film.ID'			=> $rs['film_id'],
		'film.IMG'			=> check_img(replaceimg($rs['film_img'])),
		'film.URL'			=> $web_link.'/phim-'.replace($rs['film_name_ascii']).'.vc'.replace($rs['film_id']).'.html'
		)
		);
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
	'dien_vien_film' 		=> $main,
	)
	);
	$main = $temp->replace_value($main,array(
	'pageA'		=>	$pagesA
	)
	);
	return $main;
}
?>