<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {
	echo "Ban khong du quyen de truy cap vao phan nay.";
	exit();
}
$edit_url = 'index.php?act=user&mode=edit';

$inp_arr = array(
		'name'		=> array(
			'table'	=>	'user_name',
			'name'	=>	'USER NAME',
			'type'	=>	'free',
		),
		'password'	=> array(
			'table'	=>	'user_password',
			'name'	=>	'PASSWORD',
			'type'	=>	'free',
			'always_empty'	=>	true,
			'update_if_true'	=>	'trim($password) != ""',
			'can_be_empty'	=>	true,
		),
		'fullname'	=> array(
			'table'	=>	'user_fullname',
			'name'	=>	'Full Name',
			'type'	=>	'free',
		),
		'email'	=> array(
			'table'	=>	'user_email',
			'name'	=>	'Email',
			'type'	=>	'free',
		),
		'avatar'	=> array(
			'table'	=>	'user_avatar',
			'name'	=>	'Avatar',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'ban'	=> array(

			'table'	=>	'user_ban',
			'name'	=>	'Ban Nick',
			'type'	=>	"function::acp_user_ban",
		),
		'level'	=> array(
			'table'	=>	'user_level',
			'name'	=>	'PERMISSION',
			'type'	=>	'function::acp_user_level::number',
		),
		
);
$inp_arr_level =array(
		'level_name'	=> array(
			'table'	=>	'user_level_name',
			'name'	=>	'Tên cấp bậc',
			'type'	=>	'free',
		),
		'level_color'	=> array(
			'table'	=>	'user_level_color',
			'name'	=>	'Màu sắc phân biệt',
			'type'	=>	'free',
		),
		'level_group'	=> array(
			'table'	=>	'user_level_group',
			'name'	=>	'Ảnh nhóm phân biệt',
			'type'	=>	'free',
		),
		/*
		'level_own'	=> array(
			'table'	=>	'user_level_own',
			'name'	=>	'Server ưu tiên cho cấp bậc này. Mỗi server cách nhau bởi dấu phẩy<br/>(Nếu giá trị là 0 sẽ xem được tất cả các server, Server được thêm nên được cấp phép là server dành cho thành viên trước khi thêm vào đây. Cấp phép tại Cấu Hình Hệ Thống)',
			'type'	=>	'free',
		),*/
	);
##################################################
# ADD LEVEL
##################################################
if ($mode == 'add_level') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr_level);
		if (!$error_arr) {
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'user_level'),$inp_arr_level);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('ADD LEVEL',$inp_arr_level,$error_arr);
}
##################################################
# EDIT LEVEL
##################################################
if ($mode == 'edit_level') {
	if ($user_level_type) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user_level WHERE user_level_type = '$user_level_type'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr_level as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr_level);
			if (!$error_arr) {
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'user_level','user_level_type','user_level_type'),$inp_arr_level);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa cấp bậc thành viên',$inp_arr_level,$error_arr);
	}
	else
	{
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
			echo "<tr><td align=center class=title width=30%>Tên Level</td><td class=title style='border-right:0' width=30%>Màu sắc</td><td class=title style='border-right:0' width=30%>Thành viên</td></tr>";
			$level_query = $mysql->query("SELECT user_level_type,user_level_name,user_level_color,user_level_group FROM ".$tb_prefix."user_level ORDER BY user_level_type ASC");
			while ($level = $mysql->fetch_array($level_query)) {
				$tt = get_total('user','user_id',"WHERE user_level = ".$level['user_level_type']."");
				echo "<tr><td class=fr_2 width=50%><img src=".$level['user_level_group']." width=15 height=15 border=0> - <a href='$link&user_level_type=".$level['user_level_type']."'><b>".$level['user_level_name']."</b></a></td><td class=fr_2 width=50%>Màu ".$level['user_level_color']." - <font style='color:".$level['user_level_color']."'>".$level['user_level_color']."</font></td><td class=fr_2 width='5%' align=center>".$tt."</td></tr>";
			}
			echo '</form></table>';
	}
}
##################################################
# ADD USER
##################################################
if ($mode == 'add') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$password = md5(stripslashes($_POST['password']));
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'user'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "ADD FINISH <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('ADD USER',$inp_arr,$error_arr);
}
##################################################
# EDIT USER
##################################################
if ($mode == 'edit') {
	if ($us_del_id) {
		if ($_POST['submit']) {
			$mysql->query("DELETE FROM ".$tb_prefix."user WHERE usre_id = ".$us_del_id);
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">
		WOULD YOU LIKE TO SCRUB?<br>
		<input value="YES" name=submit type=submit class=submit>
		</form>
		<?php
	}
	elseif ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
			$in_sql = implode(',',$arr);
			$mysql->query("DELETE FROM ".$tb_prefix."user WHERE user_id IN (".$in_sql.")");
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		elseif ($_POST['selected_option'] == 'ban') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban = 1, user_ban_time = '".NOW."' WHERE user_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		elseif ($_POST['selected_option'] == 'no_ban') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."user SET user_ban = 0, user_ban_time = '' WHERE user_id IN (".$in_sql.")");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
	}
	elseif ($us_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_id = '$us_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = (($r[$arr['table']]));
			
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				if ($_POST['password']) 
				$password = md5(stripslashes($_POST['password']));
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'user','user_id','us_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT USER',$inp_arr,$error_arr);
	}
	else {
		$m_per_page = 30;
		if (!$pg) $pg = 1;
		if ($user_ban) {
        	$q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_ban = 1 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
			$extra = " user_ban = 1";
		}elseif ($point){
			$extra = " user_level = 2 OR user_level = 3";
			 $q = $mysql->query("SELECT * FROM ".$tb_prefix."user WHERE user_level = 2 OR user_level = 3 ".(($extra)?"AND ".$extra." ":'')." ".$order." LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		}else{
			$search = trim(urldecode($_GET['search']));
			$extra = (($search)?"user_name LIKE '%".$search."%' ":'');
			
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."user ".(($extra)?"WHERE ".$extra." ":'')."ORDER BY user_name ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		}
		$tt = $mysql->num_rows($mysql->query("SELECT user_id FROM ".$tb_prefix."user".(($extra)?" WHERE ".$extra:'')));
		
		if ($tt) {
			if ($search) {
				$link2 = preg_replace("#&search=(.*)#si","",$link);
			}
			else $link2 = $link;
			
			echo "<br>Tìm thành viên : <input id=search size=20 value=\"".$search."\"> <input type=button onclick='window.location.href = \"".$link2."&search=\"+document.getElementById(\"search\").value;' value='Thực hiện'><br><br>";
			echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo "<tr align=center><td width=3%><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td><td class=title width=30%>Tên Thành viên</td><td class=title>Quyền Hạn</td><td class=title>Phim Post</td><td class=title>Treo Nick</td><td class=title>Ngày bị treo nick</td></tr>";
			while ($r = $mysql->fetch_array($q)) {
				$banned_date="";
			    $id = $r['user_id'];
				$name = $r['user_name'];
				$post = $r['user_point'];
				$banned  = ($r['user_ban'])?'<font color=red><b>X</b></font>':'';
				if ($r['user_ban_time']!="") $banned_date= date('d-m-Y',$r['user_ban_time']);
	            $level=get_data('user_level_name','user_level','user_level_type',$r['user_level']);
				echo "<tr><td><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href='$link&us_id=".$id."'><b>".$name."</b></a></td><td class=fr_2 align=center>".$level."</td><td class=fr align=center>".$post." <a href='index.php?act=film&mode=edit&film_upload=".$id."'>(Tìm)</></td><td class=fr align=center>".$banned."</td><td class=fr_2 align=center>".$banned_date."</td></tr>";
			}
			echo "<tr><td colspan=3>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";
			echo '<tr><td colspan=3 align="center">Với những thành viên đã chọn '.
				'<select name=selected_option><option value=del>Xóa</option>'.
				'<option value=ban>Treo(Ban) Nick</option>'.
				'<option value=no_ban>Ngừng treo Nick</option>'.
				'</select>'.
				'<input type="submit" name="do" class=submit value="SEND"></td></tr>';
			echo '</form></table>';
		}
		else echo "THERE IS NO USERS";
	}
	
}
?>