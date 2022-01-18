<?php
if (!defined('IN_MEDIA')) die("Hack");
class temp {
	var $ext = ".html";
	var $cache_temp = array();
	function get_htm($filename,$blockname = '',$c = false) {
		$full_link = $_SESSION['skin_folder']."/".$filename.$this->ext;
		if (!file_exists($full_link)) {
			die("Không tìm thấy file : <b>".$full_link."</b>");
		}
		if ($this->cache_temp['file_'.$filename]) $file_content = $this->cache_temp['file_'.$filename];
		else {
			$this->cache_temp['file_'.$filename] = $file_content = file_get_contents($full_link);
		}
		return $file_content;
	}
	function get_box_play($filename,$blockname = '',$c = false) {
		$full_link = $_SESSION['skin_folder']."/player/".$filename.$this->ext;
		if (!file_exists($full_link)) {
			die("Không tìm thấy file : <b>".$full_link."</b>");
		}
		if ($this->cache_temp['file_'.$filename]) $file_content = $this->cache_temp['file_'.$filename];
		else {
			$this->cache_temp['file_'.$filename] = $file_content = file_get_contents($full_link);
		}
		return $file_content;
	}
	function get_block_from_htm($str,$block = '',$c = false) {
		
		if (!$this->cache_temp['block_'.$block]) {
			preg_replace('#<!-- '.(($c)?'\#':'').'BEGIN '.$block.' -->[\r\n]*(.*?)[\r\n]*<!-- '.(($c)?'\#':'').'END '.$block.' -->#se','$s = stripslashes("\1");',$str);
			if ($s != $str)	$str = $s;
			else $str = '';
			$this->cache_temp['block_'.$block] = $str;
		}
		return $this->cache_temp['block_'.$block];
	}
	
	function replace_value($code,$arr) {
		foreach ($arr as $block => $val) {
				$code = str_replace('{'.$block.'}',$val,$code);
		}
		return $code;
	}
	
	function replace_blocks_into_htm($code,$arr) {
		foreach ($arr as $block => $val) {
			$code = preg_replace('#<!-- BEGIN '.$block.' -->[\r\n]*(.*?)[\r\n]*<!-- END '.$block.' -->#s', $val, $code);
		}
		return $code;
	}
	
	function auto_get_block($str) {
		preg_match_all('#<!-- \#BEGIN (.*?) -->[\r\n]*(.*?)[\r\n]*<!-- \#END (.*?) -->#s', $str, $arr, PREG_PATTERN_ORDER);
		$a = array();
		for ($i=0; $i<count($arr[0]); $i++) {
			$a[$arr[1][$i]] = $arr[0][$i];
		}
		return $a;
	}
	
	function eval_main($func,$exp = '') {
		$exp = trim(stripslashes($exp));
		if ($exp) $code = @eval("return ".$func."(".$exp.");");
		else $code = @eval("return ".$func."();");
		return $code;
	}
	
	function print_htm($code) {
		global $web_title,$web_link,$link_href,$value;
		$code = preg_replace('#<!-- MAIN (.*?)\((.*?)\) -->#se', '$this->eval_main("\\1","\\2");', $code);
		if ($value[1]!='watch') $code = preg_replace('#<!-- BEGIN (.*?) -->[\r\n]*(.*?)[\r\n]*<!-- END (.*?) -->#s', '\\2', $code);
		$code = str_replace('{web.TITLE}', $web_title, $code);
		$code = str_replace('{web.LINK}', $web_link, $code);
		$code = str_replace('{link_href}', $web_link, $code);
		$code = str_replace('{skin.LINK}', $_SESSION['skin_folder'], $code);
		echo $code;
	}
}
?>