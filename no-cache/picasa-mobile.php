<?php
if(!$_GET['url'])
die('I dont know');
function get_by_curl($url){
     $ch = curl_init(); 
     curl_setopt ($ch, CURLOPT_URL, $url); 
     curl_setopt ($ch, CURLOPT_USERAGENT, "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
     curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
     curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
     $result = curl_exec ($ch);
     curl_close($ch);
return $result;
}
$url=urldecode($_GET['url']);
$data = get_by_curl($url);
preg_match('/http\:\/\/redirector\.googlevideo\.com\/videoplayback\?([^>]*)\,\"description\"/U', $data, $arr);
$chuoilink = $arr[0];
preg_match_all("/http([^>]*)key\=lh1/U", $chuoilink, $brr);
$linkmp4 = ($brr[0][1]);
header ('Location: '.$linkmp4);	
?>