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
          if(($debug['global'])){
            echo "<pre>Global: ";
            print_r($GLOBALS);
            echo "</pre>\n";
          }
?>
