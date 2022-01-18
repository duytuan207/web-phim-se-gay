<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$menu_arr = array(
	'cat'	=>	array(
		'THỂ LOẠI',
		array(
			'edit'	=>	array('Danh Sách Thể Loại','act=cat&mode=edit'),
			'add'	=>	array('Thêm Thể Loại','act=cat&mode=add'),
		),
	),
	'country'	=>	array(
		'QUỐC GIA',
		array(
			'edit'	=>	array('Danh Sách Quốc Gia','act=country&mode=edit'),
			'add'	=>	array('Thêm Quốc Gia','act=country&mode=add'),
		),
	),
	'film'	=>	array(
		'DANH SÁCH PHIM',
		array(
			'add_episode'	=>	array('Thêm Phim','act=episode&mode=multi_add'),
			'add_episodes'	=>	array('Multi Phim','act=clipvn'),
			'edit'	=>	array('Danh Sách Phim','act=film&mode=edit'),
			'edit_broken'	=>	array('Phim Lỗi','act=film&mode=edit&show_broken=1'),
			'edit_phimle'	=>	array('Phim Lẻ','act=film&mode=edit&show_film_lb=0'),
			'edit_phimbo'	=>	array('Phim Bộ','act=film&mode=edit&show_film_lb=1'),
			'edit_dangchieurap'	=>	array('PHIM ĐANG CHIẾU RẠP','act=film&mode=edit&show_film_type=2'),
			'edit_sapchieurap'	=>	array('PHIM SẮP CHIẾU RẠP','act=film&mode=edit&show_film_type=3'),
			'edit_decu'	=>	array('Phim Đề Cử','act=film&mode=edit&show_film_type=1'),
			'add_request'	=>	array('Yêu Cầu Phim','act=request&mode=edit'),
		),
	),
	'dienvien'	=>	array(
		'DIỄN VIÊN',
		array(
			'lech'	=>	array('Lech Diễn Viên','act=lech_dienvien'),
			'edit'	=>	array('Danh Sách Diễn Viên','act=dienvien&mode=edit'),
			'add'	=>	array('Thêm Diễn Viên','act=dienvien&mode=add'),
		),
	),
	'contact'	=>	array(
		'Mail to all',
		array(
			'add_episodesz'	=>	array('Gởi Mail2','act=sendmail2'),
			//'pm'	=>	array('Gửi tin nhắn','act=contact&mode=pm'),
			'email'	=>	array('Gửi Email','act=contact&mode=email'),
		),
	),
	'webmail'	=>	array(
		'Add Mail',
		array(
			'add'	=>	array('Add Mail','act=webmail&mode=add'),
			'email'	=>	array('Edit Email','act=webmail&mode=edit'),
		),
	),
	'news'	=>	array(
		'Tin Tức',
		array(
			'edit'	=>	array('Danh Sách Tin Tức','act=news&mode=edit'),
			'add'	=>	array('Thêm Tin Tức','act=news&mode=add'),
		),
	),
	'user'	=>	array(
		'THÀNH VIÊN',
		array(
			'edit'	=>	array('Danh Sách Thành Viên','act=user&mode=edit'),
			'edit_ban'	=>	array('Danh Sách Đen','act=user&mode=edit&user_ban=1'),
			'edit_level'	=>	array('Danh sách bậc thành viên','act=user&mode=edit_level'),
			'add'	=>	array('Thêm Thành Viên','act=user&mode=add'),
			'add_level'	=>	array('Thêm bậc thành viên','act=user&mode=add_level'),
		),
	),
	'link'	=>	array(
		'LIÊN KẾT - ADS',
		array(
			'edit'	=>	array('Danh Sách Quảng Cáo','act=ads&mode=edit'),
			'add'	=>	array('Thêm Quảng Cáo','act=ads&mode=add'),
		),
	),
	'skin'	=>	array(
		'GIAO DIỆN',
		array(
			'edit'	=>	array('Danh Sách Giao Diện','act=skin&mode=edit'),
			'add'	=>	array('Thêm Giao Diện','act=skin&mode=add'),
		),
	),
	'config'	=>	array(
		'CẤU HÌNH',
		array(
			'config'		=>	array('Cấu Hình','act=config'),
			'permission'	=>	array('Quyền Hạn','act=permission'),
			'local'			=>	array('Server','act=local'),
			'Mod_ponit'		=>	array('Kiểm soát','act=user&mode=edit&point=yes'),	
		),
	)
);
if ($level == 2) {

	unset($menu_arr['config']);
	unset($menu_arr['user']);
	unset($menu_arr['contact']);
	foreach ($menu_arr as $key => $v) {
		if (!$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add']);
		if (!$mod_permission['edit_'.$key]) unset($menu_arr[$key][1]['edit']);
		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_episode']);
		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_request']);
		if ($key == 'film' && !$mod_permission['edit_'.$key]) unset($menu_arr[$key][1]['edit_broken']);
		if ($key == 'film' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['edit_trailer']);
		if ($key == 'episode' && !$mod_permission['add_'.$key]) unset($menu_arr[$key][1]['add_multi']);
		if (!$menu_arr[$key][1]) unset($menu_arr[$key]);
	}
}
echo "<div><a href='index.php?act=main'><b>MAIN</b></a> || <a href='logout.php'><b>LOGOUT</b></a></div>";
foreach ($menu_arr as $key => $arr) {
	echo "<table cellpadding=2 cellspacing=0 width=100% class=border style='margin-bottom:5'>";
	echo "<tr><td class=title><b>".$arr[0]."</b></td></tr>";
	foreach ($arr[1] as $m_key => $m_val) {
		echo "<tr><td><font class=\"sub\">¤</font> <a href=\"?".$m_val[1]."\">".$m_val[0]."</a></td></tr>";
	}
	echo "</table>";
}
echo "<div class=footer><b>Cover By Mr.Hung</b></div>";
?>