<?php
$site_name = "Benzing Technologies";
 
/**
 * The URL of your site
 */
$site_url = "http://benzingtech.com";
 
$request = xmlrpc_encode_request("weblogUpdates.ping", array($site_name, $site_url));
 
#echo $request;

$context = stream_context_create(array('http' => array(
    'method' => "POST",
    'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\nHost: rpc.technorati.com\r\n",
    'content' => $request
)));
 
$server = "http://rpc.technorati.com/rpc/ping";
$file = file_get_contents($server, false, $context);
 
$response = xmlrpc_decode($file);
 
if (is_array($response) and xmlrpc_is_fault($response)){
    echo "Failed to ping Technorati";
} else {
    echo "Successfully pinged Technorati";
}
 
?>