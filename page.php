<?php
session_start(); 

if(isset($_SESSION['enquiry_submitted'])){
  $_SESSION['enquiry_submitted']=null;
}


$pageid="0";


$sid=session_id();

if(isset($_GET['pageid'])){
	$pageid=$_GET['pageid'];
}else{
	$pageid="0";
}

?>
