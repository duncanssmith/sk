<?php $script=""; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <link href='images/spacer.gif' rel='shortcut icon' />
    <link href='css/main.css' rel='stylesheet' type='text/css' />
    <meta content=' ' name='keywords' />
    <meta content=' ' name='description' />
    <meta content='index,follow' name='robots' />
    <meta content='text/html; charset=iso-8859-1' httpequiv='Content-Type' />
    <meta content='yes' name='search' />
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
  </head>
  <script src='js/main.js'></script>
  <script src='js/menu_functions.js'></script>
  <script src='js/layer.js'></script>
  <body>
    <div id='container'>
			<div id='header'>
        <img src="img/logo.png" alt="SK Nutrition" />
      </div>
			<div id='navigation'>
      <?php
	      include "menu.php"
        #	 echo "<script>";
        #	 echo $script;
        #  echo "</script>";
      ?>
      </div>
      <div id='content_container'>
				<div id='left_sidebar'>

        </div>
				<div id='content'>

        </div>
				<div id='right_sidebar'>

        </div>
				<div id='footer'>

        </div>
      </div>
    </div>
  </body>
</html>
