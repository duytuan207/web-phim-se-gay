<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

function time_encode_input($timestamp) {
	$date	= 	date('d/m/Y G:i',$timestamp);
	$html	=	'<input type="text" name="time" size="50" value="'.$date.'">';
	return $html;
}

$edit_url = 'index.php?act=ads&mode=edit';

$inp_arr = array(
		'name'	=> array(
			'table'	=>	'ads_name',
			'name'	=>	'Tên Website',
			'type'	=>	'free',
		),
		'time'	=> array(
			'table'	=>	'ads_time',
			'name'	=>	'Ngày hết hạn (Ngày/tháng/năm Giờ:phút)',
			'type'	=>	'function::time_encode_input::number'
		),
		'about'	=> array(
			'table'	=>	'ads_about',
			'name'	=>	'Giới thiệu ngắn về website',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'ads_type'	=> array(
			'table'	=>	'ads_type',
			'name'	=>	'Loại ADS',
			'type'	=>	'function::acp_ads_type::number',
		),
		'pos'	=> array(
			'table'	=>	'ads_pos',
			'name'	=>	'Vị trí của ADS trên site',
			'type'	=>	'function::acp_ads_pos::number',
		),
		'url'	=> array(
			'table'	=>	'ads_url',
			'name'	=>	'Link Website',
			'type'	=>	'free',
		),
		'img'	=> array(
			'table'	=>	'ads_img',
			'name'	=>	'Link ảnh liên kết',
			'type'	=>	'img',
			'can_be_empty'	=> true,
		),
		'img'	=> array(
			'table'	=>	'ads_img',
			'name'	=>	'Link ảnh liên kết',
			'type'	=>	'img',
			'can_be_empty'	=> true,
		),
		'height'	=> array(
			'table'	=>	'ads_height',
			'name'	=>	'Chiều cao IMG/SWF',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'width'	=> array(
			'table'	=>	'ads_width',
			'name'	=>	'Chiều rộng IMG/SWF',
			'type'	=>	'free',
			'can_be_empty'	=> true,
		),
		'embed'	=> array(
			'table'	=>	'ads_embed',
			'name'	=>	'Mã Nhúng',
			'type'	=>	'text',
			'can_be_empty'	=> true,
		)
	);
##################################################
# ADD ADS
##################################################
if ($mode == 'add') {
	    acp_check_permission_mod('add_link');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$time	=	time_decode($time);
		    if(move_uploaded_file($_FILES['img']['tmp_name'],'../'.$img_ads_folder."/".$_FILES['img']['name']))
			$img = $img_ads_folder."/".$_FILES['img']['name'];
			else $img = $_POST['img'];
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'ads'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('THÊM ADS',$inp_arr,$error_arr);
}
##################################################
# EDIT ADS
##################################################
if ($mode == 'edit') {
	if ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			acp_check_permission_mod('del_link');
			$in_sql = implode(',',$arr);
			$img = $mysql->fetch_array($mysql->query("SELECT ads_img FROM ".$tb_prefix."ads WHERE ads_id IN (".$in_sql.")"));
			$img_remove = "../".$img[0];
			unlink($img_remove);
			$mysql->query("DELETE FROM ".$tb_prefix."ads WHERE ads_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	elseif ($ads_id) {
		acp_check_permission_mod('edit_link');
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads WHERE ads_id = '$ads_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$time	=	time_decode($time);
			    if(move_uploaded_file ($_FILES['img']['tmp_name'],'../'.$img_ads_folder."/".$_FILES['img']['name']))
			    $img = $img_ads_folder."/".$_FILES['img']['name'];
			    else $img = $_POST['img'];
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'ads','ads_id','ads_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('SỬA ADS',$inp_arr,$error_arr);
	}
	else {
	acp_check_permission_mod('edit_link');
       	$m_per_page = 30;
		if (!$pg) $pg = 1;
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."ads ORDER BY ads_id ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		$tt = get_total('ads','ads_id');
		if ($tt) {
			$html="<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			$html .= "<tr align=center><td class=title width=3%></td><td class=title width=20%>Website</td><td class=title width=20%>LINK WEBSITE</td><td class=title>LOẠI</td><td class=title>VỊ TRÍ</td><td class=title>ẢNH</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['ads_id'];
				$about = $r['ads_about'];
				$img = ''; if ($r['ads_img']) { $img_src = $r['ads_img']; if (!ereg("http://",$img_src)) $img_src = "../".str_replace(" ","%20",$img_src); $img ="<img src=".$img_src." width=150 height=75>"; }
				$type = $r['ads_type'];
	                switch ($type) {
							 case 0 : $type = 'TextLink';   	break;
		                     case 1 : $type = 'Images';	        break;
		                     case 2 : $type = 'Flash';	        break;
		                     case 3 : $type = 'HTML Code';	    break;
		        	}
				$pos = $r['ads_pos'];
	                switch ($pos) {
							 case 0 : $pos = 'Header 222';   	break;
		                     case 1 : $pos = 'Footer';	        break;
		                     case 2 : $pos = 'Top Center';   	break;
							 case 3 : $pos = 'Center';	        break;
							 case 4 : $pos = 'Right1';	        break;
							 case 5 : $pos = 'Trên Player1';	break;
							 case 6 : $pos = 'Trên Player2';	break;
							 case 7 : $pos = 'Dưới Player1';	break;
							 case 8 : $pos = 'Dưới Player2';	break;
							 case 9 : $pos =  'Right2';	        break;
							 case 10 : $pos = 'Right3';	        break;
							 case 11 : $pos = 'Right4';	        break;
							 case 12 : $pos = 'HTML CODE';	    break;
							 case 13 : $pos = 'PRELOAD CODE';	break;

		        	}
				$html .= "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><b><a title=\"".$about."\" href=?act=ads&mode=edit&ads_id=".$id.">".$r['ads_name']."</a></b></td><td class=fr_2 align=center><input value=\"".$r['ads_url']."\" size=40/><a href=\"".$r['ads_url']."\" target=_blank><b>Đi đến</b></a></td><td class=fr_2 align=center>".$type."</td><td class=fr_2 align=center>".$pos."</td><td class=fr_2 align=center>".$img."</td></tr>";
			}
			$html .= '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>
			     <td colspan=5 align="center" class=fr>Với những ADS được chọn '.
				'<select name=selected_option><option value=del>Xóa</option>'.
				'<input type="submit" name="do" class=submit value="Thực hiện"></td></tr>';
			$html .= "<tr><td colspan=4>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";
			$html .= '</form></table>';
			echo $html;
		}
		else echo "Không có ADS nào!";
	}
}
?>