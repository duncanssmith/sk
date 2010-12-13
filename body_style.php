<?php


if($control['body_styling']){
  $foundz = false;
  $z = array();
  $z=getlayout($pages,$pageid,$depth);

  if($foundz){
    ;
  }else{
    echo "<h1>NOT FOUNDZ!</h1>";
    $pageid = $_GET['pageid'] = 0;
    $z=getlayout($pages,$pageid,$depth);
  }
}else{
  echo "<body class=\"NOSTYLE\">\n";
}


?>
