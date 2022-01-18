<?php
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
if ($level != 3) {
	echo "Ban khong du quyen de truy cap vao phan nay.";
	exit();
}
$link = 'index.php?act=contact&mode=email';
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
$inp_arr = array(
		'title'		=> array(
			'table'	=>	'c_title',
			'name'	=>	'Tiêu đề',
			'type'	=>	'free',
		),
		'content'			=> array(
			'table'		=>	'c_content',
			'name'		=>	'Nội dung',
			'type'		=>	'text',
			'can_be_empty'	=> false,
		),
);
$text_link 	= array("<a href='http://phimoke.com' title='xem phim'><b>Xem Phim</b></a>","<a href='http://phimoke.com/phim-18.html' title='phim 18+'><b>Phim 18+</b></a>","<a href='http://phimoke.com/phim-cap-3.html' title='phim cap 3'><b>Phim cap 3</b></a>","<a href='http://phimoke.com/phim-phim-sex-chon-loc-tren-may-tinh-2014.oke25.html' title='phim sex'><b>Phim sex</b></a>","<a href='http://phimoke.com/phim-sex-co-trang-thoi-xua-hay-va-chat-luong.oke152.html' title='phim sex co trang'><b>Phim sex co trang</b></a>");
##################################################
# ADD MEDIA
##################################################
if ($mode == 'email') {
	if ($_POST['submit']) {
		$error_arr = array();
		$error_arr = $form->checkForm($inp_arr);
		$qq = $mysql->query("SELECT * FROM ".$tb_prefix."config WHERE cf_id = 1");
		$cf = $mysql->fetch_array($qq);
		$from 		= 	$cf['cf_web_email'];
		$send_mail = add_send_mail($_POST['content']);
		$qqq = $mysql->query("SELECT * FROM ".$tb_prefix."sendmail WHERE sendmail_id = $send_mail");
		$cff = $mysql->fetch_array($qqq);
		$content 		= 	$cff['sendmail_info'];
		$mail_content = $_POST['title']."<br />".$content."<br>".$text_link[array_rand($text_link)];
		$mail_title = get_ascii($_POST['title']);
		if (!$error_arr) {
			$q = $mysql->query("SELECT send_mail_seo FROM ".$tb_prefix."config WHERE cf_id = 1");
			$i = 0;
			while ($r = $mysql->fetch_array($q)) {
			$to = $r['send_mail_seo'];
			$header = m_build_mail_headerzz($to,$from);
			$i++;
			mail($to,$mail_title,$mail_content,$header);
			//if($i%100==0) sleep(1);
			}
			echo "Đã thực hiện xong <meta http-equiv='refresh' content='0;url=$link'>";
			exit();
		}
	}
	$warn = $form->getWarnString($error_arr);

	$form->createForm('Gửi email đến website cần seo',$inp_arr,$error_arr);
}
?>