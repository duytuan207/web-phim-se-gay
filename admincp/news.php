<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$edit_url = 'index.php?act=news&mode=edit';

$inp_arr = array(
		'name'	=> array(
			'table'	=>	'news_name',
			'name'	=>	'NEWS NAME',
			'type'	=>	'free'
		),
		'img'	=> array(
			'table'	=>	'news_img',
			'name'	=>	'IMG',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'quote'	=> array(
			'table'	=>	'news_quote',
			'name'	=>	'QUOTE',
			'type'	=>	'text',
			'can_be_empty'	=>	true,
		),		
		'content'	=> array(
			'table'	=>	'news_content',
			'name'	=>	'INFO',
			'type'	=>	'text',
		),
		'date'	=>	array(
			'table'	=>	'news_date',
			'name'	=>	'DATE',
			'type'	=>	'hidden_value',//'number',
			'can_be_empty'	=>	false,
			'value'	=>	date("d/m/Y"),
		),
		'name_ascii'	=>	array(
			'table'	=>	'news_name_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
	);
##################################################
# ADD ALBUM
##################################################
if ($mode == 'add') {
	acp_check_permission_mod('add_news');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		$content = $_POST['content'];
		if (!$error_arr) {
		    $inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'news'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('ADD NEWS',$inp_arr,$error_arr);
}
##################################################
# EDIT news
##################################################
if ($mode == 'edit') {
	if ($news_del_id) {
		acp_check_permission_mod('del_news');
		if ($_POST['submit']) {
				$mysql->query("DELETE FROM ".$tb_prefix."news WHERE news_id = '".$news_del_id."'");
				echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
		}
		?>
		<form method="post">WOULD YOU LIKE TO SCRUB?<br><input value="YES" name=submit type=submit class=submit></form>
		<?php
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			if($level == 2)	acp_check_permission_mod('del_news');
			$in_sql = implode(',',$arr);
			$mysql->query("DELETE FROM ".$tb_prefix."news WHERE news_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	
	elseif ($news_id) {
		acp_check_permission_mod('edit_news');
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."news WHERE news_id = '".$news_id."'");
			$r = $mysql->fetch_array($q);			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			$content = $_POST['content'];
			if (!$error_arr) {
		        $inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'news','news_id','news_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT NEWS',$inp_arr,$error_arr);
	}
	else {
		acp_check_permission_mod('edit_news');
		$news_per_page = 30;
		if (!$pg) $pg = 1;	
		$xsearch = strtolower(get_ascii(urldecode($_GET['xsearch'])));
		$extra = (($xsearch)?"news_name_ascii LIKE '%".$xsearch."%' ":'');
			
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."news ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY news_id DESC LIMIT ".(($pg-1)*$news_per_page).",".$news_per_page);
		$tt = get_total('news','news_id',"".(($extra)?"WHERE ".$extra." ":'')."");
		if ($tt) {
		 	if ($xsearch) {
				$link2 = preg_replace("#&xsearch=(.*)#si","",$link);
			}
			else $link2 = $link;
			
		    echo "RICHES SERIAL NUMBER NEWS NEED <b>EDIT</b> <input id=news_id size=20> <input type=button onclick='window.location.href = \"".$link."&news_id=\"+document.getElementById(\"news_id\").value;' value=EDIT><br><br>";
			echo "RICHES SERIAL NUMBER NEWS NEED <b>DEL</b> <input id=news_del_id size=20> <input type=button onclick='window.location.href = \"".$link."&news_del_id=\"+document.getElementById(\"news_del_id\").value;' value=DEL><br><br>";
			echo "SEARCH NEWS <input id=xsearch size=20 value=\"".$xsearch."\"> <input type=button onclick='window.location.href = \"".$link2."&xsearch=\"+document.getElementById(\"xsearch\").value;' value=GO><br><br>";
			
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<tr align=center><td width=3% class=title><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td><td class=title width=60%>NEWS NAME</td><td class=title>IMG</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['news_id'];
				$news_name = $r['news_name'];
				$img = ''; if ($r['news_img']) { $img_src = $r['news_img']; if (!ereg("http://",$img_src)) $img_src = "../".str_replace(" ","%20",$img_src); $img ="<img src=".$img_src." width=50 height=50>"; }
				echo "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><b><a href=?act=news&mode=edit&news_id=".$id.">".$news_name."</a></b></td><td class=fr_2 align=center>".$img."</td></tr>";
			}
			echo "<tr><td colspan=3>".admin_viewpages($tt,$news_per_page,$pg)."</td></tr>";
			echo '<tr><td colspan=3 align="center">WITH NEWS CHOOSED '.
				'<select name=selected_option><option value=del>DEL</option>'.
				'<input type="submit" name="do" class=submit value="SEND"></td></tr>';
			echo '</form></table>';
		}
		else echo "THERE IS NO NEWS";
	}
}
?>
