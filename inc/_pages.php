<?php
if (!defined('IN_MEDIA')) die("Hack");
function view_pages($type,$ttrow,$limit,$page,$ext='',$apr='',$cat_id=''){
	$total = ceil($ttrow/$limit);
	if ($total <= 1) return '';
	$style_1 = '';
	$style_2 = 'class="item"';
	$style_3 = 'class="item"';
    if ($page<>1){
	    if($type=='request') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",1); return false;'>FIRST</a></span>&nbsp;";
        elseif($type=='trailer') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",1); return false;'>FIRST</a></span>&nbsp;";
		elseif($type=='film') 
		$main .= "<li><a href='".$ext."/trang-1.html'>« Đầu</a></li>&nbsp; ";
        elseif($type=='comment') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",1); return false;'>FIRST</a></span>&nbsp;";
    }
	for($num = 1; $num <= $total; $num++){
		if ($num < $page - 1 || $num > $page + 4) 
		continue;
		if($num==$page) 
			$main .= "<li class=\"active\"><a rel=\"nofollow\">$num</a></li>&nbsp;"; 
        else { 
           if($type=='request') 
		   $main .= "<li><a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",".$num."); return false;'>$num</a></li>&nbsp;";
		   elseif($type=='trailer') 
		   $main .= "<li><a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",".$num."); return false;'>$num</a></li>&nbsp;"; elseif($type=='film') 
		   $main .= "<li><a $style_1 href='".$ext."/trang-".$num.".html'>$num</a></li>&nbsp; "; 
           elseif($type=='comment') 
		   $main .= "<li><a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",".$num."); return false;'>$num</a></li>&nbsp;";
       } 	
    }
    if ($page<>$total){
	    if($type=='request') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showRequest(".$limit.",".$total."); return false;'>LAST</a></span>";      
		elseif($type=='trailer') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showTrailer(".$limit.",".$ext.",".$total."); return false;'>LAST</a></span>"; 
        elseif($type=='film') 
		$main .= "<li><a href='".$ext."/trang-".$total.".html'>Cuối »</a></li>&nbsp; "; 
        elseif($type=='comment') 
		$main .= "<span class=\"item\"><a $style_1 href='javascript:void(0)' onClick='return showComment(".$limit.",".$ext.",".$total."); return false;'>LAST</a></span>"; 
    }
  return $main;
}
?>