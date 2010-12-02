<?php $script=""; ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<link rel="shortcut icon" href="images/spacer.gif" />

<!--[if opera]><!-->
<link rel="stylesheet" href="css/main.css" type="text/css">
<!-- <![endif]-->
<meta http-equiv="pragma" content="no-cache">
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
