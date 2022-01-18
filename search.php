<?php
define('IN_MEDIA',true);
include('inc/_config.php');
include('inc/_functions.php');
header('Content-Type: text/plain');
$showf	=	5;		//	số phim hiện thị
$expire = 	1800; // 24h - thời gian tạo cache mới
$file	= 	"tim-kiem.txt";
if (file_exists($file) &&	filemtime($file) > (time() - $expire)) {
	$q = $mysql->query("SELECT film_id,
								film_name,
								film_name_real,
								film_img,
								film_name_ascii,
								film_actor_ascii,
								film_director_ascii,
                                film_year	FROM ".$tb_prefix."film WHERE film_id > 0 ORDER BY film_date DESC");
	while ($r = $mysql->fetch_array($q)) {
		$film_id	=	$r['film_id'];
		$film_name		=	$r['film_name'];
		$film_name_real		=	$r['film_name_real'];
		$film_name_ascii		=	$r['film_name_ascii'];
		$film_actor_ascii			=	$r['film_actor_ascii'];
		$film_director_ascii			=	$r['film_director_ascii'];
		$film_img							=	$r['film_img'];
		$film_year							=	$r['film_year'];
		$html	.=	"$film_id\t$film_name\t$film_name_real\t$film_name_ascii\t$film_actor_ascii\t$film_director_ascii\t$film_img\t$film_year\n";
	}
	$fp = fopen($file,"w");
	fputs($fp, $html);
	fclose($fp);
}

$file2	= 	"dien-vien.txt";
if (file_exists($file2) &&	filemtime($file2) > (time() - $expire)) {
	$q = $mysql->query("SELECT  actor_name,actor_name_kd,actor_img	FROM ".$tb_prefix."dienvien WHERE  actor_id > 0 ORDER BY  actor_id DESC");
	while ($r = $mysql->fetch_array($q)) {
		$actor_name			=	$r['actor_name'];
		$actor_name_kd		=	$r['actor_name_kd'];
		$actor_img			=	$r['actor_img'];
		$htmlz	.=	"$actor_name\t$actor_name_kd\t$actor_img\n";
	}
	$fpz = fopen($file2,"w");
	fputs($fpz, $htmlz);
	fclose($fpz);
}

if(isset($_REQUEST['q'])) {
	$search = strtolower(get_ascii($_REQUEST['q']));
	// tìm phim
	$lines = file($file);
	$found = false;
	foreach($lines as $line){
		if(strpos($line, $search) !== false){
			++$i;
			if($i<=5) {
				$found 			=	true;
				$exp			=	explode("\t",$line);
				$film_id		=	$exp[0];
				$film_name		=	$exp[1];
				$film_name_real	=	$exp[2];
				$film_img		=	$exp[6];
				$film_year		=	trim($exp[7]);
				$url_film		=	'/phim/'.replace($exp[3]).'-'.$film_id.'.html';
				$show			.=	"<li class=\"singer_li\"><a href=\"$url_film\"><p>$film_name ($film_year)</p></a></li>";
			}
		}
	}
	if($show) {
		$show	=	'<ul><li class="title activer"><a class="title activer" href="/tim-kiem/'.str_replace(' ',"+",$search).'">Phim "'.$search.'"</a></li>'.$show.'</ul>';
		echo $show;
	}
	// tìm diễn viên
	$linesz = file($file2);
	$foundz = false;
	$search2	=	replace($search);
	foreach($linesz as $linez){
		if(strpos($linez, $search2) !== false){
			++$x;
			if($x<=5) {
				$foundz			=	true;
				$exp			=	explode("\t",$linez);
				$actor_name		=	trim($exp[0]);
				$actor_name_kd	=	trim($exp[1]);
				$actor_img		=	trim($exp[2]);
				$url_actor		=	'dien-vien/phim-'.$actor_name_kd.'.html';
				$showz			.=	"<li class=\"singer_li\"><a href=\"$url_actor\"><p>$actor_name</p></a></li>";
			}
		}
	}
	if($showz) {
		$showz	=	'<ul><li class="title">Diễn viên "'.$search.'"</li>'.$showz.'</ul>';
		echo $showz;
	}
	echo '<div class="clr"></div>';
	exit();
}
exit();
?>