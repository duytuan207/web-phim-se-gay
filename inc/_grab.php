<?php
if (!defined('IN_MEDIA')) die("Hacking attempt") ;
function get_by_curl($url){
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
    if($var) {
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $var);
    }
    curl_setopt($ch, CURLOPT_URL,$url);
    return curl_exec($ch);
}
function get_URL($url)
{
    $headers = @get_headers($url);
    $pattern = '/Location\s*:\s*(https?:[^;\s\n\r]+)/i';
    if ($locations = preg_grep($pattern, $headers))
    {
        preg_match($pattern, end($locations), $redirect);
        return $redirect[1];
    }
    return $url;
}
function cut_str($str_cut,$str_c,$val)
{	
	$url=split($str_cut,$str_c);
	$urlv=$url[$val];
	return $urlv;
}
function get_link_total($url='',$id=0,$type=0) {
	global $web_link,$link_seo,$episode_id;
	$link=$url;
	if(preg_match('#http:\/\/clip.vn\/watch\/([^/,]+),([^/]+)#', $url, $id_sr)) {
		$id = $id_sr[2];
		$url = 'http://clip.vn/embed/'.$id;
	}
	elseif(preg_match('#clip.vn#', $url, $id_sr)) {
		$clipvn = str_replace('http://clip.vn/w/','http://clip.vn/embed/',$url);
		$url = $clipvn;
	}
	elseif (preg_match("#video.google.com/(.*?)#",$url,$id_sr)) {
		$url = str_replace('http://video.google.com/videoplay','http://video.google.com/googleplayer.swf',$url);
	}
    elseif (preg_match("#http://www.truongxua.vn/video/video_detail/(.*?)#",$url,$id_sr)){
		$data=get_by_curl($url);
		$file1 = explode("'url':'",$data);
        $file2 = explode("','",$file1[1]);
		$url	=	$file2[0];
    }
    elseif (preg_match('#nhaccuatui.com#', $url,$id_sr)){
	    $urlend = get_URL($url);
		//xac dinh url de lay id
		$data = get_by_curl($urlend);
		$urllayid=preg_match('/\[FLASH\](.*?)\[\/FLASH\]/',$data,$arr);
		$urllayid = $arr[1];
		// bat dau lay link xml
		$urlxml = get_URL($urllayid);
		$urlxml = preg_match('/file\=(.*?)&/',$urlxml,$brr);
		$urlxml= $brr[1];
		////////////////////////////////get lay link mp4, flv, img
		$bdata= get_by_curl($urlxml);
		$linkfile=preg_match('/http([^>]*)\.mp4/U', $bdata, $crr);
		$linkfile= $crr[0];
		$url = $linkfile;

    }	
	elseif (preg_match('#tv.zing.vn#', $url,$id_sr)){
	    $data=get_by_curl($url);
		$file1 = explode('<source src="',$data);
        $file2 = explode('"',$file1[1]);
		$url	=	$file2[0];
    }
	elseif (preg_match('#dailymotion.com#', $url,$id_sr)){
	    $embed = str_replace('http://www.dailymotion.com','http://www.dailymotion.com/embed',$url);
		$url	=	$embed;
    }
	else if (preg_match('#http://bang.vn/Du_Lieu/View/Video/(.*?)#s', $url, $id_sr)){
		$id = cut_str('Video/',$url,1);
		$link2='http://xemphimon.com/server-bang/'.$id.'.mp4';
        $url = $link2;
	}
	else if (preg_match("#picasaweb.google.com/lh/photo/([^/]+)#",$url,$id_sr))  {
		$id = str_replace('?feat=directlink','',cut_str('photo/',$url,1));
		$id = str_replace('?feat=directlinks','',$id);
		$mobilemp4 = "http://phim1v.com/server-picasa-mobile/".$id.".mp4";
		$url= $mobilemp4;
	}
return $url;
}
?>