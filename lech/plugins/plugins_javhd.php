<?php
$username = "margaretgabriele";
$password = "huadailoc";

$getacc = $_POST['getacc'];
if($getacc=="true"){
	$txtacc = "&u=".$username."&p=".$password."&";
	echo $txtacc;
}
?> 