<body>
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
        <ul class="content_sub group">
          <li class="content_sub_left">
            <a href="?pageid=1">Your Health &rarr;</a>
          </li>
          <li class="content_sub_center">
            <a href="?pageid=2">Your Organisation &rarr;</a>
          </li>
          <li class="content_sub_right">
            <a href="?pageid=1.6">Weight Loss &rarr;</a>
          </li>
        </ul>
      </div>
      <div id="right_sidebar">

        <?php
          include "right_sidebar.php";
          if(($debug['global'])){
                  include "debug_printout.php";
          }
        ?>
      </div>
      <div id="footer">
        <ul class="footboxes group">
          <li class="footbox_left"> 
            <?php  
          echo "Lorem ipsum hac haec hoc ipso facto da da da";
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
