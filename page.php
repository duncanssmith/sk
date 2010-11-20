<?php
session_start(); 

$sid=session_id();

if(isset($_GET['pageid'])){
	$pageid=$_GET['pageid'];
}else{
	$pageid="0";
}

?>
