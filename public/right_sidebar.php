<?php

if($control['show_right_sidebar_images']){
  $y = array();
  $y=getimages($pages,$pageid,$depth);
  if(!$foundy){
    $pageid = $_GET['pageid'] = 0;
    $y=getimages($pages,$pageid,$depth);
  }
}

?>
