<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");

$edit_url = 'javascript:history.go(-2)';
$edit_del = 'javascript:history.go(-1)';

$inp_arr = array(
		'name'		=> array(
			'table'	=>	'episode_name',
			'name'	=>	'TẬP SỐ',
			'type'	=>	'free',
		),
		'film'		=> array(
			'table'	=>	'episode_film',
			'name'	=>	'TÊN PHIM',
			'type'	=>	'function::acp_film::number',
		),
		'file_type'	=> array(
			'table'	=>	'episode_type',
			'name'	=>	'SERVER',
			'desc'	=>	'If not already known in order to wear think of',
			'type'	=>	'function::set_type::number',
			'change_on_update'	=>	true,
		),
		'local_url'    => array(
            'table'    =>    'episode_local',
            'name'    =>    'LOCAL URL',
            'type'    =>    'function::acp_local::number',
        ),  
		'url'		=> array(
			'table'	=>	'episode_url',
			'name'	=>	'ĐƯỜNG DẪN',
			'type'	=>	'free',
		),
		'episode_urlsub'	 => array(
            'table'    =>    'episode_urlsub',
            'name'    =>    'Subtitle',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
        ),
		'episode_message'	 => array(
            'table'    =>    'episode_message',
            'name'    =>    'Message',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
        ),
		'new_film'	=>	array(
			'name'	=>	'THÊM PHIM NHANH',
			'type'	=>	'function::acp_quick_add_film_form::free',
			'desc'	=>	'If database ised havent Web is gently self-made',
			'can_be_empty'	=>	true,
		),
);
$inp_arr_edit = array(
		'name'		=> array(
			'table'	=>	'episode_name',
			'name'	=>	'TẬP SỐ',
			'type'	=>	'free',
		),
		'film'		=> array(
			'table'	=>	'episode_film',
			'name'	=>	'TÊN PHIM',
			'type'	=>	'function::acp_film::number',
		),
		'file_type'	=> array(
			'table'	=>	'episode_type',
			'name'	=>	'SERVER',
			'desc'	=>	'If not already known in order to wear think of',
			'type'	=>	'function::set_type::number',
			'change_on_update'	=>	true,
		),
		'local_url'    => array(
            'table'    =>    'episode_local',
            'name'    =>    'LOCAL URL',
            'type'    =>    'function::acp_local::number',
        ),  
		'episode_urlsub'	 => array(
            'table'    =>    'episode_urlsub',
            'name'    =>    'Subtitle',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
        ),
		'episode_message'	 => array(
            'table'    =>    'episode_message',
            'name'    =>    'Message',
			'type'	=>	'free',
			'can_be_empty'	=>	true,
        ),
		'url'		=> array(
			'table'	=>	'episode_url',
			'name'	=>	'ĐƯỜNG DẪN',
			'type'	=>	'free',
		),
);

##################################################
# ADD EPISODE
##################################################
if ($mode == 'multi_add') {
	acp_check_permission_mod('add_film');
	include('multi_add_episode.php');
}
##################################################
# EDIT EPISODE
##################################################

if ($mode == 'remove') {
	$serverid	=	@$_GET['serverid'];
	$filmid		=	@$_GET['filmid'];
	if($serverid && $filmid) {
		$mysql->query("DELETE FROM ".$tb_prefix."episode WHERE episode_film = '$filmid' AND episode_type = '$serverid'");	
		echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_del."'>";
	}
	//exit();
}


if ($mode == 'edit') {
	if ($_POST['do']) {
		$arr = $_POST['checkbox'];
		if (!count($arr)) die('BROKEN');
		if ($_POST['selected_option'] == 'del') {
		acp_check_permission_mod('del_film');
		$in_sql = implode(',',$arr);
		$mysql->query("DELETE FROM ".$tb_prefix."episode WHERE episode_id IN (".$in_sql.")");			
			echo "DEL FINISH <meta http-equiv='refresh' content='0;url=".$edit_del."'>";
		}		
		acp_check_permission_mod('edit_film');
		if ($_POST['selected_option'] == 'multi_edit') {
			$arr = implode(',',$arr);
			header("Location: ./?act=multi_edit_episode&id=".$arr);
		}
		elseif ($_POST['selected_option'] == 'normal') {
			$in_sql = implode(',',$arr);
			$mysql->query("UPDATE ".$tb_prefix."episode SET episode_broken = 0 WHERE episode_id IN (".$in_sql.")");
			$broken_fix = $mysql->fetch_array($mysql->query("SELECT episode_film FROM ".$tb_prefix."episode WHERE episode_id IN (".$in_sql.")"));
			$mysql->query("UPDATE ".$tb_prefix."film SET film_broken = 0 WHERE film_id = '".$broken_fix['episode_film']."'");
			echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
		}
		exit();
	}
	elseif ($episode_id) {
		acp_check_permission_mod('edit_film');
		if (!$_POST['submit']) {
			$q = $mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_id = '$episode_id' ORDER BY episode_name ASC");
			if (!$mysql->num_rows($q)) {
				echo "THERE IS NO EPISODE";
				exit();
			}
			$r = $mysql->fetch_array($q);
				
			foreach ($inp_arr as $key=>$arr) $$key = $r[$arr['table']];
		}
		else {
			$error_arr = array();
			$error_arr = $form->checkForm($inp_arr);
			if (!$error_arr) {
				if($file_type == 0) $file_type = acp_type($url);
				if ($new_film) {
				if(move_uploaded_file ($_FILES['upload_img']['tmp_name'],'../'.$img_film_folder."/".$_FILES['upload_img']['name']))
				$new_film_img = $img_film_folder."/".$_FILES['upload_img']['name'];
				else $new_film_img = $_POST['url_img'];
				$film = acp_quick_add_film($new_film,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info,$country);
			    }
				$sql = $form->createSQL(array('UPDATE',$tb_prefix.'episode','episode_id','episode_id'),$inp_arr);
				eval('$mysql->query("'.$sql.'");');
				echo "EDIT FINISH <meta http-equiv='refresh' content='0;url=".$edit_url."'>";
				exit();
			}
		}
		$warn = $form->getWarnString($error_arr);
		$form->createForm('EDIT EPISODE',$inp_arr_edit,$error_arr);
	}
	else {
		acp_check_permission_mod('edit_film');		
		$episode_per_page = 30;
		if (!$pg) $pg = 1;
		if($server)	$extra=" episode_type=".$server;
		if($show_broken)	$extra=" episode_broken=".$show_broken;
		if ($film_id) {
        $q = $mysql->query("SELECT * FROM ".$tb_prefix."episode WHERE episode_film='".$film_id."' ".(($extra)?"AND ".$extra." ":'')."  ORDER BY episode_id ASC LIMIT ".(($pg-1)*$episode_per_page).",".$episode_per_page);
		$tt = get_total('episode','episode_id',"WHERE episode_film = '".$film_id."' ".(($extra)?"AND ".$extra." ":''));
		}
		if ($mysql->num_rows($q)) {
			while ($r = $mysql->fetch_array($q)) {
				$id = $r['episode_id'];
				$episode_name = $r['episode_name'];
				$film_name = check_data(get_data("film_name","film","film_id",$r['episode_film']));
				$film_name_ascii =get_ascii($film_name);
				$server_name="<a href='index.php?act=episode&mode=edit&film_id=".$film_id."&server=".$r['episode_type']."'><b> ".acp_text_type($r['episode_type'])."</b>";
				$broken = ($r['episode_broken'])?'<font color=red><b>X</b></font>':'';
				$sub_yes = ($r['episode_urlsub'])?"<font color=\"green\"><b>[Sub]</b></font>":"";
				$message_yes = ($r['episode_message'])?"<font color=\"red\"><b>[Message]</b></font>":"";
	            if($r['episode_local']) $url = get_data('local_link','local','local_id',$r['episode_local']).$r['episode_url'];
                else $url = $r['episode_url'];
				$main_html .="<tr><td class=fr><input class=checkbox type=checkbox id=checkbox onclick=docheckone() name=checkbox[] value=$id></td><td class=fr><a href='index.php?act=episode&mode=edit&episode_id=".$id."'><b>Episode ".$episode_name."</b></a> ||".$server_name." </a><br/><input type='text' value='".$url."' size='30' class='title' />".$sub_yes." ".$message_yes."</td><td class=fr_2 align=center><b><a href=?act=film&mode=edit&film_id=".$r['episode_film'].">".$film_name."</a></b></td><td  class=fr_2 align=center>".$broken."</td><td class=fr align=center><a href='?act=edit_episode&id=".$id."' target=_blank >Sửa</a> </td><td class=fr align=center><a href='../xem-phim-online/".replace($film_name_ascii)."/".$id.".html' target=_blank >Xem phim</a> </td></tr>";
			}
			$server_list=str_replace(array('<select name=file_type>','value=0','DEFAULT'),array('<select name=file_type onchange="load_again(this.value)">','value=""','Tất cả'),set_type($server));
			echo "<script>
function load_again(url){
	window.location='index.php?act=episode&mode=edit&film_id=".$film_id."&server='+url;
}
</script>
<table width=90% align=center cellpadding=0 cellspacing=0 class=border><form name=media_list method=post action=$link onSubmit=\"return check_checkbox();\">";
			echo '<tr><td class=fr><td colspan=8 align="center" class=fr>Hiện tập phim ở server '.$server_list.'</td><tr>';
			echo "<tr align=center><td width='3%' class=title></td><td class=title width=40%>TẬP || ĐƯỜNG DẨN</td><td class=title>TÊN PHIM</td><td class=title width=7%>LỖI</td><td class=title width=10%>SỬA</td><td class=title width=10%>KIỂM TRA</td></tr>";
			echo $main_html;
			echo '<tr><td class=fr><input class=checkbox type=checkbox name=chkall id=chkall onclick=docheck(document.media_list.chkall.checked,0) value=checkall></td>
			     <td colspan=7 align="center" class=fr>Với những tập đã chọn '.
				'<select name=selected_option>
			    <option value=multi_edit>Sửa</option>
			    <option value=del>Xóa</option>
				<option value=normal>Thôi báo lỗi</option></select>'.
				'<input type="submit" name="do" class=submit value="SEND">';
			echo '</form> Nhập ID server để xóa <input type="text" id="server_id"  name="server_id"> <input type="submit" class="submit" onclick="return removeserver();" value="Xóa"></td></tr></table>';

			echo "<tr><td colspan=8>".admin_viewpages($tt,$episode_per_page,$pg)."</td></tr>";
			echo "<script>
					function removeserver(){
						//var serverid	=	document.getElementById('server_id').value;
						//alert(serverid);
						window.location='index.php?act=episode&mode=remove&filmid=".$film_id."&serverid='+document.getElementById('server_id').value;
						return false;
					}
					</script>";
			
			}
		else echo "Phần này không có dữ liệu";
	}
}
?>