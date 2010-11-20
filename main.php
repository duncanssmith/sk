<?php $script=""; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="shortcut icon" href="images/spacer.gif" />
<link rel="stylesheet" href="css/main.css" type="text/css">

<meta name="keywords" content=" " >
<meta name="description" content=" ">
<meta name="robots" content="index,follow">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="search" content="yes">

<title>
<?php 
	if(isset($pages['title'])){
		echo $pages['title'];
	}else{
	}
	if(isset($sid)){
	  $sid=strtoupper($sid);
	}
?>
</title>

<script src="js/main.js"> </script>
<script src="js/menu_functions.js"> </script>
<script src="js/layer.js"> </script>
</head>
<body>
<div id="container">
  <div id="header">
<?php  
  include "menu.php"; 
#	 echo "<script>";
#	 echo $script;
#  echo "</script>";
?>

<?php 

 	if($settings['logo']){
    echo $logoline;
	}else{
    echo $nologoline;
	}
?>
<br/>

  </div>

<div id="content_container">


<div id="left_sidebar">
<h1>left sidebar</h1>
</div>
<div id="content">
<h1>content</h1>
<?php
  # the file state contains code that determines 
  # the current state of the application 
  # and acts on it accordingly
	include "state.php";

?>
<div id="login">
<?php 
  #include "login.php";
?>
</div> 
<br/>
<br/>
</div>
<div id="right_sidebar">
<?php
  if($debug['page']){
		echo "<p>PAGEID</p>\n<pre>";
		print_r($pageid);
    echo "</pre>";
  }

  if($debug['control']){
    echo "<p>CONTROL</p>\n<pre>";
    print_r($control);
   echo "</pre>";
  }

	if(($debug['session'])){
		echo "<p>SESSION</p><pre> ";
		print_r($_SESSION);
		echo "</pre>\n";
	}

  if($debug['get']){
    echo "<p>GET</p>\n<pre>";
    print_r($_GET);
   echo "</pre>";
  }

  if($debug['post']){
    echo "<p>POST</p>\n<pre>";
    print_r($_POST);
   echo "</pre>";
  }

?>

</div>
<div id="footer">
<div>
<?php 
  echo $itingline; 
  if($settings['logo']){
    echo $bottom_of_page_line;
  }else{
    echo $nologo_bottom_of_page_line;
  }

?>
<?php #echo $now?>
</div>
<?php
	if(($debug['global'])){
		echo "<pre>Global: ";
		print_r($GLOBALS);
		echo "</pre>\n";
	}
?>
</div>
</div>

</body>
</html>
