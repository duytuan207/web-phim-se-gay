<?php
error_reporting(E_ERROR| E_PARSE);
function is_mobile(){	
	if(isset($_SERVER['HTTP_X_WAP_PROFILE']))
	return true;
	if(preg_match('/wap.|.wap/i',$_SERVER['HTTP_ACCEPT']))
	return true;
	
	if(isset($_SERVER['HTTP_USER_AGENT']))
	{
		$user_agents = array(
		'midp', 'j2me', 'avantg', 'docomo', 'novarra', 'palmos', 
		'palmsource', '240x320', 'opwv', 'chtml', 'pda', 
		'mmp\/', 'blackberry', 'mib\/', 'symbian', 'wireless', 'nokia', 
		'cdm', 'up.b', 'audio', 'SIE-', 'SEC-', 
		'samsung', 'mot-', 'mitsu', 'sagem', 'sony', 'alcatel', 
		'lg', 'erics', 'vx', 'NEC', 'philips', 'mmm', 'xx', 'panasonic', 
		'sharp', 'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt', 
		'pg', 'vox', 'amoi', 'bird', 'compal', 'kg', 'voda', 'sany', 
		'kdd', 'dbt', 'sendo', 'sgh', 'gradi', 'jb', 'dddi', 'moto', 'ipad', 'iphone', 'Opera Mobi', 'android'
		);
		$user_agents = implode('|', $user_agents);
		if (preg_match("/$user_agents/i", $_SERVER['HTTP_USER_AGENT']))
		return true;
	}
	
	return false;
}
define('IN_MEDIA', true);
define('IN_MEDIA_ADMIN', true);
include("../inc/_config.php");
include("../inc/_form.php");
include("../inc/_functions.php");
include("../inc/_string.php");
$level = $_SESSION['admin_level'];
$form = new HTMLForm;
?>
<html>
<head>
<?php if ($act == 'left') echo '<base target="frame_content">'; ?>
<title>.: <?php echo $web_title?> CONTROL PANEL :.</title>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<link rel=stylesheet href="style.css" type=text/css>
</head>
<?php if (!$level) { ?>
	<form method="post" action="login.php">
	<table width=31% align=center cellpadding=2 cellspacing=0 class=border bgcolor=white>
	<tr><td colspan=2 align=center class=title><?php if($error=="u"){ ?>Sai mật khẩu<?php }else{ ?>Điền đầy đủ thông tin đăng nhập<?php } ?></td></tr>
	<tr><td width=48% class=fr>Tên đăng nhập</td><td width=52% class=fr_2><input name="name" type="text" size="20"></td></tr>
	<tr><td class=fr>Mật khẩu</td><td class=fr_2><input name="password" type="password" size="20"></td></tr>
	<tr><td class=fr colspan=2 align=center><input class="submit" type="submit" name="submit" value="Đăng nhập"></td></tr>
	</table>
	</form>
	<?php
	exit();
}
include("admin_functions.php");

$mod_permission = acp_get_mod_permission($level);
$link = 'index.php';
if ($_SERVER["QUERY_STRING"]) $link .= '?'.$_SERVER["QUERY_STRING"];
?>
<script src="../js/lib.jquery.js"></script>
<script src="../js/admin.js"></script>
<script src="../js/unikey.js"></script>
<script language="JavaScript" type="text/javascript" src="./ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/openwysiwyg/wysiwyg.js"></script>
<?php
if ($act) echo '<table cellspacing="0" align="center" cellpadding="0" width="100%"><tr><td align="center" width="100%">';
switch($act){
	case "episode":				include("episode.php");break;
	case "leech":				include("multi_add_leech.php");break;
	case "contact":				include("contact.php");break;
	case "hdonline":			include("hdonline.php");break;
	case "mananhnho":			include("mananhnho.php");break;
	case "lech_dienvien":		include("lech_dienvien.php");break;
	case "vkool":				include("vkool.php");break;
	case "xps":					include("multi_add_xps.php");break;
	case "multi_edit_episode":	include("multi_edit_episode.php");break;
	case "edit_episode":		include("edit_episode.php");break;
	case "cat":					include("cat.php");break;
	case "country":				include("country.php");break;
	case "dienvien":			include("dienvien.php");break;
	case "film":				include("film.php");break;
	case "multi_edit_film":		include("multi_edit_film.php");break;
	case "skin":				include("skin.php");break;
	case "ads":					include("ads.php");break;
	case "user":				include("user.php");break;
	case "news":				include("news.php");break;
	case "config":				include("configures.php");break;
	case "comment":				include("comment.php");break;
	case "local":				include("local.php");break;
	case "trailer":				include("trailer.php");break;
	case "request":				include("request.php");break;
	case "tags":				include("tags.php");break;
	case "player":				include("player.php");break;
	case "permission":			include("permission.php");break;
	case "text":    			include("textlink.php");break;
	case "main"	:				echo "<div class=title><b>Welcome to ".$web_title." Control Panel"; break;
	case "left"	:				include("left.php");break;
	case "addmulti"	:			include("addfilm_new.php");break;
	case "clipvn"	:			include("clipvn.php");break;
	case "webmail"	:			include("webmail.php");break;
	case "sendmail2"	:		include("sendmail2.php");break;
	default : echo '<script type="text/javascript">if (self.parent.frames.length != 0) self.parent.location.replace(document.location.href);</script>';	break;
}
	?>
	<frameset cols="200,*" rows="*" id="mainFrameset">
	<frame src="index.php?act=left" name="frame_navigation" frameborder="0" noresize />		
	<frame src="index.php?act=film&mode=edit" name="frame_content" id="frame_content" frameborder="0" noresize />	
	
<?php
if ($act) echo '</td></tr></table>';
?>
</html>