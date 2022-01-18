<?php
error_reporting(E_ERROR | E_PARSE);
if (!defined('IN_MEDIA')) die("Hack");
function cut($bandau,$batdau,$ketthuc,$laydau=1,$laycuoi=1){
		$ban = ' '.$bandau;
		$a = strpos($ban,$batdau);
		if ($a == 0) return '';
		$b = strpos($ban, $ketthuc, $a+strlen($batdau));
		if ($b == 0) return '';
		if ($laydau<>1) $a = $a + strlen($batdau);
		if ($laycuoi==1) $b = $b + strlen($ketthuc);
		return substr($ban,$a,$b - $a);
}
function get_by_curl_link($url){
    $headers = array(
		"User-Agent: googlebot",
        "Content-Type: application/x-www-form-urlencoded",
		"Referer: ".$url,
        );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if($var) {     curl_setopt($ch, CURLOPT_POST, 1);        
    curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
    }
    curl_setopt($ch, CURLOPT_URL,$url);

    return curl_exec($ch);
}
function grab_linkkk($url) {
	$is_tvzing	 	= preg_match("#http://tv.zing.vn/video/(.*?).html#",$url, $tvzing_id, $link_sub);
	$zingphim	 	= preg_match("#http://mp3.zing.vn/tv/media/(.*?).html#",$url, $zing_phim , $link_sub);
	$is_nct 		= preg_match('#http://www.nhaccuatui.com/nghe\?M=(.*?)#i', $url, $id_sr);
	$is_google1 	= preg_match("#picasaweb.google.com/lh/photo(.*?)#s",$url, $link_sub);
	$is_picasa		= preg_match('#picasaweb.google.com/#', $url, $link_sub);
	$is_youtube		= preg_match('#youtube.com/#', $url, $link_sub);
	$is_docsgoogle	= preg_match('#docs.google.com#', $url);
	$is_rebtube		= preg_match('#www.redtube.com/#', $url);
	$is_dailymotion = preg_match("#dailymotion.com#s",$url, $dailymotion);
	$is_zip 		= preg_match('#zippyshare.com/v/(.*?)/file.html#', $url, $id_sr);
	
	if($is_picasa) {
		$text = get_by_curl_link($url); 
		$text = cut($text,'"media":{"content":',']',0);
		$j = json_decode($text);
		$d = array();
		foreach($j AS $o){
			if ($o->type == 'video/mpeg4'){
				$d[] = $o->url;
			}
		}
		$link =$d[count($d)-1];
	}
	elseif($is_rebtube) {
		$data=get_by_curl_link($url);
	    $file1 = explode("src='http://",$data);
        $file2 = explode("'",$file1[1]);
        $link = 'http://'.$file2[0];
	}
	elseif($is_google1) {
		$data=get_by_curl_link($url);
	    $file1 = explode('",3,[[5,426,240,"',$data);
        $file2 = explode('"]',$file1[1]);
        $file3 = urldecode($file2[0]);
		$link  = $file3;
	}
	elseif($is_docsgoogle) {
		$data=get_by_curl_link($url);
	    $file1 = explode("<meta itemprop=\"url\" content=\"",$data);
        $file2 = explode('">',$file1[1]);
        $file3 = $file2[0];
		$link  = $file3;
	}
	elseif($is_dailymotion) {
		$data=get_by_curl_link($url);
	    $file1 = explode('<meta name="twitter:player" value="',$data);
        $file2 = explode('"',$file1[1]);
        $file3 = $file2[0]."";
		$link  = $file3;
	}
	elseif($is_tvzing) {
		$data=get_by_curl_link($url);
	    $file1 = explode("document.write('<source src=\"",$data);
        $file2 = explode('"',$file1[1]);
        $file3 = $file2[0]."";
		$link  = $file3;
	}
	elseif($is_youtube) {
		$link=str_replace("watch?v=","embed/",$url);
	}
	else $link = $url;
	return $link;
}
function player_mobile($url,$film_id,$e_id,$type){
    global $mysql, $web_link,$temp,$tb_prefix;
		$link_player = grab_linkkk($url);
		if($link_player){
		if($type==11){ //clipvn
		$player = "<iframe width=\"100%\" height=\"300\" src=\"$url\" frameborder=\"0\" allowfullscreen></iframe>";
		}elseif($type==32){ //youtube
		$player = "<iframe width=\"100%\" height=\"300\" src=\"".$link_player."\" frameborder=\"0\" allowfullscreen></iframe>";
		}elseif($type==79){ //picasaweb
		$player = "<video width=\"100%\" height=\"300\" data-setup='true' controls autoplay>
			<source src=\"".$link_player."\" type=\"video/mp4\"></video>";
		}elseif($type==152){ //dotgoogle
		$player = "<iframe width=\"100%\" height=\"300\" src=\"".$link_player."\" frameborder=\"0\" allowfullscreen></iframe>";
		}elseif($type==31){
		$player = "<iframe width=\"100%\" height=\"300\" src=\"".$link_player."\" frameborder=\"0\" allowfullscreen></iframe>";
		}elseif($type==153){
		$player = "<video width=\"100%\" height=\"300\" data-setup='true' controls autoplay>
			<source src=\"".$link_player."\" type=\"video/mp4\"></video>";
		}elseif($type==155){
		$player = "<video width=\"100%\" height=\"300\" data-setup='true' controls autoplay>
			<source src=\"".$link_player."\" type=\"video/mp4\"></video>";
		}else{
		$player = "<center><font color='red'><b>Server này chưa hỗ trợ xem phim trực tuyến mọi chi tiếc liên hệ 01634444120<br/> <font color='green'>Facebook : http://facebook.com/traiquangngai</b></font></center>";
		}
		}else{
		$player = "<iframe width=\"100%\" height=\"300\" src=\"http://youtube.com/embed/kfE2fXyj2fA\" frameborder=\"0\" allowfullscreen></iframe><br/>
		<center><font color='red'><b>Link phim này đã bị hư mong bạn thông cảm và nghe nhạc</b></font></center>";
		}
		return $player;
}
?>