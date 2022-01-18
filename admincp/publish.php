<?php 
define('IN_MEDIA', true);
define('IN_MEDIA_ADMIN', true);
include("../inc/_config.php");
include("../inc/_functions.php");
include("../inc/_grab.php");
include("../inc/_string.php");
set_time_limit(0);
$n_p = 0;
$e_p = array();
$title		= array("Xem phim ","Phim ","");
$ten_phim 	= array("Phim ","Xem Phim ","");
$dao_dien 	= array("Đạo diễn:","Director:","Biên đạo ");
$dien_vien 	= array("Diễn viên:","Actor/Actress:","Với sự tham gia của:"); 
$the_loai 	= array("Thể loại:","Category:","Phim của:"); 
$quoc_gia 	= array("Quốc gia:","Country:","Phim nước: "); 
$thoi_luong = array("Thời lượng:","Time:","Độ dài: ");
$nam 		= array("Năm phát hành:","Publish date:","Năm sản xuất: ");
$product	= array("Sản xuất:","Production:","Producted by: ");
$radom_link = array("xem phim","xem phim online","phim");
$info		= array("Nội dung phim:","Infomation:");
$info_text	= array("Trong phim ","Phim ","Câu chuyện phim ","Bộ phim ","Phim kể về ");
$blogger_cf		= array(
			0	=> array(
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.abc1@blogger.com",
			"blog_link"		=> "http://www.sezonnaslaskie.com",
			"post_link"		=> "",			),			 
			1	=> array(				
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.abc2@blogger.com",
			"blog_link"		=> "http://www.epfrokolkata.com",
			"post_link"		=> "",			),			
			2	=> array(				
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.abc3@blogger.com",
			"blog_link"		=> "http://www.e-dpc.net",	
			"post_link"		=> "",			),			
			3	=> array(				
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.abc4@blogger.com",	
			"blog_link"		=> "http://www.jobmailing.net",	
			"post_link"		=> "",			),
			4	=> array(				
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.abc5@blogger.com",	
			"blog_link"		=> "http://www.watches-sale.net",	
			"post_link"		=> "",			),	
			5	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",	
			"blog_email"	=> "lebuuhoa040387.phimso5@blogger.com",
			"blog_link"		=> "http://xemphimso5.blogspot.com",	
			"post_link"		=> "",			),			
			6	=> array(	
			"your_email"	=> "lebuuhoa040387@blogger.com",	
			"blog_email"	=> "lebuuhoa040387.phimso7@blogger.com",
			"blog_link"		=> "http://xemphimso7.blogspot.com",		
			"post_link"		=> "",			),		
			7	=> array(	
			"your_email"	=> "lebuuhoa040387@blogger.com",	
			"blog_email"	=> "lebuuhoa040387.phimso1@blogger.com",
			"blog_link"		=> "http://xemphimso1.blogspot.com",
			"post_link"		=> "",			),
			8	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso2@blogger.com",
			"blog_link"		=> "http://xemphimso2.blogspot.com",
			"post_link"		=> "",			),
			9	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso3@blogger.com",
			"blog_link"		=> "http://xemphimso3.blogspot.com/",
			"post_link"		=> "",			),
			10	=> array(
			"your_email"	=> "phimcc8@blogger.com",
			"blog_email"	=> "phimcc8.sdfhj@blogger.com",
			"blog_link"		=> "http://xemphimso4.blogspot.com",
			"post_link"		=> "",			),
			11	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso5@blogger.com",
			"blog_link"		=> "http://xemphimso5.blogspot.com",
			"post_link"		=> "",			),
			12	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso6@blogger.com",
			"blog_link"		=> "http://xemphimso6.blogspot.com",
			"post_link"		=> "",			),
			13	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso7@blogger.com",
			"blog_link"		=> "http://xemphimso7.blogspot.com",
			"post_link"		=> "",			),
			14	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso8@blogger.com",
			"blog_link"		=> "http://xemphimso8.blogspot.com",
			"post_link"		=> "",			),
			15	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso9@blogger.com",
			"blog_link"		=> "http://xemphimso9.blogspot.com",
			"post_link"		=> "",			),
			16	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso10@blogger.com",
			"blog_link"		=> "http://xemphimso10.blogspot.com",
			"post_link"		=> "",			),
			17	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso11@blogger.com",
			"blog_link"		=> "http://xemphimso11.blogspot.com",
			"post_link"		=> "",			),
			18	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso12@blogger.com",
			"blog_link"		=> "http://xemphimso12.blogspot.com",
			"post_link"		=> "",			),
			19	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso13@blogger.com",
			"blog_link"		=> "http://xemphimso13.blogspot.com",
			"post_link"		=> "",			),
			20	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso14@blogger.com",
			"blog_link"		=> "http://xemphimso15.blogspot.com",
			"post_link"		=> "",			),
			21	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso16@blogger.com",
			"blog_link"		=> "http://xemphimso17.blogspot.com",
			"post_link"		=> "",			),
			22	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso18@blogger.com",
			"blog_link"		=> "http://xemphimso18.blogspot.com",
			"post_link"		=> "",			),
			23	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso19@blogger.com",
			"blog_link"		=> "http://xemphimso19.blogspot.com",
			"post_link"		=> "",			),
			24	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso20@blogger.com",
			"blog_link"		=> "http://xemphimso20.blogspot.com",
			"post_link"		=> "",			),
			25	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso21@blogger.com",
			"blog_link"		=> "http://xemphimso21.blogspot.com",
			"post_link"		=> "",			),
			26	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso22@blogger.com",
			"blog_link"		=> "http://xemphimso22.blogspot.com",
			"post_link"		=> "",			),
			27	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso23@blogger.com",
			"blog_link"		=> "http://xemphimso23.blogspot.com",
			"post_link"		=> "",			),
			28	=> array(
			"your_email"	=> "lebuuhoa040387@blogger.com",
			"blog_email"	=> "lebuuhoa040387.phimso24@blogger.com",
			"blog_link"		=> "http://xemphimso24.blogspot.com",
			"post_link"		=> "",			),
			29	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc10@blogger.com",
			"blog_link"		=> "http://phimcc14.blogspot.com",
			"post_link"		=> "",			),
			30	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc11@blogger.com",
			"blog_link"		=> "http://phimcc13.blogspot.com",
			"post_link"		=> "",			),
			31	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.haynhi@blogger.com",
			"blog_link"		=> "http://phimcc17.blogspot.com",
			"post_link"		=> "",			),
			32	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc9@blogger.com",
			"blog_link"		=> "http://phimcc1.blogspot.com",
			"post_link"		=> "",			),
			33	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc1@blogger.com",
			"blog_link"		=> "http://phimcc15.blogspot.com",
			"post_link"		=> "",			),
			34	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc6@blogger.com",
			"blog_link"		=> "http://phimcc7.blogspot.com",
			"post_link"		=> "",			),
			35	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc3@blogger.com",
			"blog_link"		=> "http://phimcc10.blogspot.com",
			"post_link"		=> "",			),
			36	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.hotqua@blogger.com",
			"blog_link"		=> "http://phimcc16.blogspot.com",
			"post_link"		=> "",			),
			37	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc7@blogger.com",
			"blog_link"		=> "http://phimcc6.blogspot.com",
			"post_link"		=> "",			),
			38	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc2@blogger.com",
			"blog_link"		=> "http://phimcc2.blogspot.com",
			"post_link"		=> "",			),
			39	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc8@blogger.com",
			"blog_link"		=> "http://phimcc5.blogspot.com",
			"post_link"		=> "",			),
			40	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc12@blogger.com",
			"blog_link"		=> "http://phimcc12.blogspot.com",
			"post_link"		=> "",			),
			41	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc13@blogger.com",
			"blog_link"		=> "http://phimcc11.blogspot.com",
			"post_link"		=> "",			),
			42	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc5@blogger.com",
			"blog_link"		=> "http://phimcc8.blogspot.com",
			"post_link"		=> "",			),
			43	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc4@blogger.com",
			"blog_link"		=> "http://phimcc9.blogspot.com",
			"post_link"		=> "",			),
			44	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc15@blogger.com",
			"blog_link"		=> "http://phimcc3.blogspot.com",
			"post_link"		=> "",			),
			45	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.abc14@blogger.com",
			"blog_link"		=> "http://phimcc4.blogspot.com",
			"post_link"		=> "",			),
			46	=> array(
			"your_email"	=> "phimcc.net@blogger.com",
			"blog_email"	=> "phimcc.net.alovui@blogger.com",
			"blog_link"		=> "http://phim-sex-phimcc.blogspot.com",
			"post_link"		=> "",			),

);
/*$wordpress_cf	= array(
			0	=> array(
				"your_email"	=> "phimcc.net@gmail.com",
				"wp_email"		=> "huva339funi@post.wordpress.com",
			),
); */
function build_mail_header($to_email, $from_email) {
	$CRLF = "\n";
	$headers = 'MIME-Version: 1.0'.$CRLF;
	$headers .= 'Content-Type: text/html; charset=UTF-8'.$CRLF;
	$headers .= 'Date: ' . gmdate('D, d M Y H:i:s Z', NOW) . $CRLF;
	$headers .= 'From: phimcc.net@gmail.com'. $CRLF;
	$headers .= 'Reply-To: <'. $from_email .'>'. $CRLF;
	$headers .= 'Auto-Submitted: auto-generated'. $CRLF;
	$headers .= 'Return-Path: <'. $from_email .'>'. $CRLF;
	$headers .= 'X-Sender: <'. $from_email .'>'. $CRLF; 
	$headers .= 'X-Priority: 3'. $CRLF;
	$headers .= 'X-MSMail-Priority: Normal'. $CRLF;
	$headers .= 'X-MimeOLE: Produced By xtreMedia'. $CRLF;
	$headers .= 'X-Mailer: PHP/ '. phpversion() . $CRLF;
	return $headers;

}
function check_cat($cat){
	global $r,$web_link;
	$cat=explode(',',$cat);
	$film_cat="";
	for ($i=0; $i<count($cat);$i++) {
		$cat_name=check_data(get_data('cat_name','cat','cat_id',$cat[$i]));
		$film_cat .= '<a title="'.$cat_name.'" href="'.$web_link.'/'.replace(strtolower(get_ascii($cat_name))).'.html'.'" >'.$cat_name.'</a>,';
	}
	return $film_cat;
}
function check_dv($name) {
	global $mysql,$tb_prefix,$web_link;
	$name 	= 	str_replace(",  ",",",$name);
	$name 	= 	str_replace(", ",",",$name);
	$s 		= 	explode(',',$name);
	for($x=0;$x<count($s);$x++) {
		$tname		=	strtolower(replace($s[$x]));
		$url_name	=	$web_link."/dien-vien/phim-$tname.html";
		$q			=	$mysql->query("SELECT actor_id FROM ".$tb_prefix."dienvien WHERE actor_name_kd = '".$tname."'");
		if ($mysql->num_rows($q))
			$html_name  .=	"<a href=\"".$url_name."\" title=\"".$s[$x]."\"><font color=\"#00adff\">".$s[$x]."</font></a>, ";
		else
			$html_name  .=	$s[$x].", ";
	}
	$html_name 		= substr($html_name,0,-2);
	return $html_name;
}
function check_country($country){
   global $r,$web_link;
    $country=explode(',',$country);
	$link_country="";
	for ($i=0; $i<count($country);$i++) {
		$film_country = check_data(get_data('country_name','country','country_id',$r['film_country']));
		$link_country .= '<a title="'.$film_country.'" href="'.$web_link.'/'.replace(strtolower(get_ascii($film_country))).'.html'.'" >'.$film_country.'</a>,';
	}
	return $link_country;
}

function make_xlink($title){
	$x = str_replace(array(" ","%20"),"-",strtolower($title));
	$x = str_replace(".","",$x);
	return $x;
}
function make_rand_title(){
	global $r,$title;
	$xtitle	= $title[array_rand($title)].ucwords(strtolower($r["film_name_ascii"]));
	return $xtitle;
}
function make_rand_content($link){
	global $r,$ten_phim,$dao_dien,$dien_vien,$the_loai,$quoc_gia,$thoi_luong,$nam,$film_link,$product,$radom_link,$info,$info_text;
	if ($link=="") $link =$film_link;
	$make_content ="<h2>".$ten_phim[array_rand($ten_phim)]." <a href=\"".$link."\" title=\"Phim ".ucwords(strtolower($r["film_name_ascii"]))."\">Phim ".ucwords(strtolower($r["film_name_ascii"]))."</a></h2><br/><br/>";
	$make_content .="<center><img src=\"".check_img($r['film_img'],4,'y')."\" title=\"".ucwords(strtolower($r["film_name_ascii"]))."\" width=\"250px\" height=\"360px\" alt=\"".ucwords(strtolower($r["film_name_ascii"]))."\"/></center><br/>";
	$make_content .="<b>".$dao_dien[array_rand($dao_dien)]."</b>".check_data($r["film_director"])."<br/>";
	$make_content .="<b>".$dien_vien[array_rand($dien_vien)]."</b> ".check_dv($r["film_actor"])."<br/>";
	$make_content .="<b>".$the_loai[array_rand($the_loai)]."</b> ".strip_tags(check_cat($r["film_cat"]),"<a>")."<br/>";
	$make_content .="<b>".$quoc_gia[array_rand($quoc_gia)]."</b> ".strip_tags(check_country($r['film_country']),"<a>")."<br/>";
	$make_content .="<b>".$thoi_luong[array_rand($thoi_luong)]."</b>: ".$r['film_time']."<br/>";
	$make_content .="<b>".$nam[array_rand($nam)]."</b> ".$r['film_year']."<br/><br/>";
	$e = explode(".",$r["film_info"]);
	$key = array_rand($info_text);
	if ($key == (count($info_text)-1))  $xkey = $key-1;
	else $xkey = $key++;
	$e[1] =  $info_text[$key].$r['film_name'].$e[1];
	$e[2] =  $info_text[$xkey].$r['film_name'].$e[2];
	$xinfo = implode(".",$e);
	$make_content .="<b>".$info[array_rand($info)]."</b> ".html_entity_decode(del_HTML(trim($xinfo)),ENT_QUOTES, 'UTF-8')."<br/>";
	$make_content .= "Chúc các bạn <a href=\"http://phimvc.com\">xem phim</a> vui vẻ hạnh phúc may mắn thành công";
	return $make_content;
	
}
function post_blogger($pub){
	global $blogger_cf,$e_p,$n_p;
	$c_post = count($blogger_cf);
	for ($i=0;$i<$c_post;$i++){
		$header 	= build_mail_header($blogger_cf[$i]["blog_email"],$blogger_cf[$i]["your_email"]);
		$content 	= make_rand_content($blogger_cf[$start]["post_link"]);
		if ($blogger_cf[$start]["post_link"]=="") $bigo=false;
		$title		= make_rand_title();
		$plink 		= make_xlink($title);
		if (mail($blogger_cf[$i]["blog_email"],$title,$content,$header))
		{ 
			$n_p++;$stop++;
			$blogger_cf[$i]["post_link"] = $blogger_cf[$i]["blog_link"].$pub.$plink.".html";
		}
		else
			array_push($e_p,$blogger_cf[$i]["blog_link"]);
		
	}
}
function post_wp(){
	global $wordpress_cf,$e_p,$n_p;
	$c_post = count($wordpress_cf);
	for ($i=0;$i<$c_post;$i++)
	{
		$header 	= build_mail_header($wordpress_cf[$i]["wp_email"],$blogger_cf[$i]["your_email"]);
		$content 	= make_rand_content("");
		$title		= make_rand_title();
		if (mail($wordpress_cf[$i]["wp_email"],$title,$content,$header) ) 
			$n_p++;
		else
			array_push($e_p,$wordpress_cf[$i]["wp_email"]);
	}
}
if (!isset($film_id) || !is_numeric($film_id))
	$rt["message"]	="Không thể publish!";
else{
	$q = $mysql->query("SELECT * FROM ".$tb_prefix."film WHERE film_id = ".$film_id);
	$r = $mysql->fetch_array($q);
	$film_real = $r['film_name_real'];
	$knam = $r['film_year'];
    if ((strlen($film_real)) > 1){
	$knam = replace(strtolower($r['film_name_real']));
    }
	$film_link = $web_link."/phim-".replace($r['film_name_ascii']).".vc".replace($r['film_id']).'.html';
	$day = date("Y/m",time());
	$link = "/".$day."/";
	post_blogger($link);
	post_wp($link);
	$rt["count"] 	= $n_p;
	$rt["cantpost"] = implode("\r", $e_p);
	if ($n_p>0) $mysql->query("UPDATE ".$tb_prefix."film SET film_publish = 1 WHERE film_id = ".$film_id);
}
echo json_encode($rt);
exit();
?>