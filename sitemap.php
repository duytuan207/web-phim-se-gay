<?php
define('IN_MEDIA',true);
require('inc/_config.php');
require_once('inc/_functions.php');

$rssVersion = 2.0;
$cat = (int) $_GET['c'];

if(empty($cat)) {
	$query = "SELECT * FROM ".$tb_prefix."film ORDER BY film_id DESC";
}
elseif(!empty($cat) && is_numeric($cat)) { 
	$query = "SELECT * FROM ".$tb_prefix."film WHERE film_cat =$cat ORDER BY film_id DESC";
}
function replace1($string) {
	$string = get_ascii($string);
    $string = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'),
        array('', '-', ''), htmlspecialchars_decode($string));
    return $string;
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
	$limit = 100000;
		$query = mysql_query("SELECT * FROM ".$tb_prefix."film WHERE film_cat='".$cat."'");
		$result = mysql_fetch_array($query);
	}
$rss = "";
// tell the browser we want xml output by setting the following header.
header("Content-Type: text/xml; charset=utf-8");
$time	= date('Y-m-d H:i:s \G\M\T',time());

$rss .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
$rss .= "<?xml-stylesheet href=\"sitemap.xsl\" type=\"text/xsl\"?>\r\n";
$rss .= "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n";
$rss .= "<url>\r\n";
$rss .= "<loc>http://phim6v.com/</loc>\r\n";
$rss .= "<changefreq>daily</changefreq>\r\n";
$rss .= "<priority>1.0</priority>\r\n";
$rss .= "<lastmod>".date('c',time())."</lastmod>\r\n";
$rss .= "</url>\r\n";
//Select Cat
$select = mysql_query('SELECT cat_id,cat_name_ascii FROM '.$tb_prefix.'cat ORDER BY cat_id ASC');
while ($rs = mysql_fetch_array($select))


{
	$film_link ='http://phim6v.com/'.replace($rs['cat_name_ascii']).'.html';
	$time	= date('c',$rs["film_date"]);
	$rss .= "   <url>\r\n";
	$rss .= "		<loc>".$film_link."</loc>\r\n";
	$rss .= "   		<changefreq>daily</changefreq>\r\n";
	$rss .= "   		<priority>0.8</priority>\r\n";
	$rss .= "   		<lastmod>".date('c',time())."</lastmod>\r\n";
	$rss .= "   </url>\r\n";
}
//Select Country
$select = mysql_query('SELECT country_id,country_name_ascii FROM table_country ORDER BY country_id ASC');
while ($rs = mysql_fetch_array($select))
{
	$film_link = 'http://phim6v.com/'.replace($rs['country_name_ascii']).'.html';
	$time	= date('c',$rs["film_date"]);
	$rss .= "   <url>\r\n";
	$rss .= "		<loc>".$film_link."</loc>\r\n";
	$rss .= "   		<changefreq>daily</changefreq>\r\n";
	$rss .= "   		<priority>0.9</priority>\r\n";
	$rss .= "   		<lastmod>".date('c',time())."</lastmod>\r\n";
	$rss .= "   </url>\r\n";
}
//Select ien Vien
$select = mysql_query('SELECT actor_name_kd FROM table_dienvien ORDER BY actor_order ASC');
while ($rs = mysql_fetch_array($select))
{
	$film_link = 'http://phim6v.com/dien-vien/phim-'.replace($rs['actor_name_kd']).'.html';
	$time	= date('c',$rs["film_date"]);
	$rss .= "   <url>\r\n";
	$rss .= "		<loc>".$film_link."</loc>\r\n";
	$rss .= "   		<changefreq>daily</changefreq>\r\n";
	$rss .= "   		<priority>0.9</priority>\r\n";
	$rss .= "   		<lastmod>".date('c',time())."</lastmod>\r\n";
	$rss .= "   </url>\r\n";
}
while ($row = mysql_fetch_array($results)){
	$rss .= "<url>\r\n";
    $rss .= "<loc>http://phim6v.com/phim-".clean_feed(replace($row['film_name_ascii'])).".vc".$row['film_id'].".html</loc>\r\n";
	$rss .= "<changefreq>daily</changefreq>\r\n";
	$rss .= "<priority>0.6</priority>\r\n";
	$rss .= "<lastmod>".date('c',time())."</lastmod>\r\n";
	$rss .= "</url>\r\n\r\n";
}
$rss .= "</urlset>\r\n";

echo $rss;
file_put_contents('sitemap.xml',$rss);
}
}
generateFeed( $link_href , $web_title, $rssVersion, $query );

?>