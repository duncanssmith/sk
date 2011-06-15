<?php

//Group Anagrams

//Input
$s=array( 'abc', 'bac', 'pzxa',  'cba' );

//Output
////(abc, bac, cba)
//(pzxa)


function group_anagrams(array $strings)
{
   $lengths = array();
   $temp=array();
   $temp_hash=array();
print("<p>In group anagrams function:</p>");
   
  for($i=0; $i < count($strings); $i++){
    $lengths[$i]=strlen($strings[$i]);

    printf("string %d length: %d<br/>\n", $i, $lengths[$i]);
    
    $temp[]=str_split($strings[$i]);
    //$sorted = $strings[$i];
    $sorted = str_split($strings[$i]);
    sort($sorted);
    $temp_hash[$strings[$i]] = join('', $sorted);

    $sorted_values=asort($temp_hash);


    printf("%s<br/>\n", $temp_hash[$strings[$i]]);
    $current=$temp_hash[$strings[$i]];
    for($j=1;$j<count($temp_hash);$j++){
       if($temp_hash[$j]==$current){
         //anagram
         printf("-- %s --<br/>\n", $temp_hash[$j]);
       }else{
         // not an anagram
         printf("New anagram\n%s\n", $temp_hash[$j]);
         $current=$temp_hash[$j];
       }
         
    }
  }
  print_r($temp_hash);
  print("<br/>");
  print_r($sorted_values);
   
return true;
} 
print("<p>Do group anagrams function:</p>");
group_anagrams($s);

?>
