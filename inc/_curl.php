<?php
if (!defined('Xuanhoa88')) die("Hack");
class curl {
    var $contents;
    var $_header;
    var $headers=array();
    var $body;
    var $url="";
    function exec($method, $url, $vars="",$h=1,$cookie="",$referer="",$ua="Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)") {
        $ch = curl_init();
        $ip = rand(0,255).".".rand(0,255).".".rand(0,255).".".rand(0,255);
        $header =array("REMOTE_ADDR: $ip");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, ($h==2) ? 0:1);
        if($ua) curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        if($referer || $this->url) curl_setopt($ch, CURLOPT_REFERER,$referer?$referer:$this->url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);    
        @curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $h!=5?1:0);
        if(strncmp($url,"https",6)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'c.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'c.txt');
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        }
        $data = curl_exec($ch);
        $this->url=$url;
        if ($data) {
            if(preg_match("/^HTTP\/1\.1 302/",$data) && $h!=2 && strstr($data,"\r\n\r\nHTTP/1.1 200") ){
                $pos = strpos($data, "\r\n\r\n");
                $data= substr($data, $pos  + 4);             
            }
            if($h!=3&&$h!=4) return $data;
            else{
                $pos = strpos($data, "\r\n\r\n");
                $this->body = substr($data, $pos  + 4);
                $this->_header = substr($data, 0,$pos);
                $this->_header=explode("\r\n",trim($this->_header));
                foreach($this->_header as $v){
                     $v=explode(":",$v,2);
                     $this->headers[$v[0]]=trim($v[1]);
                }
                return $h==3?$this->headers:array($this->headers,$this->body);
            }
        } 
		else {
            return curl_error($ch);
        }
        curl_close($ch);
    }

    function get($url, $vars="" ,$h=1) {
        return $this->exec('GET', $url, $vars,$h);
    }

    function post($url, $vars ,$h=1) {
        return $this->exec('POST', $url, $vars,$h);
    }

    function seturl($url){
        $this->url=$url;
    }
}
?>