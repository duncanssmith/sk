<?php

$x=array();

$x=getpage($pages,$pageid,$depth);

if(!$found){
  $pageid=$_GET['pageid']=0;
  $x=getpage($pages,$pageid,$depth);
}



?>

