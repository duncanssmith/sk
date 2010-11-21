<body>
  <div id="container">
    <div id="header">
      <?php 
         if($settings['logo']){
          echo $logoline;
        }else{
          echo $nologoline;
        }
      ?>
      <br/>
      <br/>
    </div>
    <div id="navigation">
      <?php  
        include "menu.php"; 
          #   echo "<script>";
          #   echo $script;
          #  echo "</script>";
      ?>
    </div>

    <div id="content_container">
			<div id="left_sidebar">
        <?php
				  include "sidebar.php";
					#$pageid=$_GET['pageid']=0;
					# $z = array();
					# $z=getlinks($pages,$pageid,$depth);
          # if(!$foundx){
					#   $pageid = $_GET['pageid'] = 0;
					#	 $z=getlinks($pages,$pageid,$depth);
					# }
           #sidebar_links($p)
        ?>
      </div>
      <div id="content">
          <?php
            # the file state contains code that determines 
            # the current state of the application 
            # and acts on it accordingly
            include "state.php";
          ?>
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
          <?php 
            echo $itingline; 
            echo $sknutritionline; 
            if($settings['logo']){
              echo $bottom_of_page_line;
            }else{
              echo $nologo_bottom_of_page_line;
            }

          ?>
					<?php echo $now ?>
        <?php
          if(($debug['global'])){
            echo "<pre>Global: ";
            print_r($GLOBALS);
            echo "</pre>\n";
          }
        ?>
        <br/>
        <br/>
        <br/>
      </div>
    </div>
  </body>
</html>
