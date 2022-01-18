<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
$edit_url = 'index.php?act=dienvien&mode=edit';
$inp_arr = array(
		'actor_name'	=> array(
			'table'	=>	'actor_name',
			'name'	=>	'Tên diễn viên',
			'type'	=>	'free'
		),
		'actor_name1'	=> array(
			'table'	=>	'actor_name1',
			'name'	=>	'Tên Khác',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'actor_name_kd'	=>	array(
			'table'	=>	'actor_name_kd',
			'type'	=>	'hidden_value',
			'value'	=>	'',
			'change_on_update'	=>	true,
		),
		'actor_birthday'	=> array(
			'table'	=>	'actor_birthday',
			'name'	=>	'Ngày sinh',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
		),
		'actor_location'	=> array(
			'table'	=>	'actor_location',
			'name'	=>	'Nơi sinh',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'actor_height'	=> array(
			'table'	=>	'actor_height',
			'name'	=>	'Chiều cao',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'actor_movie'	=> array(
			'table'	=>	'actor_movie',
			'name'	=>	'Vai diễn đáng chú ý',
			'type'	=>	'free',
			'can_be_empty'	=>	true
		),
		'img'	=> array(
			'table'	=>	'actor_img',
			'name'	=>	'Hình đại diện',
			'type'	=>	'img3',
			'can_be_empty'	=>	true,
		),
		'actor_info'	=>	array(
			'table'	=>	'actor_info',
			'name'	=>	'Thông tin chi tiết',
			'type'	=>	'text'
		),
		'actor_order'	=> array(
			'table'	=>	'actor_order',
			'name'	=>	'Thứ tự hiện thị',
			'type'	=>	'number'
		),

);
##################################################
# ADD MEDIA COUNTRY
##################################################
if ($mode == 'add') {
	acp_check_permission_mod('add_dienvien');
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		if (!$error_arr) {
			$inp_arr['actor_name_kd']['value'] = strtolower(replace($actor_name));
			
			/* begin upload images*/
				$server_img		=	$_POST['server_img'];
				if($server_img == 2) {
					$fileupload		=	strtolower(UPLOAD_TB.replace($name)).'.jpg';
					if(move_uploaded_file ($_FILES['img']['tmp_name'],"./upload/tmp/".$fileupload)){
						$new_film_img = "./upload/tmp/".$fileupload;
					}
					else {
						$new_film_img = "./upload/tmp/".$fileupload;
						@copy($_POST['img'],$new_film_img);
					}

						define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
						include_once("./upload/inc/class_image.php");
						include_once("./upload/inc/class_image_uploader.php");
						$imgtranload	=	$new_film_img;
						// picasa

							$service 	= 'picasa';
							$uploader 	= c_Image_Uploader::factory($service);
							$uploader->login(GNAME,GPASS);
							$uploader->setAlbumID(ABUMID);
							$new_film_img	= $uploader->upload($imgtranload);
							$new_film_img= 	explode('.com/',$new_film_img);
							$actor_img	=	'http://2.bp.blogspot.com/'.$new_film_img[1];

						@unlink($imgtranload);
				}
				/* end upload images*/

			
			
			$sql = $form->createSQL(array('INSERT',$tb_prefix.'dienvien'),$inp_arr);
			eval('$mysql->query("'.$sql.'");');
			echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Thêm diễn viên',$inp_arr,$error_arr);
}
##################################################
# EDIT MEDIA COUNTRY
##################################################
if ($mode == 'edit') {	
	acp_check_permission_mod('edit_dienvien');
	if ($actor_id) {
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."dienvien WHERE actor_id = '$actor_id'");
			$r = $mysql->fetch_array($q);
			
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				$inp_arr['actor_name_kd']['value'] = strtolower(replace($actor_name));
				
				/* begin upload images*/
		$fileupload		=	strtolower(UPLOAD_TB.replace($actor_name)).'.jpg';
	    if(move_uploaded_file ($_FILES['img']['tmp_name'],"./upload/tmp/".$fileupload)){
			$new_film_img = "./upload/tmp/".$fileupload;
		}
		else {
			$new_film_img = "./upload/tmp/".$fileupload;
			@copy($_POST['img'],$new_film_img);
		}
		$server_img		=	$_POST['server_img'];
		if($server_img) {
			if($server_img == 1) {
				$img = $img;
			}else {
				define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
				include_once(DIR . "./upload/inc/class_image.php");
				include_once(DIR . "./upload/inc/class_image_uploader.php");
				$imgtranload	=	$img;
				// picasa
				if($server_img == 2) {
					$service 	= 'picasa';
					$uploader 	= c_Image_Uploader::factory($service);
					$uploader->login(GNAME,GPASS);
					$uploader->setAlbumID(ABUMID);
					$img	= $uploader->upload($imgtranload);
					//$img	= 	explode('.com/',$img);
					//$img	=	'http://2.bp.blogspot.com/'.$img[1];
				}
				// imageshack
				elseif($server_img == 3) {
					$service 		= 	'imageshack';
					$uploader 		= 	c_Image_Uploader::factory($service);
					// nếu cấu hình tài khoản imageshack thì bỏ 2 dấu // ở dưới --> ok
					//$uploader->login(INAME,IPASS);
					//$uploader->set_api(IKEY);
					$img 	= 	$uploader->upload($imgtranload);
				}
				@unlink($imgtranload);
			}
			/* end upload images*/
		}

				
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'dienvien','actor_id','actor_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "Đã sửa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('Sửa diễn viên',$inp_arr,$error_arr);
	}
	else {
		$m_per_page = 20;
		if (!$pg) $pg = 1;
		if ($_POST['sbm']) {
			$z = array_keys($_POST);
			$q = $mysql->query("SELECT actor_id FROM ".$tb_prefix."dienvien ORDER BY actor_order ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
			for ($i=0;$i<$mysql->num_rows($q);$i++) {
				$id = @split('o',$z[$i]);
				$od = ${$z[$i]};
				$mysql->query("UPDATE ".$tb_prefix."dienvien SET actor_order = '$od' WHERE actor_id = '".$id[1]."'");
			}
		}
		echo "<script>function check_del(id) {".
		"if (confirm('Bạn có muốn xóa diễn viên này không ?')) locountryion='?act=dienvien&mode=del&actor_id='+id;".
		"return false;}</script>";
		echo "<table width=90% align=center cellpadding=2 cellspacing=0 class=border><form method=post>";
		echo "<tr><td align=center class=title width=5%>STT</td><td class=title style='border-right:0'>Tên diễn viên</td></tr>";
		$actor_query = $mysql->query("SELECT * FROM ".$tb_prefix."dienvien ORDER BY actor_order ASC LIMIT ".(($pg-1)*$m_per_page).",".$m_per_page);
		$tt = get_total('dienvien','actor_id');
		while ($actor = $mysql->fetch_array($actor_query)) {
			$iz = $actor['actor_order'];
			
			echo "<tr><td class=fr_2><input onclick=this.select() type=text name='o".$actor['actor_id']."' value=$iz size=2 style='text-align:center'></td><td class=fr><table width=100% cellpadding=2 cellspacing=0 class=border>";
			echo "<tr><td class=fr_2 width=50%><a href='$link&actor_id=".$actor['actor_id']."'><b> ".$actor['actor_name']."</b></a></td><td class=fr_2 width='5%' align=center><a href='?act=dienvien&mode=del&actor_id=".$actor['actor_id']."'><b>Xoá</b></a></td></tr>";
			echo "</table></td></tr>";
		}
		echo '<tr><td colspan="4" align="center"><input type="submit" name="sbm" class=submit value="Sửa thứ tự"></td></tr>';
		echo "<tr><td colspan=4>".admin_viewpages($tt,$m_per_page,$pg)."</td></tr>";
		echo '</form></table>';
	}
}	
##################################################
# DELETE MEDIA country
##################################################
if ($mode == 'del') {
	//acp_check_permission_mod('del_country');
	if ($actor_id) {
		if ($_POST['submit']) {
			//$mysql->query("DELETE FROM ".$tb_prefix."film WHERE film_country = '".$actor_id."'");
			$mysql->query("DELETE FROM ".$tb_prefix."dienvien WHERE actor_id = '".$actor_id."'");
			echo "Đã xóa xong <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
			exit();
		}
		?>
		<form method="post">Bạn có muốn xóa diễn viên này không ?<br><input value="Có" name=submit type=submit class=submit></form>
<?php
	}
}
?>