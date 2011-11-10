<?php

/*  $pk = array_keys($pages);
  
  echo "<pre>";
  echo "PAGEID: ";
  echo $pageid;
  echo "<br />";
  for($i=0;$i<sizeof($pk);$i++){
    print_r($pk[$i]);
    print_r (" ");
  }
  echo "</pre>";
*/
#include "body_style.php";

?>

  <div id="container">
    <div id="header">
      <div id="logo">
        <?php 
          if($settings['logo']){
            echo $logoline;
          }else{
            echo $nologoline;
          }
        ?>
        <br/>
      </div>
      <div id="contact">
        <?php
          echo $phonelogoline;
        ?> 
      </div>
      <div id="clearer">&nbsp;</div>
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
        ?>
      </div>
      <div id="content">
          <?php
            include "state.php";
          ?>
       <!-- <ul class="content_sub group"> -->
          <!--<li class="content_sub_left">-->
         <!-- <li> -->
            <!--<a href="?pageid=1">Your Health &rarr;</a>-->
          <!--</li> -->
          <!--<li class="content_sub_center">-->
          <!--<li> -->
            <!--<a href="?pageid=2">Your Organisation &rarr;</a>-->
          <!--</li> -->
          <!--<li class="content_sub_right">-->
          <!--<li> -->
            <!--<a href="?pageid=1.6">Weight Loss &rarr;</a>-->
          <!--</li> -->
        <!--</ul> -->
      </div>
      <div id="right_sidebar">
        <?php
          include "right_sidebar.php";
          if(($debug['global'])){
                  include "debug_printout.php";
          }
        ?>
      </div>
      <div id="ribbon">
        <ul class="ribbon_sub group">
          <li class="ribbon_sub_left">
            <a href="index.php?pageid=1"><img src="img/blank_your_health.png" alt="Your Health" width="240" height="120" /></a>
          </li>
          <li class="ribbon_sub_center">
            <a href="index.php?pageid=2"><img src="<?php echo "img/blank_your_organisation.png";?>" alt="Your Organisation" width="240" height="120" /></a>
          </li>
          <li class="ribbon_sub_right">
            <a href="index.php?pageid=1.5"><img src="<?php echo "img/blank_weight_loss.png";?>" alt="Weight Loss" width="240" height="120"  /></a>
          </li>
        </ul>

      </div>

      <div id="footer">
        <ul class="footboxes group">
          <li class="footbox_left"> 
            <?php  
              echo "<br />\n";
              echo $sknutritionline; 
            ?> 
          </li>
          <li class="footbox_center"> 
           <?php 
              echo "<br />\n";
              #echo $itingline; 
              echo "&nbsp;";
           ?> </li>
          <li class="footbox_right"> <?php echo $now ?> </li>
        </ul>
      </div>
    </div>
  </body>
</html>
