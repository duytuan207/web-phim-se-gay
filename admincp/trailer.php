<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$edit_url = 'javascript:history.go(-2)';
$edit_del = 'javascript:history.go(-1)';

$inp_arr = array(
		'name'	=> array(
			'table'	=>	'trailer_name',
			'name'	=>	'NAME',
			'type'	=>	'free'
		),
	    'img'	=> array(
			'table'	=>	'trailer_img',
			'name'	=>	'IMG',
			'type'	=>	'img',
			'can_be_empty'	=> true,
		),
		'file_type'	=> array(
			'table'	=>	'trailer_type',
			'name'	=>	'SET TYPE',
			'desc'	=>	'If not already known in order to wear think of',
			'type'	=>	'function::set_type::number',
			'change_on_update'	=>	true,
		),
		'url'	=> array(
			'table'	=>	'trailer_url',
			'name'	=>	'LINK',
			'type'	=>	'free',
		),
		'local_url'    => array(
            'table'    =>    'trailer_local',
            'name'    =>    'Local URL',
            'type'    =>    'function::acp_local::number',
        ), 
		
);
##################################################
# ADD TRAILER
##################################################
if ($mode == 'add') {
	if($level == 2)	acp_check_permission_mod('add_film');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
		    $name = UNIstr($_POST['name']);
			if(move_uploaded_file ($_FILES['img']['tmp_name'],'../'.$img_trailer_folder."/".$_FILES['img']['name']))
			$img = $img_trailer_folder."/".$_FILES['img']['name'];
			else $img = $_POST['img'];
		    if($file_type == 0) $file_type = acp_type($url);
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'trailer'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('ADD TRAILER',$inp_arr,$error_arr);
}
##################################################
# EDIT TRAILER
##################################################
if ($mode == 'edit') {
	if ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
		if($level == 2)	acp_check_permission_mod('del_film');
			$in_sql = implode(',',$arr);
			$img = $mysql->fetch_array($mysql->query("SELECT trailer_img FROM ".$tb_prefix."trailer WHERE trailer_id IN (".$in_sql.")"));
			$img_remove = "../".$img[0];
			unlink($img_remove);
			$mysql->query("DELETE FROM ".$tb_prefix."trailer WHERE trailer_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		if($level == 2)	acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'normal') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."trailer SET trailer_broken = 0 WHERE trailer_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		exit();
	}	
	elseif ($trailer_id) {
		if($level == 2)	acp_check_permission_mod('edit_film');
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."trailer WHERE trailer_id = '".$trailer_id."'");
			$r = $mysql->fetch_array($q);			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
			    if($file_type == 0) $file_type = acp_type($url);
			    $name = UNIstr($_POST['name']);
			    if(move_uploaded_file ($_FILES['img']['tmp_name'],'../'.$img_trailer_folder."/".$_FILES['img']['name']))
			    $img = $img_trailer_folder."/".$_FILES['img']['name'];
			    else $img = $_POST['img'];
			   	$sql = $form->createSQL(array('UPDATE',$tb_prefix.'trailer','trailer_id','trailer_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
			 	echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT TRAILER',$inp_arr,$error_arr);
	}
	else {
		if($level == 2)	acp_check_permission_mod('edit_film');
		$trailer_per_page = 30;
		if (!$pg) $pg = 1;
		
		$xsearch = strtolower(urldecode($_GET['xsearch']));
		$extra = (($xsearch)?"trailer_name LIKE '%".$xsearch."%' ":'');		
				
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."trailer ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY trailer_id DESC LIMIT ".(($pg-1)*$trailer_per_page).",".$trailer_per_page);
		$tt = get_total('trailer','trailer_id',$extra);        
		if ($show_broken) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."trailer WHERE trailer_broken = 1 ".(($extra)?"AND ".$extra." ":'')."ORDER BY trailer_id DESC LIMIT ".(($pg-1)*$trailer_per_page).",".$trailer_per_page);
		$tt = get_total('trailer','trailer_id','WHERE trailer_broken = 1 '.(($extra)?"AND ".$extra." ":''));
		}
		if ($tt) {
			if ($xsearch) {
				$link2 = preg_replace("#&xsearch=(.*)#si","",$link);
			}
			else $link2 = $link;
		    echo "SEARCH TRAILER <input id=xsearch size=20 value=\"".$xsearch."\"> <input type=button onclick='window.location.href = \"".$link2."&xsearch=\"+document.getElementById(\"xsearch\").value;' value=GO><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<tr align=center><td width=3% class=title></td><td class=title width=77%>FILM NAME</td><td class=title>IMG</td><td class=title>BROKEN</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['trailer_id'];
				$name = $r['trailer_name'];
				$img = ''; if ($r['trailer_img']) { $img_src = $r['trailer_img']; if (!ereg("http://",$img_src)) $img_src = "../".str_replace(" ","%20",$img_src); $img ="<img src=".$img_src." width=50 height=50>"; }
				$broken = ($r['trailer_broken'])?'<font color=red><b>X</b></font>':'';
				echo "<tr><td align=center><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><b><a href=?act=trailer&mode=edit&trailer_id=".$id.">".$name."</a></b></td><td class=fr_2 align=center>".$img."</td><td class=fr_2 align=center>".$broken."</td></tr>";
			}
			echo '<tr><td class=fr align=center><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>
			     <td colspan=3 align="center" class=fr>WITH TRAILERS CHOOSED : '.
				'<select name=selected_option>
				<option value=del>DELETE</option>
				<option value=normal>FIX BROKEN</option></select>'.
				'<input type="submit" name="do" class=submit value="SUBMIT"></td></tr>';
			echo "<tr><td colspan=4>".admin_viewpages($tt,$trailer_per_page,$pg)."</td></tr>";
			echo '</form></table>';
		}
		else echo "THERE IS NO TRAILERS";
	}
}
?>
