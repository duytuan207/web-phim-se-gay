<?php
error_reporting(E_ERROR| E_PARSE);
if (!defined('IN_MEDIA_ADMIN')) die("Hacking attempt");
//Add  Multi Episode of Film - Code by thegioitinhocs@yahoo.com

if (!$_POST['ok'] && !$_POST['submit'])  {

?>

<form method="post">
<table class="border" cellpadding="2" cellspacing="0" width="80%">
    <tr>
        <td class="title" align="center" colspan="2">
          Thêm
        </td>
    </tr>
    <tr>
        <td class="fr" align="center" width="50%">
            <input name="episode_begin" size="45" value="Tập bắt đầu" onclick="this.select()" style="text-align:center;background:violet;font-weight: bold;"/>
        </td>
    
        <td class="fr" align="center">
            <input name="episode_end" size="45" value="Tập kết thúc" onclick="this.select()" style="text-align:center;background:yellow;font-weight: bold;"/>
        </td>
    </tr>
	<tr>
    	<td class="fr" colspan="2" align="center">
        	<font color="red">Chú ý</font>
        </td>
    </tr>
	<tr>
    	<td class="fr" align="left" style="padding-left:50px;">
        	<input type="radio" name="is_full" id="is_full[]" value="Full" /><label>&nbsp;Sửa "Full" cho tập đầu</label>&nbsp;<br/>
            <input type="radio" name="is_full" id="is_full[]" value="Download" /><label>&nbsp;Sửa "Download" cho tập đầu</label>&nbsp;
        </td>
		<td class="fr" align="left" style="padding-left:50px;">
        	<input type="checkbox" name="end" id="end"  /><label>&nbsp;Thêm "End" tập kết thúc</label><br />
            <input type="radio" name="is_full" id="is_full[]" value="Trailer" /><label>&nbsp;Sửa "Trailer" cho tập đầu</label>&nbsp;

        </td>
    <tr>
    	<td class="fr" align="left" style="padding-left:50px;">
            <input type="radio" name="is_sort" id="is_sort[]" value="0" checked="checked" /><label>&nbsp;Dạng  1,2,3,4,5,6,7,8,9</label>&nbsp;
        </td>
		<td class="fr" align="left" style="padding-left:50px;">
			<input type="radio" name="is_sort" id="is_sort[]" value="1" /><label>&nbsp;Dạng  1a,1b,2a,2b,1a,1b,2a,2b</label>&nbsp;
        </td>
    </tr>
    <tr>
		<td class=fr align=center>
        	Số Server: <input name="part_per_ep" size="20" value="Số server" onclick="this.select()" style="text-align:center;background:white;font-weight: bold;">
        </td>
		<td class=fr align=center>
        	Số tập nhỏ: <input name="part_per_ep2" size="20" value="S&#7889; ph&#7847;n/t&#7853;p" onclick="this.select()" style="text-align:center;background:white;font-weight: bold;">
        </td>
    </tr>
    <tr>
		<td class=fr align=center colspan=2>
        	<p><textarea name="multilink" id="multilink" style="background:white;width:100%;height:250px"></textarea></p>
        </td>
	</tr>

    <tr>
    	<td class="fr" align="center" colspan="2">
			<input type="submit" name="ok" class="submit">
		</td>
	<tr>
  	
    </tr>
</table>
</form>



<?php

}

else

{

$url = $_POST['multilink'];

$url_clip = explode("\n", $url);

$begin = $_POST['episode_begin'];

$end = $_POST['episode_end'];
if(!$film_id)
$add_new_film ="<table cellpadding=\"2\" cellspacing=\"0\" width=\"100%\">	
	<tr>
	<td width=\"15%\" align=\"left\"><b>Tên Phim</b></td>
	<td width=\"25%\"><input name=\"new_film\" size=\"40\"></td>
	</tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Tên English: </b></td>
	<td width=\"25%\"><input name=\"name_real\" size=\"40\"></td>
	</tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Status</b></td>
	<td width=\"25%\"><input name=\"tapphim\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\" valign=\"top\"><b>Ảnh phim</b></td>
	<td width=\"25%\"><input name=\"url_img\" size=\"50\">-Link Ảnh<br><br>
		Server chứa ảnh:
		<input type=\"radio\" value=\"1\" name=\"server_img\"> ko up
		<input type=\"radio\" value=\"2\" checked name=\"server_img\"> Picasa
		
		</td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Đạo Diễn</b></td>
	<td width=\"25%\"><input name=\"director\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Diễn Viên</b></td>
	<td width=\"25%\"><input name=\"actor\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Sản Xuất</b></td>
	<td width=\"25%\"><input name=\"area\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Năm</b></td>
	<td width=\"25%\"><input name=\"year\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Thời Lượng</b></td>
	<td width=\"25%\"><input name=\"time\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Điểm IMDb</b></td>
	<td width=\"25%\"><input name=\"imdb\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Trạng Thái Hoàn Thành/Chưa Hoàn Thành</b></td>
	<td width=\"25%\"><input name=\"hoanthanh\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Trailer Phim</b></td>
	<td width=\"25%\"><input name=\"gioithieu\" size=\"50\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Ưu tiên</b></td>
	<td width=\"25%\">".set_type()."</td>
    </tr>		
	<tr>
	<td width=\"15%\" align=\"left\"><b>Trạng thái</b></td>	
	<td width=\"25%\">".trang_thai()."</td>    
	</tr>
    <tr>
	<td width=\"15%\" align=\"left\"><b>Phim bộ/lẻ</b></td>
	<td width=\"25%\"><select name=\"bo_le\"><option value=\"0\" selected=\"selected\">- Phim Lẻ</option><option value=\"1\">- Phim Bộ</option></select></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Quốc gia</b></td>
	<td width=\"25%\">".acp_country()."</td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Thể Loại</b></td>
	<td width=\"25%\">".acp_cat()."</td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Thông Tin</b></td>
	<td colspan=\"2\" align=\"center\" style=\"padding-top:15px;\"><textarea name=\"info\" class=\"ckeditor\" id=\"editor1\" cols=\"150\" rows=\"30\"></textarea>
		<script>CKEDITOR.replace( 'editor1',{skin : 'v2',language: 'vi'});</script></td>
    </tr>
    <tr>
	<td width=\"15%\" align=\"left\"><b>Keywords</b></td>
	<td><input name=\"key\" size=\"100\"></td>
    </tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Description</b></td>
	<td><input name=\"des\" size=\"100\"></td>
	</tr>
	<tr>
	<td width=\"15%\" align=\"left\"><b>Từ Khóa</b></td>
	<td><input name=\"tag\" size=\"100\"></td>
    </tr>
	</table>
	</td>

</tr>";
else $add_new_film ="<tr>

	<td class=fr width=15%><b>Choose Film</b></td>

	<td class=fr_2>".acp_film($film_id)."</td>

</tr>";
////BEGIN CHECK EPISODE

if(!is_numeric($begin) && !is_numeric($end)){
    $episode_begin = 1;

    $episode_end = 10;
}
elseif(!is_numeric($begin)){
    $episode_begin = $episode_end = $end;

}

else{
    $episode_begin = $begin; 

	$episode_end = $end;
}

////END CHECK EPISODE

if (!$_POST['submit']) {

?>

<form enctype="multipart/form-data" method=post>

<?php	if(!$film_id) {	?>

<table class="border" cellpadding="2" cellspacing="0" width="95%">



<tr><td colspan="2" class="title" align="center">Thêm</td></tr>

<tr>

	<td class="fr" width="10%"><b>Lựa chọn</b></td>

	<td class="fr_2"><?php echo acp_film();?></td>
</tr>

<tr>
	<td class=fr width="10%">
		<b>THÊM PHIM NHANH</b>
		<br>If database ised havent Web is gently self-made</td>
	<td class=fr_2 >
<?=$add_new_film?>
	</td>


<tr>

    <td class="fr" width="10%"><b>LOCAL SEVER</b></td>

    <td class="fr_2"><?=acp_local(0,'main')?>
</td>
<tr>

    <td class="fr" width="10%"><b>Server Post</b></td>

    <td class="fr_2"><?php echo set_server(0);?>

</td>
<?php

$is_end = $_POST['end'];
$is_full = $_POST['is_full'];
$is_ep_end = 0;

$part_ep = $_POST['part_per_ep'];
$part_ep_2 = $_POST['part_per_ep2'];
if (!is_numeric($part_ep)) $part_ep=1;
if (!is_numeric($part_ep_2)) $part_ep_2=1;
$m=0;
if ($_POST['is_sort']==0)
{
	for ($i=$episode_begin;$i<=$episode_end;$i++) 
	{
		if ($i<10) $j= ''.$i;
		elseif ($i>9 && $i<100) $j=''.$i;
		else $j = $i;
		$b=range('`','z');
		for ($e=1;$e<=$part_ep_2;$e++)
		{
			if ($part_ep_2>1) $ep = $i.$b[$e];
			else $ep = $i;
			if ( $is_end =="on" && $i==$episode_end && $e==$part_ep_2) $ep .= "-End";  
			for ($s =1; $s<=$part_ep;$s++,$m++)
				{	
					
					$is_ep_end++;
					if ($ep<10) $j= ''.$ep;
					elseif ($ep>9 && $ep<100) $j=''.$ep;
					else $j = $ep;
					if ( $is_full && $i==$episode_begin) $j = $is_full;
					$dmcc = str_replace('||','|',$url_clip[$m]);
					$xxxx	=	explode("|",$dmcc);
					$link	=	trim($xxxx[1]);
					$subk	=	$xxxx[0];
					if($link){
					$link_s = $link;
					$jjj	= $xxxx[0];
					}else{
					$link_s = $xxxx[0];
					$jjj	= $j;
					}
					
?>

<tr>

<td class="fr" width="10%"><b>Tập <input onclick="this.select()" type="text" name="name[<?php echo $is_ep_end;?>]" value="<?php echo $jjj;?>" size=7 style="text-align:center"></b></td>
<td class=fr_2>
    	<div><input type="text" name="url[<?=$is_ep_end;?>]" value="<?=$link_s;?>" size="45"></div>
       
</td>
</tr>

<?php
			}
		}
	}
}
else
{
	$total_ep =($episode_end-$episode_begin +1)*$part_ep*$part_ep_2;
	for ($i=1,$s= $episode_begin,$p=1,$p_e= $episode_begin;$i<=$total_ep;$i++,$s++,$p++) 
	{
		if ($i<10) $j= ''.$i;
		elseif ($i>9 && $i<100) $j=''.$i;
		else $j = $i;
		$b=range('`','z');
		if($part_ep > 0)
		{
			if ($part_ep_2>1)
			{
				if ($p>$part_ep_2)
				{	
					$p=1;
					$p_e++;
				}
				if ($p_e > $episode_end) $p_e= $episode_begin;
				$ep = $p_e.$b[$p];
			}
			else
			{
				if($s>$episode_end)
				{
					$ep_end =true;
					$s = $episode_begin;
				}
				$ep = $s;
			}
		}
		else $ep=$i;	
		if ( $is_end =="on" && ( $ep_end || ($p_e==$episode_end && $p==$part_ep_2))) $ep .= "-End"; 
		$xxxx	=	explode("|",$url_clip[$i-1]);
		$link	=	trim($xxxx[0]);
		$subk	=	$xxxx[1];
		$is_ep_end++;
		if ($ep<10) $j= ''.$ep;
		elseif ($ep>9 && $ep<100) $j=''.$ep;
		else $j = $ep;
		if ( $is_full && ( $s==$episode_begin || ($p_e==$episode_begin && $p==1))) $j = $is_full;
?>
<tr>

<td class="fr" width="10%"><b>Tập <input onclick="this.select()" type="text" name="name[<?php echo $is_ep_end;?>]" value="<?php echo $j;?>" size=7 style="text-align:center"></b></td>
<td class=fr_2>
    	<div><input type="text" name="url[<?=$is_ep_end;?>]" value="<?=trim($link);?>" size="45"><?php echo acp_local(0,$is_ep_end);?>Sub: <input type="text" name="sub[<?=$is_ep_end;?>]" value="<?=$subk;?>" size="35" />Text: <input type="text" name="message[<?=$is_ep_end;?>]" value="<?=$message;?>" size="35" /></div>
       
</td>
</tr>

<?php
	}
}
?>

<tr><td class="fr" colspan="2" align="center">

<input type="hidden" name="episode_begin" value="1">

<input type="hidden" name="episode_end" value="<?php echo $is_ep_end;?>">

<input type="hidden" name="ok" value="SUBMIT">

<input type="submit" name="submit" class="submit"></td></tr>

<script>

var total = <?php echo $is_ep_end;?>;

function check_local(id){

    for(i=1;i<=total;i++)

           document.getElementById("local_url["+i+"]").value=id;
}

</script> 

</table>	

<?php	} else { ?>

<table class="border" cellpadding="2" cellspacing="0" width="95%">

<tr><td colspan="2" class="title" align="center">Thêm</td></tr>

<tr>

	<td class="fr" width="10%"><b>Lựa Chọn</b></td>

	<td class="fr_2"><?php echo acp_film($film_id);?></td>

</tr>

<tr>

    <td class="fr" width="10%"><b>Local Sever</b></td>

    <td class="fr_2"><?php echo acp_local(0,'main');?> 

</td>


<tr>

    <td class="fr" width="10%"><b>Server Post</b></td>

    <td class="fr_2"><?php echo set_server(0);?>

</td>

<?php

$is_end = $_POST['end'];
$is_ep_end = 0;

$part_ep = $_POST['part_per_ep'];
$part_ep_2 = $_POST['part_per_ep2'];
if (!is_numeric($part_ep)) $part_ep=1;
if (!is_numeric($part_ep_2)) $part_ep_2=1;
$m=0;
if ($_POST['is_sort']==0)
{
	for ($i=$episode_begin;$i<=$episode_end;$i++) 
	{
		if ($i<10) $j= ''.$i;
		elseif ($i>9 && $i<100) $j=''.$i;
		else $j = $i;
		$b=range('`','z');
		for ($e=1;$e<=$part_ep_2;$e++)
		{
			if ($part_ep_2>1) $ep = $i.$b[$e];
			else $ep = $i;
			if ( $is_end =="on" && $i==$episode_end && $e==$part_ep_2) $ep .= "-End"; 
			for ($s =1; $s<=$part_ep;$s++,$m++)
				{	
					//$xxxx	=	explode("|",$url_clip[$m]);
					//$link	=	trim($xxxx[0]);
					//$subk	=	$xxxx[1];
					$is_ep_end++;
					if ($ep<10) $j= ''.$ep;
					elseif ($ep>9 && $ep<100) $j=''.$ep;
					else $j = $ep;
					if ( $is_full && $i==$episode_begin) $j = $is_full;
					$dmcc = str_replace('||','|',$url_clip[$m]);
					$xxxx	=	explode("|",$dmcc);
					$link	=	trim($xxxx[1]);
					if($link){
					$link_s = $link;
					$jjj	= $xxxx[0];
					}else{
					$link_s = $xxxx[0];
					$jjj	= $j;
					}
					
?>
<tr>

<td class="fr" width="10%"><b>Tập <input onclick="this.select()" type="text" name="name[<?php echo $is_ep_end;?>]" value="<?php echo $jjj;?>" size=7 style="text-align:center"></b></td>
<td class=fr_2>
    	<div><input type="text" name="url[<?=$is_ep_end;?>]" value="<?=$link_s;?>" size="45">Sub: <input type="text" name="sub[<?=$is_ep_end;?>]" value="" size="35" />Text: <input type="text" name="message[<?=$is_ep_end;?>]" value="<?=$message;?>" size="35" /></div>
       
</td>
</tr>
<?php
			}
		}
	}
}
else
{
	$total_ep =($episode_end-$episode_begin +1)*$part_ep*$part_ep_2;
	for ($i=1,$s= $episode_begin,$p=1,$p_e= $episode_begin;$i<=$total_ep;$i++,$s++,$p++) 
	{
		if ($i<10) $j= ''.$i;
		elseif ($i>9 && $i<100) $j=''.$i;
		else $j = $i;
		$b=range('`','z');
		if($part_ep > 0)
		{
			if ($part_ep_2>1)
			{
				if ($p>$part_ep_2)
				{	
					$p=1;
					$p_e++;
				}
				if ($p_e > $episode_end) $p_e= $episode_begin;
				$ep = $p_e.$b[$p];
			}
			else
			{
				if($s>$episode_end)
				{
					$ep_end =true;
					$s = $episode_begin;
				}
				$ep = $s;
			}
		}
		else $ep=$i;	
		if ( $is_end =="on" && ( $ep_end || ($p_e==$episode_end && $p==$part_ep_2))) $ep .= "-End";
		$xxxx	=	explode("|",$url_clip[$i-1]);
		$link	=	trim($xxxx[0]);
		$subk	=	$xxxx[1];
		$is_ep_end++;
		if ($ep<10) $j= ''.$ep;
		elseif ($ep>9 && $ep<100) $j=''.$ep;
		else $j = $ep;
		if ( $is_full && ( $s==$episode_begin || ($p_e==$episode_begin && $p==1))) $j = $is_full;
?>
<tr>

<td class="fr" width="10%"><b>Tập <input onclick="this.select()" type="text" name="name[<?php echo $is_ep_end;?>]" value="<?php echo $j;?>" size=7 style="text-align:center"></b></td>
<td class=fr_2>
    	<div><input type="text" name="url[<?=$is_ep_end;?>]" value="<?=$link;?>" size="45">Sub: <input type="text" name="sub[<?=$is_ep_end;?>]" value="<?=$subk;?>" size="35" />Text: <input type="text" name="message[<?=$is_ep_end;?>]" value="<?=$message;?>" size="35" /></div>
       
</td>
</tr>
<?php
	}
}

?>

<tr><td class="fr" colspan="2" align="center">

<input type="hidden" name="episode_begin" value="1">

<input type="hidden" name="episode_end" value="<?php echo $is_ep_end;?>">

<input type="hidden" name="ok" value="SUBMIT">

<input type="submit" name="submit" class="submit"></td></tr>

<script type="text/javascript">

var total = <?php echo $is_ep_end;?>;

function check_local(id){

    for(i=1;i<=total;i++)

           document.getElementById("local_url["+i+"]").value=id;

}

</script> 

</table>

<?php	} ?>

</form>

<?php

}

else {	

	if ($new_film) {
		/* begin upload images*/
		$server_img		=	$_POST['server_img'];
		if($server_img == 1) {
			$new_film_img = $url_img;
		}else {
				// picasa
				if($server_img == 2) {
					define('DIR', dirname(__FILE__));
					$tempfolder = DIR . '/temp/';
					$isWatermark = 1;
					$transfer = false;
					$max_images_size = 10;
					$images_in_slide = 25;
					$_url = $_urlc = $url_img;
						if(!preg_match('#^https?:\/\/(.*)\.(gif|png|jpg)$#i', $_url)) die('image=Invalid Url');
						while(stripos($_url,'%')!==false){
							$_url = rawurldecode($_url);
						}
						$filePath = $tempfolder . basename($_url);
						$imgk = @file_get_contents($_urlc);
						$fk = fopen($filePath,"w");
						fwrite($fk,$imgk);
						fclose($fk);
						
						if (!$error && (filesize($filePath) > $max_images_size * 1024 * 1024))
						{
							$error = 'Please transfer only files smaller than 2Mb!';
						}

						if (!$error && !($size = @getimagesize($filePath) ) )
						{
							$error = 'Please transfer only images, no other files are supported.';
						}

						if (!$error && !in_array($size[2], array(1, 2, 3, 7, 8) ) )
						{
							$error = 'Please transfer only images of type JPEG, GIF or PNG.';
						}

						if($error) {
							@unlink($filePath);
							die($error);
						}
						$_FILES['Filedata'] = array(
							'name' => $filePath,
							'tmp_name' => $filePath
						);
						$transfer = true;
						unset($_POST,$_REQUEST,$_GET);
						$error = false;
						$file = $_FILES['Filedata'];
						if (!isset($filePath)) $filePath = $tempfolder . UPLOAD_TB . time().'.'.end(explode('.',basename($file['name'])));
						
						if($isWatermark && (($size[0] > 150) && ($size[1] > 35))){
							$watermark_path = DIR . '/logo1.png';
							$watermark_id = imagecreatefrompng($watermark_path);
							imagealphablending($watermark_id, false);
							imagesavealpha($watermark_id, true);
						
							$info_wtm = getimagesize($watermark_path);
							$fileType = strtolower($size['mime']);
							
							$image_w 		= $size[0];
							$image_h 		= $size[1];
							$watermark_w	= $info_wtm[0];
							$watermark_h	= $info_wtm[1];
							$is_gif = false;	
							switch($fileType)
							{
								case	'image/gif':	$is_gif = true;break;
								case	'image/png': 	$image_id = imagecreatefrompng($filePath);imagealphablending($image_id, true);
							imagesavealpha($image_id, true);	break;
								default:				$image_id = imagecreatefromjpeg($filePath);	break;
							}
							if(!$is_gif){
								/* Watermark in the bottom right of image*/
								$dest_x  = ($image_w - $watermark_w); 
								$dest_y  = ($image_h  - $watermark_h);
								
								/* Watermark in the middle of image 
								$dest_x = round(( $image_height / 2 ) - ( $logo_h / 2 ));
								$dest_y = round(( $image_w / 2 ) - ( $logo_w / 2 ));
								*/
								imagecopy($image_id, $watermark_id, $dest_x, $dest_y, 0, 0, $watermark_w, $watermark_h);
								if($transfer){
									@unlink($filePath);
									$filePath = $tempfolder . basename($file['name']);
								}	
								//override to image
								switch($fileType)
								{
									case	'image/png': 	@imagepng ($image_id, $filePath); 		break;
									default:				@imagejpeg($image_id, $filePath, 100); 		break;
								}       		 
								imagedestroy($image_id);
								imagedestroy($watermark_id);
							}
						}
						// load classes
						require_once 'Zend/Loader.php';
						Zend_Loader::loadClass('Zend_Gdata');
						Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
						Zend_Loader::loadClass('Zend_Gdata_Photos');
						Zend_Loader::loadClass('Zend_Http_Client');	
						
						$serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
						$client = Zend_Gdata_ClientLogin::getHttpClient(GNAME, GPASS, $serviceName);

						// update the second argument to be CompanyName-ProductName-Version
						$gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
						$username = "default";
						$filename = $filePath;
						$xname = preg_replace('/\s+/','_',basename($file['name']));
						if(!preg_match('/^'. preg_quote(UPLOAD_TB) .'/i',$xname)) $photoName = UPLOAD_TB.'-'.$xname;
						else $photoName = $xname;
						$photoCaption = $photoName;
						$photoTags = "";
						

						$fd = $gp->newMediaFileSource($filename);
						$fd->setContentType(strtolower($size['mime']));

						// Create a PhotoEntry
						$photoEntry = $gp->newPhotoEntry();

						$photoEntry->setMediaSource($fd);
						$photoEntry->setTitle($gp->newTitle($photoName));
						$photoEntry->setSummary($gp->newSummary($photoCaption));

						// add some tags
						$keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
						$keywords->setText($photoTags);
						$photoEntry->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
						$photoEntry->mediaGroup->keywords = $keywords;

						// We use the AlbumQuery class to generate the URL for the album
						$albumQuery = $gp->newAlbumQuery();

						$albumQuery->setUser($username);
						$albumQuery->setAlbumId(ABUMID);

						// We insert the photo, and the server returns the entry representing
						// that photo after it is uploaded
						$insertedEntry = $gp->insertPhotoEntry($photoEntry, $albumQuery->getQueryUrl()); 
						$contentUrl = "";
						//$firstThumbnailUrl = "";

						if ($insertedEntry->getMediaGroup()->getContent() != null) {
						  $mediaContentArray = $insertedEntry->getMediaGroup()->getContent();
						  $contentUrl = $mediaContentArray[0]->getUrl();
						}	
						if(file_exists($filePath))
						{
							unlink($filePath);
						}		
						$new_film_img = $contentUrl;
				}
				
			}
			/* end upload images*/
				
				
		$cat=join_value($_POST['selectcat']);
	
		
			$film = acp_quick_add_film2($new_film,$name_real,$tapphim,$new_film_img,$actor,$year,$time,$area,$director,$cat,$info,$country,$file_type,$bo_le,$key,$des,$imgbn,$tag,$trang_thai,$_POST['imdb'],$_POST['hoanthanh'],$_POST['gioithieu']);
		
	}	

	$t_film = $film;

    for ($i=$episode_begin;$i<=$episode_end;$i++){
		$is_exit="";
		$t_url = $_POST['url'][$i];
		$t_name = $_POST['name'][$i];
		$t_sub = $_POST['sub'][$i];
		$t_message = $_POST['message'][$i];
		// server post
		if($_POST['server_post']==0) {
			$t_type = acp_type($t_url);
		}else {
			$t_type = intval($_POST['server_post']);
		}
		// end
		$t_local = $_POST['local_url'][$i];
		if ($_POST['check_link']=="on") $is_exit = get_data('episode_id','episode','episode_url',$t_url,1);
		//lech sub
		if (substr_count($t_sub,"phim1v.com")==0 && $t_sub!="")
		{
			$filesub[$i]	=	replace($t_film.'-'.$t_name).'.srt';
			if(copy($t_sub,'../sub/'.$filesub[$i])) {
				$t_sub 	= 	'sub/'.$filesub[$i];
			}
		}
		//lech sub
		if ($t_url && $t_name && $is_exit == "") {
		$mysql->query("INSERT INTO ".$tb_prefix."episode (episode_film,episode_url,episode_urlsub,episode_message,episode_type,episode_name,episode_local) VALUES ('".$t_film."','".$t_url."','".$t_sub."','".$t_message."','".$t_type."','".$t_name."','".$t_local."')");
		$mysql->query("UPDATE ".$tb_prefix."film SET film_date = '".NOW."' WHERE film_id = ".$t_film."");
		

		}

	}

	echo "Đã thêm xong <meta http-equiv='refresh' content='0;url=?act=episode&mode=multi_add'>";

  }

}

?>