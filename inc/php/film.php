<?php
if (!defined('IN_MEDIA')) die("Hack");
#######################################
# LIST
#######################################
// SEO Link 
$link_href=".";
if ($value[1]=='list' || $value[1]=='tim-kiem' || $value[1]=='tag' || $value[1]=='quick_search' || $value[1]=='dien-vien' || $value[1]=='dao-dien' || $value[1]=='tag-actor' || $value[1]=='tag-director' || $value[1]=='the-loai' || $value[1]=='quoc-gia'|| $value[1]=='year') {
	if ($value[2] =='phim-viet-nam' || $value[2] =='phim-trung-quoc' || $value[2] =='phim-han-quoc' || $value[2] =='phim-dai-loan' || $value[2] =='phim-my' || $value[2] =='phim-chau-au' || $value[2] =='phim-nhat-ban' || $value[2] =='phim-hong-kong' || $value[2] =='phim-thai-lan' || $value[2] =='phim-chau-a' || $value[2] =='phim-phap' || $value[2] =='phim-nga' || $value[2] =='phim-an-do')
	$value[1]='quoc-gia';
	elseif 	($value[2] == 'phim-hanh-dong' || $value[2] == 'phim-kinh-di' || $value[2] =='phim-tinh-cam' || $value[2] =='phim-phieu-luu' || $value[2] =='phim-hoat-hinh' || $value[2] =='phim-vo-thuat' || $value[2] =='phim-hai-huoc' || $value[2] =='phim-am-nhac' || $value[2] =='phim-tam-ly' || $value[2] =='phim-da-su' || $value[2] =='phim-hinh-su' || $value[2] =='phim-vien-tuong' || $value[2] =='phim-than-thoai' || $value[2] =='phim-chien-tranh' || $value[2] =='phim-18' || $value[2] =='phim-toi-pham' || $value[2] =='phim-co-trang' || $value[2] =='phim-kiem-hiep' || $value[2] =='phim-the-thao' || $value[2] =='phim-tong-hop' || $value[2] =='phim-chieu-rap')
	$value[1]='the-loai';
	if ($value[1]=='list') {
		if (!$value[2] || $value[2] == '') $value[2] = 'new';
		$where_sql = '';
		$order = $value[2];
		$page = $value[3];
		$link_page = $web_link.'/'.$value[2];
		$link_page2 = $web_link.'/'.$value[2].'/trang-1.html';
		$link_list = $web_link.'/'.$value[2].'.html';
	}
	elseif ($value[1]=='tim-kiem') {
		$kw = strip_tags($kw);
		$kw = htmlchars(stripslashes(str_replace('+',' ',$kw)));
		$keyword = htmlchars(stripslashes(urldecode(injection($value[2]))));
		$where_sql = "WHERE film_name_ascii LIKE \"%".$keyword."%\" OR film_name LIKE \"%".$keyword."%\" OR film_name_real LIKE \"%".$keyword."%\" OR film_actor LIKE \"%".$keyword."%\" OR film_actor_ascii LIKE \"%".$keyword."%\" OR film_director LIKE \"%".$keyword."%\" OR film_director_ascii LIKE \"%".$keyword."%\" OR film_tag LIKE \"%".$keyword."%\" OR film_tag_ascii LIKE \"%".$keyword."%\"";
		$page = $value[3];
		$title_name = $title_web = "Phim ".Unistr($keyword)." - Xem Phim ".Unistr($keyword)." Hay Mới Nhất 2014";
		$web_timkiem = "Phim ".Unistr($keyword)." , Xem Phim ".Unistr($keyword)." Hay nhất , Phim sex ".Unistr($keyword)." 2014 ,Phim ".Unistr($keyword)." Hay Nhất, Phim ".Unistr($keyword)." HD , Phim ".Unistr($keyword)." cấp 3 , Phim ".Unistr($keyword)." Mới Nhất , Phim sex ".Unistr($keyword)." 2014 , Xem ".Unistr($keyword)." HD";
		$web_timkiem  = "Phim ".Unistr($keyword)." , Xem Phim ".Unistr($keyword)." Hay nhất , Phim sex ".Unistr($keyword)." 2014 ,Phim ".Unistr($keyword)." Hay Nhất, Phim ".Unistr($keyword)." HD , Phim ".Unistr($keyword)." cấp 3 , Phim ".Unistr($keyword)." Mới Nhất , Phim sex ".Unistr($keyword)." 2014 , Xem ".Unistr($keyword)." HD";
		$link_page = $web_link.'/tim-kiem/'.replacesearch($value[2]);
		$link_list = $link_page2 = $web_link.'/tim-kiem/'.replacesearch($value[2]).'/trang-1.html';
		$key_name = htmlchars(stripslashes(trim(urldecode(Unistr($keyword)))));

	}
	elseif ($value[1]=='tag') {
		$keyx		=	htmlchars(stripslashes($value[2]));
		$rkeyx 		= 	$mysql->fetch_array($mysql->query("SELECT tag_id,tag_title,tag_key,tag_desc FROM ".$tb_prefix."tags WHERE tag_name_kd = '".$keyx."'"));
		if($rkeyx) {
			$web_titlez	=	$rkeyx['tag_title'];
			$web_key	=	$rkeyx['tag_key'];
			$web_desc	=	$rkeyx['tag_desc'];
			$mysql->query("UPDATE ".$tb_prefix."tags SET tag_view = tag_view + 1 WHERE tag_id = '".$rkeyx['tag_id']."'");
		}
		
		$kw = htmlchars(stripslashes(str_replace('-',' ',$value[2])));
		$kw = str_replace(array("download phim ","download "),"",$kw);
		$kws = explode(' ',$kw);
		if($kws[1]==""){  
			$keyword = $kws[0];
		}else if($kws[1]!="" && $kws[2]==""){
			$keyword = $kws[0];
		}else if($kws[2]!="" && $kws[3]==""){
			$keyword = $kws[0]." ".$kws[1];
		}else{
			$keyword = $kws[0]." ".$kws[1];
		}
		$keyword = $kw;
		$filmtag = $keyword;
		$where_sql = "WHERE film_tag_ascii LIKE \"%".$keyword."%\" OR film_tag LIKE \"%".$keyword."%\"";
		$order_sql = 'ORDER BY film_id DESC';
		$page = $value[3];
		$kwss = htmlchars(stripslashes(str_replace('-',' ',$value[2])));
		$kwss = explode(' ',$kwss);
		if($rkeyx){
			$title_name1 = $title_webtk1 = $title_name = $title_web  = $web_titlez;
		}else {
			$title_name1 = $title_webtk1 = $title_name = $title_web  = "Phim ".Unistr($kw)." - Xem Phim ".Unistr($kw)." Hay Mới Nhất 2014";
		}
		$web_tag = "Phim ".Unistr($keyword)." , Xem Phim ".Unistr($kw)." Hay nhất , Phim sex ".Unistr($kw)." 2014 ,Phim ".Unistr($kw)." Hay Nhất, Phim ".Unistr($kw)." HD , Phim ".Unistr($kw)." cấp 3 , Phim ".Unistr($kw)." Mới Nhất , Phim sex ".Unistr($kw)." 2014 , Xem ".Unistr($kw)." HD";
		$web_tag1 = "Phim ".Unistr($keyword)." , Xem Phim ".Unistr($kw)." Hay nhất , Phim sex ".Unistr($kw)." 2014 ,Phim ".Unistr($kw)." Hay Nhất, Phim ".Unistr($kw)." HD , Phim ".Unistr($kw)." cấp 3 , Phim ".Unistr($kw)." Mới Nhất , Phim sex ".Unistr($kw)." 2014 , Xem ".Unistr($kw)." HD";
		
		$link_list = $link_url = $web_link.'/'.$value[1].'/'.$value[2].'.html';		
		$link_page = $web_link.'/'.$value[1].'/'.$value[2];
		$link_page2 = $web_link.'/'.$value[1].'/'.replacesearch($value[2]).'/trang-1.html';

	}
	elseif ($value[1]=='year') {	
		$kw = htmlchars(stripslashes(str_replace('+',' ',$kw)));
		$kw = htmlchars(stripslashes(urldecode($value[2])));
		$where_sql = "WHERE film_name_ascii LIKE '%".htmlchars(stripslashes($kw))."%' OR film_name LIKE '%".htmlchars(stripslashes($kw))."%' OR film_name_real LIKE '%".htmlchars(stripslashes($kw))."%' OR film_actor LIKE '%".htmlchars(stripslashes($kw))."%' OR film_actor_ascii LIKE '%".$kw."%' OR film_year LIKE '%".$kw."%' OR film_director_ascii LIKE '%".$kw."%' OR film_director LIKE '%".htmlchars(stripslashes($kw))."%' OR film_tag LIKE '%".htmlchars(stripslashes($kw))."%'  OR film_tag_ascii LIKE '%".htmlchars(stripslashes($kw))."%' OR film_area LIKE '%".htmlchars(stripslashes($kw))."%'";
		$page = $value[3];
		$title_name = $title_web = "Phim Năm ".Unistr($kw).",Các phim sản xuất năm ".Unistr($kw)."";
		$link_page = $web_link.'/year/'.$value[2];
		$link_list = $link_page2 = $web_link.'/year/'.$value[2].'/trang-1.html';
		$key_name = trim(urldecode(Unistr($kw)));


	}
	elseif ($value[1]=='quick_search') {
		$kw = urldecode($value[2]);
		if ($value[2] == "0-9") $where_sql = "WHERE film_name_ascii RLIKE '^[0-9]'";
		else $where_sql = "WHERE film_name_ascii LIKE '".$kw."%'";
		$title_name = $title_web = "TÌM KIẾM NHANH";
		$page = $value[3];
		$link_page = $web_link.'/'.$value[1].'/'.$value[2];
	}
	elseif ($value[1]=='the-loai') {
		switch($value[2])
		{
		case "phim-chieu-rap" : $cat_id = 1 ;break;
		case "phim-hanh-dong" : $cat_id = 2 ;break;
		case "phim-kinh-di" : $cat_id = 3 ;break;
		case "phim-tinh-cam" : $cat_id = 4 ;break;
		case "phim-phieu-luu" : $cat_id = 5 ;break;
		case "phim-hoat-hinh" : $cat_id = 6 ;break;
		case "phim-vo-thuat" : $cat_id = 7 ;break;
		case "phim-hai-huoc" : $cat_id = 8 ;break;
		case "phim-am-nhac" : $cat_id = 9 ;break;
		case "phim-tam-ly" : $cat_id = 10 ;break;
		case "phim-da-su" : $cat_id = 11 ;break;
		case "phim-hinh-su" : $cat_id = 12 ;break;
		case "phim-vien-tuong" : $cat_id = 13 ;break;
		case "phim-than-thoai" : $cat_id = 14 ;break;
		case "phim-chien-tranh" : $cat_id = 15 ;break;
		case "phim-18" : $cat_id = 18 ;break;
		case "phim-toi-pham" : $cat_id = 19 ;break;
		case "phim-co-trang" : $cat_id = 20 ;break;
		case "phim-kiem-hiep" : $cat_id = 21 ;break;
		case "phim-the-thao" : $cat_id = 22 ;break;
		case "phim-tong-hop" : $cat_id = 23 ;break;
			//case "phim-tv-show" : $cat_id = 18 ;break;
			//case "phim-the-thao" : $cat_id = 19 ;break;
			//case "phim-tu-lieu" : $cat_id = 20 ;break;
			default :  $cat_id = 1 ;break;
		}
		$where_sql = "WHERE find_in_set($cat_id,film_cat)";
		$page = $value[3];
		$sc = $mysql->fetch_array($mysql->query("SELECT * FROM ".$tb_prefix."cat WHERE cat_id =  '$cat_id'"));
		$title_list = $title_name = $sc['cat_name'];
		$title_name1 = $sc['cat_name_title'];
		$title_name1 =($title_name1?$title_name1:("Xem ".$sc['cat_name']." 2013, ".$sc['cat_name_ascii']));
		$title_web = $title_name1;
		$web_des = $web_cat1 = $sc['cat_name_key'];
		$web_keywords_main = $web_cat = $sc['cat_name_des'];
		$link_catpro = $web_link.'/'.$value[2].'.html';
		$tag_cat = "<div class=\"title\" style=\"border:1px solid #333;padding-left:5px;margin-bottom:5px;height:auto;min-height:36px\"><strong>".text_tidy(get_data('cat_name_tag','cat','cat_id',$cat_id))."</strong></div>";
		$link_page = $web_link.'/'.$value[2];
		$link_list = $link_page2 = $web_link.'/'.$value[2].'.html';
		$vote_menu = vote(1);
		$web_cat = $sc['cat_name_ascii'].' 2014 - xem '.$sc['cat_name'].' hay và mới nhất, xem '.$sc['cat_name'].' hấp dẫn';
		$web_cat1 = $sc['cat_name_ascii'].', '.$sc['cat_name'].' , xem '.$sc['cat_name'].' 2014 hấp dẫn';

	}
	elseif ($value[1]=='quoc-gia') {
		switch ($value[2])
		{
		case "phim-viet-nam" : $country_id = 1 ;break;
		case "phim-trung-quoc" : $country_id = 2 ;break;
		case "phim-han-quoc" : $country_id = 3 ;break;
		case "phim-thai-lan" : 	$country_id = 4 ;break;
		case "phim-my" 		 : $country_id = 5 ;break;
		case "phim-hong-kong" : $country_id = 6 ;break;			
		case "phim-nhat-ban" : $country_id = 7;break;
		case "phim-dai-loan" : $country_id = 8 ;break;
		case "phim-chau-au" : $country_id = 9 ;break;
		case "phim-chau-a" : $country_id = 10 ;break;
		case "phim-an-do" : $country_id = 11 ;break;
		case "phim-phap" : $country_id = 12 ;break;
		case "phim-nga" : $country_id = 13 ;break;
			default :  $country_id = 1 ;break;
		}
		$where_sql = "WHERE film_country = $country_id ";
		$page = $value[3];
		$sc = $mysql->fetch_array($mysql->query("SELECT * FROM ".$tb_prefix."country WHERE country_id =  '$country_id'"));
		$title_list = $title_name = $sc['country_name'];
		$title_name1 = $sc['country_title'];
		$title_name1 = ($title_name1?$title_name1:("Xem ".$sc['country_name']." 2014, ".$sc['country_name_ascii']));
		$title_web = $title_name1;
		//$web_coun1 = $sc['country_name_key'];
		//$web_coun = $sc['country_name_des'];
		$link_counpro = $web_link.'/'.$value[2].'_'.$country_id.'.html';
		$tag_coun = "<div class=\"title\" style=\"border:1px solid #333;padding-left:5px;margin-bottom:5px;height:auto;min-height:36px\"><strong>".text_tidy(get_data('country_name_tag','country','country_id',$country_id))."</strong></div>";
		$link_page = $web_link.'/'.$value[2];
		$link_list = $link_page2 = $web_link.'/'.$value[2].'.html';
		$vote_menu = vote(2);
		$web_coun	= $sc['country_name_key'];
		$web_coun = $sc['country_name_ascii'].' 2014 - xem '.$sc['country_name'].' hay và mới nhất, xem '.$sc['country_name'].' hấp dẫn';
		$web_coun1 = $sc['country_name_ascii'].', '.$sc['country_name'].' , xem '.$sc['country_name'].' 2014 hấp dẫn';
	}
	if ($order=='xem-nhieu-nhat'){
		$order_sql = 'WHERE film_viewed > 0 ORDER BY film_viewed DESC';
		$title_list = "Danh Sách Phim Xem Nhiều Nhất";
	}
	elseif ($order == 'xem-nhieu-trong-ngay') {
		$order_sql = "WHERE film_viewed_day > 0 ORDER BY film_viewed_day DESC";
		$title_list = "Phim Xem Nhiều Trong Ngày";
		$title_list1 = "Phim Xem Nhiều Trong Ngày";
		$title_list2 = "Phim Xem Nhiều Trong Ngày";
		$title_list3 = "Phim Xem Nhiều Trong Ngày";
	}
	elseif ($order == 'xem-nhieu-trong-tuan') {
		$order_sql = "WHERE film_viewed_w > 0 ORDER BY film_viewed_w DESC";
		$title_list = "Phim Xem Nhiều Trong Tuần";
		$title_list1 = "Phim Xem Nhiều Trong Tuần";
		$title_list2 = "Phim Xem Nhiều Trong Tuần";
		$title_list3 = "Phim Xem Nhiều Trong Tuần";
	}
	elseif ($order == 'xem-nhieu-trong-thang') {
		$order_sql = "WHERE film_viewed_m > 0 ORDER BY film_viewed_m DESC";
		$title_list = "Phim Xem Nhiều Trong Tháng";
		$title_list1 = "Phim Xem Nhiều Trong Tháng";
		$title_list2 = "Phim Xem Nhiều Trong Tháng";
		$title_list3 = "Phim Xem Nhiều Trong Tháng";
	}
	elseif ($order=='phim-binh-chon-nhieu'){ 
		$order_sql = "WHERE film_rating_total > 0 ORDER BY film_rating_total DESC";
		$title_list = "Danh Sách Phim Bình Chọn Nhiều Nhất";
	}
	elseif ($order == 'phim-dien-anh') {
		$order_sql = "WHERE film_lb = 0 ORDER BY film_date DESC";
		$title_list="Danh Sách Phim lẻ, phim hot, phim 2014";
		$title_list1="Danh Sách Phim lẻ, phim hot, phim 2014";
		$title_list2="Danh Sách Phim lẻ, phim hot, phim 2014";
		$title_list3="Phim lẻ, phim hot, phim 2014";
	}elseif ($order == 'phim-le') {
		$order_sql = "WHERE film_lb = 0 ORDER BY film_date DESC";
		$title_list="Phim lẻ mới nhất, phim lẻ hay, phim lẻ hot 2014";
		$title_list1= "Danh sách phim lẻ mới nhất, phim lẻ hay, phim lẻ 2014. Tổng hợp phim lẻ hay và hấp dẫn nhất, phim lẻ HD, phim lẻ vietsub , phim lẻ lồng tiếng";
		$title_list2= "phim lẻ, phim bộ hay, phim lẻ hot, phim lẻ mới, xem phim lẻ, tải phim lẻ dài tập, phim dai tap";
		$title_list3="Phim lẻ 2014, phim lẻ hot, phim 2014";
	}
	elseif ($order == 'phim-bo') {
		$order_sql = "WHERE film_lb = 1 ORDER BY film_date DESC";
		$title_list="Phim bộ mới nhất, phim bộ hay, phim bộ hot 2014";
		$title_list1 = "Danh sách phim bộ mới nhất, phim bộ hay, phim bộ 2014. Tổng hợp phim bộ hay và hấp dẫn nhất, phim bộ HD, phim bộ vietsub , phim bộ lồng tiếng";
		$title_list2 = "phim bộ, phim bộ hay, phim bộ hot, phim bộ mới, xem phim bộ, tải phim bộ dài tập, phim dai tap";
		$title_list3 = "Phim bộ 2014, phim bộ hot 2014";
	}
	elseif ($order == 'phim-de-cu') {
		$order_sql = "WHERE film_type = 1 ORDER BY film_date DESC";
		$title_list="Đề Cử";
	}
	elseif ($order == 'phim-dang-chieu-rap') {
		$order_sql = "WHERE film_type = 2 ORDER BY film_date DESC";
		$title_list="Phim Đang Chiếu Rạp ".date("Y")."";
		$title_list1="Phim Chiếu Rạp, xem Phim Chiếu Rạp ".date("Y").", Phim6v.Com luôn cập nhật những bộ phim chiếu rạp đang chiếu tại Việt Nam và các quốc gia khác trên thế giới nhanh nhất.";
		$title_list2="Phim Chiếu Rạp, Phim Chiếu Rạp ".date("Y").",  Phim Chiếu Rạp online, Phim Chiếu Rạp hay nhất, xem Phim Chiếu Rạp, phim chiếu rạp mới nhất, xem phim chiếu rạp mới";
		$title_list3="Phim Đang Chiếu Rạp ".date("Y")."";
	}
	elseif ($order == 'phim-sap-chieu-rap') {
		$order_sql = "WHERE film_type = 3 ORDER BY film_date DESC";
		$title_list="Danh Sách Phim Sắp Chiếu Rạp";
	}
	elseif ($order == 'phim-yeu-cau') {
		$order_sql = "WHERE film_date ORDER BY film_date DESC";
		$title_list="Theo Yêu Cầu";
	}elseif ($order == 'phim-18') {
		$order_sql = "WHERE film_date ORDER BY film_date DESC";
		$title_list="Phim 18+ | Phim Cấp 3 | Xem Phim 18+ Vietsub";
		$title_list1 = "Phim 18+, Xem phim 18+ vietsub, Phim 18+ online, Phim 18+ HD, phim 18+ hay manh, Phim cap 3, phim cap ba,Phim cap 3 hay manh, phim cap 3 HD,phim cap 3 vietsub";
		$title_list2 = "Phim 18+ HD, Xem phim 18+ vietsub, Phim 18+ online mỹ, Phim 18+ Thai lan, phim 18+ hay manh, Phim cap 3 HD, phim cap ba,Phim cap 3 hay nhat, phim cap 3 hay manh nhat,phim cap 3 vietsub online";
	}
	else {
		$order_sql = "ORDER BY film_date DESC";
		$title_list = "Phim mới tháng ".date("m/Y")."";
	}
	$file_name = 'list';	
	$htm = $temp->get_htm($file_name);
	$page_size = $per_page;
	if (!$page) $page = 1;
	$limit = ($page-1)*$page_size;

	$h['num_tag'] = $temp->get_block_from_htm($htm,'num_tag',1);
	$h['start_tag'] = $temp->get_block_from_htm($htm,'start_tag',1);
	$h['end_tag'] = $temp->get_block_from_htm($htm,'end_tag',1);
	$h['row'] = $temp->get_block_from_htm($htm,'row',1);
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film $where_sql $order_sql LIMIT ".$limit.",".$page_size);
	$total = get_total("film","film_id","$where_sql $order_sql");
	if ($total){
		if ($value[1]=='list') 
		$title_web = $title_name = $title_list;
		$key_webtk = $title_name1;
		$des_webtk = $title_name2;
		$web_list = $title_list1;
		$web_list1 = $title_list2;
		$tag_list = $title_list3;
		$web_phimmoi = $title_phimmoi1;
		$web_phimmoi1 = $title_phimmoi2;
		$link_film = $link_list;
		$meta_seo 		= '<h1 class="meta_title">'.$title_name.'</h1>';
		while ($rs = $mysql->fetch_array($q)) {
			static $i = 0;
			$breadcrumbs	 = '<ol class="breadcrumb" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">';
			$breadcrumbs	.= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a title="Xem Phim Online, Xem phim HD nhanh" href="'.$web_link.'" itemprop="url"><span  itemprop="title">Xem phim</span></a></li>';
			$breadcrumbs 	.= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a title="'.$title_name.'" href="'.$web_link.''.$_SERVER['REQUEST_URI'].'" itemprop="url"><span itemprop="title">'.get_words($title_name,16).'</span></a></li>';
			$breadcrumbs	.= '</ol>';
			$str_url = text_tidy( $rs['film_info']);
			$str_url = strip_tags($str_url);
			$info_cut = get_words($str_url,50);
			rating_img($rs['film_rating'],$rs['film_rating_total']);
			$rater_stars_img = $r_s_img;
			rating_img($rs['film_rating'],$rs['film_rating_total'],3);
			$rater_stars_img1 = $r_s_img;
			if ($h['start_tag'] && fmod($i,$h['num_tag']) == 0) $main .= $h['start_tag'];
			$main .= $temp->replace_value($h['row'],
			array(
			'film.ID'			=> $rs['film_id'],
			'film.URL'			=> $web_link.'/phim-'.replace($rs['film_name_ascii']).'.vc'.replace($rs['film_id']).'.html',			
			'film.NAMEVN'		=> $rs['film_name'],
			'film.NAMEEN'		=> $rs['film_name_real'],
			'film.VN'			=> $rs['film_name'],
			'film.EN'			=> $rs['film_name_real'],
			'film.NAME'			=> $rs['film_name'].($rs['film_name_real']?' - '.$rs['film_name_real']:""),
			'film.VIEWED'		=> $rs['film_viewed'],
			'film.VIEWED_DAY'	=> $rs['film_viewed_day'],
			'film.TIME'	        => $rs['film_time'],
			'film.YEAR'			=> check_data($rs['film_year']),
			'film.TAP'			=> ($rs['film_tapphim']?$rs['film_tapphim']:"SD"),
			'film.TAPPHIM'			=> ($rs['film_tapphim']?$rs['film_tapphim']:"SD"),
			'film.INFO'			=> $info_cut,
			'film.CUT_NAME'		=> $rs['film_name'],
			'film.CAT'			=> check_data(get_data('cat_name','cat','cat_id',$rs['film_cat'])),
			'film.IMG'			=> check_img($rs['film_img']),
			'film.ACTOR'		=> $rs['film_actor'],
			'film.DIRECTOR'		=> $rs['film_director'],
			'web_mobile'		=> $web_mobile,
			'rate.IMG'			=>	$rater_stars_img,
			'rate.IMG1'			=>	$rater_stars_img1,
			'rate.VIEWED'		=>	$rs['film_rating_total'],
			)
			);
			if ($h['end_tag'] && fmod($i,$h['num_tag']) == $h['num_tag'] - 1) $main .= $h['end_tag'];
			$i++;
		}
		$main = $temp->replace_blocks_into_htm($htm,array(
		'film_list' 		=> $main
		)
		);
		
		
		$main = $temp->replace_value($main,
		array(
		'BREADCRUMBS' 		=> $breadcrumbs,
		'title.NAME'		=> $title_name,
		'link.NAME'			=> $link_page2,
		'TOTAL'				=> $total,
		'VIEW_PAGES'		=> view_pages('film',$total,$page_size,$page,$link_page,$link_page2),
		)
		);
		$web_keywords_main = $web_title_main = $title_web."";
		if($web_titlez) {
			$web_title_main	=	$web_titlez;
		}
		if($web_desc) {
			$web_phimmoi1	=	$web_desc;
			$des_webtk		=	'';	
		}
		if($web_key) {
			$web_phimmoi	=	$web_key;	
			$key_webtk		=	'';
		}
	} else {
		$htm = $temp->get_htm('error2');
		$main= $temp->replace_value($htm,
		array(
		'ERROR'            => "Không tìm thấy kết quả với từ khóa",
		'ERROR_2'        => Unistr($keyword),
		
		)
		);
		$web_nvcy = $title_web = "Thông Báo";
		$web_keywords_main = $web_title_main = $title_web = Unistr($keyword);
		//$meta_seo = Unistr($keyword);
		$meta_seo = "<h1 class='meta_title'><a href='".$link_page."' title='".Unistr($keyword)."'>".Unistr($keyword)."</a></h1>";
	}  
}
#######################################
# INFO
#######################################
elseif ($value[1]=='thong-tin' && is_numeric($value[2])) {
	$film_id = intval($value[2]);
	$film = $mysql->fetch_array($mysql->query("SELECT film_id, film_name, film_name_ascii, film_name_real, film_rating, film_rating_total, film_trailer, film_lb FROM ".$tb_prefix."film WHERE film_id = '".$film_id."'"));
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = '$film_id'");
	$num = $mysql->num_rows($q);
	if (!$num) header("Location: $web_link/error.html");
	$r = $mysql->fetch_array($q);	
	$film_viewed = $rs['album_viewed'];	
	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed = film_viewed + 1,
													film_viewed_day = film_viewed_day + 1,
													film_viewed_w = film_viewed_w + 1,
													film_viewed_m = film_viewed_m + 1 WHERE film_id = '".$film_id."'");
	//Set Server Load 
	if($r['film_server']==0)	$splitserver='';
	else $splitserver="AND episode_type='".$r['film_server']."'";	
	$episode = $mysql->fetch_array($mysql->query("SELECT episode_id,episode_name FROM ".$tb_prefix."episode WHERE episode_film = '".$film_id."' ".$splitserver."  ORDER BY episode_id ASC LIMIT 0,1"));
	//Check Episode 
	if ($episode['episode_id']=="") $episode = $mysql->fetch_array($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_film = '".$film_id."' ORDER BY episode_id ASC LIMIT 0,1"));
	
	$film_title 		= $r['film_name'];
	$film_title_en 		= $r['film_name_real'];
	$film_trailer 		= check_data(get_link_total($r['film_trailer'],0));
	$film_upload 		= check_img($r['film_upload']);
	$film_img 			= check_img(replaceimg($r['film_img']));
	$film_imgbn 		= text_tidy($r['film_imgbn']);
	$film_info 			= htmltxt(text_tidy1($r['film_info']));
	$film_info1 		= strip_tags($film_info);
	$film_key 			= text_tidy($r['film_key']);
	$film_key1 			= strip_tags($film_key);
	$film_des 			= text_tidy($r['film_des']);
	$film_des1 			= strip_tags($film_des);
	$film_download 		= text_tidy($r['film_download']);
	$film_name_real 	= text_tidy($r['film_name_real']);
	$film_sub 			= text_tidy($r['film_sub']);
	$film_tag 			= text_tidy($r['film_tag']);
	$film_year 			= check_year($r['film_year']);
	$film_time 			= check_data($r['film_time']);
	$film_lb 			= check_data($r['film_lb']);
	$film_area 			= splitlink(check_data($r['film_area']));
	$film_director 		= check_data($r['film_director']);
	$film_actor 		= check_data(get_url_dv($r['film_actor']));
	$film_actordes 		= check_data($r['film_actor']);
	$film_infoname 		= html_entity_decode($film_info,ENT_QUOTES, 'UTF-8');
	$cat		=	explode(',',$r['film_cat']);
	$film_cat	=	false;
	for ($i=0; $i<count($cat);$i++) {
		$cat_name_title	=	check_year(get_data('cat_name','cat','cat_id',$cat[$i]));
		$cat_name		=	check_year(get_data('cat_name','cat','cat_id',$cat[$i]));
		$film_cat 	.= '<a class="category" href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_name))).'.html" title="'.$cat_name.'">'.$cat_name.'</a>,';
		$cat_film		= '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_name))).'.html" title="'.$cat_name.'" itemprop="url"><span itemprop="title">'.$cat_name.'</span></a></div>';
	}
	$film_cat_info		=	substr($film_cat,0,-1);
	
	
	$area=explode(',',$film_area);
	$film_area="";
	for ($i=0; $i<count($area);$i++) {
		$film_area .= ''.$area[$i].',';
	}
	$country=@explode('',$r['film_country']);
	$link_country="";
	for ($i=0; $i<count($country);$i++) {
		$film_country = check_data(get_data('country_name','country','country_id',$r['film_country']));
		$link_country .= '<a href="'.$web_link.'/'.replace(strtolower(get_ascii($film_country))).'.html'.'" title="'.$film_country.'">'.$film_country.'</a>';
	}
	if ($episode['episode_id']){
		$link_seo= $web_link.'/xem-phim-'.replace($r['film_name_ascii']).'.vc'.replace($episode['episode_id']).'.html';
	}
	else {
		$link_seo =	'javascript:void()" onclick="alert(\'Coming soon!\');';
	}
	// film san xuat
	$area = '';
	if ((strlen($film_area)) > 1){
		$area = '<p>Sản xuất: 	<span>'.$film_area.'</span></p>';
	}
	$catz		  =	explode(',',$r['film_cat']);
	$link_film = $web_link.'/phim-'.replace($r['film_name_ascii']).".vc".replace($r['film_id']).'.html';
	$film_bo = '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/phim-bo.html" title="phim bộ" itemprop="url"><span itemprop="title">Phim Bộ</span></a></div>';
	$film_le = '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/phim-le.html" title="phim lẻ" itemprop="url"><span itemprop="title">Phim Lẻ</span></a></div>';
	
	$breadcrumbs = '<ol class="breadcrumb" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">';
	$breadcrumbs .= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a title="Phim Mới" href="'.$web_link.'" itemprop="url"><span itemprop="title">HOME</span></a></li>';
	for ($i=0; $i<count($catz);$i++) {
		$cat_namez	  =	check_year(get_data('cat_name','cat','cat_id',$catz[$i]));
		$breadcrumbs .= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_namez))).'.html" title="'.$cat_namez.'" itemprop="url"><span itemprop="title">'.$cat_namez.'</span></a></li>';
	}
	$breadcrumbs .= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a href="'.$link_film.'" title="Xem Phim '.$r['film_name'].'" itemprop="url"><span itemprop="title">Phim '.$r['film_name'].'</span></a></li>';
	$breadcrumbs .= '</ol>';
	
	rating_img($r['film_rating'],$r['film_rating_total']);
	$rater_stars_img = $r_s_img;
	$htm = $temp->get_htm('info');
	$main = $temp->replace_value($htm,array(
	'film.ID'		=> $r['film_id'],
	'cat.ID'		=> $r['film_cat'],
	'episode.ID'		=> 	$episode['episode_id'],
	'episode.PLAY'		=> 	$play_button,
	'web_mobile'		=> 	$web_mobile,
	'filmtag.2'			=> 	$film_tag2,
	'film.TRAILER'		=> 	$trailer,
	'film.URL'			=> 	$web_link.'/phim-'.replace($r['film_name_ascii']).'.vc'.replace($r['film_id']).'.html',
	'film.IMG'			=> 	$film_img,
	'film.NAME'			=> 	$r['film_name'],
	'film.GACH'			=> 	($r['film_name_real']?" - ":""),
	'film.NAMEREAL'		=> 	($r['film_name_real']?''.$r['film_name_real'].'':""),
	'film.NAMEDES'		=> 	($r['film_name_real']?'<h4>'.$r['film_name_real'].'</h4>':""),
	'film.NAMEREAL1'	=> 	$r['film_name_real'],
	'film.KEY'			=> 	$r['film_key'],
	'film.DES'			=> 	$film_des1,
	'film.WATCH'		=> 	$link_seo,
	'film.IMDb'		    =>	$r['film_imdb'],
	'film.GIOITHIEU'	=>	$r['film_gioithieu'],
	'film.HOANTHANH'	=>	$r['film_hoanthanh'],
	'film.TAP'			=> 	($r['film_tapphim']?$r['film_tapphim']:"SD"),
	'film.TAPPHIM'		=> 	($r['film_tapphim']?"<span class=\"status-update\">".$r['film_tapphim']."</span>":"<span class=\"status-update\">SD</span>"),
	'film.ACTOR'		=> 	$film_actor,
	'film.ACTORDES'		=> 	strip_tags($film_actor),
	'film.POSTER'		=> 	$posterby,
	'film.COUNTRY'		=> 	$link_country,
	'film.COUNTRYDES'	=> 	strip_tags($film_country),
	'film.DIRECTOR'		=> 	$film_director,
	'film.YEAR'			=> 	$film_year,
	'film.TIME'			=> 	$film_time,
	'film.SUB'			=> 	$sub,
	'film.TAG' 			=> 	($r['film_tag']?'<div class="block-tags"><h3 class="movie-detail-h3">Từ khóa:</h3><ul class="tag-list">'.TAGS_LINK2($film_tag).'</div>':""),
	'film.AREA'			=> 	$area,
	'film.CAT'			=>  $film_cat_info,
	'film.CATDES'		=>  strip_tags($film_cat_info),
	'film.BL'			=> 	$film_bl,
	'film.VIEWED'		=> 	$r['film_viewed'],
	'film.INFO'			=>	alo_alo($film_info),
	'film.INFOMOBILE'	=>	$film_info1,
	'film.REAL'			=> 	$r['film_name_real'],
	'BREADCRUMBS' 		=> 	$breadcrumbs,
	'rate.IMG'			=>	$rater_stars_img,
	'rate.VIEWED'		=>	$r['film_rating_total'],
	'rate.MESS'		=>	($r['film_rating_total'] == 0 ) ? 'Phim này chưa có lượt bình chọn nào!' : round($r['film_rating']/$r['film_rating_total'], 1).'/5 từ '.$r['film_rating_total'].' lần đánh giá.',
	)
	);
	
	// phân title
	$film_lb = $r['film_lb'];
	if ($film_lb==0)
	{
		$titlephim 	= 'Phim '.check_data($r['film_name'])." VietSub HD".($r['film_name_real']?' | '.$r['film_name_real']:"")." | ".$r['film_year'];
	}else 
	{
		$titlephim 	= 'Phim '.check_data($r['film_name'])." - ".$film_title_en." | ".$film_country." | ".$r['film_year'];
	}
	// phân title
	// seo keywords
	$key = $r['film_name_real'].", ".$r['film_name'].", Phim ".$r['film_name'].", Xem phim ".$r['film_name'].", xem phim ".$r['film_name_real'].", xem phim ".$r['film_name_ascii'];
	if ((strlen($film_key)) > 1){
		$key = $film_key1;
	}
	// seo keywords
	
	// seo description
	$film_lb = $r['film_lb'];
	if ($film_lb==0){
		$des = $titlephim.': '.html_entity_decode(del_HTML(trim(str_replace('"',"'",get_words((strip_tags(text_tidy($r['film_info']))),14)))),ENT_QUOTES, 'UTF-8');
	}else {
		$des = $titlephim.': '.html_entity_decode(del_HTML(trim(str_replace('"',"'",get_words((strip_tags(text_tidy($r['film_info']))),14)))),ENT_QUOTES, 'UTF-8');
	}
	// seo description
	$web_title_main = $titlephim;
	$web_keywords_main= $key;
	$web_des_main = $des;
	$link_film = $web_link.'/phim-'.replace($r['film_name_ascii']).'.vc'.replace($r['film_id']).'.html';
	$link_img = check_img(replaceimg($r['film_img']));
	$web_imgfilm = $link_img ;
	$meta_seo = "<h1 class='meta_title'><a href='".$link_film."' title='Phim ".$r['film_name']."'>Phim ".$r['film_name']."</a></h1>";
	$web_catid = $r['film_cat'];
}
#######################################
# WATCH 
#######################################
elseif (($value[1]=='watch' && is_numeric($value[2])) || $_POST['watch'] || ($value[1]=='xem-full' && is_numeric($value[2]) && is_numeric($value[3]))) {
	// xem ful tập phim
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		$episode_id = 	(int)$_POST['episode_id'];
		$sv_full	=	0;
	}else {
		$playck		= 	explode("?server=",urldecode($_SERVER['REQUEST_URI']));
		$playck		=	replace($playck[1]);
		$episode_id = 	intval($value[2]);
		$q 			= 	$mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_id = $episode_id ");
		$rs 		= 	$mysql->fetch_array($q);
		$film_vip 	= 	$rs['episode_film'];
		$film_sub 	= 	$rs['episode_urlsub'];
		$film_message 	= 	$rs['episode_message'];
	}
	$num = $mysql->num_rows($q); 
	if ($num){
# select info film
		$film = $mysql->fetch_array($mysql->query("SELECT film_id, film_name,film_down,film_tbphim,film_lb,film_tag,film_img,film_imgbn,film_country,film_actor,film_director,film_cat,film_year,film_time, film_name_ascii, film_name_real, film_rating, film_rating_total, film_viewed,film_info FROM ".$tb_prefix."film WHERE film_id = '".$film_vip."'"));
		if ($film['film_rating_total'] == 0) $rate_text = "BÌNH CHỌN";
		else $rate_text = $film['film_rating']." Star | ".$film['film_rating_total']." Rates";
		rating_img($film['film_rating'],$film['film_rating_total'], 1);
		$rater_stars_img = $r_s_img; 
		$film_id = $film['film_id'];
		$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed = film_viewed + 1,
													film_viewed_day = film_viewed_day + 1,
													film_viewed_w = film_viewed_w + 1,
													film_viewed_m = film_viewed_m + 1 WHERE film_id = '".$film['film_id']."'");
		# select info episode
		if($rs['episode_local']) $url = get_data('local_link','local','local_id',$rs['episode_local']).$rs['episode_url'];
		else
		$url = $rs['episode_url'];
		
		$film_year 			= check_year($film['film_year']);
		$film_name_real 	= $film['film_name_real'];
		$film_img 			= check_img(replaceimg($r['film_img']));
		$film_time 			= check_data($film['film_time']);
		$film_area 			= splitlink(check_data($film['film_area']));
		$film_imgbn 		= text_tidy($film['film_imgbn']);
		$film_tag 			= text_tidy($film['film_tag']);
		$film_director 		= check_data($film['film_director']);
		$film_actor 		= strip_tags(check_data($film['film_actor']));
		$film_lb 			= $film['film_lb'];
		$film_real 			= $film['film_name_ascii'];
		$episode_id			= $rs['episode_id'];
		//Reruen Player
		$player = players($url,$film_id,$rs['episode_id'],$rs['episode_type'],'100%',445,0,$film_sub,$film_message,$film_imgbn);  
		$player_mobile = player_mobile($url,$film_id,$rs['episode_id'],$rs['episode_type']);  
		//Return Total Episode
		
		$total_episodes = get_total("episode","episode_id","WHERE episode_film = $film_id"); 
		//Return Episode
		$other_server= episode_show($total_episodes,$film_id,$episode_id,$rs['episode_name']);
		
		if($r['film_server']==0)	$splitserver='';
		else $splitserver="AND episode_type='".$r['film_server']."'";	
		$episode = $mysql->fetch_array($mysql->query("SELECT episode_id,episode_name,episode_type FROM ".$tb_prefix."episode WHERE episode_film = '".$film_id."' ".$splitserver."  ORDER BY episode_id ASC LIMIT 0,1"));
		// check film on box
		$userids = $_SESSION['user_id'];
		$check_id 			= $mysql->query("SELECT user_id,user_filmbox FROM ".$tb_prefix."user WHERE user_filmbox LIKE '%,".$film_id.",%' AND user_id = '".$userids."' ORDER BY user_id ASC");
		$phimadd = $film_id.",";	
		if($mysql->num_rows($check_id)){ 
			$filmIDbox = "Xóa khỏi tủ phim";
		} else $filmIDbox = "Thêm vào tủ phim";
		//Check Episode 
		if ($episode['episode_id']=="") $episode = $mysql->fetch_array($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_film = '".$film_id."' ORDER BY episode_id ASC LIMIT 0,1"));
		$htm = $temp->get_htm('watch');
		
		$tagphim = '';
		if ((strlen($film_tag)) > 1){
			$tagphim = '<div class="tag_movie">Tag: '.TAGS_LINK2($film_tag).'</div>';
		}
		$catz		  =	explode(',',$film['film_cat']);
		$linkinfo 	= $web_link.'/phim-'.replace($film['film_name_ascii']).'.vc'.replace($film['film_id']).'.html';
		$link_ep 	= $web_link.'/xem-phim-'.replace($film['film_name_ascii']).'.vc'.replace($rs['episode_id']).'.html';
		
		$film_bo = '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/phim-bo.html" title="phim bộ" itemprop="url"><span itemprop="title">Phim Bộ</span></a></div>';
		$film_le = '<div class="item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$web_link.'/phim-le.html" title="phim lẻ" itemprop="url"><span itemprop="title">Phim Lẻ</span></a></div>';
		
		$breadcrumbs = '<ol class="breadcrumb" itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a href="'.$web_link.'" title="Xem Phim Online, Xem phim HD nhanh" itemprop="url"><span itemprop="title">HOME</span></a></li>';
		//$breadcrumbs.= $film_lb==0?$film_le:$film_bo;
		for ($i=0; $i<count($catz);$i++) {
			$cat_namez	  =	check_year(get_data('cat_name','cat','cat_id',$catz[$i]));
			$breadcrumbs .= '<li itemtype="http://data-vocabulary.org/Breadcrumb" itemscope=""><a href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_namez))).'.html" title="'.$cat_namez.'" itemprop="url"><span itemprop="title">'.$cat_namez.'</span></a></li>';
		}
		$link_film = $web_link.'/phim-'.replace($film['film_name_ascii']).'.vc'.replace($film['film_id']).'.html';
		$breadcrumbs.= '<li class="item last-child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.$link_film.'" title="Xem Phim '.$film['film_name'].'" itemprop="url"><span itemprop="title">Phim '.$film['film_name'].'</span></a></li></ol>';
		
		$film_tag 			= text_tidy($film['film_tag']);
		$next		=	$mysql->fetch_array($mysql->query("SELECT episode_id FROM ".$tb_prefix."episode WHERE episode_id > ".$rs['episode_id']." AND episode_film = ".$film['film_id']." AND episode_type = ".$rs['episode_type']." ORDER BY episode_id ASC LIMIT 1"));
		$nextepisode_id = $next['episode_id'];
		$main = $temp->replace_value($htm,array(
		'server.ID'		=>	$rs['episode_type'],
		'player'		=> 	$player,
		'player_mobile'	=> 	$player_mobile,
		'tapfilm'		=> 	check_data($rs['episode_name']),
		'film.IMG'		=> 	check_img($film['film_img']),
		'film.INFO'		=> 	cut_string(htmltxt(text_tidy1($film['film_info'])),530),
		'film.TAP'		=> 	check_tapphim($rs['film_tapphim']),
		'episode.ID'	=> 	$episode_id,
		'next.ID'		=> 	$nextepisode_id,
		'film_id'		=> 	$film['film_id'],
		'film_cat'		=> 	$film['film_cat'],
		'film_name'		=> 	get_words($film['film_name'],15),
		'film_year'		=> 	$film_year,
		'film_actor'	=> 	$film_actor,
		'film_IDBOX'    => $filmIDbox,
		'ep_url'	=> 	$url,
		'url_goc'		=>	$url,
		'web_mobile'	=>	$web_mobile,
		'film.TAG' 		=> 	($film['film_tag']?'<div class="block-tags"><h3 class="movie-detail-h3">Từ khóa:</h3><ul class="tag-list">'.TAGS_LINK2($film_tag).'</ul></div>':""),
		'ep'			=>	$link_ep,
		'server_phim' 	=>	$acp_text_type,
		'episode_phim'	=>	$rs['episode_name'],
		'total_episodes'=> 	$total_episodes,
		'comment' 		=> 	write_comment(7,$film_id,1),
		'any_episodes' 	=> 	$other_server,
		'name' 			=> 	$film_real,
		'server' 		=> 	$serverphim,
		'BREADCRUMBS' 	=> 	$breadcrumbs,
		'film.URL'		=>  $web_link.'/phim-'.replace($film['film_name_ascii']).'.vc'.replace($film['film_id']).'.html',
		'rate.IMG'		=>	$rater_stars_img,
		)
		);
		
		if($_SERVER['REQUEST_METHOD'] == "POST") echo $main;
		$episode_name = $str = $rs['episode_name'];
		if($str[0].$str[1]=='00') $episode_name=$str[2].$str[3].$str[4].$str[5];
		elseif($str[0]=='0') $episode_name=$str[1].$str[2].$str[3].$str[4].$str[5].$str[6].$str[7].$str[8];
		$web_title_main = 'Xem Phim '.($film['film_name'])." - ".$film_name_real." | Tập " .$episode_name." | Server ".acp_text_type($rs['episode_type'])."";
		$web_keywords_main= 'Bạn đang xem phim ' .$film['film_name']." tập " .$episode_name." ".$serverphim." trên website phim6v.com";
		$web_watch_main= 'Bạn đang xem phim ' .$film['film_name']."/ ".check_data($film['film_name_real'])."/ đạo diễn ".$film_director."/ tập " .$episode_name."/ ".$serverphim."/ năm ".$film_year." trên website phim6v.com";
		$link_film = $web_link.'/phim-'.replace($film['film_name_ascii']).'.vc'.replace($film['film_id']).'.html';
		$meta_seo = "<h1 class='meta_title'><a href='".$link_film."' title='Phim ".$film['film_name']."'>Phim ".$film['film_name']."</a></h1>";
		$web_des_main = $film['film_name'].' '.html_entity_decode(del_HTML(trim(str_replace('"',"'",get_words((strip_tags(text_tidy($film['film_info']))),14)))),ENT_QUOTES, 'UTF-8');

	}
	elseif (!$num)
	header("Location: $web_link/error.html");
#keywords to set SEO
	$web_film = $link_film ;
	$web_titles = $web_title_main;
	$web_titles1 = $web_title_main.$film_info;  
	$web_keywords = $web_keywords_main;

}
//sitemap
elseif ($value[1]=='sitemap') {
	$page		=	intval($value[2]);
	$page_size 	= $per_pagez;
	if (!$page) $page = 1;
	$limit = ($page-1)*$page_size;
	
	$htm 		= $temp->get_htm('sitemap_html');
	
	if($page == 1) {
		// danh sách thể loại
		$q1 			= $mysql->query("SELECT cat_id,cat_name FROM ".$tb_prefix."cat ORDER BY cat_name ASC");
		$h['cat.row'] 	= $temp->get_block_from_htm($htm,'cat.row',1);
		while ($r1 	= $mysql->fetch_array($q1)) {
			$main 		.= $temp->replace_value($h['cat.row'],array(
			'cat_name'			=> $r1['cat_name'],
			'cat_url'			=> strtolower(replace($r1['cat_name'])).'.html',
			)
			);
		}
		// danh sách quốc gia
		$q2 			= $mysql->query("SELECT country_id,country_name FROM ".$tb_prefix."country ORDER BY country_name ASC");
		$h['country.row'] 	= $temp->get_block_from_htm($htm,'country.row',1);
		while ($r2 	= $mysql->fetch_array($q2)) {
			$main 		.= $temp->replace_value($h['country.row'],array(
			'country_name'			=> $r2['country_name'],
			'country_url'			=> strtolower(replace($r2['country_name'])).'.html',
			)
			);
		}
		// danh sách diễn viên
		$q3 			= $mysql->query("SELECT actor_id,actor_name FROM ".$tb_prefix."dienvien ORDER BY actor_name ASC");
		$h['dienvien.row'] 	= $temp->get_block_from_htm($htm,'dienvien.row',1);
		while ($r3 	= $mysql->fetch_array($q3)) {
			$main 		.= $temp->replace_value($h['dienvien.row'],array(
			'dienvien_name'			=> $r3['actor_name'],
			'dienvien_url'			=> 'dien-vien/phim-'.strtolower(replace($r3['actor_name'])).'.html',
			)
			);
		}
	}
	// danh sách phim
	$q 			= $mysql->query("SELECT film_id,film_name,film_name_real,film_year FROM ".$tb_prefix."film WHERE film_id > 0 ORDER BY film_name ASC LIMIT ".$limit.",".$page_size);
	$total 		= get_total("film","film_id","");
	$h['row'] 	= $temp->get_block_from_htm($htm,'row',1);
	while ($rs 	= $mysql->fetch_array($q)) {
		// film gach
		$gach = '';
		$knam = $rs['film_year'];
		if ((strlen($rs['film_name_real'])) > 1){
			$gach = ' - ';
			$knam = replace(strtolower($rs['film_name_real']));
		}
		// film gach
		$main 		.= $temp->replace_value($h['row'],array(
		'film_name'			=> $rs['film_name']."".$gach."".$rs['film_name_real'],
		'film_url'			=> '/phim-'.replace(strtolower($rs['film_name'])).'.vc'.$rs['film_id'].'.html',
		)
		);
	}
	$main = $temp->replace_blocks_into_htm($htm,array(
	'film_list' 		=> $main
	)
	);
	$main = $temp->replace_value($main,
	array(
	'pages_number'		=> view_pages('film',$total,$page_size,$page,'danh-sach-phim')
	)
	);
	$web_title_main 	= 	$web_keywords_main	=	"Danh sách phim";
}
?>