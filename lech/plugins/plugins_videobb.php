<?php
$username = "YourUsername";
$password = "YourPassword";


$getacc = $_POST['getacc'];
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

function get_curl($url)
{
	global $useheader,$useragent,$referer,$autoreferer,$usehttpheader,$ucookie,$encoding,$timeout,$follow,$mpost,$mpostfield;
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
	if($ucookie!=""){curl_setopt($curl, CURLOPT_COOKIE, rawurldecode($ucookie));}
	if($referer!=""){curl_setopt($curl, CURLOPT_REFERER, $referer);}
	if($autoreferer=="true"){curl_setopt($curl, CURLOPT_AUTOREFERER, 1);}
	if($encoding!=""){curl_setopt($curl, CURLOPT_ENCODING, $encoding);}
	if($timeout!=""){curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);}
	if($follow=="true"){curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);}
	if($mpost=="true"){curl_setopt($curl, CURLOPT_POST, 1);}
	if($mpostfield!=""){curl_setopt($curl, CURLOPT_POSTFIELDS, $mpostfield);}

	$result = curl_exec($curl);
	curl_close($curl);
	return $result;
}

if($getacc=="true"){
	echo "&u=".$username."&p=".$password."&";
}else{
	$text = get_curl($link); 
	echo $text;
}
?> 