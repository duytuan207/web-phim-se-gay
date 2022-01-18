<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=country&mode=edit';
$inp_arr = array(
		'name'	=> array(
			'table'	=>	'country_name',
			'name'	=>	'Tên quốc gia',
			'type'	=>	'free'
		),
		'name_ascii'	=>	array(
			'table'	=>	'country_name_ascii',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
		'name_title'	=> array(
			'table'	=>	'country_name_title',
			'name'	=>	'Thẻ Title',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'name_key'	=> array(
			'table'	=>	'country_name_key',
			'name'	=>	'Thẻ Key',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'name_des'	=> array(
			'table'	=>	'country_name_des',
			'name'	=>	'Thẻ DES',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'order'	=> array(
			'table'	=>	'country_order',
			'name'	=>	'Thứ tự',
			'type'	=>	'number',
			'can_be_empty'	=>	true,
		),
		'name_tag'	=>	array(
			'table'	=>	'country_name_tag',
			'name'	=>	'Thêm Key Quốc Gia',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),

);
##################################################
# ADD MEDIA COUNTRY
##################################################
if ($mode == 'add') {
	acp_check_permission_mod('add_country');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'country'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Thêm quốc gia',$inp_arr,$error_arr);
}
##################################################
# EDIT MEDIA COUNTRY
##################################################
if ($mode == 'edit') {	
	acp_check_permission_mod('edit_country');
	if ($country_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."country WHERE country_id = '$country_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['name_ascii']['value'] = strtolower(get_ascii($name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'country','country_id','country_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa quốc gia',$inp_arr,$error_arr);
	}
	else {
		if ($_POST['sbm']) {
			$z = array_keys($_POST);
			$q = $mysql->query("SELECT country_id FROM ".$tb_prefix."country");
			for ($i=0;$i<$mysql->num_rows($q);$i++) {
				$id = split('o',$z[$i]);
				$od = ${$z[$i]};
				$mysql->query("UPDATE ".$tb_prefix."country SET country_order = '$od' WHERE country_id = '".$id[1]."'");
			}
		}
		echo "<script>function check_del(id) {".
		"if (confirm('Bạn có muốn xóa quốc gia này không ?')) locountryion='?act=country&mode=del&country_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>STT</td><td class=title style='border-right:0'>Tên quốc gia</td></tr>";
		$country_query = $mysql->query("SELECT * FROM ".$tb_prefix."country ORDER BY country_order ASC");
		while ($country = $mysql->fetch_array($country_query)) {
			$tt = get_total('film','film_id',"WHERE film_country = ".$country['country_id']."");
			$iz = $country['country_order'];
			echo "<tr><td class=fr_2><input onclick=this.select() type=text name='o".$country['country_id']."' value='$iz' style='text-align:center'></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&country_id=".$country['country_id']."'><b> ".$country['country_name']."</b></a> ( ".$tt." )</td><td class=fr_2 width='15%' align=center><a href='?act=film&mode=edit&country_id=".$country['country_id']."'><b>Quản lý Phim</b></a></td><td class=fr_2 width='5%' align=center><a href=# onclick=check_del(".$country['country_id'].")><b>Xoá</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '<tr><td colspan="4" align="center"><input type="submit" name="sbm" class=submit value="Sửa thứ tự"></td></tr>';
		echo '</form></table>';
	}
}	
##################################################
# DELETE MEDIA country
##################################################
if ($mode == 'del') {
	acp_check_permission_mod('del_country');
	if ($country_id) {
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_country = '".$country_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."country WHERE country_id = '".$country_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn xóa quốc gia này không ?<br><input value="Có" name=submit type=submit class=submit></form>
<?php
	}
}
?>