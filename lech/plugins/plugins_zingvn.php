<?php
$username = "YourUsername";
$password = "YourPassword";

$getacc = $_POST['getacc'];
if($getacc=="true"){
	$txtacc = "&u=".$username."&p=".$password."&";
	echo $txtacc;
}
?> 