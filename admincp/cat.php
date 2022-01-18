<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=cat&mode=edit';
$inp_arr = array(
		'name'	=> array(
			'table'	=>	'cat_name',
			'name'	=>	'Tên thể loại',
			'type'	=>	'free'
		),
		'name_ascii'	=>	array(
			'table'	=>	'cat_name_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
		'name_title'	=> array(
			'table'	=>	'cat_name_title',
			'name'	=>	'Thẻ Title',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'name_key'	=> array(
			'table'	=>	'cat_name_key',
			'name'	=>	'Thẻ Key',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'name_des'	=> array(
			'table'	=>	'cat_name_des',
			'name'	=>	'Thẻ DES',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'order'	=> array(
			'table'	=>	'cat_order',
			'name'	=>	'Thứ tự',
			'type'	=>	'number',
			'can_be_empty'	=>	true,
		),
		'name_tag'	=>	array(
			'table'	=>	'cat_name_tag',
			'name'	=>	'Thêm Key Thể Loại',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
);
##################################################
# ADD MEDIA CAT
##################################################
if ($mode == 'add') {
	acp_check_permission_mod('add_cat');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'cat'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Thêm thể loại',$inp_arr,$error_arr);
}
##################################################
# EDIT MEDIA CAT
##################################################
if ($mode == 'edit') {	
	acp_check_permission_mod('edit_cat');
	if ($cat_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."cat WHERE cat_id = '$cat_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'cat','cat_id','cat_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa thể loại',$inp_arr,$error_arr);
	}
	else {
		if ($_POST['sbm']) {
			$z = array_keys($_POST);
			$q = $mysql->query("SELECT cat_id FROM ".$tb_prefix."cat");
			for ($i=0;$i<$mysql->num_rows($q);$i++) {
				$id = split('o',$z[$i]);
				$od = ${$z[$i]};
				$mysql->query("UPDATE ".$tb_prefix."cat SET cat_order = '$od' WHERE cat_id = '".$id[1]."'");
			}
		}
		echo "<script>function check_del(id) {".
		"if (confirm('Bạn có muốn xóa thể loại này không ?')) location='?act=cat&mode=del&cat_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>STT</td><td class=title style='border-right:0'>Tên thể loại</td></tr>";
		$cat_query = $mysql->query("SELECT * FROM ".$tb_prefix."cat ORDER BY cat_order ASC");
		while ($cat = $mysql->fetch_array($cat_query)) {
			$tt = get_total('film','film_id',"WHERE film_cat = ".$cat['cat_id']."");
			$iz = $cat['cat_order'];
			
			echo "<tr><td class=fr_2><input onclick=this.select() type=text name='o".$cat['cat_id']."' value=$iz size=2 style='text-align:center'></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&cat_id=".$cat['cat_id']."'><b>".$cat['cat_name']."</b></a> ( ".$tt." )</td><td class=fr_2 width='15%' align=center><a href='?act=film&mode=edit&cat_id=".$cat['cat_id']."'><b>Quản lý Phim</b></a></td><td class=fr_2 width='5%' align=center><a href=# onclick=check_del(".$cat['cat_id'].")><b>Xoá</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '<tr><td colspan="4" align="center"><input type="submit" name="sbm" class=submit value="Sửa thứ tự"></td></tr>';
		echo '</form></table>';
	}
}	
##################################################
# DELETE MEDIA CAT
##################################################
if ($mode == 'del') {
	acp_check_permission_mod('del_cat');
	if ($cat_id) {
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_cat = '".$cat_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."cat WHERE cat_id = '".$cat_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn xóa thể loại này không ?<br><input value="Có" name=submit type=submit class=submit></form>
<?php
	}
}
?>