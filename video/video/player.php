<?
error_reporting(E_All);
function get_curl($url, $header=1){
	$url = str_replace(' ', '%20', $url);
	$useheader = (isset($_POST['iheader']) ? $_POST['iheader'] : $header);
	$useragent = (isset($_POST['iagent'])? (string)$_POST['iagent'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:13.0) Gecko/20100101 Firefox/13.0');
	$referer = $_POST['ireferer'];
	$autoreferer = $_POST['iautoreferer'];
	$usehttpheader = (isset($_POST['ihttpheader']) ? $_POST['ihttpheader'] : true);
	$ucookie = $_POST['icookie'];
	$encoding = (isset($_POST['iencoding']) ? $_POST['iencoding'] : 'gzip,deflate');
	$timeout = $_POST['itimeout'];
	$follow = $_POST['ifollow'];
	$mpost = $_POST['ipost'];
	$mpostfield = $_POST['ipostfield'];
	$proxytunnel = $_POST['iproxytunnel'];
	$proxytype = $_POST['iproxytype'];
	$proxyport = $_POST['iproxyport'];
	$proxyip = $_POST['iproxyip'];
	$sslverify = (isset($_POST['isslverify']) ? $_POST['isslverify'] : true);
	$nobody = $_POST['inobody'];
	
	$curl = @curl_init();
	$header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Keep-Alive: 115";
	$header[] = "Connection: keep-alive";
	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_HEADER, $useheader);
	if($useragent!=""){curl_setopt($curl, CURLOPT_USERAGENT, $useragent);}
	if($usehttpheader=="true"){curl_setopt($curl, CURLOPT_HTTPHEADER, $header);}
	if($ucookie!=""){curl_setopt($curl, CURLOPT_COOKIE, str_replace('\\"','"',$ucookie));}
	if($referer!=""){curl_setopt($curl, CURLOPT_REFERER, $referer);}
	if($autoreferer=="true"){curl_setopt($curl, CURLOPT_AUTOREFERER, 1);}
	if($encoding!=""){curl_setopt($curl, CURLOPT_ENCODING, $encoding);}
	if($timeout!=""){
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	}
	else{
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	}
	if($follow=="true"){curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);}
	if($mpost=="true"){curl_setopt($curl, CURLOPT_POST, 1);}
	if($mpostfield!=""){curl_setopt($curl, CURLOPT_POSTFIELDS, $mpostfield);}
	if($proxytunnel=="true"){curl_setopt($curl, CURLOPT_HTTPPROXYTUNNEL, 1);}
	if($proxytype=="http"){curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);}
	if($proxyip=="socks5"){curl_setopt($curl, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);}
	if($proxyport!=""){curl_setopt($curl, CURLOPT_PROXYPORT, $proxyport);}
	if($proxyip!=""){curl_setopt($curl, CURLOPT_PROXY, $proxyip);}
	if($nobody=="true"){curl_setopt($curl, CURLOPT_NOBODY, 1);}
	if($sslverify=="true"){
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	}

	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

function rebuild_url($url) {
	return $url['scheme'] . '://' . (!empty($url['user']) && !empty($url['pass']) ? rawurlencode($url['user']) . ':' . rawurlencode($url['pass']) . '@' : '') . $url['host'] . (!empty($url['port']) && $url['port'] != 80 && $url['port'] != 443 ? ':' . $url['port'] : '') . (empty($url['path']) ? '/' : $url['path']) . (!empty($url['query']) ? '?' . $url['query'] : '') . (!empty($url['fragment']) ? '#' . $url['fragment'] : '');
}

function GetVideosArr($fmtmaps, $fmts) {
	$fmturls = array();
	foreach ($fmtmaps as $fmtlist) {
		$fmtlist = array_map('urldecode', FormToArr($fmtlist));
		if (!in_array($fmtlist['itag'], $fmts)) continue;
		$fmtlist['url'] = parse_url($fmtlist['url']);
		$fmtlist['url']['query'] = array_map('urldecode', FormToArr($fmtlist['url']['query']));
		if (empty($fmtlist['url']['query']['signature'])) $fmtlist['url']['query']['signature'] = (!empty($fmtlist['s']) ? '' : $fmtlist['sig']);
		foreach (array_diff(array_keys($fmtlist), array('signature', 'sig', 's', 'url')) as $k) $fmtlist['url']['query'][$k] = $fmtlist[$k];
		ksort($fmtlist['url']['query']);
		$fmtlist['url']['query'] = http_build_query($fmtlist['url']['query']);
		$fmturls[$fmtlist['itag']] = rebuild_url($fmtlist['url']);
	}
	return $fmturls;
}

function FormToArr($content, $v1 = '&', $v2 = '=') {
	$rply = array();
	if (strpos($content, $v1) === false || strpos($content, $v2) === false) return $rply;
	foreach (array_filter(array_map('trim', explode($v1, $content))) as $v) {
		$v = array_map('trim', explode($v2, $v, 2));
		if ($v[0] != '') $rply[$v[0]] = $v[1];
	}
	return $rply;
}

$url = urldecode($_GET['url']);
if(strpos($url , 'picasaweb') !== false){
	if(stristr($url, '#')) list($url, $id) = explode('#', $url);
	$data = get_curl($url);
	if($id){
		$test1=explode('"gphoto$id":"'.$id,$data);
		$test1=explode('"gphoto$id',$test1[1]);
		$data = $test1[0];
	}
	$patten = '/\{"url":"https?:\/\/redirector.googlevideo.com\/videoplayback([^\}]+)/';
	preg_match_all($patten,$data,$match);
	if (count($match[0]) > 0)
	{
		foreach($match[0] as $item)
		{
			$itemJS =json_decode($item.'}', true);             
			if ($itemJS['height']>300 && $itemJS['height'] < 400 && !isset($itemmedium)) $itemmedium = $itemJS['url'];
			if ($itemJS['height']>=400 && $itemJS['height'] < 700 && !isset($itemlarge)) $itemlarge = $itemJS['url'];
			if ($itemJS['height']>=700 && !isset($itemhd)) $itemhd = $itemJS['url'];				
		}
		if (!isset($itemmedium))
		{
			$itemJS =json_decode($match[0][count($match[0])-1].'}', true);  
			$itemmedium = $itemJS['url'];
		}
	}  
}
elseif(strpos($url , 'youtube') !== false){
	preg_match("/v=([^\&]+)/i", $url, $id);
	$data = get_curl('http://www.youtube.com/get_video_info?video_id='.$id[1].'&asv=3&el=detailpage&hl=en_US', 0);
	$response = array_map('urldecode', FormToArr(substr($data, strpos($data, "\r\n\r\n") + 4)));
	$fmts = array(38,37,46,22,45,44,35,43,34,18,6,5,36,17);
	$fmt_url_maps = explode(',', $response['url_encoded_fmt_stream_map']);
	$fmturlmaps = GetVideosArr($fmt_url_maps, $fmts);
	if($fmturlmaps[18]) $itemmedium = $fmturlmaps[18];
	if($fmturlmaps[22]) $itemhd = $fmturlmaps[22];
	if($fmturlmaps[37]) $itemlarge = $fmturlmaps[37];
}
elseif(strpos($url, 'tv.zing.vn')){
	$id = explode('/', $url);
	$idzing = explode('.', $id[5]);
	$data = get_curl("http://api.tv.zing.vn/2.0/media/info?api_key=d04210a70026ad9323076716781c223f&media_id={$idzing[0]}&session_key=91618dfec493ed7dc9d61ac088dff36b&", 0);
	$data = json_decode($data, true);
	if($data['response']['download_url']['Video360']) $itemmedium = reset(explode('?', "http://".$data['response']['download_url']['Video360']));
	if($data['response']['download_url']['Video480']) $itemlarge = reset(explode('?', "http://".$data['response']['download_url']['Video480']));
	if($data['response']['download_url']['Video720']) $itemhd = reset(explode('?', "http://".$data['response']['download_url']['Video720']));
}
elseif(strpos($url, 'dailymotion.com')){
	$data = get_curl($url, 0);
	preg_match('/autoURL%22%3A%22(.*)%22%2C%22allow/', $data, $match);
	$link = str_replace('\\', '', urldecode($match[1]));
	$page = get_curl($link, 0);
	$test = json_decode($page, true);
	foreach($test['alternates'] as $item){
		if($item['name']>300 && $item['name'] < 400 && !isset($itemmedium))	$itemmedium = reset(explode('#', $item['template']));
		if($item['name']>=400 && $item['name'] < 700 && !isset($itemlarge))	$itemlarge = reset(explode('#', $item['template']));
		if($item['name']>=700 && !isset($itemhd))	$itemhd = reset(explode('#', $item['template']));
	}
}
elseif(strpos($url, 'docs.google.com')){
	preg_match("/\/d\/([^\/]+)/i", $url, $id);
	$data = get_curl('https://docs.google.com/get_video_info?docid='.$id[1].'&asv=3&el=detailpage&hl=en_US', 0);
	$response = array_map('urldecode', FormToArr(substr($data, strpos($data, "\r\n\r\n") + 4)));
	$fmts = array(38,37,46,22,45,44,35,43,34,18,6,5,36,17);
	$fmt_url_maps = explode(',', $response['url_encoded_fmt_stream_map']);
	$fmturlmaps = GetVideosArr($fmt_url_maps, $fmts);
	if($fmturlmaps[18]) $itemmedium = $fmturlmaps[18];
	if($fmturlmaps[22]) $itemhd = $fmturlmaps[22];
	if($fmturlmaps[37]) $itemlarge = $fmturlmaps[37];
}
else{
	//$itemmedium = 'https://www.youtube.com/watch?v=qEYOyZVWlzs';
}

if($itemmedium) $link['360'] = $itemmedium;
if($itemlarge) $link['480'] = $itemlarge;
if($itemhd) $link['720'] = $itemhd;
echo json_encode($link);


?>