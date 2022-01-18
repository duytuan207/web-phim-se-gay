<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=webmail&mode=edit';
$link	= "index.php?act=webmail&mode=add";
$inp_arr = array(
		'name'	=> array(
			'table'	=>	'webmail_name',
			'name'	=>	'Tên Website',
			'type'	=>	'free'
		),
		'name_email'	=>	array(
			'table'	=>	'webmail_name_email',
			'name'	=>	'Email',
			'type'	=>	'free'
		),
		'name_type'	=> array(
			'table'	=>	'webmail_name_type',
			'name'	=>	'Thứ tự',
			'type'	=>	'type_number',
			'can_be_empty'	=>	true,
		),
);
##################################################
# ADD MEDIA CAT
##################################################
if ($mode == 'add') {
	//acp_check_permission_mod('add_webmail');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['webmail_name_email']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'webmail'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Thêm Webmail',$inp_arr,$error_arr);
}
##################################################
# EDIT MEDIA CAT
##################################################
if ($mode == 'edit') {	
	//acp_check_permission_mod('edit_webmail');
	if ($webmail_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."webmail WHERE webmail_id = '$webmail_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['webmail_name_email']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'webmail','webmail_id','webmail_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa Webmail',$inp_arr,$error_arr);
	}
	else {
		if ($_POST['sbm']) {
			$z = array_keys($_POST);
			$q = $mysql->query("SELECT webmail_id FROM ".$tb_prefix."webmail");
			for ($i=0;$i<$mysql->num_rows($q);$i++) {
				$id = split('o',$z[$i]);
				$od = ${$z[$i]};
				$mysql->query("UPDATE ".$tb_prefix."webmail SET webmail_type = '$od' WHERE webmail_id = '".$id[1]."'");
			}
		}
		echo "<script>function check_del(id) {".
		"if (confirm('Bạn có muốn xóa thể loại này không ?')) location='?act=webmail&mode=del&webmail_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>STT</td><td class=title style='border-right:0'>Tên Webmail</td></tr>";
		$cat_query = $mysql->query("SELECT * FROM ".$tb_prefix."webmail ORDER BY webmail_id ASC");
		while ($cat = $mysql->fetch_array($cat_query)) {
			$iz = $cat['webmail_name_type'];
			if($iz==1){
			$class ="Tin Tức";
			}else{
			$class ="Giải Trí";
			}
			echo "<tr><td class=fr_2><input onclick=this.select() type=text value=".$cat['webmail_id']."></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=35%><a href='$edit_url&webmail_id=".$cat['webmail_id']."'><b>".$cat['webmail_name']."</b></a></td><td class=fr_2 width='30%' align=center><b>".$cat['webmail_name_email']."</b></td><td class=fr_2 width='15%' align=center><b>".$class."</b></td><td class=fr_2 width='5%' align=center><a href=# onclick=check_del(".$cat['webmail_id'].")><b>Xoá</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '</form></table>';
	}
}	
##################################################
# DELETE MEDIA CAT
##################################################
if ($mode == 'del') {
	//acp_check_permission_mod('del_cat');
	if ($webmail_id) {
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."webmail WHERE webmail_id = '".$webmail_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn xóa thể loại này không ?<br><input value="Có" name=submit type=submit class=submit></form>
<?php
	}
}
?>