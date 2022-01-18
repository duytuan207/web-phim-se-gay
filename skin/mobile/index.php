<?php
define('Xuanhoa88',true);

include('inc/_config.php');
include('inc/_functions.php');
include('inc/_string.php');
include('inc/class_template.php');
$cachedir="cache/";
$temp = new Template;
$cat 		= $_GET['cat'];
$country 	= $_GET['cty'];
$film		= $_GET['film'];
$search		= $_GET['search'];
$tag		= $_GET['tag'];
$act		= $_GET['act'];
if (!($act) && !($film))
{
	if (isset($cat))
	{
		
		$cat_ = explode("/",$cat."/");
				
		$page = grab_code($cat, 'trang-', $web_type, 2);
		
		$cat = $cat_[0];
		switch ($cat)
		{
			case "hanh-dong":		$cat_id=1;break;
			case "phieu-luu":		$cat_id=2;break;
			case "kinh-di":			$cat_id=3;break;
			case "tinh-cam":		$cat_id=4;break;
			case "hoat-hinh":		$cat_id=5;break;
			case "vo-thuat":		$cat_id=6;break;
			case "hai-huoc":		$cat_id=7;break;
			case "tam-ly":			$cat_id=8;break;
			case "vien-tuong":		$cat_id=9;break;
			case "than-thoai":		$cat_id=10;break;
			case "chien-tranh":		$cat_id=11;break;
			case "da-su-co-trang":	$cat_id=12;break;
			case "the-thao-am-nhac":$cat_id=13;break;
			case "hinh-su":			$cat_id=14;break;
			case "tv-show":			$cat_id=15;break;
			case "phim-18":			$cat_id=16;break;
			case "3d":				$cat_id=17;break;
			default:				$cat_id=1;break;
		}
		$cid = $cat_id;
		
		$xcat = check_cat($cid);
		
		$list_title = strip_tags($xcat);
		
		$where_sql 	= "WHERE (film_cat LIKE '%,".$cat.",%' OR film_cat LIKE ',".$cat_id.",')";
	
		$order_sql 	= 'ORDER BY film_date DESC';
		
		$link		= "phim-".$cat;

		$list_url 	= "the_loai.html";
		
		$cache 		= $cachedir."cache_cat.".$cat; 
	}
	else if (isset($country))
	{
		$country_ = explode("/",$country."/");
				
		$page = grab_code($country, 'trang-', $web_type, 2);
		
		$country = $country_[0];
		
		switch ($country)
		{
			case "viet-nam":		$country_id=1;break;
			case "trung-quoc":		$country_id=2;break;
			case "han-quoc":		$country_id=3;break;
			case "dai-loan":		$country_id=4;break;
			case "my":				$country_id=5;break;
			case "chau-au":			$country_id=6;break;
			case "nhat-ban":		$country_id=7;break;
			case "hong-kong":		$country_id=8;break;
			case "thai-lan":		$country_id=9;break;
			case "chau-a":			$country_id=10;break;
			case "an-do":			$country_id=11;break;
			default:				$country_id=1;break;
		}
		$xcountry = check_country($country_id);
		
		$list_title = "Quốc gia ";
		
		$list_title .= strip_tags($xcountry);
					
		$where_sql 	= "WHERE film_type = 2  AND ( film_country LIKE '%,".$country_id.",%' OR film_country LIKE ',".$country_id.",' OR film_country = ".$country_id.") ";
			
		$order_sql 	= 'ORDER BY film_date DESC';
		
		$link		= "phim-bo-".$country;
		
		$list_url 	=  "quoc_gia.html";
		
		$cache 		= $cachedir."cache_country.".$country; 
		
	}
	else if (isset($top))
	{
		$top_ = explode("/",$top."/");
				
		$page = grab_code($top, 'trang-', $web_type, 2);
		
		$top = $top_[0];		
		if ($top=="xem-nhieu")
		{
			$where_sql		= 'WHERE film_viewed > 0';
			
			$order_sql 		= " ORDER BY film_viewed DESC";
		
			$list_title 	= 'Top Phim Xem Nhiều Nhất';
			
		}
		else if ($top=="xem-nhieu-trong-ngay")
		{
			$where_sql 		= 'WHERE film_viewed_day > 0 ';
			
			$order_sql 		= "ORDER BY film_viewed_day DESC";	
		
			$list_title 	= 'Top Phim Xem Nhiều Trong Ngày';
		}
		else if ($top=="phim-chieu-rap")
		{
			$where_sql 		= "WHERE film_cinema=1 ";
			
			$order_sql 		= " ORDER BY film_date DESC";	
		
			$list_title 	= 'Top Phim Nổi Bật';
			
		}
		else if ($top=="binh-chon-nhieu")
		{
			$where_sql = 'WHERE film_rating_total != 0'; 
			
			$order_sql = 'ORDER BY film_rating_total';	
		
			$list_title 	= 'Top Phim Đánh Giá Cao';
		}
		else if ($top=="phim-le")
		{
			$where_sql 		= "WHERE film_type=2 ";
			
			$order_sql 		= " ORDER BY film_date DESC";	
		
			$list_title 	= 'Danh Sách Phim Lẻ Mới';
		}
		else if ($top=="phim-bo")
		{
			$where_sql 		= "WHERE film_type=2 ";
			
			$order_sql 		= " ORDER BY film_date DESC";	
		
			$list_title 	= 'Danh Sách Phim Bộ Mới';
		}
		
		$link		= "danh-sach/".$top;
		
		$list_url	= "top_phim.html";
		
		$cache 		= $cachedir."cache_top.".$top; 
	}
	else if ($search)
	{
		$key = injection($search);
		
		if (substr_count(str_replace(',',"search-",$key),"search-good")>0)
		{
			$kw = str_replace(array('good',','),"",$key);
			$is_good = true;
		}
		else $kw = $key;
		
		$list_title = "Tìm kiếm phim : ".ucwords(Unistr($kw));
		
		$web_keywords = "Ban dang tim kiem bo phim: ".ucwords(Unistr($kw));
		
		$web_des = "tim kiem, phim, ".ucwords(Unistr($kw)).", xem phim nhanh, phim chieu rap, truc tuyen, phim online nhanh";
			
		$kw = get_ascii($kw);
		
		$web_menu[0] =  "ac";
		
		if ($is_good)
		{
			$where_sql = "WHERE (film_name ='".injection($kw)."' OR film_name_real ='".injection($kw)."'  OR film_name_ascii ='".injection($kw)."')";
		}
		else
			$where_sql = "WHERE MATCH(film_name, film_name_real, film_actor, film_name_nospace, film_name_ascii, film_actor_ascii,  film_director, film_tag, film_tag_ascii, film_info) AGAINST ('".injection($kw)."')";
	
		$order_sql = ' ORDER BY film_date DESC';
	
		$link = "?search=".injection($key);
					
		}
	else if ($tag) {
			
		$key = $tag;
		
		$tag = str_replace(array('+','%20',","),' ',$key);
		
		$list_title = "Tìm kiếm phim : ".ucwords(Unistr($tag));
		
		$web_keywords = "Ban dang tim kiem bo phim: ".ucwords(Unistr($tag));
		
		$web_des = "tim kiem, phim, ".ucwords(Unistr($tag)).", xem phim nhanh, phim chieu rap, truc tuyen, phim online nhanh";
			
		$where_sql = "WHERE MATCH(film_tag) AGAINST ('".injection($t_film_tag)."')";
		
		$link = "?tag=".injection($tag);
		
		$web_menu[0] =  "ac";
	}
	else
	{
		$where_sql = "WHERE film_viewed > 0";
	
		$order_sql = 'ORDER BY film_date DESC';
		
		$list_url="#";
		
		$list_title = "Phim mới cập nhật";
		
		$list_url 	= "?act=listcat";
		
		$cache 		=$cachedir."cache_top.1";
		
		$web_menu[0] =  "ac"; 
	}
	if (!$page || !is_numeric($page)) $page = 1;
	
		$cachefile 		= $cache.".p".$page.".".$cacheext; 
	
		$main = cache_begin($cachefile,4*60*60);
		
		if (!$main)
		{
		
			$limit = ($page-1)*$page_size;
			
			$file_name = 'item.list';
			
			$htm = $temp->get_htm($file_name);
			
			$block = $temp->get_block_from_str($htm,'item_block');
			
			$t = $temp->auto_get_block($block);
		
			$block = '';
			$q = $mysql->query("SELECT film_id,film_name,film_name_real,film_name_ascii,film_rating,film_rating_total,film_type,film_update_ep,film_info,film_img,film_year,film_cat,film_info,film_country,film_actor,film_server,film_country FROM ".$tb_prefix."film ".$where_sql." AND film_show = 1 AND film_mobile = 1 ".$order_sql." LIMIT ".$limit.",".$page_size);
			while ($rs = $mysql->fetch_array($q)) {
				$film_name = change_name($rs['film_name'],$rs['film_name_real']);
		
				$film_title = name_title($rs['film_name'],$rs['film_name_real']);	
				
				if ($rs['film_type']==1) $film_link = makelink("thong-tin:bo",$rs['film_id'],$rs['film_name'],$rs['film_name_real'],'','');
		
				else $film_link = makelink("thong-tin:le",$rs['film_id'],$rs['film_name'],$rs['film_name_real'],'','');
				
				if (!$cat)
				{
					$cid 		= explode(',',$rs['film_cat']);
					
					$cid 		= $cid[rand(1,count($cid)-2)];
					
					$xcat 		= check_cat($cid);
				}
				else $web_menu[2] =  "class=\"active\"";
					
					
				if (!$country)
				{
					$qid		= explode(',',$rs['film_country']);
				
					$qid		= $qid[rand(1,count($qid)-2)];
					
					$xcountry 	= check_country($qid);
					
				}else $web_menu[3] =  "class=\"active\"";

				$block .= $temp->replace_value($t['list_item'],
					array(
						'episodeURL'   	=> $episode_url,
						
						'CAT'			=> $xcat,
		
						'URL'		    => $film_link,
						
						'UPDATE'		=> $rs['film_update_ep'] ,
		
						'NAME'			=> $film_name,
						
						'TITLE'			=> $film_title,
						
						'YEAR'			=> $rs['film_year'],
						
						'COUNTRY'		=> $xcountry,
						
						'ACTOR'			=> $rs['film_actor'],
						
						'IMG'			=> check_img($rs['film_img'],4,1),
		
						'DETAIL'		=> htmlent_to_utf8(cut_string(strip_tags(text_tidy(htmlspecialchars_decode($rs['film_info']))),100)),
						)
				);
				$i++;
			}
			$total = get_total('film','film_id',$where_sql." AND film_show = 1 AND film_mobile = 1 ".$order_sql);
		
			$page_list = viewpages($link,$total,$page_size,$page);
			
			$main = $temp->assign_blocks_content($htm,
					array(
						'item_block'	=>	$block,
					)
				);
			$main = $temp->replace_value($main,array(
					'LIST.URL'		=>	$list_url,
					'LIST.TITLE'	=>	$list_title,
				)
			);
			$main .=$page_list ;
			if ($cat)
			{
				$main .= ($temp->get_htm('listcat'));
			}
			else if ($country)
			{
				$main .= ($temp->get_htm('listcty'));
			}
			else if ($top)
			{
				$main .= ($temp->get_htm('listtop'));
			}
			cache_end ($cachefile,$main);
		}
}
else if (!($act) && isset($film))
{
	$episode_ = explode('-',$film.'-');
	$film = $episode_[count($episode_)-2];
	if (!is_numeric($film)) $film = Decode_ID($film);
	
	$mysql->query("UPDATE ".$tb_prefix."film SET film_viewed = film_viewed + 1, film_viewed_day = film_viewed_day + 1 WHERE film_id = ".$film);	

	$q = $mysql->query("SELECT film_id,film_name,film_name_real,film_name_ascii,film_img,film_info,film_year,film_time,film_time,film_area,film_director,film_actor,film_cat,film_country,film_incomesearch,film_type,film_tag,film_server,film_update_ep,film_screenshot FROM ".$tb_prefix."film WHERE film_id = ".$film."");
	
	$rs = $mysql->fetch_assoc($q);
	
	$film_name = change_name($rs['film_name'],$rs['film_name_real']);
	
	$film_title = name_title($rs['film_name'],$rs['film_name_real']);	
	
	$episode_url = "play.php?id=".Encode_ID($rs['film_id']);
	
	$film_link = "?film=".Encode_ID($rs['film_id']);
	
	$film_tag=splitlink_tag($rs['film_tag'],'tag','');
	
	$film_cat 		= check_cat($rs['film_cat']);
	
	$film_time 		= check_data($rs['film_time']);
	
	$film_country 	= check_country($rs['film_country']);	
	
	$web_title 		= "Phim ".$film_name." - ".$web_title;
		
	$htm = $temp->get_htm("info");
	
	$main = $temp->replace_value($htm,
				array(
					'episodeURL'   	=> $episode_url,
					
					'CAT'			=> $film_cat,
	
					'URL'		    => $film_link,
					
					'UPDATE'		=> $rs['film_update_ep'] ,
	
					'NAME'			=> $film_name,
					
					'TITLE'			=> $film_title,
					
					'YEAR'			=> $rs['film_year'],
					
					'COUNTRY'		=> $film_country,
					
					'ACTOR'			=> $rs['film_actor'],
					
					'IMG'			=> check_img($rs['film_img'],4,1),
	
					'DETAIL'		=> htmlent_to_utf8(text_tidy(htmlspecialchars_decode($rs['film_info']))),
					
					'EPISODE'		=> check_server($rs['film_id']),
					
					'TAG'	    	=>	$film_tag,
					
					'TIME'	    	=> $film_time,
					)
			);
}
else
{
	if ($act=="listcat"){
		$main = $temp->get_htm('listcat');
		$web_menu[2] =  "class=\"active\"";
	}
	else if ($act=="listcty")
	{
	 	$main = $temp->get_htm('listcty');
		$web_menu[3] =  "class=\"active\"";
	}
	else if ($act=="listtop")
	{
		$main = $temp->get_htm('listtop');
		$web_menu[1] =  "class=\"active\"";
	}
	else if ($act=="listall")
	{
		$main = $temp->get_htm('listall');
		$web_menu[0] =  "ac";
	}
	else if ($act=="guide")
	{
		$main = $temp->get_htm('guide');
		$web_menu[0] =  "ac";
	}
	else if ($act=="info")
	{
		$main = $temp->get_htm('site_info');
		$web_menu[0] =  "ac";
	}
	else $web_menu[0] =  "ac";
}
$html = $temp->get_htm('main');
$html = $temp->replace_value($html,array(
		'WEB.TITLE'			=>	$web_title,
		'WEB.LINK'			=>	$web_link.$link_code,
		'WEB.MAIN'			=>	$main,
		'WEB.KEYWORDS'		=>	$web_keywords,
		'WEB.ANOUN'			=>  $web_anoun,
		'WEB.MENU'			=>  $web_menu[0],
		'WEB.MENUTOP'		=>  $web_menu[1],
		'WEB.MENULE'		=>  $web_menu[2],
		'WEB.MENUBO'		=>  $web_menu[3],
	)
);
$temp->print_htm($html);
?>