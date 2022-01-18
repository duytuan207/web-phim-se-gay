<?php
if (!defined('IN_MEDIA')) die("Hack");
if ($_POST['request']) {
	$security 		= 	intval($_POST['sec_num']);
	$request_content 	= 	urldecode($_POST['request_content']);
	if (!$security || $security != $_SESSION['antifloodimage'] || !$_SESSION['antifloodimage']) {
		echo ('Mã bảo vệ không đúng.');exit();
	}
	if ($request_content){
		$mysql->query("INSERT INTO ".$tb_prefix."request (request_content,request_time) 
													VALUES ('$request_content','".NOW."')");
		unset($_SESSION['antifloodimage']);
		echo 1;
	}
	exit();
}
elseif ($_POST['dienvien']) {
	$page	=	intval($_POST['page']);
  	echo dienvien($page);
	exit();
}
elseif ($_POST['filmdienvien']) {
	$key 	= 	$_POST['key'];
	$page	=	intval($_POST['page']);
  	echo 		film_dienvien($key,$page);
	exit();
}
elseif ($_POST['tooltip']) {
	$film_id	=	intval($_POST['film_id']);
	$showimg	=	intval($_POST['showimg']);
	$r 			= 	$mysql->fetch_array($mysql->query("SELECT film_name,film_name_real,film_cat,film_info,film_img FROM ".$tb_prefix."film WHERE film_id = '$film_id'"));
	// category
	$cat		=	explode(',',$r['film_cat']);
	$film_cat	=	false;
	for ($i=0;$i<count($cat);$i++) {
		$cat_name	=	check_year(get_data('cat_name','cat','cat_id',$cat[$i]));
		$film_cat .= $cat_name.', ';
	}
	$film_cat		=	substr($film_cat,0,-2);
	$film_img		=	$r['film_img'];
	$film_name		=	$r['film_name'];
	$film_name_real	=	$r['film_name_real'];
	$film_info		=	get_words(del_HTML(un_htmlchars($r['film_info'])),35).'...';
	if($showimg == 1)
		echo	"<div class=\"contenst cf\"><img src=\"$film_img\"><h2>$film_name</h2><p class=\"name_real\">$film_name_real</p><p class=\"cat\">Thể loại: $film_cat</p><p class=\"desc-t\">$film_info</p></div>";
	else
		echo	"<div class=\"contenst\"><h2>$film_name</h2><p class=\"name_real\">$film_name_real</p><p class=\"cat\">Thể loại: $film_cat</p><p class=\"desc-t\">$film_info</p></div>";
	exit();
}
elseif ($_POST['rating']) {
	$id = (int)$_POST['film_id'];
	$star = (int)$_POST['star'];
	$mysql->query("UPDATE ".$tb_prefix."film SET film_rating = film_rating+$star, film_rating_total = film_rating_total+1, film_rate = film_rating / film_rating_total WHERE film_id = $id");
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = $id");
	$q = $mysql->fetch_array($q);
	rating_img($q['film_rating'],$q['film_rating_total']);
	$rater_stars_img = $r_s_img;
	echo $rater_stars_img;
	exit;
}
?>