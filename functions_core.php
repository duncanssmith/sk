<?php

function validate_purchase_form(){

	global $debug;
	global $control;
	global $pageid;

	if($debug['functions']){
		$thisFunction ="validate_purchase_form()";
		echo_functionname($thisFunction);
  }
    echo "<p>SESSION</p><pre>";
    print_r($_SESSION);
    echo "</pre>";
    echo "<p>POST</p><pre>";
    print_r($_POST);
    echo "</pre>";

  return true;

}

function build_session_purchase_data(){

	global $debug;
	global $control;
	global $pageid;

	if($debug['functions']){
		$thisFunction ="build_session_purchase_data()";
		echo_functionname($thisFunction);
  }

  if(isset($_SESSION['order'])){
    if(isset($_POST)){
      $_SESSION['customer_details']=$_POST;
    }
  }

  return true;

}

function build_js_zoom($images){

	global $debug;
	global $control;
	global $pageid;

	if($debug['functions']){
		$thisFunction ="build_js_zoom(\$images)";
		echo_functionname($thisFunction);
  }

  if($debug['data']){
    echo "<p>build_js_zoom\n</p><pre>";
    print_r($images);
    echo "</pre>";
  }

  $img=Array();

  echo "<script language=\"JavaScript\">\n";
	echo "\tvar zoom=new Array;\n";
	for($i=0;$i<sizeof($images);$i++){
		$img[$i]=sprintf("%s",$images, $i+1);
		echo "\tzoom[".$i."]=\"".$images[$i]."\";\n";
  }
  echo "</script>\n";

}

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

	#$filename=$paths['include']."/".$files['tabs'];
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


		#echo "<h2>Opening: ".$filename."</h2>";
		$file=fopen($filename, "w+");
		#fprintf($file, "// %s %s\n", $filename, $now);

		$flm=menur($p,0,"",$file);

		$combined1=combine_arrays($pagekeys,$menulevels);
		sort($combined1);

		$filename1=$files['menutmp'];
		#echo "<h2>Opening: ".$filename1."</h2>";
		$file1=fopen($filename1,"w+");

		fprintf($file1,"<?php\n#generated file %s - do not edit\n\n	%s\n", $timestamp, "\$menuindex=array(");
		for($i=0;$i<sizeof($combined1);$i++){
			fprintf($file1,"		%s\n",$combined1[$i]);
		}
		fprintf($file1,"	%s\n", ");\n?>");
		#echo "<h2>Closing: ".$filename1."</h2>";
		fclose($file1);
		#
		#$combined2=combine_arrays($pagekeys,$pagetitles);
		#$combined3=combine_arrays($menulevels,$pagetitles);

		#echo "<p>Combined1<pre>\n";
		#print_r($menulevels);
		#print_r($pagekeys);
		#print_r($pagetitles);
		#print_r($combined1);
		#print_r($combined2);
		#print_r($combined3);
		#echo "</pre></p>\n";

		#$f=sprintf("\nvar NoOffFirstLineMenus=%d",$flm);
		#echo "<h2>Closing: ".$filename."</h2>";
		fclose($file);

		$filename=$files['menuintermed'];
		#echo "<h2>Opening: ".$filename."</h2>";
		$file=fopen($filename, "r");

		$string1="";
		$string1=fread($file, 8192);

		$menu_array=explode(';',$string1);
		
		sort($menu_array);
		$offset=sizeof($menu_array);
		$offset=(($offset)-($offset+$offset));
		$menu_array=array_slice($menu_array, $offset+1);
		#
		#echo "<p>Menu_array<pre>\n";
		#print_r($menu_array);
		#echo "</pre></p>\n";
		
		#echo "<h2>Closing: ".$filename."</h2>";
		fclose($file);
	#echo "<br/>";
	#echo $f;
	#
	include $files['menutmp']; 

	$menuindex=array_values($menuindex);

	#echo "<p>Menuindex<pre>\n";
	#print_r($menuindex);
	#echo "</pre></p>\n";
	 
	#echo "<p>Menu_array<pre>\n";
	#print_r($menu_array);
	#echo "</pre></p>\n";

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
		#fprintf($file1,"\n", "\n");
		#echo "<h2>Closing: ".$menufile."</h2>";
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
		#echo_functionname($thisFunction);
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
	global $paths;
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

function select_quantity($p){

	global $debug;
	global $pageid;

	if($debug['functions']){
		$thisFunction ="select_quantity($p)";
		echo_functionname($thisFunction);
	}

	for($i=0;$i<sizeof($p);$i++){

		echo "<td valign=\"top\">\n";
		if($i==0){echo "<br/><br/>";};
		echo "<p><b>".$p[$i]['title']."</b></p>\n";
		echo "</td>\n";

		echo "<td class=\"green\" valign=\"top\">\n";

		if($i==0){echo "<br/><br/>";};
		echo "<select name=\"".$p[$i]['paypalname']."\">\n";

		for($j=0;$j<13;$j++){
			echo "	<option value=\"".$j."\">".$j."</option>\n";
		}

		echo "</select>&nbsp;\n";
		print "<nobr class=\"text\">copies at £".$p[$i]['price']." each</nobr>\n";

		echo "</td>\n";
		echo "</tr><tr>\n";
	}

	return TRUE;
}

function products_page($p, $cols){

	global $images;
	global $debug;
	global $pageid;
	global $paypal_info;

	if($debug['functions']){
		$thisFunction ="products_page($p,$cols)";
		echo_functionname($thisFunction);
	}

	echo "<table border=\"0\" width=\"60%\" cellspacing=\"2\" cellpadding=\"0\">\n";
	echo "<tr>";
	
	for($i=0;$i<sizeof($p);$i++){

		if($cols>0){
			if(($i%$cols==0)){	
				echo "<tr>\n";
			}
		}
		echo "<td align=\"center\">\n";
		echo "<div class=\"prodbox\">\n";
		echo "<a href=\"".$p[$i]['link']."\">\n";
		echo "<p class=\"smallWhiteText\">".$p[$i]['title']."</p>\n";
		echo "<img src=\"images/".$images[$i]['small']."\" alt=\"".$images[$i]['small']."\" border=\"0\">\n";
		echo "<p class=\"smallWhiteText\">\n";
		echo "by Mark Knight\n";
		echo "</p></a>\n";
		echo "<div class=\"PayPalPayNow\">\n";
		echo "<form name=\"_xclick\" target=\"paypal\" action=\"".$paypal_info['url']."\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"cmd\" value=\"_cart\">\n";
		echo "<input type=\"hidden\" name=\"business\" value=\"".$paypal_info['cadenzas_business_email']."\">\n";
		echo "<input type=\"hidden\" name=\"currency_code\" value=\"GBP\">\n";
		echo "<input type=\"hidden\" name=\"item_name\" value=\"".$p[$i]['paypalname']."\">\n";
		echo "<input type=\"hidden\" name=\"amount\" value=\"".$p[$i]['price']."\">\n";
		#echo "<input type=\"image\" src=\"".$paypal_info['']."http://www.paypal.com/en_GB/i/btn/sc-but-01.gif\" border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">\n";
		echo "<input type=\"image\" src=\"".$paypal_info['payment_button']."http://www.paypal.com/en_GB/i/btn/sc-but-01.gif\" border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">\n";
		echo "<input type=\"hidden\" name=\"add\" value=\"1\">\n";
		echo "</form>\n";
		echo "<p class=\"smallWhiteText\">&pound;".$p[$i]['price']." plus P+P</p>\n";
		echo "</div>\n";
		echo "</div>\n";
		echo "</td>\n";

#		echo "<img src=\"".$images[$p[$i]]['path']."\" height=\"140\" width=\"140\" alt=\"".$images[$p[$i]]['title']."\" border=\"".$settings['border']."\">";
#		echo "</a>";
#		echo "<p>".$images[$p[$i]]['title']."</p>\n";
#		echo "<p>".$images[$p[$i]]['media']."</p>\n";
#		echo "<p>".$images[$p[$i]]['height']."x".$images[$i]['width']." ".$images[$i]['units']."</p>\n";
#		echo "<p>".$images[$p[$i]]['date']."</p>\n";
#		echo "<p>".$images[$p[$i]]['path']."</p>\n";
#		echo "</td>";
#
		if($cols>0){
			if($i%$cols==3){
				echo "</tr>\n";
			}
		}
	}
	echo "</table>\n";

};

function products_page1($p, $cols){

	global $images;
	global $debug;
	global $pageid;

	if($debug['functions']){
		$thisFunction ="products_page1($p,$cols)";
		echo_functionname($thisFunction);
	}


	echo "<table bgcolor=\"#ccccaa\"	border=\"0\" width=\"90%\" cellspacing=\"4\" cellpadding=\"2\">\n";
	echo "<tr>";
	
	for($i=0;$i<sizeof($p);$i++){

		if($cols>0){
			if(($i%$cols==0)){	
				echo "<tr>\n";
			}
		}
		echo "<td align=\"center\">\n";
		#echo "<div class=\"prodbox\">\n";
		echo "<a href=\"".$p[$i]['link']."\">\n";
		echo "<p class=\"smallWhiteText\">".$p[$i]['title']."</p>\n";
		echo "<p>".$p[$i]['text']."</p>\n";
		echo "<img src=\"images/".$images[$i]['small']."\" alt=\"".$images[$i]['small']."\" border=\"0\">\n";
		echo "<p class=\"smallWhiteText\">\n";
		echo "by Mark Knight\n";
		echo "</p></a>\n";
		echo "<div class=\"PayPalPayNow\">\n";
		echo "<form name=\"_xclick\" target=\"paypal\" action=\"".$paypal_url."\" method=\"post\">\n";
		echo "<input type=\"hidden\" name=\"cmd\" value=\"_cart\">\n";
		echo "<input type=\"hidden\" name=\"business\" value=\"".$cadenzas_business_email."\">\n";
		echo "<input type=\"hidden\" name=\"currency_code\" value=\"GBP\">\n";
		echo "<input type=\"hidden\" name=\"item_name\" value=\"".$p[$i]['paypalname']."\">\n";
		echo "<input type=\"hidden\" name=\"amount\" value=\"".$p[$i]['price']."\">\n";
		echo "<input type=\"image\" src=\"http://www.paypal.com/en_GB/i/btn/sc-but-01.gif\" border=\"0\" name=\"submit\" alt=\"Make payments with PayPal - it's fast, free and secure!\">\n";
		echo "<input type=\"hidden\" name=\"add\" value=\"1\">\n";
		echo "</form>\n";
		echo "<p class=\"smallWhiteText\">&pound;".$p[$i]['price']." plus P+P</p>\n";
		echo "</div>\n";
		#echo "</div>\n";
		echo "</td>\n";

#		echo "<img src=\"".$images[$p[$i]]['path']."\" height=\"140\" width=\"140\" alt=\"".$images[$p[$i]]['title']."\" border=\"".$settings['border']."\">";
#		echo "</a>";
#		echo "<p>".$images[$p[$i]]['title']."</p>\n";
#		echo "<p>".$images[$p[$i]]['media']."</p>\n";
#		echo "<p>".$images[$p[$i]]['height']."x".$images[$i]['width']." ".$images[$i]['units']."</p>\n";
#		echo "<p>".$images[$p[$i]]['date']."</p>\n";
#		echo "<p>".$images[$p[$i]]['path']."</p>\n";
#		echo "</td>";
#
		if($cols>0){
			if($i%$cols==3){
				echo "</tr>\n";
			}
		}
	}
	echo "</table>\n";

};

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

function getpage($p,$pageid,$d){

	global $debug;
	global $pageid;
	global $found;
	global $page;

	if($debug['functions']){
		$thisFunction ="getpage( ".$p.", $pageid, $d)";
		echo_functionname($thisFunction);
	}

	if($debug['data']){
		echo "<pre>";
		print_r($p);
		echo "</pre>";
	}

	$pk=array_keys($p);

	#if($pageid){
	#	if($found){
	#		echo "<p>getpage(): FOUND:".$found." page ID:".$pageid.", depth:[".$d."] a:".$p[$pk[0]].", b:".$pk[0]."</p>\n";
	#	}else{
	#		echo "<p>getpage(): page not found. page ID:".$pageid.", depth:[".$d."] a:".$p[$pk[0]].", b:".$pk[0]."</p>\n";
	#	}
	#}

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
					#echo "index <pre>";
					#print_r($pk[$i]);
					#echo "</pre>";

					showpage($p[$pk[$i]],2);
					#
					#return $p[$pk[$i];
					#echo "<p>p[pk[$i]]:".$pk[$i].", pageid:".$pageid."</p>";
					#echo "<p class=\"in\">pagestr:{".$pagestr."}, pageidstr:{".$pageidstr."}</p>";
					#printf("<h1>%s</h1>", tf($found));

					#echo "IN GETPAGE FUNCTION<pre>";
					#print_r($p[$pk[$i]]);
					#echo "</pre>";
					
					$page=$p[$pk[$i]];
					#$pageid=$page;
					break;
				}else{
					$found==FALSE;
					$page=getpage($p[$pk[$i]],$pageid,$d+1);
				}
			}else{
				$page=$p;
			}
		}
		#printf ("<p class=\"out\">Found?: %s</p>", tf($found));
		#echo "<p class=\"out\">depth:".$d." returning ".$pageid."</p>";;
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
	
	if($debug['functions']){
		$thisFunction ="//menur($p,$d,$m,$f)";
		echo_functionname($thisFunction);
	}

	# local vars
	$n=0;
	$a=0;
	$menus=0;

	$pk=array_keys($p);

	if($d==0){
		#echo "<p class=\"in\">";
		#echo "=> {".$pk[$d]."=\"".$p[$pk[$d]]."\"} depth:".$d." ";
		#echo "</p>";
	}
 
#echo "<pre>";
#print_r($pk);
#print_r($p[$pk[0]]);
#echo "</pre>";

	for($i=0;$i<sizeof($p);$i++){
		if(is_array($p[$pk[$i]])){
			$n++;
		}
			$item_no=$i+1;
			#echo "<p>";
			if($n>0){
				#echo "--{".$pk[$i]."=\"".$p[$pk[$i]]."\" item_no=\"".$item_no."\" menu_no=\"".$n."\"} m:".$m."---|	\n";
				if($d==0){
					$menuout=sprintf("Menu%s%d=new Array(\"%s\", \"index.php?pageid=%s\",\"\", %s,20,120);", $m, $n, $p[$pk[$i]]['title'],$pk[$i],"%d");
				}else{
					$menuout=sprintf("Menu%s_%d=new Array(\"%s\", \"index.php?pageid=%s\",\"\", %s,20,120);", $m, $n, $p[$pk[$i]]['title'],$pk[$i],"%d");
				}
				#echo $menuout;
				fprintf($f,"%s", $menuout); 
				
			}else{
				#echo "--{".$pk[$i]."=\"".$p[$pk[$i]]."\" item_no=\"".$item_no."\"}";
			}
			#echo "</p>";
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

		 
			#echo "<p class=\"in\">";
			#$x=$d+1;
			#echo "=> {".$pk[$i]."} depth:".$x." ";
			#echo "</p>";
			
			$menus=menur($p[$pk[$i]],$d+1, $menustring,$f);
			$depth=$d+1;
			#echo "<p class=\"out\"><= {".$pk[$i]."} depth:".$depth." contains:".$menus." arrays";
			$menulevels[]=$menus;
			$pagekeys[]=$pk[$i];
			$pagetitles[]=$p[$pk[$i]]['title'];
		}else{
			;
		}
	}

	if($d==0){
		#echo "<p class=\"out\"><= {".$p[$pk[$d]]."} depth:".$d." returned:".$number_of_arrays." arrays";
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

	#if(sizeof($template)!=(sizeof($values))){
	#	echo "<h1>Error - template and values are of differing size!</h1>";
	#}else{

	#	echo "<h1>OK - template and values are same size!</h1>";
	#}

 #echo "<p>Template<pre>\n";
 #print_r($template);
 #echo "</pre></p>\n";

 #echo "<p>Values<pre>\n";
 #print_r($values);
 #echo "</pre></p>\n";

	for($i=0;$i<sizeof($template);$i++){
		#printf("<p class=\"in\">%s</p><p class=\"out\">%s</p>\n",$template[$i],$values[$i]);
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

function tabs_imple($p){

	global $debug;
	global $pageid;
	
	if($debug['functions']){
		$thisFunction ="tabs_imple($p)";
		echo_functionname($thisFunction);
	}

	$pk=array_keys($p);

	echo "<div id=\"tabs\">\n<ul>";

	for($i=0;$i<sizeof($p);$i++){
		if($i==0){
			echo "<li id=\"current\"><a href=\"index.php?pageid=".$pk[$i]."\">".$p[$pk[$i]]."</a></li>\n";
		}else{
			echo "<li><a href=index.php?pageid=\"".$pk[$i]."\">".$p[$pk[$i]]."</a></li>\n";
		}


	}

	echo "</ul></div>\n";

	return TRUE;
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
	
	#echo "<p>TABS:<pre>";
	#	print_r($pk);
	#echo "</pre></p>";

	#array_shift($pk);
	#echo "<p>TABS pk:<pre>";
	#	print_r($tabs[0]['title']);
	#echo "</pre></p>";

	echo "\n<div id=\"tabs\">\n";
	echo "<ul>\n";

	for($i=0;$i<sizeof($tabs);$i++){

		if($pageid==$pk[$i]){ 
				echo "<li id=\"current\"><a href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
		}else{
				echo "<li><a href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
		}
	}
	echo "</ul>\n</div>";

	return TRUE;
}

function putpage($p){

	global $debug;
	global $pageid;
	
	if($debug['functions']){
		$thisFunction ="tabs($p)";
		echo_functionname($thisFunction);
		}
	#echo "<p>TABS:<pre>";
	#	print_r($t);
	#echo "</pre></p>";

	$pk=array_keys($p);

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

	if(!empty($p['title'])){
		echo "<h1>".$p['title']."</h1>\n";
  }
  #
  # Default xmlfile is books.xml but this
  # can be overridden by adding a new xml
  # filename to any page
  #
	if(!empty($p['xmlfile'])){
    $xmlfile=$p['xmlfile'];
  }else{
    $xmlfile=$files['artworks'];
  }

  if($settings['php5']){
    $my_catalog = new Artworklist($xmlfile);

    if(($_GET['pageid'])&&
      ($_GET['pageid']!=='0') &&
      ($_GET['pageid']!=='1') &&
      ($_GET['pageid']!=='2') &&
      ($_GET['pageid']!=='2.0'))
    {
      //return info on one book
        $my_catalog->show_artwork($_GET['pageid']);
    }else{
      //show menu of books
      if(($_GET['pageid']==='2')){
          $my_catalog->show_menu();
      }elseif(($_GET['pageid']==='2.0')) {

        if(isset($_POST['submit'])){
          if($_POST['submit']=='purchase'){
            $my_catalog->pre_process_order($_POST);
          }elseif($_POST['submit']=='confirm'){
            $my_catalog->verify_order($_POST);
            $my_catalog->process_order($_POST);
          }
       }else{
          $my_catalog->order_list();
        }
      }else{
        $my_catalog->show_menu();
      }
    }

  }elseif(isset($_GET['pageid'])){
    get_static_content_file($_GET['pageid']);
  }

    if(!empty($p['content'])){
     # echo "<div class=\"box2\">\n";
      include $paths['include']."/".$p['content'];
     # echo "</div>\n";
    }

	return true;
}

function get_static_content_file($pageid){

	global $debug;
	global $settings;

$static_content_files=array(
  '0'=>'include/contentPage0.inc',
  '0.0'=>'include/contentPage00.inc',
  '0.1'=>'include/contentPage01.inc',
  '0.2'=>'include/contentPage02.inc',
  '0.3'=>'include/contentPage03.inc',
  '0.4'=>'include/contentPage04.inc',
  '1'=>'include/contentPage1.inc',
  '1.0'=>'include/contentPage10.inc',
  '1.1'=>'include/contentPage11.inc',
  '2'=>'include/contentPage2.inc',
  '2.0'=>'include/contentPage20.inc',
  '3'=>'include/contentPage3.inc',
  '4'=>'include/contentPage4.inc',

  );

	if($debug['functions']){
		$thisFunction ="get_static_content_file(".$pageid.")";
		echo_functionname($thisFunction);
	}

  #echo "<p>".$static_content_files[$pageid]."</p>";
  include $static_content_files[$pageid];

  return true;
}


function generate_order_form(){
  
    #<p><a href="" onClick(window.open("include/cadenzas_content_occT.php");return false;)>Order Form<a></p>
    printf("<p><a href=\"\" onClick=\"javascript: pop_zoom('%s','%s','%s',600,600);return false;\" alt=\"%s, %s\" height=\"240\">form\n</a></p>\n", 
      $zoom_data[$i], 
      $zoom_data[$i], 
      $book['title'], 
      $zoom_more[$i], 
      $book['title'], 
      $zoom_data[$i],
      $zoom_more[$i]
    );
#include("cadenzas_content_occT.php"); 

    return true;
}
