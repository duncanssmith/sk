<?php

function generate_tabs($p,$f){

	global $debug;
	global $control;
	global $pageid;
	global $flm;
	global $final_menu;
	global $menu_array;
	global $timestamp;
	global $pagekeys;
	global $menulevels;
	global $pagetitles;
	global $tabs;

	if($debug['functions']){
		$thisFunction ="generate_tabs(".$p['title'].",".$f.")";
		echo_functionname($thisFunction);
	}

	$pk=array_keys($p);

	$file=fopen($f, "w+");

	fprintf($file,"<?php\n#generated file %s %s - do not edit\n\n	%s\n", $f, $timestamp, "\$tabs=array(");

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){

			$str=sprintf("%s", $p[$pk[$i]]['title']);
			$str1=sprintf(" %s=>'%s'",$pk[$i],$p[$pk[$i]]['title']);

			if($i+1==(sizeof($p))){
				$str1=sprintf("%s\n", $str1 );
			}else{
				$str1=sprintf("%s,\n", $str1 );
			}
			$tabs[]=$str;
			fprintf($file,"%s", $str1);
		}else{
			;
		}
	}

	fprintf($file,"	%s\n", ");\n?>");

	tabs();

	fclose($file);

	return TRUE;

}

function generate_sidebar_links($p){

	global $debug;
	global $control;
	global $pageid;
	global $files;
	global $flm;
	global $final_menu;
	global $menu_array;
	global $timestamp;
	global $pagekeys;
	global $menulevels;
	global $pagetitles;
	global $tabs;
	global $timestamp;

	if($debug['functions']){
		$thisFunction ="generate_sidebar_links(".$p.")";
		echo_functionname($thisFunction);
	}
  $pk = array_keys($p); 

	$file=fopen( $p['sidebar_file'], "w");
	#echo "<p>".$p['title']." - ".$p['sidebar_file']."</p>\n";
	fprintf($file,"\n<ul>\n");

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
      fprintf($file, "<li><a href=\"index.php?pageid=%s\">%s</a></li>\n", $pk[$i], $p[$pk[$i]]['title']);
			generate_sidebar_links($p[$pk[$i]]);
		}
		else{
      #fprintf($file, "<li><a href=\"index.php?%s\">%s</a></li>\n", $p[$pk[$i]], $p['title']);
		}
	}
	fprintf($file, "</ul>\n");
  fclose($file);

  return true;
}

function generate_menu($p){

	global $debug;
	global $control;
	global $pageid;
	global $files;
	global $flm;
	global $final_menu;
	global $menu_array;
	global $timestamp;
	global $pagekeys;
	global $menulevels;
	global $pagetitles;
	global $tabs;
	global $timestamp;

	if($debug['functions']){
		$thisFunction ="generate_menu(".$p.")";
		echo_functionname($thisFunction);
	}

	 $filename=$files['menuintermed'];
		#echo "<h2>Opening: ".$filename."</h2>";
		$file=fopen($filename, "w+");
		#fprintf($file, "// %s %s\n", $filename, $now);

		$flm=menur($p,0,"",$file);

		$combined1=combine_arrays($pagekeys,$menulevels);
		sort($combined1);

		$filename1=$files['menutmp'];

		$file1=fopen($filename1,"w+");

		fprintf($file1,"<?php\n#generated file %s - do not edit\n\n	%s\n", $timestamp, "\$menuindex=array(");
		for($i=0;$i<sizeof($combined1);$i++){
			fprintf($file1,"		%s\n",$combined1[$i]);
		}
		fprintf($file1,"	%s\n", ");\n?>");

		fclose($file1);

		fclose($file);

		$filename=$files['menuintermed'];

		$file=fopen($filename, "r");

		$string1="";
		$string1=fread($file, 8192);

		$menu_array=explode(';',$string1);
		
		sort($menu_array);
		$offset=sizeof($menu_array);
		$offset=(($offset)-($offset+$offset));
		$menu_array=array_slice($menu_array, $offset+1);

		fclose($file);

	include $files['menutmp']; 

	$menuindex=array_values($menuindex);

		$final_menu=build_menu($menu_array,$menuindex);

		$menufile=$files['menu'];
			#echo "<h2>Opening: ".$menufile."</h2>";
		$file=fopen($menufile, "w+");

			#echo "<p>Write Final Menu to File:\n";

		fprintf($file,"// generated file %s - %s - do not edit\n",$menufile, $timestamp);

		for($i=0;$i<sizeof($final_menu);$i++){
			fprintf($file,"	%s\n",$final_menu[$i]);
		}
		fprintf($file, "\nvar NoOffFirstLineMenus=%d",$flm);

		fclose($file);

	return TRUE;
}

function output_menu(){

	global $debug;
	global $pageid;
	global $flm;
	global $final_menu;

	if($debug['functions']){
		$thisFunction ="output_menu()";
		echo_functionname($thisFunction);
	}

	for($i=0;$i<sizeof($final_menu);$i++){
		echo $final_menu[$i]."\n"; 
	} 

	#$f=sprintf("\nvar NoOffFirstLineMenus=%d",$flm);
	
	#echo $f;
	echo "\n";

	return TRUE;
}
#---------------------------------------------------------------------
# Here we are writing an XML file generated from the main pages array
#---------------------------------------------------------------------
function generate_xml($p,$f){

	global $debug;
	global $pageid;
	global $files;

	if($debug['functions']){
		$thisFunction ="generate_xml()";
		echo_functionname($thisFunction);
	}
	
	$file=fopen($f, "w+");
		
	php_array_to_xml($p,0,$file); 
		
	fclose($file);

	return TRUE;
}

function echo_functionname($name){

	global $debug;
	global $errors;

	$thisFunction="echo_functionname($name)";
	#echo $thisFunction;

	echo "<p class=\"foo\">";
	echo $name;
	echo "</p>\n";
}

function tf($v){return $v ? "True" : "False";}

#	$page=array();

function find_sidebar_include_file($p,$pageid, $d){

	global $debug;
	global $pageid;
	global $foundx;
	global $page;

	if($debug['functions']){
		$thisFunction ="find_sidebar_include_file(".$p.", ".$pageid.", ".$d.")";
		#echo_functionname($thisFunction);
	}
  $pk=array_keys($p);
  $pageidstr=sprintf("%s",$pageid);
	for($i=0;$i<sizeof($p);$i++){
	  $pkeystr=sprintf("%s",$p[$pk[$i]]);
	  echo "<p>key: ".$p[$pk[$i]]."</p>\n";
		if($pkeystr===$pageidstr){
			$file = $p['sidebar_file'];
			echo "<p>SIDEBAR FILE: ".$file."</p>\n";
    }
  }
				return $file;
}

function getlinks($p,$pageid,$d){

	global $debug;
	global $pageid;
	global $foundx;
	global $page;

	if($debug['functions']){
		$thisFunction ="getpage( ".$p.", $pageid, $d)";
		#echo_functionname($thisFunction);
	}

	if($debug['data']){
		echo "<pre>";
		print_r($p);
		echo "</pre>";
	}

	$pk=array_keys($p);

	if($foundx){
		$page=$p;
		if($debug['page']){
			echo "<pre>";
			print_r($page);
			echo "</pre>";
		}
	}else{
		for($i=0;$i<sizeof($p);$i++){
			if(is_array($p[$pk[$i]])){

				$pagestr=sprintf("%s", $pk[$i]);
				$pageidstr=sprintf("%s", $pageid);
	
				if($pagestr===$pageidstr){

					$foundx=TRUE;

					showlinks($p[$pk[$i]],2);

					$page=$p[$pk[$i]];
					break;
				}else{
					$foundx==FALSE;
					$page=getlinks($p[$pk[$i]],$pageid,$d+1);
				}
			}else{
				$page=$p;
			}
		}
	}
	return $page;
}




function getpage($p,$pageid,$d){

	global $debug;
	global $pageid;
	global $found;
	global $page;

	if($debug['functions']){
		$thisFunction ="getpage( ".$p.", $pageid, $d)";
		#echo_functionname($thisFunction);
	}

	if($debug['data']){
		echo "<pre>";
		print_r($p);
		echo "</pre>";
	}

	$pk=array_keys($p);

	if($found){
		$page=$p;
		if($debug['page']){
			echo "<pre>";
			print_r($page);
			echo "</pre>";
		}
	}else{
		for($i=0;$i<sizeof($p);$i++){
			if(is_array($p[$pk[$i]])){

				$pagestr=sprintf("%s", $pk[$i]);
				$pageidstr=sprintf("%s", $pageid);
	
				if($pagestr===$pageidstr){

					$found=TRUE;

					showpage($p[$pk[$i]],2);

					$page=$p[$pk[$i]];
					break;
				}else{
					$found==FALSE;
					$page=getpage($p[$pk[$i]],$pageid,$d+1);
				}
			}else{
				$page=$p;
			}
		}
	}
	return $page;
}

#-------------------------------------------------------------
# Give this function a PHP array and a depth(0) and a file 
# and it will translate the array into a MENU file.
# NB: It is a recursive function 
#-------------------------------------------------------------
function menur($p,$d,$m,$f){

	global $debug;
	global $menulevels;
	global $pagekeys;
	global $pagetitles;
	global $menu_cell;
	
	if($debug['functions']){
		$thisFunction ="//menur($p,$d,$m,$f)";
		#echo_functionname($thisFunction);
	}

	$n=0;
	$a=0;
	$menus=0;

	$pk=array_keys($p);

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
			$n++;
		}
			$item_no=$i+1;
			if($n>0){
				if($d==0){
					$menuout=sprintf("Menu%s%d=new Array(\"%s\", \"index.php?pageid=%s\",\"\", %s,%d,%d);", 
						$m, $n, $p[$pk[$i]]['title'],$pk[$i],"%d" ,
						$menu_cell['height'],$menu_cell['width']);
				}else{
					$menuout=sprintf("Menu%s_%d=new Array(\"%s\", \"index.php?pageid=%s\",\"\", %s,%d,%d);", 
						$m, $n, $p[$pk[$i]]['title'],$pk[$i],"%d",
						$menu_cell['height'],$menu_cell['width']);
				}
				fprintf($f,"%s", $menuout); 
				
			}else{
			}
	}
	$number_of_arrays=$n;
	$number_of_elements=$i;
	$number_of_non_array_elements=$number_of_elements-$number_of_arrays;
	$menustring="";

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){

			$a++;

			if($a>0){
				if($d==0){
					$menustring=sprintf("%d",$a);
				}else{
					$menustring=sprintf("%s_%d",$m,$a);
				}

			}

		 
			
			$menus=menur($p[$pk[$i]],$d+1, $menustring,$f);
			$depth=$d+1;
			$menulevels[]=$menus;
			$pagekeys[]=$pk[$i];
			$pagetitles[]=$p[$pk[$i]]['title'];
		}else{
			;
		}
	}

	return $number_of_arrays;
}

function build_menu($template,$values){

	global $debug;
	global $control;

	if($debug['functions']){
		$thisFunction ="build_menu($template, $values)";
		echo_functionname($thisFunction);
	}
	$a=array();

	for($i=0;$i<sizeof($template);$i++){
		$a[]=sprintf($template[$i],$values[$i]);
	}

	return $a;
}

function combine_arrays($a,$b){
	global $debug;
	global $control;
	# Assume arrays are same length
	#
	if($debug['functions']){
		$thisFunction ="combine_arrays($a,$b)";
		echo_functionname($thisFunction);
	}

	$c=array();
	$s="";
	for($i=0;$i<sizeof($a);$i++){
		$s=sprintf("'%s'=>'%s',",$a[$i],$b[$i]);
		$c[]=$s; 
	}

	return $c;
}

function tabs(){

	global $debug;
	global $pageid;
	global $tabs;
	
	if($debug['functions']){
		$thisFunction ="tabs()";
		echo_functionname($thisFunction);
	}

	$pk=array_keys($tabs);
	
	#echo "\n   <div id=\"navigation\">\n";
	echo "     <ul>\n";

	for($i=0;$i<sizeof($tabs);$i++){

		if($pageid==$pk[$i]){ 
				echo "       <li id=\"current\"><a href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
		}else{
				echo "       <li><a href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
		}
	}
	echo "     </ul>\n";
	# echo "		</div>";

	return TRUE;
}



#-------------------------------------------------------------
#
# Give this function a PHP array and a depth(0) and a file 
# and it will translate the array into an XML file
# Assumed is that 'title' will become tag name
#-------------------------------------------------------------

function php_array_to_xml($p,$d,$f){

	# p is the array
	# d is the depth 
	# a is the number of sub arrays in this level of the array
	# n is the number of non arrays in this level of the array
	# e is the number of elements in the array

	global $debug;
	global $e;
	global $timestamp;

	$xmlstring="<?xml version='1.0' encoding='ISO-8859-1' ?>";

	if($debug['functions']){
		$thisFunction ="//php_array_to_xml($p,$d,$f)";
		#echo_functionname($thisFunction);
	}

	$pk=array_keys($p);

	$a=0;
	$n=0;
	
	# count the number of arrays and non-array elements at this depth
	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
			$a++;
			$e++;
		}else{
			$n++;
			#echo "<p>".$p[$pk[$i]]."</p>\n";
		}
	}
	$z=$i-$a;
	#echo "<p>All Elements:[$e]. Depth:[$d]; Arrays:[$a]; non Arrays in depth ($i-$a):[$z=$n]</p>\n\n";

	if($d==0){

		#$xmltag=str_replace(" ", "_", $p['title']);
		$xmltag=str_replace(" ", "_", $p['title']);
		#$first=sprintf("%s\n<%s depth=\"%d\">\n", $xmlstring, $xmltag, $d);
		$first=sprintf("%s\n<%s timestamp=\"%s\">\n", $xmlstring, $xmltag, $timestamp);
		fprintf($f, "%s", $first);
		#echo "<h1>".$first."</h1>";
		#echo "<h1>".$xmlstring."</h1>";
		$d++;
	}

	for($i=0;$i<sizeof($p);$i++){

		if(is_array($p[$pk[$i]])){
			$_xmltag=str_replace(" ", "_", $p[$pk[$i]]['title']);
			#$down=sprintf("<%s depth=\"%d\">%s\n", $_xmltag, $d, "");
			$down=sprintf("<%s>%s\n", $_xmltag, "");
			fprintf($f,"%s", $down);
			#echo $down;
			php_array_to_xml($p[$pk[$i]],$d+1,$f);
			$up=sprintf("</%s>\n", $_xmltag);
			fprintf($f,"%s", $up);
			#echo $up;
		}else{
			$_xmltag=str_replace(" ", "_", $p[$pk[$i]]['title']);
			$down=sprintf("<%s depth=\"%d\">\n", $_xmltag, $d);
			fprintf($f,"%s\n", $p[$pk[$i]]);
			#echo $down;

			$up=sprintf("</%s>\n", $p[$pk[$i]]['title']);
			#echo $up;
		}
	}
	$d--;
	if($d==0){
		#$xmltag=str_replace(" ", "_", $p['title']);
		$last=sprintf("</%s>", $xmltag);
		fprintf($f, "%s", $last);
		#echo $last;
	}
}

function showlinks($p,$cols){
	
	global $debug;
	global $settings;
	global $files;

	if($debug['functions']){
		$thisFunction ="showlinks(p,".$cols.")";
		echo_functionname($thisFunction);
	}
  $pk=array_keys($p);

  $showheader = 0;
	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
      $showheader++; 
		}
	}

	if(!empty($p['title'])&&(!empty($p['showtitle']))){
    if($showheader > 0){
						echo "<h6 id=\"links\">".$p['title']." </h6>\n";
		}
  }
	#echo $p['include'];
	# echo "<pre>PAGE:";
	#	print_r($p);
	# echo "</pre>";
	#
	#echo "<p>DUNCAN</p>\n";
	#echo "<p>".sizeof($p)."</p>\n";
	echo "<br/><ul id=\"left_sidebar_links\">\n";	

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
      printf ("<li><a href=\"index.php?pageid=%s\"> %s </a></li>\n", $pk[$i], $p[$pk[$i]]['title']); 
		}
	}

  echo "</ul>\n";	

	return true;
}


function showpage($p,$cols){
	
	global $debug;
	global $settings;
	global $files;

	if($debug['functions']){
		$thisFunction ="showpage(p,".$cols.")";
		echo_functionname($thisFunction);
	}
	#echo $p['include'];
	# echo "<pre>PAGE:";
	#	print_r($p);
	# echo "</pre>";
	#
  $pk=array_keys($p);

	if(!empty($p['title'])&&(!empty($p['showtitle']))){
		echo "<h1 id=\"pagetitle\">".$p['title']."</h1>\n";
  }
  #
  # Default xmlfile is books.xml but this
  # can be overridden by adding a new xml
  # filename to any page
  #
	if(!empty($p['xmlfile'])){
    $xmlfile=$p['xmlfile'];
  }else{
    $xmlfile=$files['itemsxml'];
  }

    $my_catalog = new Itemlist($xmlfile);

    if(($_GET['pageid']))
    {
      //return info on one item
        $my_catalog->show_item($_GET['pageid']);
    }else{
      //show list of items
        $my_catalog->show_item($_GET['pageid']);
        #  $my_catalog->show_list();
    }

    if(!empty($p['include'])){
			#echo "<div class=\"box2\">\n";
			#echo $p['include'];
      include $p['include'];
      #echo "</div>\n";
    }

	return true;
}

function get_static_content_file($pageid){

	global $debug;
	global $settings;

$static_content_files=array(
  );

	if($debug['functions']){
		$thisFunction ="get_static_content_file(".$pageid.")";
		echo_functionname($thisFunction);
	}

  #echo "<p>".$static_content_files[$pageid]."</p>";
  include $static_content_files[$pageid];

  return true;
}


