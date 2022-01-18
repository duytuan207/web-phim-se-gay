<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$view_url = 'index.php?act=request&mode=edit';

$inp_arr = array(
         'request_content'	=> array(
			'table'	=>	'request_content',
			'name'	=>	'Nội dung yêu cầu',
			'type'	=>	'text'
		)
		
);
##################################################
# UPDATE REQUEST
##################################################
if ($mode == 'edit') {
	if ($request_del_id) {	
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."request WHERE request_id = '".$request_del_id."'");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn thực hiện<br><input value="YES" name=submit type=submit class=submit></form>
		<?php
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			$in_sql = implode(',',$arr);
			$mysql->query("DELETE FROM ".$tb_prefix."request WHERE request_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	elseif ($request_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."request WHERE request_id = '$request_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'request','request_id','request_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$view_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('VIEW INFO OF REQUEST',$inp_arr,$error_arr);
	}
	else {
		$request_per_page = 30;
		if (!$pg) $pg = 1;
		$search = strtolower(get_ascii(urldecode($_GET['search'])));
		$extra = (($search)?"request_content LIKE '%".$search."%' ":'');
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."request ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY request_id DESC LIMIT ".(($pg-1)*$request_per_page).",".$request_per_page);
		$tt = get_total('request','request_id',"".(($extra)?"WHERE ".$extra." ":'')."");
		if ($mysql->num_rows($q)) {
			if ($search) {
				$link2 = preg_replace("#&search=(.*)#si","",$link);
			}
			else $link2 = $link;
			echo "<br>REQUEST SEARCH : <input id=search size=20 value=\"".$search."\"> <input type=button onclick='window.location.href = \"".$link2."&search=\"+document.getElementById(\"search\").value;' value=GO><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "	<tr align=center>
						<td width=3% class=title>
							<input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall>
						</td>
						<td class=title width=50%>
							Nội dung yêu cầu
						</td>
						<td class=title>
							Thời gian
						</td>
						</tr>";
			while ($r = $mysql->fetch_array($q)) {
				$id 		= $r['request_id'];
				$contents 	= $r['request_content'];
				$rtime 		= date('G:i:s d/m/Y',$r['request_time']);
				echo "<tr>
						<td class=fr align=center>
							<input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id>
						</td>
						<td class=fr_2>
							<b><a href=$link&request_id=".$id.">".$contents."</a></b>
						</td>
						<td class=fr_2 align=center>
							".$rtime."
						</td>
						</tr>";
			}
			echo "<tr><td colspan=5>".admin_viewpages($tt,$request_per_page,$pg)."</td></tr>";
			echo '<tr><td colspan=5 align="center">VỚI NHỮNG YÊU CẦU ĐÃ CHỌN '.
				'<select name=selected_option><option value=del>Xóa</option>'.
				'<input type="submit" name="do" class=submit value="GỬI"></td></tr>';
			echo '</form></table>';
		}
		else echo "CHƯA CÓ YÊU CẦU NÀO";
    }
}
?>