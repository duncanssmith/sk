<?php

if($control['generate_sidebar_links']){
  $x=array();
  $x=getlinks($pages,$pageid,$depth);
  if(!$foundx){
    $pageid = $_GET['pageid'] = 0;
    $x=getlinks($pages,$pageid,$depth);
  }
}

if($control['include_sidebar_links']){    
  $pageid_0 = $pageid[0];
  if(isset($pageid[1])){
    $pageid_1 = $pageid[1];
    if(isset($pageid[2])){
      $pageid_2 = $pageid[2];
    }
  }
  $str = sprintf("_%s", $pageid_0);
  $str2 = sprintf("gen/sidebar%s.inc", $str);
  include $str2;
}

include 'inc/bonafides.inc';

?>
