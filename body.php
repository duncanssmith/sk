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
        <div id="footboxes">
          <div id="footbox_left">
            <?php echo $itingline; ?>
          </div>
          <div id="footbox_middle">
            <?php  echo $sknutritionline; ?>
          </div>
          <div id="footbox_right">
            <?php echo $now ?>
          </div>
        </div>
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
