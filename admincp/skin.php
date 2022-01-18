<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {
	echo "Bạn không có quyền vào trang này.";
	exit();
}
$edit_url = 'index.php?act=skin&mode=edit';

$inp_arr = array(
		'name'	=> array(
			'table'	=>	'skin_name',
			'name'	=>	'SKIN NAME',
			'type'	=>	'free'
		),
		'folder'	=> array(
			'table'	=>	'skin_folder',
			'name'	=>	'DIR NAME IS RECIPIENT',
			'type'	=>	'free'
		),
		'order'	=> array(
			'table'	=>	'skin_order',
			'name'	=>	'ORDER',
			'type'	=>	'number'
		),
	);
##################################################
# ADD
##################################################
if ($mode == 'add') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {			
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'skin'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);
	$form->createForm('ADD SKIN',$inp_arr,$error_arr);
}
##################################################
# EDIT
##################################################
if ($mode == 'edit') {
	if (!$skin_id) {
		if ($_POST['sbm']) {
			$z = array_keys($_POST);
			$q = $mysql->query("SELECT skin_id FROM ".$tb_prefix."skin");
			for ($i=0;$i<$mysql->num_rows($q);$i++) {
				$id = split('o',$z[$i]);
				$ord = ${$z[$i]};
				$mysql->query("UPDATE ".$tb_prefix."skin SET skin_order = '$ord' WHERE skin_id = '".$id[1]."'");
			}
		}
		echo "<script>function check_del(id) {".
		"if (confirm('WOULD YOU LIKE TO SCRUB?')) location='?act=skin&mode=del&skin_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>ORDER</td><td class=title style='border-right:0'>SKIN NAME</td></tr>";
		$q = $mysql->query("SELECT * FROM ".$tb_prefix."skin ORDER BY skin_id ASC");
		while ($r = $mysql->fetch_array($q)) {
			echo "<tr><td align=center class=fr><input onclick=this.select() type=text name='o".$r['skin_id']."' value=".$r['skin_order']." size=2 style='text-align:center'></td><td class=fr_2><a href=# onclick=check_del(".$r['skin_id'].")>DELETE</a> - <a href=?act=skin&mode=set_default&skin_id=".$r['skin_id'].">SET DEFAULT</a> - <a href='$link&skin_id=".$r['skin_id']."'><b>".$r['skin_name']."</b></a></td></tr>";
		}
		echo '<tr><td colspan="2" align="center"><input type="submit" name="sbm" class=submit value="EDIT ORDER"></td></tr>';
		echo '</form></table>';
	}
	else {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."skin WHERE skin_id = '$skin_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'skin','skin_id','skin_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT SKIN',$inp_arr,$error_arr);
	}
}
if ($mode == 'set_default' && is_numeric($skin_id)) {
	$name = $mysql->fetch_array($mysql->query("SELECT skin_id FROM ".$tb_prefix."skin WHERE skin_id = '$skin_id'"));
	if ($name) {
		$mysql->query("UPDATE ".$tb_prefix."config SET cf_skin_default = '".$name[0]."' WHERE cf_id = 1");
		echo "SET SKIN DEFAULT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
	}
	else echo "BROKEN";
	
}
##################################################
# DELETE
##################################################
if ($mode == 'del') {
	if ($skin_id) {
		if ($_POST['submit'] && is_numeric($skin_id) && $act=='skin' && $mode == 'del') {
			$mysql->query("DELETE FROM ".$tb_prefix."skin WHERE skin_id = $skin_id");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">
		WOULD YOU LIKE TO SCRUB?<br>
		<input value="YES" name=submit type=submit class=submit>
		</form>
<?php
	}
}
?>