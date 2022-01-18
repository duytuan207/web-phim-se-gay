<?php
if (!defined('IN_MEDIA')) die("Hack");
if ($value[2] == 'phim') {
	$dienvien	=	replace($value[3]);
	$q 			= $mysql->query("SELECT * FROM ".$tb_prefix."dienvien WHERE actor_name_kd = '$dienvien'");
	$rs 		= $mysql->fetch_array($q);
	$htm 		= $temp->get_htm('dien_vien_info');
	$breadcrumbs	= '<div class="breadcrumbs">';
	$breadcrumbs	.= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'" title="Xem Phim Online, Xem phim HD nhanh" itemprop="url"><span itemprop="title">Xem Phim</span></a></div>';
	$breadcrumbs	.= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/dien-vien.html" title="Danh Sách Diễn Viên" itemprop="url"><span itemprop="title">Danh Sách Diễn Viên</span></a></div>';
	$breadcrumbs	.= '<h2 class="item last-child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><span title="'.$rs['actor_name'].'" itemprop="title">'.$rs['actor_name'].'</span></h2>';
	$breadcrumbs	.= '</div>';
	$main 		= $temp->replace_value($htm,array(
					'actor_name'			=> $rs['actor_name'],
					'actor_name1'			=> $rs['actor_name1'],
					'actor_birthday'		=> $rs['actor_birthday'],
					'actor_location'		=> $rs['actor_location'],
					'BREADCRUMBS'			=> $breadcrumbs,
					'actor_height'			=> $rs['actor_height'],
					'actor_img'				=> $rs['actor_img'],
					'actor_movie'			=> $rs['actor_movie'],
					'actor_info'			=> un_htmlchars($rs['actor_info']),
					'film_dien_vien'		=> film_dienvien($rs['actor_name_kd']),
					'actor_url'				=> 'dien-vien/phim-'.$rs['actor_name_kd'].'.html',
		)
	);
	$web_imgfilm 		= 	$link_img =	$rs['actor_img'];
	$link_film			=	$web_link.'/dien-vien/phim-'.$rs['actor_name_kd'].'.html';
	$web_title_main 	= 	'Diễn Viên '.$rs['actor_name'].', Các Phim Diễn Viên '.$rs['actor_name'].' '.date("Y").'';
	$web_keywords_main	=	$rs['actor_name'].', Phim '.$rs['actor_name'].', Xem Phim '.$rs['actor_name'].', Xem Phim Diễn Viên '.$rs['actor_name'];
	$web_des_main		=	"Xem Phim ".$rs['actor_name']." ".date("Y").":".get_words(del_HTML(un_htmlchars($rs['actor_info'])),180);
}else {
	$q 			= $mysql->query("SELECT actor_name,actor_name1,actor_name_kd,actor_birthday,actor_location,actor_img,actor_info 
						FROM ".$tb_prefix."dienvien ORDER BY actor_id ASC LIMIT $page_actor");
	$ttrow 		= get_total("dienvien","actor_id","ORDER BY actor_id ASC");
	$nump 		= ceil($ttrow/$page_actor);
	if($nump>1)	
	$pages	=	'<a href="javascript:dienvien(2)" id="show-actor-click">Xem thêm</a>';					
	$htm 		= $temp->get_htm('dien_vien_list');
	$breadcrumbs	= '<div class="breadcrumbs">';
	$breadcrumbs	.= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'" title="Xem Phim Online, Xem phim HD nhanh" itemprop="url"><span itemprop="title">Xem Phim</span></a></div>';
	$breadcrumbs	.= '<h2 class="item last-child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><span title="Danh Sách Diễn Viên" itemprop="title">Danh Sách Diễn Viên</span></h2>';
	$breadcrumbs	.= '</div>';
	$h['row'] 	= $temp->get_block_from_htm($htm,'row',1);
	while ($rs 	= $mysql->fetch_array($q)) {
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
		'actor_list' 		=> $main
		)
	);
	$main = $temp->replace_value($main,
		array(
			'pages_number'		=> $pages,
			'BREADCRUMBS'			=> $breadcrumbs,
		)
	);
	$web_title_main 	= 	$web_keywords_main	=	"Danh Sách Diễn Viên";
	$link_film 			=   $web_link.'/dien-vien.html';
}
?>