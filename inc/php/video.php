<?php
if (!defined('IN_MEDIA')) die("Hack");
if ($value[1] == 'video') {
	$h1title	=	'Video hài hước, video vui nhộn nhất 2013';
	$link_page	=	'video-moi';
	$page 		= 	$value[2];
	if ($value[2] == 'cat') {
		$cat_asii	=	str_replace('-',' ',$value[3]);
		$cat_asii	=	strtolower(get_ascii($cat_asii));
		$page		=	$value[4];
		$q 			= 	$mysql->query("SELECT cat_id,cat_name FROM ".$tb_prefix."video_cat WHERE cat_name_ascii = '$cat_asii' LIMIT 1");
		$cz 		= 	$mysql->fetch_array($q);
		$sql_where	=	"WHERE v_cat = '".$cz['cat_id']."'";
		$h1title	=	'Video '.$cz['cat_name'];
		$link_page	=	'/video-'.$value[3];
	}
	$htm 		= $temp->get_htm('video_list');
	
	$page_size 	= 30;
	if (!$page) $page = 1;
	$limit = ($page-1)*$page_size;
	
	$q 			= $mysql->query("SELECT * FROM ".$tb_prefix."video $sql_where ORDER BY v_id DESC LIMIT ".$limit.",".$page_size);
	$total 		= get_total("video","v_id","ORDER BY v_id DESC");
	
	$h['row'] 	= $temp->get_block_from_htm($htm,'row',1);
	while ($rs 	= $mysql->fetch_array($q)) {
		$main .= $temp->replace_value($h['row'],
				array(
					'v_title'		=> 		$rs['v_title'],
					'v_img'			=> 		img_youtube($rs['v_url']),
					'v_time'		=> 		time_youtube($rs['v_time']),
					'v_view'		=> 		$rs['v_view'],
					'v_url'			=> 		'/video-'.replace(strtolower($rs['v_title'])).'.'.$rs['v_id'].'.html',
				)
			);
	}
	
	$main = $temp->replace_blocks_into_htm($htm,array(
		'video_list' 		=> $main
		)
	);
	$main = $temp->replace_value($main,
		array(
			'title.NAME'		=>	$h1title,
			'VIEW_PAGES'		=> 	view_pages('film',$total,$page_size,$page,$link_page),

		)
	);
	
	$web_title_main 	= 	$h1title;
	$web_des_main		=	"video hài hước, video vui nhộn, video 18+, video thể thao, video âm nhạc, video phóng sự";
	$web_keywords_main	=	"tổng hợp các video clip hài hước vui nhộn nhất, từ thể thao -  âm nhạc - phiêu lưu mạo hiểm - phóng sự luôn được cập nhật giúp các bạn thư giản.";
}
elseif ($value[1] == 'vplay') {
	$v_id		=	intval($value[3]);
	$main 		= 	$temp->get_htm('video_play');
	$mysql->query("UPDATE ".$tb_prefix."video SET v_view = v_view+1 WHERE v_id = '$v_id'");
	$q 			= 	$mysql->query("SELECT * FROM ".$tb_prefix."video WHERE v_id = '$v_id'");
	$r	 		= 	$mysql->fetch_array($q);
	
	$link_film	=	'http://phim1v.com/video-'.replace(strtolower($r['v_title'])).'.'.$r['v_id'].'.html';
	$link_img	=	img_youtube($r['v_url']);
	$main = $temp->replace_value($main,
		array(
			'title.NAME'	=>		$r['v_title'],
			'v_url'			=>		str_replace('http://www.youtube.com/watch?v=','http://www.youtube.com/embed/',$r['v_url']),
			'v_img'			=> 		$link_img,
			'v_time'		=> 		time_youtube($rs['v_time']),
			'v_info'		=>		($r['v_info']?'<div class="info_video">'.html_entity_decode($r['v_info'],ENT_QUOTES, 'UTF-8').'</div>':""),
			'm_url'			=> 		$link_film
		)
	);
	
	$web_title_main 	= 	'Xem video '.$r['v_title'];
	$web_keywords_main	=	'Xem video '.$r['v_title'].', video '.$r['v_title'].' hay, video '.$r['v_title'].' mới 2013';
	$web_des_main		=	($r['v_info']?html_entity_decode($r['v_info'],ENT_QUOTES, 'UTF-8'):$web_keywords_main);
	$web_imgfilm 		= 	img_youtube($r['v_url']);
}
?>