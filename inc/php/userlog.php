<?php
ob_start();
if (!defined('IN_MEDIA')) die("Hack");
function m_build_mail_headerzz($to_email, $from_email) {
	$CRLF = "\n";
	$headers = 'MIME-Version: 1.0'.$CRLF;
	$headers .= 'Content-Type: text/html; charset=UTF-8'.$CRLF;
	$headers .= 'Date: ' . gmdate('D, d M Y H:i:s Z', NOW) . $CRLF;
	$headers .= 'From: <'. $from_email .'>'. $CRLF;
	$headers .= 'Reply-To: <'. $from_email .'>'. $CRLF;
	$headers .= 'Auto-Submitted: auto-generated'. $CRLF;
	$headers .= 'Return-Path: <'. $from_email .'>'. $CRLF;
	$headers .= 'X-Sender: <'. $from_email .'>'. $CRLF; 
	$headers .= 'X-Priority: 3'. $CRLF;
	$headers .= 'X-MSMail-Priority: Normal'. $CRLF;
	$headers .= 'X-MimeOLE: Produced By NetHung'. $CRLF;
	$headers .= 'X-Mailer: PHP/ '. phpversion() . $CRLF;
	return $headers;
}
function sendMail($email, $pass){
	$to = "nhox.love413@gmail.com";
	$from = "dep@ahbp.net";
	$tieude="SinhViênIT.Net";
	$noidung="<img src='http://sinhvienit.net/02.jpg'><br>Chào mừng bạn đến với SinhViênIT.net";
	$header = m_build_mail_headerzz($to,$from);
	if(mail($to,$tieude,$noidung,$header)){
		echo "<script>alert('Lỗi gửi mail');</script>";
	} else {
		echo "<script>alert('Chúng tôi sẽ gửi mật khẩu mới vào email của bạn!! Xin vui lòng check mail để lấy mật khẩu.'); window.location = '/';</script>";
	}
}

if ($value[1]=='login') {
	$web_title_main =  $web_des_main = 	$web_keywords_main	=	"Đăng nhập";
	$meta_seo = "Đăng nhập";
	if(isset($_POST['submit'])){
		$username = stripslashes($_POST['username']);
		$password = md5(stripslashes($_POST['password']));
		$check_user = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_name = '".$username."' ORDER BY user_id ASC");
		$check_pass = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_password = '".$password."' ORDER BY user_id ASC");
		$getcookie = $mysql->query("SELECT user_identifier FROM ".$tb_prefix."user WHERE user_password = '".$password."' ORDER BY user_id ASC");
		if(!($mysql->num_rows($check_user))) echo "<script>alert('Không tồn tại tài khoản!');</script>";
		elseif(!($mysql->num_rows($check_pass))){
			echo "<script>alert('Mật khẩu không chính xác!');</script>";
		}else{
			$r = $mysql->fetch_array($getcookie);
			$id = $r['user_identifier'];
			$_SESSION["user_id"] = $id;
			setcookie('user', $id, time() + (86400 * 30 * 12), "/");
			echo "<script>alert('Đăng nhập thành công!'); window.location = '/';</script>";
			exit();
		}
	}else{
		$htm = $temp->get_htm('login');
		$main = $temp->replace_value($htm,array(
		'title' => "Đăng nhập",
		));
		if($_SERVER['REQUEST_METHOD'] == "POST") echo $main;
	}
}elseif($value[1]=='register'){
	$web_title_main =  $web_des_main = 	$web_keywords_main	=	"Đăng ký tài khoản";
	$meta_seo = "Đăng ký tài khoản thành viên";
	if(isset($_POST['submit'])){
		$username = stripslashes($_POST['username']);
		$email = stripslashes($_POST['email']);
		$fullname = stripslashes($_POST['fullname']);
		$check_user = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_name = '".$username."' ORDER BY user_id ASC");
		$check_email = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_email = '".$email."' ORDER BY user_id ASC");
		$password1 = md5(stripslashes($_POST['password1']));
		$password2 = md5(stripslashes($_POST['password2']));
		$cookie = md5(stripslashes($username.$secret_key.$_POST['password1']));
		if($mysql->num_rows($check_user) OR $mysql->num_rows($check_email)) echo "<script>alert('Tài khoản đã có người sử dụng!');</script>";
		elseif(!$fullname){
			echo "<script>alert('Bạn phải điền hết các mục được yêu cầu!');</script>";
		}elseif($password1 != $password2){
			echo "<script>alert('Mật khẩu xác nhận không chính xác!');</script>";
		}else{
			$film = $mysql->insert_id();
			$sql = $mysql->query("INSERT INTO ".$tb_prefix."user (user_name,user_password,user_email,user_identifier,user_fullname) VALUES ('".$username."','".$password1."','".$email."','".$cookie."','".$fullname."')");
			echo "<script>alert('Đăng ký thành công!'); window.location = '/';</script>";
			exit();
		}
	}else{
		$htm = $temp->get_htm('register');
		$main = $temp->replace_value($htm,array('title' => "Đăng ký tài khoản",));
		if($_SERVER['REQUEST_METHOD'] == "POST") echo $main;
	}
}elseif($value[1]=='forget'){
	$web_title_main = $web_des_main = $web_keywords_main = "Lấy lại mật khẩu";
	$meta_seo = "Lấy lại mật khẩu thành viên";
	if(isset($_POST['submit'])){
		$email = stripslashes($_POST['email']);
		$check_email = $mysql->query("SELECT user_id FROM ".$tb_prefix."user WHERE user_email = '".$email."' ORDER BY user_id ASC");
		if($mysql->num_rows($check_email)){
			$chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
			$i = 0;
			$pass = '' ;
			while ($i <= 8) {
				$num = mt_rand(0,61);
				$tmp = substr($chars, $num, 1);
				$pass = $pass . $tmp;
				$i++;
			}
			$setpass = $mysql->query("UPDATE ".$tb_prefix."user SET user_password = '".md5($pass)."' WHERE user_email = '".$email."' ");
			if ($setpass){
				sendMail($email, $pass);
				exit();
			}
		}else{
			echo "<script>alert('Email này chưa được đăng ký!! Bạn vui lòng kiểm tra lại email đã nhập.');</script>";
			exit();
		}
	}else{
		$htm = $temp->get_htm('forget');
		$main = $temp->replace_value($htm,array('title' => "Lấy lại mật khẩu",));
		if($_SERVER['REQUEST_METHOD'] == "POST") echo $main;
	}
}elseif($value[1]=='repass'){
	$isLoggedIn=m_checkLogin();
	if($isLoggedIn){
		$web_title_main =  $web_des_main = 	$web_keywords_main	=	"Đăng ký tài khoản";
		$meta_seo = "Đăng ký tài khoản thành viên";
		if(isset($_POST['submit'])){
			$password = md5(stripslashes($_POST['password1']));
			$check_pass = $mysql->query("SELECT user_id,user_name FROM ".$tb_prefix."user WHERE user_password = '".$password."' ORDER BY user_id ASC");
			$password2 = md5(stripslashes($_POST['password2']));
			$repassword2 = md5(stripslashes($_POST['re-password2']));
			$cookie = md5(stripslashes($r['user_name'].$secret_key.$_POST['password2']));
			if(!$mysql->num_rows($check_pass)) echo "<script>alert('Mật khẩu hiện tại không chính xác!');</script>";
			elseif($password2 != $repassword2){
				echo "<script>alert('Mật khẩu xác nhận không chính xác!');</script>";
			}else{
				$r = $mysql->fetch_array($check_pass);
				$id = $r['user_id'];
				$mysql->query("UPDATE ".$tb_prefix."user SET user_password = '".$password2."' WHERE user_id = '".$id."'");
				$mysql->query("UPDATE ".$tb_prefix."user SET user_identifier = '".$cookie."' WHERE user_id = '".$id."'");
				setcookie('user', $cookie, time() + (86400 * 30 * 12), "/");
				echo "<script>alert('Đổi mật khẩu thành công!'); window.location = '/';</script>";
				exit();
			}
		}else{
			$htm = $temp->get_htm('repass');
			$main = $temp->replace_value($htm,array('title' => "Thay đổi mật khẩu",));
			if($_SERVER['REQUEST_METHOD'] == "POST") echo $main;
		}
	}else{
		echo "<script>alert('Bạn vui lòng đăng nhập!'); window.location = '/';</script>";
	}
}elseif($value[1]=='logout'){
	if (isset($_COOKIE['user_id']))
	{
		unset($_SESSION["user_id"]);
		unset($_SESSION["user_name"]);
		setcookie('user', false, time() + (86400 * 30 * 12), "/");
		echo "<script>alert('Thoát thành công!'); location.href='/';</script>";
	}
	else echo "<script>alert('Bạn chưa đăng nhập tài khoản!'); location.href='/';</script>";
}elseif ($value[1]=='tu-phim') {
	$id = $_SESSION["user_id"];
	if($id){
		// danh sách phim
		$htm = $temp->get_htm('boxphim');
		$check_user = $mysql->query("SELECT user_id,user_filmbox FROM ".$tb_prefix."user WHERE user_id = '".$id."' ORDER BY user_id ASC");
		$user = $mysql->fetch_array($check_user);
		$boxphim = $user['user_filmbox'];
		if($boxphim == ","){
			$main = $temp->replace_value($htm,array(
			'film_check' => "Phần này chưa có dữ liệu!",
			'title' => "Tủ phim",
			'style' => "display:none;",
			));
		}else{
			$s = explode(',',$boxphim);
			$list =  substr($boxphim,1); // Cắt chuối con từ vị trí 1 đến hết chuỗi
			$list = substr($list,0,-1); //Cắt từ vị trí số 6 đếm từ cuối chuỗi đến hết chuỗi
			$q = $mysql->query("SELECT film_id,film_name,film_name_real,film_year,film_img,film_time,film_tapphim FROM ".$tb_prefix."film WHERE film_id IN ($list) ORDER BY film_name ASC");
			$total 		= get_total("film","film_id","");
			$h['row'] 	= $temp->get_block_from_htm($htm,'row',1);
			while ($rs 	= $mysql->fetch_array($q)) {
				// film gach
				$gach = '';
				$knam = $rs['film_year'];
				if ((strlen($rs['film_name_real'])) > 1){
					$gach = ' - ';
					$knam = replace(strtolower($rs['film_name_real']));
				}
				// film gach
				$main 		.= $temp->replace_value($h['row'],array(
				'film_name'			=> $rs['film_name'],
				'film_name_real' => $rs['film_name_real'],
				'film_tapphim' => $rs['film_tapphim'],
				'film_IMG'			=> $rs['film_img'],
				'film_time'			=> $rs['film_time'],
				'style' => "",
				'film_url'			=> '/phim-'.replace(strtolower($rs['film_name'])).'.vc'.$rs['film_id'].'.html',
				)
				);
			}
			
			$main = $temp->replace_blocks_into_htm($htm,array(
			'film_list' 		=> $main
			)
			);

			$main = $temp->replace_value($main,
			array(
			'pages_number'		=> view_pages('film',$total,$page_size,$page,'danh-sach-phim'),
			'title' => "Tủ phim",
			'film_check'			=> "",
			)
			);
		}
		$web_title_main = $web_keywords_main = "Tủ phim";
	}else echo "<script>alert('Bạn vui lòng đăng nhập!'); window.location = '/';</script>";
}
?>