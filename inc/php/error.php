<?php
if (!defined('IN_MEDIA')) die("Hack");
	$htm = $temp->get_htm('error');
	$main= $temp->replace_value($htm,
		array(
				'ERROR'			=> "Phần này chưa có dữ liệu hoặc đã bị xóa khỏi hệ vì bản quyền.<br>
										Xin lỗi về sự bất tiện này.",
		)
	);
	$web_title_main 	= 	$web_keywords_main	=	$web_des_main		=	"Thông Báo Lỗi";
	$meta_seo = "<h1 class='meta_title'><a href='".$web_link."' title='Xem Phim'>Xem Phim</a></h1>";
?>