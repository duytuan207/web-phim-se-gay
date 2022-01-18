<?php
define('IN_MEDIA',true);
require('inc/_config.php');
require_once('inc/_functions.php');

$rssVersion = 2.0;
$cat = (int) $_GET['c'];

if(empty($cat)) {
	$query = "SELECT * FROM ".$tb_prefix."film ORDER BY film_id DESC LIMIT 10";
}
elseif(!empty($cat) && is_numeric($cat)) { 
	$query = "SELECT * FROM ".$tb_prefix."film WHERE film_cat =$cat ORDER BY film_id DESC LIMIT 10";
}
function clean_feed($input) {
	$original = array("<", ">", "&", '"');
	$replaced = array("&lt;", "&gt;", "&amp;", "&quot;");
	$newinput = str_replace($original, $replaced, $input);
	return $newinput;
}
function generateFeed ( $homeURL, $title, $version = '2.0', $query) {
global $mysql, $cat, $tb_prefix;
// a little check for the arguments thrown in.
if (func_num_args() < 2)
exit ("Insufficant Parameters");
// only select the columns you need, thus reducing the work the DBMS has to do.
// execute the query
$results = mysql_query ($query) or exit(mysql_error());

// check for the number of rows returned before doing any further actions.
if (mysql_num_rows ($results) == 0){
exit("Nothing to show.");
}
else {
// Get category name
	if(!empty($cat) && is_numeric($cat)) { 
		$query = mysql_query("SELECT * FROM ".$tb_prefix."film WHERE film_cat='".$cat."'");
		$result = mysql_fetch_array($query);
	}

$rss = "";
// tell the browser we want xml output by setting the following header.
header("Content-Type: text/xml; charset=utf-8");
$rss .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
$rss .= "<rss version=\"2.0\">\r\n";
$rss .= "<channel>\r\n";
$rss .= "<title>" . ucwords($title) . " - RSS Feed</title>\r\n";
$rss .= "<link>" . $homeURL . "</link>\r\n";
$rss .= "<description>Phim | Phim HD | Xem Phim</description>\r\n";
$rss .= "<language>vi-vn</language>\r\n";
$rss .= "<copyright>Copyright (C) " . ucwords($title) . "</copyright>\r\n";
$rss .= "<ttl>60</ttl>\r\n";
$rss .= "<generator>Phim1v.Com</generator> \r\n";

while ($row = mysql_fetch_array($results)){
	$film_name_real = $row['film_name_real'];
	$gach = '';
	if ((strlen($film_name_real)) > 1){
	$gach = ' | ';
    }
	$m_time = date('D, d M Y H:i:s');
	$rss .= "\t<item>\r\n";
	$rss .= "\t\t<title>" . htmlspecialchars($row['film_name']) ."".$gach."". check_data(htmlspecialchars($row['film_name_real'])) . "</title>\r\n";
	$rss .= "\t\t<description>
	<![CDATA[
	 <TABLE><TR><TD>
	<img src='".$row['film_img']."' width='200' height='270' alt='' /></TD>
    	<TD>
	<a href='".$homeURL."/phim-".clean_feed(replace($row['film_name_ascii'])).".oke".$row['film_id'].".html'
	title='" . htmlspecialchars($row['film_name']) . " | " . check_data(htmlspecialchars($row['film_name_real'])) ."' target='_blank'>
	<h1 /><b> Phim " . htmlspecialchars($row['film_name']) . " | " . check_data(htmlspecialchars($row['film_name_real'])) ." Online</b></h1> </a>
	<br />Diễn viên: " . check_data(htmlspecialchars($row['film_actor'])) . " 
	<br />Đạo diễn: " .check_data(htmlspecialchars($row['film_director'])) . " 
	<br />Quốc gia: " .check_data(htmlspecialchars($row['film_area']))." 
	<br />Thể loại: " .check_data(htmlspecialchars(get_data('cat_name','cat','cat_id',$row['film_cat'])))." 
	<br />Thời lượng: " .check_data(htmlspecialchars($row['film_time']))." 
	</td></tr></TABLE>
	<br /> ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>" .htmlspecialchars_decode($row['film_info'])."
	 ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>
	]]>
	</description>\r\n";
	
	$rss .= "\t\t<link>".$homeURL."/phim-".clean_feed(replace($row['film_name_ascii'])).".oke".$row['film_id'].".html</link>\r\n";
	$rss .= "\t\t<pubDate>".$m_time." GMT</pubDate>\r\n";
	$rss .= "\t</item>\r\n\r\n";
}
$rss .= "</channel>\r\n";
$rss .= "</rss>\r\n";

echo $rss;
}
}
// call the function with all our settings from the top of the script
generateFeed( $web_link , $web_title, $rssVersion, $query );

?>
