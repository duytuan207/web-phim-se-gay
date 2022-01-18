<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=comment&mode=edit';
$inp_arr = array(
		'content'			=> array(
			'table'		=>	'comment_content',
			'name'		=>	'Bình luận',
			'type'		=>	'text',
			'can_be_empty'	=>	1
		),
);
if ($mode == 'edit') {
	if ($c_del_id) {
			if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."comment WHERE comment_id = '".$c_del_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_del."'>";
			exit();
		}
		?><form method="post">WOULD YOU LIKE TO SCRUB?<br><input value="YES" name=submit type=submit></form><?php
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			$in_sql = implode(',',$arr);
			$r = $mysql->query("SELECT * FROM ".$tb_prefix."comment WHERE comment_id IN (".$in_sql.")");
			while ($u = $mysql->fetch_array($r)) {
			}
			$mysql->query("DELETE FROM ".$tb_prefix."comment WHERE comment_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_del."'>";
		}
		exit();
	}
	elseif ($comment_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."comment WHERE comment_id = '$comment_id'");
			if (!$mysql->num_rows($q)) {
				echo "THERE IS NO COMMENT";
				exit();
			}
			$r = $mysql->fetch_array($q);
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		 else {
			$error_arr = array();
			if (!$error_arr) {
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'comment','comment_id','comment_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT COMMENT',$inp_arr,$error_arr);
	}
	else {
		$comment_per_page = 30;
		if (!$pg) $pg = 1;
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."comment ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY comment_id DESC LIMIT ".(($pg-1)*$comment_per_page).",".$comment_per_page);
		$tt = get_total('comment','comment_id',"".(($extra)?"WHERE ".$extra." ":'')."");
		if ($tt) {
			echo "<table width=98% align=center cellpadding=0 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<tr class=head_c>
					<td width=3% class=title></td>
					<td class=title align=left>TOTAL [ ".$tt." ] COMMENT</td>
				</tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['comment_id'];
			    $content = admin_emotions_replace(text_tidy(del_HTML($r['comment_content'])));
				$poster = $r['comment_poster'];
				$film_name = check_data(get_data('film_name','film','film_id',$r['comment_film']));
	           	echo "<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td>
				<td class=fr><b><a href='$link&comment_id=".$id."'>".$film_name."</a></b><br><b>".$poster."</b> : </b>".$content."</td>                                                                                                                                           
					</tr>";
			}
			echo '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>
			     <td colspan=3 align="center" class=fr>WITH COMMENTS CHOOSED '.
				'<select name=selected_option>
				<option value=del>DEL</option>
				</select>'.
				'<input type="submit" name="do" value="SUBMIT"></td></tr>';
			echo "<tr><td colspan=4>".admin_viewpages($tt,$comment_per_page,$pg)."</td></tr>";
			echo '</form></table>';
		}
		else echo "THERE IS NO COMMENTS";
	}
}
?>