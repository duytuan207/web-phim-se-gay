<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$permission_list = array(
	'add_cat'	=>	'THÊM THỂ LOẠI',
	'edit_cat'	=>	'QUẢN LÝ VÀ SỬA THỂ LOẠI',
	'del_cat'	=>	'XÓA THỂ LOẠI',
	'add_film'	=>	'THÊM PHIM',
	'edit_film' =>	'QUẢN LÝ VÀ SỬA PHIM',
	'del_film'	=>	'XÓA PHIM',
	'add_link'	=>	'THÊM ADS',
	'edit_link'	=>	'QUẢN LÝ VÀ SỬA ADS',
	'del_link'	=>	'XÓA ADS',
	'add_country' => 'THÊM QUỐC GIA',
	'edit_country' => 'QUẢN LÝ VÀ SỬA QUỐC GIA',
	'del_country' =>  'XÓA QUỐC GIA',
	'add_news' => 'THÊM THÔNG BÁO - TIN TỨC',
	'edit_news' => 'QUẢN LÝ VÀ SỬA THÔNG BÁO - TIN TỨC',
	'del_news' =>  'XÓA THÔNG BÁO - TIN TỨC',
);

if ($_POST['sel_level']) {
	$lv=$_POST['level'];
?>
<form method="post">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td colspan=2 class=title align=center>PHÂN QUYỀN CHO <?=acp_user_level($lv)?></td></tr>
<?php
$mod_permission = acp_get_mod_permission($lv);

foreach ($permission_list as $name => $desc) {
?>
<tr>
	<td class=fr width=30%><b><?=$desc?></b></td>
	<td class=fr_2><input type="radio" class="checkbox" value="1" name=<?=$name?><?=(($mod_permission[$name])?' checked':'')?>> Được phép <input type="radio" class="checkbox" value="0" name=<?=$name?><?=((!$mod_permission[$name])?' checked':'')?>> Không được phép </td>
</tr>
<?php
}
?>
<tr><td class=fr colspan=2 align=center><input type="submit" name="submit" class="submit" value="SUBMIT"></td></tr>
</table>
</form>
<?php
}
elseif ($_POST['submit']) {
	$per = '';
	$lv=$_POST['level'];
	foreach ($permission_list as $name => $desc) {
		$v = $_POST[$name];
		if ($v == '') $v = 0;
		$per .= $v;
	}
	$mysql->query("UPDATE ".$tb_prefix."user_level SET user_permission = '".$per."' WHERE user_level_type = ".$lv."");
	echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=$link'>";
}
else{
?>
<form method="post">
<table class=border cellpadding=2 cellspacing=0 width=95%>
<tr><td colspan=2 class=title align=center>PHÂN QUYỀN CHO <?=acp_user_level()?></td></tr>
<tr><td class=fr colspan=2 align=center><input type="submit" name="sel_level" class="submit" value="SUBMIT"></td></tr>
</form>
<?php
}
?>