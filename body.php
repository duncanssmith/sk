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
          </li>
          <li class="content_sub_center">
          </li>
          <li class="content_sub_right">
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
        <br />
        <ol class="footboxes group">
          <li class="footbox_left">
            <?php  echo $sknutritionline; ?>
            <?php echo $itingline; ?>
          </li>
					<li class="footbox_middle">
            &nbsp;
          </li>
          <li class="footbox_right">
            <?php echo $now ?>
          </li>
        </ol>
      </div>
    </div>
  </body>
</html>
