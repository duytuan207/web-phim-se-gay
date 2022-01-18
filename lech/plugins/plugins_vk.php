<?php
$username = "YourUsername";
$password = "YourPassword";
$last4digitsPhoneNumber = "";


$getacc = $_POST['getacc'];
$savecookie = $_POST['savecookie'];
$checkcookie = $_POST['checkcookie'];
$link = $_POST['url'];
$useheader = $_POST['iheader'];
$useragent = $_POST['iagent'];
$referer = $_POST['ireferer'];
$autoreferer = $_POST['iautoreferer'];
$usehttpheader = $_POST['ihttpheader'];
$ucookie = $_POST['icookie'];
$encoding = $_POST['iencoding'];
$timeout = $_POST['itimeout'];
$follow = $_POST['ifollow'];
$mpost = $_POST['ipost'];
$mpostfield = $_POST['ipostfield'];
$proxytunnel = $_POST['iproxytunnel'];
$proxytype = $_POST['iproxytype'];
$proxyport = $_POST['iproxyport'];
$proxyip = $_POST['iproxyip'];
$sslverify = $_POST['isslverify'];
$nobody = $_POST['inobody'];

function get_curl($url)
{
	global $useheader,$useragent,$referer,$autoreferer,$usehttpheader,$ucookie,$encoding,$timeout,$follow,$mpost,$mpostfield,$proxytunnel,$proxytype,$proxyport,$proxyip,$sslverify,$nobody;
	$curl = curl_init();
	$header[0] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Keep-Alive: 115";
	$header[] = "Connection: keep-alive";
	
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	if($useheader=="true"){curl_setopt($curl, CURLOPT_HEADER, 1);}
	if($useragent!=""){curl_setopt($curl, CURLOPT_USERAGENT, $useragent);}
	if($usehttpheader=="true"){curl_setopt($curl, CURLOPT_HTTPHEADER, $header);}
	if($ucookie!=""){curl_setopt($curl, CURLOPT_COOKIE, str_replace('\\"','"',$ucookie));}
	if($referer!=""){curl_setopt($curl, CURLOPT_REFERER, $referer);}
	if($autoreferer=="true"){curl_setopt($curl, CURLOPT_AUTOREFERER, 1);}
	if($encoding!=""){curl_setopt($curl, CURLOPT_ENCODING, $encoding);}
	if($timeout!=""){curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);}
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

$filenamecookie = 'plugins_vk_cookie.php';
$fileout = $_GET['f'];
$filelength = $_GET['l'];
$filecookie = $_GET['c'];
$filestream = $_GET['start'];
if($fileout!=""){
	$fileout = base64_decode($fileout);
	$filelength = base64_decode($filelength);
	$filecookie = base64_decode($filecookie);
	if($filestream!=""){
		$filelength -= $filestream;
		$filestream = "&start=".$filestream;
	}
	header('Content-Type: application/octet-stream');
	header('Content-Length: ' . $filelength);
	$ct = stream_context_create(array('http'=>array('header'=>"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:13.0) Gecko/20100101 Firefox/13.0.1\r\nCookie: ".$filecookie."\r\n")));
	readfile($fileout.$filestream,false,$ct);
}else if($getacc=="true"){
	echo "&u=".$username."&p=".$password."&d=".$last4digitsPhoneNumber."&";
}else if($savecookie=="true"){
	$fp = fopen($filenamecookie, 'w');
	fwrite($fp, '<?php ;$cookieTemp=\''.$username.":".base64_encode($ucookie).'\';?>');
	fclose($fp);
}else if($checkcookie=="true"){
	$rs = "";
	if (!file_exists($filenamecookie)) {
		$rs = "false";
	}else{
		include($filenamecookie);
		$arrck = explode(":",$cookieTemp);
		if($arrck[0]!=$username){
			$rs = "false";
		}else{
			$rs = base64_decode($arrck[1]);
		}
	}
	echo "&cookie=".$rs;
}else{
	$text = get_curl($link); 
	echo $text;
}

?> 