<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$edit_url = 'index.php?act=film&mode=edit';
$edit_del = 'index.php?act=film&mode=edit';

$inp_arr = array(
		'uplaidate'	=> array(
			'name'	=>	'Up lại phim này',
			'type'	=>	'function::uplaidate::number'
		),
		'name'	=> array(
			'table'	=>	'film_name',
			'name'	=>	'TÊN PHIM',
			'type'	=>	'free'
		),
	    'name_real'	=> array(
			'table'	=>	'film_name_real',
			'name'	=>	'TÊN ENGLISH',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'img'	=> array(
			'table'	=>	'film_img',
			'name'	=>	'Ảnh phim',
			'type'	=>	'img5',
			'can_be_empty'	=> true,
		),
		'cat'	=> array(
			'table'	=>	'film_cat',
			'name'	=>	'THỂ LOẠI',
			'type'	=>	'function::acp_cat::number',
			'can_be_empty'	=> true,
		),
		'country'	=> array(
			'table'	=>	'film_country',
			'name'	=>	'QUỐC GIA',
			'type'	=>	'function::acp_country::number',
		),
		
		'director'	=> array(
			'table'	=>	'film_director',
			'name'	=>	'ĐẠO DIỄN',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'actor'	=> array(
			'table'	=>	'film_actor',
			'name'	=>	'DIỄN VIÊN',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
	    'area'	=> array(
			'table'	=>	'film_area',
			'name'	=>	'NHÀ SẢN XUẤT',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'time'	=> array(
			'table'	=>	'film_time',
			'name'	=>	'THỜI LƯỢNG',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'tapphim'	=> array(
			'table'	=>	'film_tapphim',
			'name'	=>	'Tập Phim Đang Hoàn Thành',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'tapphim'	=> array(
			'table'	=>	'film_imdb',
			'name'	=>	'Điểm IMDb',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'hoanthanh'	=> array(
			'table'	=>	'film_hoanthanh',
			'name'	=>	'Trạng Thái Hoàn Thành',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'gioithieu'	=> array(
			'table'	=>	'film_gioithieu',
			'name'	=>	'Trailer Phim',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'year'	=> array(
			'table'	=>	'film_year',
			'name'	=>	'NĂM PHÁT HÀNH',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'server'	=> array(
			'table'	=>	'film_server',
			'name'	=>	'SERVER ƯU TIÊN',
			'type'	=>	'function::set_type::number',
			'can_be_empty'	=> true,
		),
		'trang_thai'	=> array(
			'table'	=>	'film_trangthai',
			'name'	=>	'Trạng Thái',
			'type'	=>	'function::trang_thai::number',
			'can_be_empty'	=> true,
		),
		'lb'	=> array(
			'table'	=>	'film_lb',
			'name'	=>	'PHIM BỘ/LẺ : 1/0',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
        'film_info'	=>	array(
			'table'	=>	'film_info',
			'name'	=>	'THÔNG TIN',
			'type'	=>	'text',
			'can_be_empty'	=>	true,
		),
		'film_key'	=>	array(
			'table'	=>	'film_key',
			'name'	=>	'Thêm Key',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
        'film_des'	=>	array(
			'table'	=>	'film_des',
			'name'	=>	'Thêm Des',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'name_ascii'	=>	array(
			'table'	=>	'film_name_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
		'tag'	=> array(
			'table'	=>	'film_tag',
			'name'	=>	'TAG',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'tag_ascii'	=>	array(
			'table'	=>	'film_tag_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
		'date'	=>	array(
			'table'	=>	'film_date',
			'type'	=>	'hidden_value',
			'change_on_update'	=>	true,

		),
);
##################################################
# EDIT FILM
##################################################
if ($mode == 'edit') {
	if ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
		if($level == 2)	acp_check_permission_mod('del_film');
			$in_sql = implode(',',$arr);
			$img = $mysql->fetch_array($mysql->query("SELECT film_img FROM ".$tb_prefix."film WHERE film_id IN (".$in_sql.")"));
			$img_remove = "../".$img[0];
			unlink($img_remove);
			$mysql->query("DELETE FROM ".$tb_prefix."episode WHERE episode_film IN (".$in_sql.")");
			$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_id IN (".$in_sql.")");
   			$mysql->query("DELETE FROM ".$tb_prefix."comment WHERE comment_film IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'multi_edit') {
			$arr = implode(',',$arr);
			header("Location: ./?act=multi_edit_film&id=".$arr);
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'normal') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 0 WHERE film_id IN (".$in_sql.")");
			$mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 0 WHERE episode_film IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'vote') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_type = 1 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'chieurap') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_type = 2 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'sapchieurap') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_type = 3 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'binhthuong') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_type = 0 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'phimle') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_lb = 0 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if ($_POST['selected_option'] == 'phimbo') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_lb = 1 WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if ($_POST['selected_option'] == 'update') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."film SET film_date = '".NOW."' WHERE film_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2) acp_check_permission_mod('edit_film');
        if ($_POST['selected_option'] == 'cap3') {
		$in_sql = implode(',',$arr);
		$mysql->query("UPDATE ".$tb_prefix."film SET film_type = 4 WHERE film_id IN (".$in_sql.")");
		echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		exit();
	}	
	elseif ($film_id) {
		if($level == 2)	acp_check_permission_mod('edit_film');
		$qq = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = '".$film_id."'");
			$rr = $mysql->fetch_array($qq);
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = '".$film_id."'");
			$r = $mysql->fetch_array($q);	
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
			    $inp_arr['name']['value'] = htmlchars(strtolower($name));
				$inp_arr['name_ascii']['value'] = htmlchars(strtolower(get_ascii($name)));
				$inp_arr['tag_ascii']['value'] = htmlchars(strtolower(get_ascii($tag)));
				$name = htmlchars(stripslashes($name));
				$name = UNIstr($_POST['name']);
				$name_real = UNIstr($_POST['name_real']);
				$name_seo = UNIstr($_POST['name_seo']);
				//New MulTi Cat
				$cat=join_value($_POST['selectcat']);
				$server=$_POST['file_type'];
				$trang_thai=$_POST['trang_thai'];
				$hoanthanh=$_POST['hoanthanh'];
				$inp_arr['cat']['value'] = $cat;
				$inp_arr['server']['value'] = $server;
				if($uplaidate == 2) {
				$inp_arr['date']['value'] = "".NOW."";
				}else{
				$inp_arr['date']['value'] = $rr['film_date'];
				}
				$inp_arr['trang_thai']['value'] = $trang_thai;

			$server_img		=	$_POST['server_img'];
			if($server_img == 1) {
				$img = $img;
			}else {
				// picasa
				if($server_img == 2) {
					define('DIR', dirname(__FILE__));
					$tempfolder = DIR . '/temp/';
					$isWatermark = 1;
					$transfer = false;
					$max_images_size = 10;
					$images_in_slide = 25;
					$_url = $_urlc = $img;
						if(!preg_match('#^https?:\/\/(.*)\.(gif|png|jpg)$#i', $_url)) die('image=Invalid Url');
						while(stripos($_url,'%')!==false){
							$_url = rawurldecode($_url);
						}
						$filePath = $tempfolder . basename($_url);
						$imgk = @file_get_contents($_urlc);
						$fk = fopen($filePath,"w");
						fwrite($fk,$imgk);
						fclose($fk);
						
						if (!$error && (filesize($filePath) > $max_images_size * 1024 * 1024))
						{
							$error = 'Please transfer only files smaller than 2Mb!';
						}

						if (!$error && !($size = @getimagesize($filePath) ) )
						{
							$error = 'Please transfer only images, no other files are supported.';
						}

						if (!$error && !in_array($size[2], array(1, 2, 3, 7, 8) ) )
						{
							$error = 'Please transfer only images of type JPEG, GIF or PNG.';
						}

						if($error) {
							@unlink($filePath);
							die($error);
						}
						$_FILES['Filedata'] = array(
							'name' => $filePath,
							'tmp_name' => $filePath
						);
						$transfer = true;
						unset($_POST,$_REQUEST,$_GET);
						$error = false;
						$file = $_FILES['Filedata'];
						if (!isset($filePath)) $filePath = $tempfolder . UPLOAD_TB . time().'.'.end(explode('.',basename($file['name'])));
						
						if($isWatermark && (($size[0] > 150) && ($size[1] > 35))){
							$watermark_path = DIR . '/logo1.png';
							$watermark_id = imagecreatefrompng($watermark_path);
							imagealphablending($watermark_id, false);
							imagesavealpha($watermark_id, true);
						
							$info_wtm = getimagesize($watermark_path);
							$fileType = strtolower($size['mime']);
							
							$image_w 		= $size[0];
							$image_h 		= $size[1];
							$watermark_w	= $info_wtm[0];
							$watermark_h	= $info_wtm[1];
							$is_gif = false;	
							switch($fileType)
							{
								case	'image/gif':	$is_gif = true;break;
								case	'image/png': 	$image_id = imagecreatefrompng($filePath);imagealphablending($image_id, true);
							imagesavealpha($image_id, true);	break;
								default:				$image_id = imagecreatefromjpeg($filePath);	break;
							}
							if(!$is_gif){
								/* Watermark in the bottom right of image*/
								$dest_x  = ($image_w - $watermark_w); 
								$dest_y  = ($image_h  - $watermark_h);
								
								/* Watermark in the middle of image 
								$dest_x = round(( $image_height / 2 ) - ( $logo_h / 2 ));
								$dest_y = round(( $image_w / 2 ) - ( $logo_w / 2 ));
								*/
								imagecopy($image_id, $watermark_id, $dest_x, $dest_y, 0, 0, $watermark_w, $watermark_h);
								if($transfer){
									@unlink($filePath);
									$filePath = $tempfolder . basename($file['name']);
								}	
								//override to image
								switch($fileType)
								{
									case	'image/png': 	@imagepng ($image_id, $filePath); 		break;
									default:				@imagejpeg($image_id, $filePath, 100); 		break;
								}       		 
								imagedestroy($image_id);
								imagedestroy($watermark_id);
							}
						}
						// load classes
						require_once 'Zend/Loader.php';
						Zend_Loader::loadClass('Zend_Gdata');
						Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
						Zend_Loader::loadClass('Zend_Gdata_Photos');
						Zend_Loader::loadClass('Zend_Http_Client');	
						
						$serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
						$client = Zend_Gdata_ClientLogin::getHttpClient(GNAME, GPASS, $serviceName);

						// update the second argument to be CompanyName-ProductName-Version
						$gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
						$username = "default";
						$filename = $filePath;
						$xname = preg_replace('/\s+/','_',basename($file['name']));
						if(!preg_match('/^'. preg_quote(UPLOAD_TB) .'/i',$xname)) $photoName = UPLOAD_TB.'-'.$xname;
						else $photoName = $xname;
						$photoCaption = $photoName;
						$photoTags = "";
						

						$fd = $gp->newMediaFileSource($filename);
						$fd->setContentType(strtolower($size['mime']));

						// Create a PhotoEntry
						$photoEntry = $gp->newPhotoEntry();

						$photoEntry->setMediaSource($fd);
						$photoEntry->setTitle($gp->newTitle($photoName));
						$photoEntry->setSummary($gp->newSummary($photoCaption));

						// add some tags
						$keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
						$keywords->setText($photoTags);
						$photoEntry->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
						$photoEntry->mediaGroup->keywords = $keywords;

						// We use the AlbumQuery class to generate the URL for the album
						$albumQuery = $gp->newAlbumQuery();

						$albumQuery->setUser($username);
						$albumQuery->setAlbumId(ABUMID);

						// We insert the photo, and the server returns the entry representing
						// that photo after it is uploaded
						$insertedEntry = $gp->insertPhotoEntry($photoEntry, $albumQuery->getQueryUrl()); 
						$contentUrl = "";
						//$firstThumbnailUrl = "";

						if ($insertedEntry->getMediaGroup()->getContent() != null) {
						  $mediaContentArray = $insertedEntry->getMediaGroup()->getContent();
						  $contentUrl = $mediaContentArray[0]->getUrl();
						}	
						if(file_exists($filePath))
						{
							unlink($filePath);
						}		
						$img = $contentUrl;
				}
				
			}
			/* end upload images*/
		
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'film','film_id','film_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
			 	echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		//$name = UNIstr($name);
		$form->createForm('EDIT FILM',$inp_arr,$error_arr);
	}
	else {
		if($level == 2)	acp_check_permission_mod('edit_film');
		$film_per_page = 30;
		$order ='ORDER BY film_date DESC';
		if (!$pg) $pg = 1;
		$xsearch = strtolower(get_ascii(urldecode($_GET['xsearch'])));
		$extra = (($xsearch)?"film_name_ascii LIKE '%".$xsearch."%' OR film_name_real LIKE '%".$xsearch."%' OR film_id LIKE '%".$xsearch."%' ":'');		
		if ($cat_id) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_cat = '".$cat_id."' ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id',"WHERE film_cat = '".$cat_id."'".(($extra)?"AND ".$extra." ":''));
		}
		elseif ($country_id) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_country = '".$country_id."' ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id',"WHERE film_country = '".$country_id."'".(($extra)?"AND ".$extra." ":''));
		}
		elseif ($show_broken) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_broken = 1 ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id','WHERE film_broken = 1 '.(($extra)?"AND ".$extra." ":''));
		}
		elseif ($show_film_lb !='') {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_lb = ".$show_film_lb." ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id','WHERE film_lb = '.$show_film_lb.' '.(($extra)?"AND ".$extra." ":''));
		}	
		elseif ($show_film_type) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_type = ".$show_film_type." ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id','WHERE film_type = '.$show_film_type.' '.(($extra)?"AND ".$extra." ":''));
		}
		elseif ($show_film_incomplete) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_incomplete = ".$show_film_incomplete." ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id','WHERE film_type = '.$show_film_incomplete.' '.(($extra)?"AND ".$extra." ":''));
		}
		elseif ($film_upload) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_upload = ".$film_upload." ".(($extra)?"AND ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id','WHERE film_type = '.$film_upload.' '.(($extra)?"AND ".$extra." ":''));
		}
        else {
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."film ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY film_date DESC LIMIT ".(($pg-1)*$film_per_page).",".$film_per_page);
		$tt = get_total('film','film_id',"".(($extra)?"WHERE ".$extra." ":'')."");
        }
			if ($tt) {
			if ($xsearch) {
				$link2 = preg_replace("#&xsearch=(.*)#si","",$link);
			}
			else $link2 = $link;
			echo "<br>TÌM PHIM<input id=xsearch size=40 value=\"".$xsearch."\"> <input type=button onclick='window.location.href = \"".$link2."&xsearch=\"+document.getElementById(\"xsearch\").value;' value='Thực hiện'><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<br><tr><td colspan=\"7\"><center>Trang ".$pg." - Hiển thị ".$film_per_page."/".$tt." phim <br/></center></td></tr><tr align=center><td width=3% class=title></td><td class=title width=50%>Tên</td><td class=\"title\">Publish</td><td class=title>Tổng số tập</td><td class=title>Tập phim</td><td class=title>Ảnh</td><td class=title>Lỗi</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['film_id'];
				$id2=$id;
				$kname = strtolower(Upcase_First($r['film_name']));
				$film_link = $web_link.'/phim/'.$kname.'-'.$id.'.html';
				$film = htmlchars(stripslashes($r['film_name'])).' <font color=\"green\">'.$r['film_tapphim']."</font>";
				$totalepisodes_of_film = get_total('episode','episode_id',"WHERE episode_film = ".$id."");
				$img = ''; if ($r['film_img']) { $img_src = $r['film_img']; if (preg_match("http://",$img_src)) $img_src = "../".str_replace(" ","%20",$img_src); $img ="<img src=".$img_src." width=50 height=50>"; }
				$broken = ($r['film_broken'])?'<font color=red><b>X</b></font>':'';
				if ($show_broken) $id .='&show_broken=1';
                // Multi Cat
				$cat=explode(',',$r['film_cat']);
				$num=count($cat);
				$cat_name="";
				for ($i=0; $i<$num;$i++) $cat_name .= '| <i><font color="blue">'.check_data(get_data('cat_name','cat','cat_id',$cat[$i])).'</font></i> ';
				
				echo "<tr><td align=center><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id2></td><td class=fr><b><a href=?act=film&mode=edit&film_id=".$id.">".$film."</a></b><br><br><a href=\"".$film_link."\" target=\"_blank\"><font class=\"sub\">&raquo;</font> <i><font color=\"green\">Thông Tin</font></i></a>".$cat_name."</a></td><td class=\"fr_2\" align=\"center\">".($r['film_publish']?"<img src=\"../images/pb.jpg\" width=\"15px\" height=\"15px\"/>":"")."<input type=\"button\" onclick=\"film_publish(".$id.")\" id=\"publish_".$id."\" name=\"publish_".$id."\" value=\"Publish\"/>"."</td><td class=fr_2 align=center><b>".$totalepisodes_of_film."</b></td><td class=fr_2 width=100px><span style=\"float:left;padding-left=10px;\"><a href=?act=episode&mode=edit&film_id=".$id."><b>Tập Phim</b></a></span><span style=\"float:right;padding-right=10px;\"><a href=?act=episode&mode=multi_add&film_id=".$id."><b>+</b></a></span></td><td class=fr_2 align=center>".$img."</td><td class=fr_2 align=center>".$broken."</td></tr>";
			}
			echo '<tr><td class=fr align=center><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>
			     <td colspan=5 align="center" class=fr>Với những phim đã chọn '.
				'<select name=selected_option>
				<option value=del>Xóa</option>
				<option value=multi_edit>Sửa</option>
				<option value=normal>Thôi báo lỗi</option>
				<option value=chieurap>ĐANG CHIẾU RẠP</option>
				<option value=sapchieurap>SẮP CHIẾU RẠP</option>
				<option value=binhthuong>DẠNG THƯỜNG</option>
				<option value=cap3>PHIM Cấp 3</option>
				<option value=vote>Đề cử</option>
				<option value=phimle>Phim lẻ</option>
				<option value=phimbo>Phim bộ</option>
				<option value=update>Update</option></select>'.
				'<input type="submit" name="do" class=submit value="SEND"></td></tr>';
			echo "<tr><td colspan=6>".admin_viewpages($tt,$film_per_page,$pg)."</td></tr>";
			echo '</form></table>';
		}
		else echo "THERE IS NO FILMS";
	}
}
?>