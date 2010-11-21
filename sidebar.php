<?php

#$pageid=$_GET['pageid']=0;
#
  
   if($control['generate_sidebar_links']){
				 #  echo "<p>DUNCAN XXX</p>\n";
					 $z = array();
					 $z=getlinks($pages,$pageid,$depth);
           if(!$foundx){
					   $pageid = $_GET['pageid'] = 0;
						 $z=getlinks($pages,$pageid,$depth);
					 }
	 }
	


	if($control['include_sidebar_links']){    
		# include the relevant generated sidebar links file
				#	echo "<p>pageid: ".$pageid."</p>\n";
					$pageid_0 = $pageid[0];
					$pageid_1 = $pageid[1];
					$pageid_2 = $pageid[2];
				#	echo "<p>[0]".$pageid_0."\n";
				#	echo "[1]".$pageid_1."\n";
				#	echo "[2]".$pageid_2."</p>\n";
					#include find_sidebar_include_file($pages,$pageid,$depth);
					#if($pageid_2 != ""){
					#				$str = sprintf("_%s_%s", $pageid_0, $pageid_2);
					#}else{
									$str = sprintf("_%s", $pageid_0);
					#}
					$str2 = sprintf("gen/sidebar%s.inc", $str);
				#	echo "<p>str2: ".$str2."</p>\n";
		include $str2;
		
  }

?>

