<?php

$x=array();

$x=getpage($pages,$pageid,$depth);

if(!$found){
#echo "<p>".$found." - page not found. depth:[".$depth."], pageid:[".$pageid."]</p>";
  $pageid=$_GET['pageid']=0;
  $x=getpage($pages,$pageid,$depth);
#  echo "<p>after 2nd call to getpage: Found: ".$found.". depth:[".$depth."], pageid:[".$pageid."]</p>";
# 					echo "<p>PAGE ARRAY</p> <pre>";
#					print_r($x);
#					echo "</pre>"; 
}
#}

#include "layer.php";

#showpage($xsuperx,1);
#echo "<h1>TITLE: ".$x['title']."</h1>";

?>

