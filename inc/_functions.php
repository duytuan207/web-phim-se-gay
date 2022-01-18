<?php
if (!defined('IN_MEDIA')) die("Hack");
//////////////////////////////
//// CACHE //////////////////
////////////////////////////
function cache_begin($cachefile,$cachetime=''){
	if (!$cachetime)	$cachetime = 60*10;
	// Ignore List
	$ignore_list = array(
	'/rss.php',
	'/search/'
	);
	// Script
	$ignore_page = false;
	for ($i = 0; $i < count($ignore_list); $i++) {
		$ignore_page = (strpos($page, $ignore_list[$i]) !== false) ? true : $ignore_page;
	}
	$cachefile_created = ((@file_exists($cachefile)) and ($ignore_page === false)) ? @filemtime($cachefile) : 0;
	@clearstatcache();
	// Show file from cache if still valid
	if (time() - $cachetime < $cachefile_created) {
		$html = file_get_contents($cachefile);
	}
	return $html;
}
function cache_end($cachefile,$content) {
	$fp = @fopen($cachefile, 'w');
	@fwrite($fp, $content);
	@fclose($fp);
}
// MAKE LINK
function make_link($type,$name,$id,$ep_name="",$server=0){
	global $web_link;
	$web_type 	=	".html";
	switch($type){
	case "cat"		:  	$link	= $web_link."/the-loai-phim-".strtolower(replace($name)).'_'.$id.'/trang-1'.$web_type;break;
	case "cat2"		:  	$link	= $web_link."/the-loai-phim-".strtolower(replace($name)).'_'.$id;break;
	case "country"	:  $link	= $web_link."/quoc-gia-".strtolower(replace($name)).'_'.$id.'/trang-1'.$web_type;break;
	case "country2"	:  $link	= $web_link."/quoc-gia-".strtolower(replace($name)).'_'.$id;break;
	case "info"		:  $link	= $web_link."/phim/".strtolower(replace($name))."-".$id.$web_type;break;
	case "watch"	:  $link	= $web_link."/xem-phim-online/".strtolower(replace($name))."/".$id.(($eps_name!="")?"-Tap-".$eps_name:"").(($server!=0)?'-server-'.(trim(strip_tags(acp_text_type($server)))):"").$web_type;break;
	case "news"		:  $link	= $web_link."/tin-tuc/".strtolower(replace($name))."/".$id.$web_type;break;
	case "list"		:  $link	= $web_link.'/danh-sach/'.$name.'/trang-1'.$web_type;break;
	case "list2"	:  $link	= $web_link.'/danh-sach/'.$name;break;
	case "tim-kiem"	:  $link	= $web_link.'/tim-kiem/'.replacesearch($name).'/trang-1'.$web_type;break;
	case "tim-kiem2":  $link	= $web_link.'/tim-kiem/'.replacesearch($name);break;
	case "dien-vien":  $link	= $web_link.'/dien-vien/'.$name.'/trang-1'.$web_type;break;
	case "dien-vien2": $link	= $web_link.'/dien-vien/'.$name;break;
	case "dao-dien"	:  $link	= $web_link.'/dao-dien/'.$name.'/trang-1'.$web_type;break;
	case "dao-dien2":  $link	= $web_link.'/dao-dien/'.$name;break;
	case "year"		:  $link	= $web_link.'/year/'.$name.'/trang-1'.$web_type;break;
	case "year2"	:  $link	= $web_link.'/year/'.$name;break;
	case "quick_search"	:  $link= $web_link.'/quick_search/'.$name;break;
	}
	return $link;
}
function Upcase_First($string)
{
	$string = replace($string);
	$string = str_replace(array('-', '_'), ' ', $string);
	$string = str_replace(' ', '-', $string); 
	return $string;
}
function Encode_ID($id)
{
	$id += 123456;
	$id = str_replace(array('0','1','2','3','4','5','6','7','8','9'),array('E','R','M','N','J','I','Z','K','L','O'),$id);
	return $id;
}
function Decode_ID($id)
{
	$id = strtoupper($id);
	$id = str_replace(array('E','R','M','N','J','I','Z','K','L','O'),array('0','1','2','3','4','5','6','7','8','9'),$id);
	$id -= 123456;
	return $id;
}
function split_link($type,$str)
{
	if ($str =="") return "N/A";
	$ex		=	explode(",",$str);
	$rstr	=	"";
	for ($i=0; $i<count($ex);$i++)
	{
		if ($type=="cat" || $type=="cat2")
		$name	=	check_data(get_data('cat_name','cat','cat_id',$ex[$i]));
		elseif ($type=="country")
		$name	=	check_data(get_data('country_name','country','country_id',$ex[$i]));
		else 
		$name	=	$ex[$i];
		if ($type=="cat2")
		$rstr .= '<span typeof="v:Breadcrumb"><a href="'.make_link("cat",$name,$ex[$i]).'" title="'.str_replace(array("dao-dien","dien-vien","cat2","country","cat"),array("Đạo diễn","Diễn viên","Thể loại","Quốc gia","Thể loại"),$type)." ".$name.'">'.$name.'</a> » </span>';
		else 
		$rstr .= '<a href="'.make_link($type,$name,$ex[$i]).'" title="'.str_replace(array("dao-dien","dien-vien","cat2","country","cat"),array("Đạo diễn","Diễn viên","Thể loại","Quốc gia","Thể loại"),$type)." ".$name.'">'.$name.'</a>,';
	}
	return $rstr;
}
function split_epi($list)
{
	if($list) $link_tapphim='<span class="process"><span>'.$film_tapphim.'</span></span>';
	$tapphim=explode(',',$list);
	$link_tapphim="";
	for ($i=0; $i<count($tapphim);$i++) {
		$film_tapphim = check_tapphim($list);
		$link_tapphim .= '<span class="process"><span>'.$film_tapphim.'</span></span>';
	}
	return $link_tapphim;
}
function build_tag($name,$rname,$name_ascii,$year,$id)
{
	$tag	=	'<a title="xem phim'.$name.'" href="'.make_link("watch",$name_ascii."-".$rname.'-'.$year,$id).'">'.$name.'</a>,'; 
	$tag	.=	'<a title="xem phim'.$name.' vietsub online" href="'.make_link("watch",$name_ascii."-".$rname.'-'.$year,$id).'">'.$name.' vietsub online</a>,';				 	$tag	.=	'<a title="'.$rname.'" href="'.make_link("info",$name_ascii."-".$rname.'-'.$year,$id).'">'.$name.'</a>,';
	$tag	.=	'<a title="Xem online '.$name.'" href="'.make_link("info",$name_ascii."-".$rname.'-'.$year,$id).'">xem online'.$name.'</a>,';
	return $tag;
}
function rating_google($rate,$rate_tt,$title,$img)
{
	if ($rate_tt =='0') $rating = 0;
	else $rating = round(($rate / $rate_tt)*2,1);
	$html ='<div itemscope="" itemtype="http://data-vocabulary.org/Recipe" style="display:none;">
		<h1 itemprop="name">'.$title.'</h1>
		<img itemprop="photo" src="'.$img.'" />By <span itemprop="author">'.$title.'</span>
		<span itemprop="review" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
		<span itemprop="rating">'.$rating.'</span> stars on 
		<span itemprop="best">10</span>
		based on
		<span itemprop="count">'.$rate_tt.'</span> reviews </span></div>';
	return $html;
}
function rating_img($rate,$rate_tt,$type=2) {
	global $r_s_img;
	if ($rate_tt =='0') $rating = 0;
	else $rating = @($rate/$rate_tt);
	if ($rating <= 0  ){$star1 = "none"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 0.5){$star1 = "half"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 1  ){$star1 = "full"; $star2 = "none"; $star3 = "none"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 1.5){$star1 = "full"; $star2 = "half"; $star3 = "none"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 2  ){$star1 = "full"; $star2 = "full"; $star3 = "none"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 2.5){$star1 = "full"; $star2 = "full"; $star3 = "half"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 3  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "none"; $star5 = "none";}
	if ($rating >= 3.5){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "half"; $star5 = "none";}
	if ($rating >= 4  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "none";}
	if ($rating >= 4.5){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "half";}
	if ($rating >= 5  ){$star1 = "full"; $star2 = "full"; $star3 = "full"; $star4 = "full"; $star5 = "full";}
	if ($type == 1 ) $r_s_img = '<div class="film_action"><div class="star_items"><span class="rate '.$star1.'" data="'.$star1.'" data-id="1" data-meaning="Kém"></span><span class="rate '.$star2.'" data="'.$star2.'" data-id="2" data-meaning="Bình thường"></span><span class="rate '.$star3.'" data="'.$star3.'" data-id="3" data-meaning="Được"></span><span class="rate '.$star4.'" data="'.$star4.'" data-id="4" data-meaning="Hay"></span><span class="rate '.$star5.'" data="'.$star5.'" data-id="5" data-meaning="Tuyệt vời"></span></div></div>'
	.'</ul>';	
	elseif ($type == 2) $r_s_img = 	"<span class=".$star1."></span><span class=".$star2."></span><span class=".$star3."></span><span class=".$star4."></span><span class=".$star5."></span>";
	elseif ($type == 3) $r_s_img = 	"<span class=".$star1."1></span><span class=".$star2."1></span><span class=".$star3."1></span><span class=".$star4."1></span><span class=".$star5."1></span>";
}
function m_setcookie($name, $value = '', $permanent = true) {
	global $web_link;
	$setCookieType=1;	
	$expire = ($permanent)?(time() + 60 * 60 * 24 * 365):0;
	
	if ($setCookieType == 1) {
		$url = $web_link;
		if ($url[strlen($url)-1] != '/') $url .= '/';
		$secure = (($_SERVER['HTTPS'] == 'on' OR $_SERVER['HTTPS'] == '1') ? true : false);
		$p = parse_url($url);
		$path = !empty($p['path']) ? $p['path'] : '/';
		$domain = $p['host'];
		if (substr_count($domain, '.') > 1) {
			while (substr_count($domain, '.') > 1)
			{
				$pos = strpos($domain, '.');
				$domain = substr($domain, $pos + 1);
			}
			
		}
		else $domain = '';
		@setcookie($name, $value, $expire, $path, $domain, $secure);
	}
	else @setcookie($name,$value,$expire);
}
// iframe
function m_checkLogin(){
	global $mysql, $tb_prefix;
	
	if ($_COOKIE['user']) {
		$identifier = $_COOKIE['user'];
		$q = $mysql->query("SELECT user_identifier,user_id,user_name FROM ".$tb_prefix."user WHERE user_identifier = '".$identifier."'");
		if ($mysql->num_rows($q)) {
			$r = $mysql->fetch_array($q);
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['user_name'] = $r['user_name'];
			$return = true;
		}
		else $return = false;
	}
	else $return = false;
	return $return;
}
function get_total($table,$f1,$f2 = '') {
	global $mysql, $tb_prefix;
	$q = "SELECT COUNT($f1) FROM ".$tb_prefix.$table;
	$q .= ($f2)?" ".$f2:'';
	$tt = $mysql->fetch_array($mysql->query($q));
	return $tt[0];
}
function m_random_str($len = 5) {
	$s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	mt_srand ((double)microtime() * 1000000);
	$unique_id = '';
	for ($i=0;$i< $len;$i++)
	$unique_id .= substr($s, (mt_rand()%(strlen($s))), 1);
	return $unique_id;
}
function m_check_random_str($str,$len = 5) {
	if (!ereg('^([A-Za-z0-9]){'.$len.'}$',$str)) return false;
	return true;
}
function replace($string) {
	$string = get_ascii($string);
	$string = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'),
	array('', '-', ''), htmlspecialchars_decode($string));
	return $string;
}
function check_img($img) {
	if ($img == '') $img = $_SESSION['skin_folder']."/img/no_img.gif";
	return $img;
}
function check_img1($img) {
	$img = str_replace('images/thumbx','http://m.xemphimon.com/images/thumbx',$img);
	return $img;
}
function check_data($name) {
	if ($name == '') $name = "";
	return $name;
}
function check_info1($name) {
	if ($name == 'alt=""') $name = 'alt="Xem Phim Online"';
	return $name;
}
function check_year($name) {
	if ($name == '') $name = "";
	return $name;
}
function check_tapphim($name) {
	if ($name == '') $name = "";
	return $name;
}
function text_tidy($string) {
	$string = str_replace ( '&amp;', '&', $string );
	$string = str_replace ( "'", "'", $string );
	$string = str_replace ( '&quot;', '"', $string );
	$string = str_replace ( '&lt;', '<', $string );
	$string = str_replace ( '&gt;', '>', $string );
	$string = str_replace ( '"', ' ', $string );
	return $string;
}
function htmltxt($document){
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
	'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
	'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
	'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
	);
	$text = preg_replace($search, '', $document);
	return $text;
} 
function text_tidy1($string) {
	$string = str_replace ( '&amp;', '&', $string );
	$string = str_replace ( "'", "'", $string );
	$string = str_replace ( '&quot;', '"', $string );
	$string = str_replace ( '&lt;', '<', $string );
	$string = str_replace ( '&gt;', '>', $string );
	$string = str_replace ( '"', '"', $string );
	$string = str_replace ( 'alt=""', 'alt="Xem Phim Online"', $string );
	return $string;
}
function cut_string($str,$len) {
	if ($str=='' || $str==NULL) return $str;
	if (is_array($str)) return $str;
	$str = trim($str);
	if (strlen($str) <= $len) return $str;
	$str = substr($str,0,$len);
	$str = $str.' ...';
	return $str;
}
function get_words($str,$num){
	$limit = $num - 1 ;
	$str_tmp = '';
	$arrstr = explode(" ", $str);
	if ( count($arrstr) <= $num ) { return $str; }
	if (!empty($arrstr))
	{
		for ( $j=0; $j< count($arrstr) ; $j++)    
		{
			$str_tmp .= " " . $arrstr[$j];
			if ($j == $limit) 
			{
				break;
			}
		}
	}
	return $str_tmp.'';/// ...
}
function check_str_old($a){
	$n=intval(strlen($a)/21);
	if($n>0)
	{
		for($i=1;$i<=$n;$i++)
		{
			$b=$b.substr($a,0,21)." ";
			$a=substr($a,21,strlen($a));
		}
	}
	else
	{
		$b=$a;
	}
	return $b;
}
function check_str($str) {$str2 = explode(' ',$str);$count = count($str2);for ($i= 0; $i < $count ; $i++){if(strlen($str2[$i]) < 10){$result .= $str2[$i].' ';continue;}$str3 = substr($str2[$i],0,10);$result .= $str3.' ';}return $result;}
function bad_words($str) {
	$chars = array('địt','Địt','ĐỊT','đéo','Đéo','ĐÉO','lồn','Lồn','LỒN','cặc','Cặc','CẶC','dái','Dái','DÁI','chó','Chó','CHÓ','Cứt','cứt','CỨT','ỉa','Ỉa','đái','Đái','ỈA','lon','nhu lon','dit','djt','dis','địt me','dit me','djt me','dis me','l0n','loz me','loz','lozz','lonn','loon','lôz','l0z');
	foreach ($chars as $key => $arr)
	$str = preg_replace( "/(^|\b)".$arr."(\b|!|\?|\.|,|$)/i", "8-x", $str ); 
	$str = wordwrap($str, 23, " ", true);
	$str = str_replace('<','&lt;',$str);
	$str = check_str($str);
	return $str;
}
function un_htmlchars($str) {
	return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39'), array('<', '>', '"', '&', chr(92), chr(39)), $str );
}
function htmlchars($str) {
	return str_replace(
	array('&', '<', '>', '"', chr(92), chr(39)),
	array('&amp;', '&lt;', '&gt;', '&quot;', '&#92;', '&#39'),
	$str
	);
}
function get_ascii($str) {
	$chars = array(
	'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
	'e' 	=>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
	'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
	'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
	'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
	'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
	'd'	=>	array('đ','Đ'),
	);
	foreach ($chars as $key => $arr) 
	foreach ($arr as $val)
	$str = str_replace($val,$key,$str);
	return $str;
}
function injection($str) {
	$chars = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(','cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20', 'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20', '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq','/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20', '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml', 'file\://', 'window.open', '<SCRIPT>', 'javascript\://','img src', 'img%20src','.jsp','ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', '/robot.txt' ,'/perl' ,'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=','\'');
	foreach ($chars as $key => $arr)
	$str = str_replace($arr, '*', $str); 
	return $str;
}
function del_HTML($document){
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
	'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
	'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
	'@<DIV[^>]*?>.*?</DIV>@siU',    // Strip style tags properly
	'@<div[^>]*?>.*?</div>@siU',    // Strip style tags properly
	'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
	);
	$text = preg_replace($search, '', $document);
	return $text;
} 
function check_name($str)
{
	for($i=0;$i<5;$i++)	{
		$str= str_replace('  ',' ',$str);}
	$str= str_replace(' ,',',',$str);
	$str = ltrim($str); $str= rtrim($str);
	$str = queryspecail($str);
	return $str;
}	
function TAGS($text) {
	$text	= 	str_replace("-","",$text);
	$text	= 	str_replace("(","",$text);
	$text	= 	str_replace(")","",$text);
	$text	= 	str_replace("  "," ",$text);
	$text	= 	str_replace("   "," ",$text);
	$text	=	explode(" ",$text);
	for ($i = 0; $i < count($text); $i++) {
		$tags	.= 	$text[$i].",";
	}
	$tags = substr($tags,0,-1);
	return	$tags;
}
function TAGS_LINK($text) {
	$text	=	str_replace(",  ",",",$text);
	$text	=	str_replace(", ",",",$text);
	$text   = 	explode(",",$text);
	for ($i = 0; $i < count($text); $i++) {
		$data	=	str_replace(" ","+",$text[$i]);
		$html	.= 	"<a href=\"".$web_link."/tu-khoa-phim/".$data.".html\" title=\"Xem Phim ".$text[$i]."\">".$text[$i]."</a>,";
	}
	$html = substr($html,0,-1);
	return $html;
}
function TAGS_LINK2($text) {
	global $web_link;
	$text	=	str_replace(",  ",",",$text);
	$text	=	str_replace(", ",",",$text);
	$text   = 	explode(",",$text);
	for ($i = 0; $i < count($text); $i++) {
		$data	=	str_replace(" ","-",$text[$i]);
		$html	.= 	"<a href=\"".$web_link."/tag/".strtolower(get_ascii($data)).".html\" rel=\"follow, index\" title=\"Xem Phim ".$text[$i]."\">".$text[$i]."</a>, ";
	}
	$html = substr($html,0,-2);
	return $html;
}
function TAGS_CLOUD($text) {
	global $web_link;
	$text	=	str_replace(",  ",",",$text);
	$text	=	str_replace(", ",",",$text);
	$text   = 	explode(",",$text);
	for ($i = 0; $i < count($text); $i++) {
		$tagcloud = del_HTML($text[$i]);
		$data	=	str_replace(" ","-",$tagcloud);
		$html	.= 	"<a href=\"".$web_link."/tag/".strtolower(get_ascii($data)).".html\" rel=\"follow, index\" title=\"".$tagcloud."\">".$text[$i]."</a> ";
	}
	$html = substr($html,0,-1);
	return $html;
}
function searchTxt($txt) {
	$txt	=	str_replace(array(' full hd','download phim ','download ',' tap cuoi',' vietsub',' phụ đề',' trọn bộ', ' hd', ' full', ' kst', ' krfilm', ' kites', ' ffvn', ' tvb', ' hàn quốc', ' trung quốc', ' đài loan', ' việt nam', ' thái lan'),array(''), $txt);
	return $txt;
}
function check_tag_cat ($id,$type='') {
	//return false;
	global $mysql,$tb_prefix;
	
	if ($id>0)
	{
		$cut = 0;
		if ($_SESSION['name_cat_'.$id] && $_SESSION['name_cat_'.$id]!="" ) return $_SESSION['name_cat_'.$id];
	}
	else $cut =1;
	
	if (!$type) {
		$id = str_replace(',',"','",$id);
		
		$q = "SELECT cat_id,cat_name FROM ".$tb_prefix."cat WHERE cat_id IN ('".$id."')";
		$key = md5($q);
		$catx = array();		
		$q = $mysql->query($q);
		while ($r=$mysql->fetch_assoc($q)){
			$catx[] = $r;			
		}						
		foreach($catx as $r) {
			if ($cut==0)
			{
				$name =  $r['cat_name'];
				$name = ucwords(mb_strtolower($name,"UTF-8"));
				$name = str_replace(array("I","N"),array("i","n"),$name);
			}
			else $name = $r['cat_name'];
			$list_cat .= ', '.$name;
		}	
		
		return substr($list_cat,2,strlen($list_cat)-2);
	}	
}
function all_cat ($id,$type='') {
	//return false;
	global $mysql,$tb_prefix;
	
	if ($id>0)
	{
		$cut = 0;
		if ($_SESSION['name_cat_'.$id] && $_SESSION['name_cat_'.$id]!="" ) return $_SESSION['name_cat_'.$id];
	}
	else $cut =1;
	
	if (!$type) {
		$id = str_replace(',',"','",$id);
		
		$q = "SELECT cat_id,cat_name FROM ".$tb_prefix."cat order by cat_order asc";
		$key = md5($q);
		$catx = array();
		$q = $mysql->query($q);
		while ($r=$mysql->fetch_assoc($q)){
			$catx[] = $r;			
		}						
		foreach($catx as $r) {
			if ($cut==0)
			{
				$name =  $r['cat_id'];
				$name = ucwords(mb_strtolower($name,"UTF-8"));
				$name = str_replace(array("I","N"),array("i","n"),$name);
			}
			else $name = $r['cat_id'];
			$list_cat .= ', '.$name;
		}	
		
		return substr($list_cat,2,strlen($list_cat)-2);
	}	
}
function queryspecail($str){
	global $typeqs;
	if ($typeqs ==1) $str = str_replace("'","\'",$str);	//Linux
	return $str;
}
function splitlink($name,$type='', $class='') {
	global $web_link,$lang_no;
	if ($name == '' || $name== $lang_no) $name = $lang_no;
	else
	{
		$dem = explode(', ',$name);
		$d=count($dem);
		for($i=0; $i<$d-1;$i++) {
			$fas= $fas.'<a title="'.$dem[$i].'" href="'.$web_link.'/tag/'.replacesearch($dem[$i]).'.html" style="text-decoration:none;" class="'.$class.'">'.$dem[$i].'</a>, ';					}
		$name = $fas.'<a "'.$dem[$i].'" href="'.$web_link.'/tag/'.replacesearch($dem[$d-1]).'.html" style="text-decoration:none;" class="'.$class.'">'.$dem[$d-1].'</a>';
	}
	return $name;
}
function replacesearch($str) {
	$str = str_replace('%20', '+', $str);
	
	$str = str_replace(' ', '+', $str);
	
	
	return $str;
}
function replaceimg($str) {
	$str = str_replace(' ', '%20', $str);
	
	
	return $str;
}
function isFloodPost(){
	$_SESSION['current_message_post'] = time();
	global $wait_post;
	$timeDiff_post = $_SESSION['current_message_post'] - $_SESSION['prev_message_post'];
	$floodInterval_post	= 5;
	$wait_post = $floodInterval_post - $timeDiff_post ;	
	if($timeDiff_post <= $floodInterval_post)
	return true;
	else 
	return false;
}
function return_zchannelid($url,$type=0)
{
	$s = explode(".",$url);
	$id = intval($s[3]);
	if ($type==0){
		$id = dechex($id + 307843200);
		$id = str_replace(array(1,2,3,4,5),array('I','W','O','U','Z'),$id);
	}
	return $id;
}
function grab_link($url,$referer='',$var='',$cookie){
	$headers = array(
	"User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",
	"Content-Type: application/x-www-form-urlencoded",
	);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_COOKIE, $cookie );
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if($var) {
		curl_setopt($ch, CURLOPT_POST, 1);        
		curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
	}
	curl_setopt($ch, CURLOPT_URL,$url);
	return curl_exec($ch);
}
#######################################
# FUNCTIONS RELATE EPISODE
#######################################
function acp_text_type($type){
	if ($type==5) $text="Streaming";
	elseif ($type==6) $text="Vk";
	elseif ($type==8) $text="Nct";
	elseif ($type==9) $text="Default";
	elseif ($type==10) $text="YTB";
	elseif ($type==11) $text="CLipvn";
	elseif ($type==17) $text="Streaming";
	elseif ($type==31) $text="DaiLy";
	elseif ($type==32) $text="YouTuBe";
	elseif ($type==33) $text="Veoh";
	elseif ($type==34) $text="Zing";
	elseif ($type==38) $text="Youku";
	elseif ($type==42) $text="Content";
	elseif ($type==47) $text="4Shared";
	elseif ($type==53) $text="Govn";
	elseif ($type==55) $text="Cyworld";
	elseif ($type==63) $text="Govn";
	elseif ($type==64) $text="Govn#";
	elseif ($type==65) $text="Gdata";
	elseif ($type==66) $text="Down";
	elseif ($type==71) $text="Youtube#";
	elseif ($type==72) $text="Youtube#";
	elseif ($type==79) $text="Picasa";
	elseif ($type==81) $text="Tudou";
	elseif ($type==83) $text="Vimeo";
	elseif ($type==84) $text="Clipvn";
	elseif ($type==107) $text="Google";
	elseif ($type==109) $text="TruongXua";
	elseif ($type==112) $text="XXX";
	elseif ($type==124) $text="Flashx";
	elseif ($type==147) $text="Zing#";
	elseif ($type==150) $text="BangVn";
	elseif ($type==151) $text="Fliiby";
	elseif ($type==152) $text="Docs";
	elseif ($type==153) $text="ZingTV";
	elseif ($type==154) $text="VidBull";
	elseif ($type==155) $text="Picasa#";
	else $text="Default";
	return $text;
}
function episode_show($total_episode='',$film_id='',$episode_id='',$episode_name='',$server=''){
	global $mysql,$tb_prefix,$link_href,$web_link;
	$playck		= 	explode("?server=",urldecode($_SERVER['REQUEST_URI']));
	$gach 		=	explode(".", $_SERVER['PHP_SELF']);
	$playck		=	replace($playck[1]);
	$q = $mysql->query("SELECT episode_id, episode_name, episode_type FROM ".$tb_prefix."episode WHERE episode_film = ".$film_id." ORDER BY CAST(episode_name AS SIGNED), episode_name ASC");
	$film = $mysql->fetch_array($mysql->query("SELECT film_name, film_name_ascii, film_name_real, film_year FROM ".$tb_prefix."film WHERE film_id = '".$film_id."'"));
	$knam = $film['film_year'];
	if ((strlen($film['film_name_real'])) > 1){
		$knam = replace(strtolower($film['film_name_real']));
	}
	while ($r = $mysql->fetch_array($q)){
		$link_seo = $web_link.'/xem-phim-'.replace($film['film_name_ascii']).'.vc'.$r['episode_id'].'.html';
		$link_seo = str_replace('.html','.html',$link_seo);
		$episode_type = $r['episode_type'];
		if ($r['episode_id']==$episode_id){
			$episode_name=$r['episode_name'];
			$sv[$episode_type] .= "<li class=\"episode\"><a title=\"Xem Phim ".$film['film_name']." - ".$film['film_name_real']." | Tập ".$r['episode_name']." | Server ".acp_text_type($episode_type)."\" data-episodeid=\"".$r['episode_id']."\" id=\"".$r['episode_id']."\" class=\"btn-episode active\" href=\"".$link_seo."\">".$r['episode_name']."</a></li>";
		}else $sv[$episode_type] .= "<li class=\"episode\"><a title=\"Xem Phim ".$film['film_name']." | Tập ".$r['episode_name']." - ".$film['film_name_real']." | Server ".acp_text_type($episode_type)."\" data-episodeid=\"".$r['episode_id']."\" id=\"".$r['episode_id']."\" class=\"btn-episode\" href=\"".$link_seo."\">".$r['episode_name']."</a></li>";
		
		
		//$v[$episode_type]	=	false;
		if(!$v[$episode_type]) {
			// playall
			$urlplay[$episode_type]	=	$web_link.'/xem-phim-'.replace($film['film_name_ascii']).'.vc'.$r['episode_id'].'.html?server='.$episode_type;
			$pl[$episode_type]		=	'<a href="'.$urlplay[$episode_type].'">Xem Full</a>';
			if($playck==$episode_type) {
				$pl[$episode_type]	=	str_replace('<a','<a class="current"',$pl[$episode_type]);
			}
			$v[$episode_type]	=	true;
		}
	}
	$server_err = get_data('cf_server_inv','config','cf_id',1);
	$server_err_item=explode(',',$server_err);
	$total_server .= '';
	for ($i=1;$i<=155;$i++){
		for ($l=0;$l<count($server_err_item);$l++){
			if (($sv[$i]) && ($server_err_item[$l]!=$i))  {
				$total_server .= '
			<li class="backup-server" id="server_'.$i.'"><h3 class="server-title">Server '.acp_text_type($i).'</h3><ul class="list-episode">'.$sv[$i].'</ul></li>';
			}//.$pl[$i]
		}
	}
	$total_server .= '';
	$link_seo = $web_link.'/xem-phim-'.replace($film['film_name_ascii']).'.vc'.$episode_id.'.html';
	$link_seo = str_replace('.html','.html',$link_seo);
	if($server == 0)
	if(!$playck) {
		$total_server = str_replace('href="'.$link_seo.'">'.$episode_name.'</a>','href="'.$link_seo.'" class="current">'.$episode_name.'</a>',$total_server);
	}
	return $total_server;
}
function get_url_dv($name) {
	global $mysql,$tb_prefix;
	$name 	= 	str_replace(",  ",",",$name);
	$name 	= 	str_replace(", ",",",$name);
	$s 		= 	explode(',',$name);
	for($x=0;$x<count($s);$x++) {
		$tname		=	strtolower(replace($s[$x]));
		$url_name	=	"/dien-vien/phim-$tname.html";
		$q			=	$mysql->query("SELECT actor_id FROM ".$tb_prefix."dienvien WHERE actor_name_kd = '".$tname."'");
		if ($mysql->num_rows($q))
		$html_name  .=	"<a href=\"".$url_name."\" title=\"".$s[$x]."\"><font color=\"#00adff\">".$s[$x]."</font></a>, ";
		else
		$html_name  .=	$s[$x].", ";
	}
	$html_name 		= substr($html_name,0,-2);
	return $html_name;
}
// timestamp
if (!function_exists('date_parse_from_format')) {
	function date_parse_from_format($format, $date) {
		$i=0;
		$pos=0;
		$output=array();
		while ($i< strlen($format)) {
			$pat = substr($format, $i, 1);
			$i++;
			switch ($pat) {
			case 'd': //    Day of the month, 2 digits with leading zeros    01 to 31
				$output['day'] = substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'D': // A textual representation of a day: three letters    Mon through Sun
				//TODO
				break;
			case 'j': //    Day of the month without leading zeros    1 to 31
				$output['day'] = substr($date, $pos, 2);
				if (!is_numeric($output['day']) || ($output['day']>31)) {
					$output['day'] = substr($date, $pos, 1);
					$pos--;
				}
				$pos+=2;
				break;
			case 'm': //    Numeric representation of a month: with leading zeros    01 through 12
				$output['month'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'n': //    Numeric representation of a month: without leading zeros    1 through 12
				$output['month'] = substr($date, $pos, 2);
				if (!is_numeric($output['month']) || ($output['month']>12)) {
					$output['month'] = substr($date, $pos, 1);
					$pos--;
				}
				$pos+=2;
				break;
			case 'Y': //    A full numeric representation of a year: 4 digits    Examples: 1999 or 2003
				$output['year'] = (int)substr($date, $pos, 4);
				$pos+=4;
				break;
			case 'y': //    A two digit representation of a year    Examples: 99 or 03
				$output['year'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'g': //    12-hour format of an hour without leading zeros    1 through 12
				$output['hour'] = substr($date, $pos, 2);
				if (!is_numeric($output['day']) || ($output['hour']>12)) {
					$output['hour'] = substr($date, $pos, 1);
					$pos--;
				}
				$pos+=2;
				break;
			case 'G': //    24-hour format of an hour without leading zeros    0 through 23
				$output['hour'] = substr($date, $pos, 2);
				if (!is_numeric($output['day']) || ($output['hour']>23)) {
					$output['hour'] = substr($date, $pos, 1);
					$pos--;
				}
				$pos+=2;
				break;
			case 'h': //    12-hour format of an hour with leading zeros    01 through 12
				$output['hour'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'H': //    24-hour format of an hour with leading zeros    00 through 23
				$output['hour'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'i': //    Minutes with leading zeros    00 to 59
				$output['minute'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 's': //    Seconds: with leading zeros    00 through 59
				$output['second'] = (int)substr($date, $pos, 2);
				$pos+=2;
				break;
			case 'l': // (lowercase 'L')    A full textual representation of the day of the week    Sunday through Saturday
			case 'N': //    ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)    1 (for Monday) through 7 (for Sunday)
			case 'S': //    English ordinal suffix for the day of the month: 2 characters    st: nd: rd or th. Works well with j
			case 'w': //    Numeric representation of the day of the week    0 (for Sunday) through 6 (for Saturday)
			case 'z': //    The day of the year (starting from 0)    0 through 365
			case 'W': //    ISO-8601 week number of year: weeks starting on Monday (added in PHP 4.1.0)    Example: 42 (the 42nd week in the year)
			case 'F': //    A full textual representation of a month: such as January or March    January through December
			case 'u': //    Microseconds (added in PHP 5.2.2)    Example: 654321
			case 't': //    Number of days in the given month    28 through 31
			case 'L': //    Whether it's a leap year    1 if it is a leap year: 0 otherwise.
			case 'o': //    ISO-8601 year number. This has the same value as Y: except that if the ISO week number (W) belongs to the previous or next year: that year is used instead. (added in PHP 5.1.0)    Examples: 1999 or 2003
			case 'e': //    Timezone identifier (added in PHP 5.1.0)    Examples: UTC: GMT: Atlantic/Azores
			case 'I': // (capital i)    Whether or not the date is in daylight saving time    1 if Daylight Saving Time: 0 otherwise.
			case 'O': //    Difference to Greenwich time (GMT) in hours    Example: +0200
			case 'P': //    Difference to Greenwich time (GMT) with colon between hours and minutes (added in PHP 5.1.3)    Example: +02:00
			case 'T': //    Timezone abbreviation    Examples: EST: MDT ...
			case 'Z': //    Timezone offset in seconds. The offset for timezones west of UTC is always negative: and for those east of UTC is always positive.    -43200 through 50400
			case 'a': //    Lowercase Ante meridiem and Post meridiem    am or pm
			case 'A': //    Uppercase Ante meridiem and Post meridiem    AM or PM
			case 'B': //    Swatch Internet time    000 through 999
			case 'M': //    A short textual representation of a month: three letters    Jan through Dec
			default:
				$pos++;
			}
		}
		return  $output;
	}
}
function time_decode($date_time) {
	$date 		= 	date_parse_from_format('d/m/Y G:i',$date_time);
	$timestamp 	= 	mktime($date['hour'], $date['minute'], 0, $date['month'], $date['day'], $date['year']);
	return $timestamp;
}
function time_encode($timestamp) {
	return date('d/m/Y G:i',$timestamp);
}
function alo_alo($info){
	$info = str_replace("Phim hành động","<a title='Phim hành động' href='http://phim6v.com/phim-hanh-dong.html'>Phim hành động</a>",$info);
	$info = str_replace("Phim tình cảm","<a title='Phim tình cảm' href='http://phim6v.com/phim-tinh-cam.html'>Phim tình cảm</a>",$info);
	$info = str_replace("Phim cấp 3","<a title='Phim cấp 3' href='http://phim6v.com/phim-cap-3.html'>Phim cấp 3</a>",$info);
	$info = str_replace("Phim 18 +","<a title='Phim 18 +' href='http://phim6v.com/phim-18.html'>Phim 18 +</a>",$info);
	$info = str_replace("Phim 18+","<a title='Phim 18+' href='http://phim6v.com/phim-18.html'>Phim 18+</a>",$info);
	$info = str_replace("Phim kinh di","<a title='Phim kinh di' href='http://phim6v.com/phim-kinh-di.html'>Phim kinh di</a>",$info);
	$info = str_replace("Phim võ thuật","<a title='Phim võ thuật' href='http://phim6v.com/phim-vo-thuat.html'>Phim võ thuật</a>",$info);
	$info = str_replace("Phim tâm lý","<a title='Phim tâm lý' href='http://phim6v.com/phim-tam-ly.html'>Phim tâm lý</a>",$info);
	$info = str_replace("Phim hài hước","<a title='Phim hài hước' href='http://phim6v.com/phim-hai-huoc.html'>Phim hài hước</a>",$info);
	$info = str_replace("Phim hoạt hình","<a title='Phim hoạt hình' href='http://phim6v.com/phim-hoat-hinh.html'>Phim hoạt hình</a>",$info);
	$info = str_replace("Phim viễn tưởng","<a title='Phim viễn tưởng' href='http://phim6v.com/phim-vien-tuong.html'>Phim viễn tưởng</a>",$info);
	$info = str_replace("Phim hình sự","<a title='Phim hình sự' href='http://phim6v.com/phim-hinh-su.html'>Phim hình sự</a>",$info);
	$info = str_replace("Xem Phim","<a title='Xem Phim' href='http://phim6v.com/'>Xem Phim</a>",$info);
	
	return $info;
}
?>