<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=tags&mode=edit';
$inp_arr = array(
		'tag_name'	=> array(
			'table'	=>	'tag_name',
			'name'	=>	'Từ khóa',
			'type'	=>	'free'
		),
		'tag_name_kd'	=>	array(
			'table'	=>	'tag_name_kd',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true
		),
		'tag_size'	=> array(
			'table'	=>	'tag_size',
			'name'	=>	'Cỡ chữ',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'tag_title'	=> array(
			'table'	=>	'tag_title',
			'name'	=>	'Web title',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'tag_key'	=> array(
			'table'	=>	'tag_key',
			'name'	=>	'Web key',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'tag_desc'	=> array(
			'table'	=>	'tag_desc',
			'name'	=>	'Web desc',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		)

);
##################################################
# ADD MEDIA COUNTRY
##################################################
if ($mode == 'add') {
	//acp_check_permission_mod('add_dienvien');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['tag_name_kd']['value'] = strtolower(replace($tag_name));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'tags'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Thêm tags',$inp_arr,$error_arr);
}
##################################################
# EDIT MEDIA COUNTRY
##################################################
if ($mode == 'edit') {	
	//acp_check_permission_mod('edit_dienvien');
	if ($tag_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."tags WHERE tag_id = '$tag_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['tag_name_kd']['value'] = strtolower(replace($tag_name));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'tags','tag_id','tag_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa từ khóa',$inp_arr,$error_arr);
	}
	else {
		$m_per_page = 20;
		if (!$pg) $pg = 1;
		echo "<script>function check_del(id) {".
		"if (confirm('Bạn có muốn xóa từ khóa này không ?')) locountryion='?act=tags&mode=del&tag_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td class=title style='border-right:0'>Từ khóa</td></tr>";
		$actor_query = $mysql->query("SELECT * FROM ".$tb_prefix."tags ORDER BY tag_view ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		$tt = get_total('tags','tag_id');
		while ($actor = $mysql->fetch_array($actor_query)) {
			$iz = $actor['actor_order'];
			
			echo "<tr><td><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&tag_id=".$actor['tag_id']."'><b> ".$actor['tag_name']."</b></a></td><td class=fr_2 width='5%' align=center><a href='?act=tags&mode=del&tag_id=".$actor['tag_id']."'><b>Xoá</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo "<tr><td colspan=4>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";
		echo '</form></table>';
	}
}	
##################################################
# DELETE MEDIA country
##################################################
if ($mode == 'del') {
	//acp_check_permission_mod('del_country');
	if ($tag_id) {
		if ($_POST['submit']) {
			//$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_country = '".$tag_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."tags WHERE tag_id = '".$tag_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn xóa từ khóa này không ?<br><input value="Có" name=submit type=submit class=submit></form>
<?php
	}
}
?>