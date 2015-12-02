<?php

function xmlparse($a,$b,$c){

  global $debug;

  if($debug['functions']){
    $thisFunction ="xmlparse(a,b,c)";
    echo_functionname($thisFunction);
  }

}

function my_character_data_handler($inParser,$inData){

  if($debug['functions']){
    $thisFunction ="my_character_data_handler(inParser,inData)";
    echo_functionname($thisFunction);
  }

  echo $inData;
}


function end_element($inParser,$inName){

  global $debug;

  if($debug['functions']){
    $thisFunction ="end_element(inParser,inName)";
    echo_functionname($thisFunction);
  }

  echo "&lt;<b>/$inName</b> &gt;";

}

function start_element($inParser,$inName,&$inAttributes){

  global $debug;
  global $control;
  global $pageid;
  global $paths;
  global $files;

  if($debug['functions']){
    $thisFunction ="start_element(inParser,inName,inAttributes)";
    echo_functionname($thisFunction);
  }

  $attributes=array();

  foreach($inAttributes as $key){
    $value=$inAttributes[$key];
    $attributes[]="<font color=\"gray\">$key=\"$value\" </font>";
  }

  echo "&lt;<b>". $inName. "</b>" . join(' ',$attributes) . "&gt;";
}
?>
