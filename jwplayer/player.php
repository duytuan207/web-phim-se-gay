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

$url = urldecode($_POST['url']);
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
	$itemmedium = $url;
}
elseif(strpos($url, 'tv.zing.vn')){
	$id = explode('/', $url);
	$idzing = explode('.', $id[5]);
	$data = get_curl("http://api.tv.zing.vn/2.0/media/info?api_key=d04210a70026ad9323076716781c223f&media_id={$idzing[0]}&session_key=91618dfec493ed7dc9d61ac088dff36b&", 0);
	$data = json_decode($data, true);
	if($data['response']['download_url']['Video360'])	$itemmedium = reset(explode('?', "http://".$data['response']['download_url']['Video360']));
	if($data['response']['download_url']['Video480'])	$itemlarge = reset(explode('?', "http://".$data['response']['download_url']['Video480']));
	if($data['response']['download_url']['Video720'])	$itemhd = reset(explode('?', "http://".$data['response']['download_url']['Video720']));
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
else{
	$itemmedium = 'https://www.youtube.com/watch?v=qEYOyZVWlzs';
}


$list['file'] = $itemmedium ? $itemmedium : $itemlarge;
if($itemlarge) $list['large.file'] = $itemlarge;
if($itemhd) $list['hd.file'] = $itemhd;
echo json_encode($list);


?>