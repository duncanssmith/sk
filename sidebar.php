<?php

if($control['generate_sidebar_links']){
  $z = array();
  $z=getlinks($pages,$pageid,$depth);
  if(!$foundx){
    $pageid = $_GET['pageid'] = 0;
    $z=getlinks($pages,$pageid,$depth);
  }
}

if($control['include_sidebar_links']){    
  $pageid_0 = $pageid[0];
  $pageid_1 = $pageid[1];
  $pageid_2 = $pageid[2];
  $str = sprintf("_%s", $pageid_0);
  $str2 = sprintf("gen/sidebar%s.inc", $str);
  include $str2;
}
?>
