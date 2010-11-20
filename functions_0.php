<?php

include_once "datefunctions.php";

function echo_functionname($name){

	global $debug;
	global $errors;

	$thisFunction="echo_functionname(name)";
	#echo $thisFunction;

	echo "<p class=\"foo\">";
	echo $name;
	echo "</p>\n";
}

function tf($v){return $v ? "True" : "False";}

function getpage($p,$pid,$d,&$found){

  global $debug;
  global $thisPage;

	if($debug['functions']){
		$thisFunction ="getpage( ".$p.", $pid, $d, $found)";
		echo_functionname($thisFunction);
  }

  if(!empty($thisPage)){return $thisPage;} //don't bother doing owt if we have it already!

  $pk=array_keys($p);

  #if($debug['data']){
    #echo "<pre>";
    #print_r($pk);
    #echo "</pre>";
  #}

#if($pid){
#  echo "<p>getpage(): page ID:".$pid.", depth:[".$d."] a:".$p[$pk[0]].", b:".$pk[0]."</p>\n";
#}

  if($found){
    $page=$p;
  }else{
    for($i=0;$i<sizeof($p);$i++){
      if(is_array($p[$pk[$i]])){
        $pagestr=sprintf("%s", $pk[$i]);
        $pidstr=sprintf("%s", $pid);
  
        if(strcmp($pagestr,$pidstr)==0){

          $found=TRUE;
          
          #return $p[$pk[$i];
          #echo "<p>p[pk[$i]]:".$pk[$i].", pid:".$pid."</p>";
          #echo "<p class=\"in\">pagestr:{".$pagestr."}, pidstr:{".$pidstr."}</p>";
          #printf("<h1>%s</h1>", tf($found));

          $page=$p[$pk[$i]];
          $thisPage=$page;
          break;
        }else{
          $found==FALSE;
          $page=getpage($p[$pk[$i]],$pid,$d+1,$found);
        }
      }else{
        $page=$p;
      }
    }
  	#printf ("<p class=\"out\">Found?: %s</p>", tf($found));
    #echo "<p class=\"out\">depth:".$d." returning ".$pid."</p>";;
  }
  return $page;
}

#-------------------------------------------------------------
# Give this function a PHP array and a depth(0) and a file 
# and it will translate the array into a MENU file
#-------------------------------------------------------------
function menur($p,$d,$m,$f){

  global $debug;
  global $levels;
  global $shovels;
  global $plovers;
  
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
        #echo "--{".$pk[$i]."=\"".$p[$pk[$i]]."\" item_no=\"".$item_no."\" menu_no=\"".$n."\"} m:".$m."---|  \n";
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
      $levels[]=$menus;
      $shovels[]=$pk[$i];
      $plovers[]=$p[$pk[$i]]['title'];
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

	if($debug['functions']){
		$thisFunction ="build_menu()";
		echo_functionname($thisFunction);
  }
  $a=array();

  #if(sizeof($template)!=(sizeof($values))){
  #  echo "<h1>Error - template and values are of differing size!</h1>";
  #}else{

  #  echo "<h1>OK - template and values are same size!</h1>";
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
  # Assume arrays are same length
  #
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
  global $thisPage;
  
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

function tabs($p){

  global $debug;
  global $thisPage;
  
	if($debug['functions']){
		$thisFunction ="//tabs($p)";
		echo_functionname($thisFunction);
  }
  echo "<p><pre>XOXOXO";
    print_r($p);
	echo "</p>";

  $pk=array_keys($p);

  #echo "<div id=\"tabs\">";
  #echo "<ul>";

  #for($i=0;$i<sizeof($p);$i++){
  #    if($thisPage==$pk[$i]){ 
  #          echo "<li id=\"current\"><a href=\"".$p[$i]."\">".$p[$pk[$i]]['title']."</a></li>\n";
  #    }else{
  #          echo "<li><a href=\"".$p[$i]."\">".$p[$pk[$i]]."</a></li>\n";
  #    }
  #}
  #echo "    </ul>";
  #echo "</div>";

}

#-------------------------------------------------------------
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

    $xmltag=str_replace(" ", "_", $p['title']);
    $first=sprintf("%s\n<%s depth=\"%d\">\n", $xmlstring, $xmltag, $d);
    fprintf($f, "%s", $first);
    #echo "<h1>".$first."</h1>";
    #echo "<h1>".$xmlstring."</h1>";
    $d++;
  }

  for($i=0;$i<sizeof($p);$i++){

    if(is_array($p[$pk[$i]])){
      $_xmltag=str_replace(" ", "_", $p[$pk[$i]]['title']);
      $down=sprintf("<%s depth=\"%d\">%s\n", $_xmltag, $d, "");
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

function menu(){  

  # this is to generate the menu based on the
  # structure of the data describing the 
  # content, by nesting arrays within
  # arrays. clever huh?
	
  global $debug;
  global $pages0;


  #global $page_keys;

  // Get the array keys for main array
  $pk_0=array_keys($pages0);

	if($debug['functions']){
		$thisFunction ="menu()";
		echo_functionname($thisFunction);
  }

  #$len=sizeof($pages);
//LOOP 0
  #for($i=0;$i<sizeof($pages);$i++){
  for($i=0;$i<sizeof($pages0);$i++){

    if((is_array($pages0[$pk_0[$i]]))){
      echo "//<p>ARRAY FOUND - process and look for deeper nested arrays: [".$pk_0[$i]."]</p>\n"; 

    $menulevel_0=sprintf("Menu%d", $i+1);
    $menulen=sizeof($pages0);
    
    if($i==0){
      $getvar="";
    }else{
      #$getvar=sprintf("index.php?pageid=%d", $page_keys[$i]);
      $getvar=sprintf("index.php?pageid=%d", $pk_0[$i]);
    }
    $string=sprintf("%s=new Array(\"%s\",\"%s\",\"\",%d, 20, 120);\n", 
      $menulevel_0, 
      #$pages[$page_keys[$i]]['title'], 
      $pages0[$pk_0[$i]]['title'], 
      $getvar, 
      $menulen);

    echo $string;
    $string="";
    #echo ">>>".sizeof($pages)."<<<\n";

    #$menulen_1=0;

////LOOP 1
    for($j=0;$j<sizeof($pages0[$pk_0[$i]]);$j++){

      if((is_array($pages0[$pk_0[$j]]))){
        echo "//<p>  Deeper ARRAY FOUND - continue".$pk_0[$j]."</p>\n"; 

        $pk_1=array_keys($pages0[$pk_0[$j]]);

        $menulen_1=sizeof($pages0[$pk_1][$j]);

        if($j==0){
          $getvar_1="";
        }else{
          $getvar_1=sprintf("index.php?pageid=%d", $pages0[$pk_1[$j]]);
        }
        $menulevel_1=sprintf("%s_%d", $menulevel_0, $j+1);
        $getvar_1=sprintf("index.php?pageid=%d", $pk_1[$j]);
        $string_1=sprintf("%s=new Array(\"%s\",\"%s\",\"\",%d, 20, 120);\n", 
          $menulevel_1,
          $pages0[$pk_1[$j]]['title'], 
          $getvar_1,
          $menulen_1);

        echo $string_1;
        $string_1="";
        
  //////LOOP 2
        for($k=0;$k<sizeof($pages0[$pk_1[$j]]);$k++){

          $pk_2=array_keys($pages0[$pk_1[$j]]);

            $menulen_2=sizeof($pages0[$pk_1[$j][$pk_2[$k]]]);

            if($i==0){
              $getvar_2="";
            }else{
              $getvar_2=sprintf("index.php?pageid=%d", $pk_2[$k]);
            }
            $menulevel_2=sprintf("%s_%d", $menulevel_1, $k+1);
            $getvar_2=sprintf("index.php?pageid=%d", $page_keys[$pk_1][$pk_2[$k]]);
            $string_2=sprintf("%s=new Array(\"%s\",\"%s\",\"\",%d, 20, 120);\n", 
              $menulevel_2,
              $pages0[$page_keys[$pk_1]][$pk_2[$k]]['title'], 
              $getvar_2,
              $menulen_2);

            echo $string_2;
            $string_2="";
          }
        }else{
          echo "//<p>".$pages0[$pk_1[$i]]."</p>\n"; 
        }
      }
    }else{
      echo "//<p>".$pages0[$pk_0[$i]]."</p>\n"; 
    }

  }
  $flm=sprintf("\nvar NoOffFirstLineMenus=%d",$i);

  echo $flm; 
}

function showpage($p,$cols){
	
	global $debug;
	global $settings;
	global $images;

	if($debug['functions']){
		$thisFunction ="showpage(p,".$cols.")";
		echo_functionname($thisFunction);
  }
  #echo $p['include'];
  # echo "<pre>PAGE:";
  #  print_r($p);
  # echo "</pre>";
  #
  $pk=array_keys($p);

  if(!empty($p['include'])){
    include $p['include'];
  }

  if(!empty($p['parent'])){
    echo "<a href=\"index.php?pageid=".$p['parent']."\"> ^ ".$p[$pk]."</a>";
  }
  if(!empty($p['previous'])){
    echo "<a href=\"index.php?pageid=".$p['previous']."\"> << </a>";
  }
  if(!empty($p['next'])){
    echo "<a href=\"index.php?pageid=".$p['next']."\"> >> </a>";
  }


#	echo "<table>\n";

#	for($i=0;$i<sizeof($p['images']);$i++){

#    if($cols>0){
#      if(($i%$cols==0)){	
#        echo "<tr>\n";
#      }
#    }
#		echo "<td>";
#		echo "<a href=\"".$images[$p[$i]]['page']."\">";
#		echo "<img src=\"".$images[$p[$i]]['path']."\" height=\"140\" width=\"140\" alt=\"".$images[$p[$i]]['title']."\" border=\"".$settings['border']."\">";
#		echo "</a>";
#		echo "<p>".$images[$p[$i]]['title']."</p>\n";
#		echo "<p>".$images[$p[$i]]['media']."</p>\n";
#		echo "<p>".$images[$p[$i]]['height']."x".$images[$i]['width']." ".$images[$i]['units']."</p>\n";
#		echo "<p>".$images[$p[$i]]['date']."</p>\n";
#		echo "<p>".$images[$p[$i]]['path']."</p>\n";
#    echo "</td>";
#
#    if($cols>0){
#      if($i%$cols==3){
#        echo "</tr>\n";
#      }
#    }
#	}
#	echo "</table>\n";

	return true;
}

function start($section,$images,$cols,$debug,$imagesOn,$textOn,$infoOn){

	head();
	body();

}

function list_items($items){

	for($i=0;$i<sizeof($items);$i++){
		echo "<p>".$items[$i]."</p>\n";
	}

}

function db_options($action,$debug){

	global $settings;
	#global $debug;

	echo "<table border=\"".$settings['border']."\">\n<tr>\n<td align=\"left\" valign=\"top\">\n";
	echo "<form name=\"select\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"select\" value=\"View all users\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"db_select_user\">\n";
	echo "</form>\n";
	echo "</td>";
	echo "<td align=\"left\" valign=\"top\">";
	echo "<form name=\"insert_new_user\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"insert\" value=\"Insert new user\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"form_insert_user\">\n";
	echo "</form>\n";
	echo "</td>";
/*	
	echo "</tr>";
	echo "<tr>";
	echo "<td align=\"left\" valign=\"top\">";
	echo "<form name=\"insert_user_address\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"insert\" value=\"Insert new user address\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"form_insert_user_address\">\n";
	echo "</form>\n";
	echo "</td>";
	echo "<td align=\"left\" valign=\"top\">";
	echo "<form name=\"insert_user_service\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"insert\" value=\"Insert new user service\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"form_insert_user_service\">\n";
	echo "</form>\n";
	echo "</td>";

	echo "<form name=\"update\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"update\" value=\"Update\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"update\"></form>\n";
	echo "</td>";
	echo "<td>";
	echo "<form name=\"delete\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"delete\" value=\"Delete\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"delete\"></form>\n";
	echo "</td>";
	echo "<td>";
	

	echo "<form name=\"csv\" action=\"".$action."\" method=\"POST\">\n";
	echo "<input type=\"submit\" name=\"csv\" value=\"Select All Plain Text\">\n";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"csv\"></form>\n";
	echo "</td>";
	*/
	echo "</tr>";
	echo "</table>";

	return true;
}


function get_db_cookie($cookieName,$page,$debug){

	if ($result=isset($_COOKIE[$cookieName])) {
		$value=$_COOKIE[$cookieName];
		if($thisPage == $page){
			#echo "<meta http-equiv=\"Refresh\" content=\"1; url=rpdb.php\">";
			#echo "</head><body><p>.</p></body></html>";
			#exit (0);
		}
		if($debug){echo "<p>Cookie value:[".$value."]</p>\n";}
		$result=true;
	}else{
		$result=false;
	}
		
	return $result;
}


function set_db_cookie($debug){
	// Set database login cookie
	$cookieName="CQ";
	$cookieValue="";
	$cookieExp="";
	$cookiePath="";
	$cookieDomain="";
	$cookieSecure=0;
	#set the cookie to determine RP logon:
	$cookieExp=time()+60*60*24*1;
	$cookieValue="cq";

	$ret=setcookie($cookieName, $cookieValue, $cookieExp, $cookiePath, $cookieDomain, $cookieSecure);
	if($debug){
		echo "<h2> set cookie </h2>";
		echo "<p> set cookie returned:".$ret."</p>";
		echo "<p> set cookieName:".$cookieName."</p>";
		echo "<p> set cookieValue:".$cookieValue."</p>";
		echo "<p> set cookieExp:".$cookieExp."</p>";
		echo "<p> set cookiePath:".$cookiePath."</p>";
		echo "<p> set cookieDomain:".$cookieDomain."</p>";
		echo "<p> set cookieSecure:".$cookieSecure."</p>";
	}
	return true;
}

function display_vars($arr){

	$i=0;

	for($i=0;$i<(sizeof($arr));$i++){
		echo "<p>".$i." ".$arr[$i]."</p>\n";
	}

}

function date_selector($name,$d,$m,$y){

       	$year=date("Y");
	$month=date("M");
	$startYear=date("Y");
	$endDay=31;

if($d){
echo "<select name=".$date_selector_day_name." id=".$date_selector_day_id." class=\"textNormal\">\n";
echo "<option value=\"\">dd</option>\n";

	for($startDay=1;$startDay <= $endDay; $startDay++){
		$string=sprintf("<option value=\"%02d\">%02d</option>\n", $startDay, $startDay);
		echo $string;
	}
echo "</select>\n";
}
if($m){
echo "<select name=\"".$date_selector_month_name." id=".$date_selector_month_id." class=\"textNormal\">\n";
?>
<option value="">MMM</option>
<option value="01" >Jan</option>
<option value="02" >Feb</option>
<option value="03" >Mar</option>
<option value="04" >Apr</option>
<option value="05" >May</option>
<option value="06" >Jun</option>
<option value="07" >Jul</option>
<option value="08" >Aug</option>
<option value="09" >Sep</option>
<option value="10" >Oct</option>
<option value="11" >Nov</option>
<option value="12" >Dec</option>
</select>
<?php
}
	if($y){ ?>
		<select name="<?php echo $date_selector_year_name;?>" id="<?php echo $date_selector_year_id;?>" class="textNormal">
		<option value="">yyyy</option>
	<?php

		for($startYear=$year;$startYear >= 1999; $startYear--){
			echo "<option value=".$startYear.">".$startYear."</option>\n";
		}
	?>
		</select>
<?php
	}
	return true;
}


function validate_inserted_data(){

	global $debug;
	global $errors;

	$retval=true;

	if($debug['functions']){
		$thisFunction ="validate_inserted_data()";
		echo_functionname($thisFunction);
	}
	
	if($_POST['workpackageid']==$_POST['dependson']){
		echo $errors['0013']; 
		$retval=false;
	}
	if(empty($_POST['dependency'])){
		echo $errors['0014']; 
		$retval=false;
	}

	return $retval;
}

function quote_smart($value) {

	global $debug;

	if($debug['functions']){
		$thisFunction ="quote_smart(value:[".$value."])";
		echo_functionname($thisFunction);
	}

    // Stripslashes
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    // Quote if not a number or a numeric string
    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}

function cut_to_the_chase($actions,$templateid){

	global $debug;
	global $thisPage;
	global $limitrange;
	global $displaylimit;

	if($debug['functions']){
		$thisFunction ="cut_to_the_chase(actions,templateid[".$templateid."])";
		echo_functionname($thisFunction);
	}

	zerosessionvars();

	echo "<form name=\"cuttothechase\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>Select All Records</legend>\n";
	if($debug['showhiddenvalues']){
		for($i=0;$i<sizeof($actions[$templateid]['attributes']);$i++){
				echo "<input type=\"hidden\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\" value=\"\"/>\n";
		}
	}else{
		for($i=0;$i<sizeof($actions[$templateid]['attributes']);$i++){
			echo "<input type=\"text\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\" value=\"".$actions[$templateid]['attributes'][$i]['name']."\"/>\n";
		}
	}
	echo "<br/><p>";
	echo "<label for=\"limit\" class=\"label\">Maximum records per page ?</label>\n";
	echo "<select name=\"limit\" id=\"limit\" onChange=\"updateSelection('limit');\">\n";
	for($i=0;$i<sizeof($limitrange);$i++){
		if($limitrange[$i]==$displaylimit['limit']){
			echo "<option value=\"".$limitrange[$i]."\" selected >".$limitrange[$i]."</option>\n";
		}else{
			echo "<option value=\"".$limitrange[$i]."\">".$limitrange[$i]."</option>\n";
		}
	}
	echo "</select>\n";
	echo "</p>";	
	echo "<br/>\n";

	echo "<p>";	
	echo "<label for=\"csv\">View in CSV format?</label>\n";
	echo "<input name=\"csv\" id=\"csv\" type=\"checkbox\" onChange=\"updateSelection('csv');\"/><br/>\n";
	echo "</p>";	
	echo "<input name=\"templateid\" value=\"".$templateid."\" type=\"hidden\"/>\n";
	echo "<input name=\"skip\" value=\"0\" type=\"hidden\"/>\n";
	echo "<input name=\"cmd\" value=\"criteriaselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"go\" type=\"submit\"/>\n";
	echo "<input name=\"reset\" value=\"clear form\" type=\"reset\"/>\n";	echo "</fieldset>\n";
	echo "</form>\n";
	echo "<h3>or</h3>\n";

	return true;
}

function countrecords($sql,$name){

	global $debug;
	global $mysql;

	$old=array("*");
	$new=array("count(*)");
	$sqlstart="";
	$sqlend="";

	if($debug['functions']){
		$thisFunction ="countrecords(sql:[".$sql."],name:[".$name."])";
		echo_functionname($thisFunction);
	}

	//connect to database:
	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password']) or  die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database' . mysql_error());

	if($sql==""){
		$sql=sprintf("SELECT count(*) FROM `%s` ", $name);
	}else{
		$sqlstart=str_replace($old, $new, $sql);
	}

	if($debug['sql']){
		showdebug($sqlstart,'sql');
	}

	$resultcount = mysql_query($sqlstart) or die('Query failed: '.mysql_error());
	$count=mysql_fetch_array($resultcount,MYSQL_NUM);
	$_SESSION['recordcount']=$count[0];

	mysql_close($link);

	return $count[0];
}

function zerosessionvars(){

	global $debug;

	$test=array();

	if($debug['functions']){
		$thisFunction ="zerosessionvars()";
		echo_functionname($thisFunction);
	}

	if(isset($_SESSION['limit'])){
		$_SESSION['limit']=null;
	}
	if(isset($_SESSION['skip'])){
		$_SESSION['skip']=null;
	}
	if(isset($_SESSION['sqlnolimit'])){
		$_SESSION['sqlnolimit']=null;
	}
	if(isset($_SESSION['recordcount'])){
		$_SESSION['recordcount']=null;
	}
	if(isset($_SESSION['displaystyle'])){
		$_SESSION['displaystyle']=null;
	}

	return true;
}

/* HS1 */
function display_csv($table,$templateid,$data,$skip,$limit){

	global $debug;
	global $settings;
	global $errors;

	if($debug['functions']){
		$thisFunction ="display_csv(table,templateid:[".$templateid."],data,skip:[".$skip."],limit:[".$limit."])";
		echo_functionname($thisFunction);
	}

	$tablerowlen=sizeof($table['attributes']);
	$rowlen=sizeof($data[0]);
	$datalen=sizeof($data);

	echo "<h3>".$table['label']."&nbsp;".$errors['0011'];

	if($rowlen==0){
		echo $errors['0001'];
		return (-1);
	}else if(($datalen!=0)&&($tablerowlen!=$rowlen)){
		echo $errors['0003'];
		return (-1);
	}

	if(isset($_SESSION['recordcount'])){
		$recordcount=$_SESSION['recordcount'];
	}

	skiplimit($templateid,$skip,$limit,$recordcount);
	#skiplimit($skip,$limit);

	for($i=0;$i<sizeof($data);$i++){
		echo "<pre>";
		for($j=0;$j<$rowlen;$j++){
			#echo "";
			echo $data[$i][$table['attributes'][$j]['name']];
			echo ",";

		}
		#echo "<br/>\n";
	echo "</pre>\n";
	}

	skiplimit($templateid,$skip,$limit,$recordcount);
	#skiplimit($skip,$limit);

	return true;
}
/* HS1 */
function csv($table,$templateid,$data,$skip,$limit){

	global $debug;
	global $settings;
	global $errors;

	$email=array();

	if($debug['functions']){
		$thisFunction ="csv(table,templateid:[".$templateid."],data,skip:[".$skip."],limit:[".$limit."])";
		echo_functionname($thisFunction);
	}

	$tablerowlen=sizeof($table['attributes']);
	$rowlen=sizeof($data[0]);
	$datalen=sizeof($data);

	if(isset($_SESSION['recordcount'])){
		$recordcount=$_SESSION['recordcount'];
	}

	echo "<h3>".$table['label']."</h3>\n";
	echo "<h3>".$recordcount." ".$errors['0011'];

	if($rowlen==0){
		echo $errors['0001'];
		return (-1);
	}else if(($datalen!=0)&&($tablerowlen!=$rowlen)){
		echo $errors['0003'];
		return (-1);
	}


	#skiplimit($templateid,$skip,$limit,$recordcount);
	#skiplimit($skip,$limit);
	echo "<p>Cut or copy the text (press and hold the 'Ctrl' key and press the 'c' key) between the two horizontal dotted lines below:</p>";
	echo "<p>-----------------------------------------------------------------------------------------------------------------------------------</p>\n";

#	$email['body']=sprintf("%s",$data[0][$table['attributes'][0]['name']]);
#	for($i=1;$i<sizeof($data);$i++){
#		for($j=0;$j<$rowlen;$j++){
#			$email['body']=sprintf("%s,%s",$email['body'],$data[$i][$table['attributes'][$j]['name']]);
#			#echo ",";
#		}
#	}

	echo "<pre class=\"csv\">";
	for($j=0;$j<$rowlen;$j++){
		if($table['attributes'][$j]['show']==1){
			echo $table['attributes'][$j]['label'];
			echo ",";
		}
	}
	#echo "</pre>";
	for($i=0;$i<sizeof($data);$i++){
	#	echo "<pre class=\"csv\">";
		for($j=0;$j<$rowlen;$j++){
			if($table['attributes'][$j]['show']==1){
				echo $data[$i][$table['attributes'][$j]['name']];
				echo ",";
			}
		}
		echo "<br/>";
	#	echo "</pre>";
	}
	echo "</pre>";
	echo "<br/><p>-----------------------------------------------------------------------------------------------------------------------------------</p>\n";
	echo "<p>Paste and save the text in a simple text file (using MS Notepad or Wordpad or a similar text editor) as \"yourfile.csv\" and open it with MS Excel</p>\n";

#	echo "<p>Alternatively enter your email address in the box below and click \"send\" to receive the above CSV data in email form</p>";
#	echo "<form action=\"".$thisPage."\" method=\"post\">\n";
#	echo "<input type=\"text\" name=\"email\"/>\n";
#	echo "<input type=\"submit\" value=\"send\">\n";
#	echo "</form>\n";

	#skiplimit($templateid,$skip,$limit,$recordcount);
	#skiplimit($skip,$limit);
	
	
	#$email['to']="duncan.smith@eurostar.co.uk";
	#$email['subject']="test CSV email";
	#$email['body'];
	#$email['headers']='From: High Speed 1 <hs1dependencies@elbrus.eurostar.inet>' . "\r\n";
	
	#mail($email['to'], $email['subject'], $email['body'], $email['headers']);

	return true;
}

/* HS1 */
function list_structures($structure,$name){

	global $debug;

	if($debug['generate_scripts']){
		echo "<h2>Writing ".$name."_array.php files</h2>\n";
		$file=sprintf("%s_array.php",$name);
		$handle=fopen($file,'w');
		fprintf($handle,"<?php\n$%s_array=array(\n",$name);
	}else{
		echo "<h2>Not writing ".$name."_array.php files</h2>\n";
	}
	$len=sizeof($structure);

	if($debug['functions']){
		$thisFunction ="list_structures(structure,name)";
		echo_functionname($thisFunction);
	}


	echo "<h2>";
	echo $name;
	echo "</h2>\n";
	echo "<p>START:[";

	for($i=0;$i<$len;$i++){

		echo $structure[$i]['name'];
		echo ", ";
		if($debug['generate_scripts']){
			fprintf($handle,"\t'%s'=>$i",$structure[$i]['name']);
			if($i+1==$len){
				fprintf($handle,"\n);\n?>");
			}
			else{
				fprintf($handle,",\n");
			}
		}
	}
	if($debug['generate_scripts']){
		fclose($handle);
	}
		echo "] END</p>\n";

	return true;
}

/* HS1 */
function login(){

	global $debug;
	global $thisPage;

	if($debug['functions']){
		$thisFunction ="login()";
		echo_functionname($thisFunction);
	}

	return true;
}

/* HS1 */
function logout(){

	global $debug;

	if($debug['functions']){
		$thisFunction ="logout()";
		echo_functionname($thisFunction);
	}

	session_destroy();

	return true;
}

/* HS1 */
function build_sql_simple($view,
			$action,
			$templateid,
			$post,
			$skip,
			$limit){

	global $debug;
	global $errors;
	global $thisPage;
	global $mysql_mode;

	if($debug['functions']){
		$thisFunction ="build_sql_simple(view*name:[".$view['name']."],action*name:[".$action['name']."],templateid:[".$templateid."],post,skip[".$skip."],limit[".$limit."])";
		echo_functionname($thisFunction);
	}

	if($debug['post']){
		showdebug($post,'post');
	}		
	if($debug['action']){
		showdebug($action,'args');
	}		
	if($debug['view']){
		showdebug($view,'args');
	}		
	if($debug['params']){
		showdebug($skip,'para');
		showdebug($limit,'para');
	}		

	$count=sizeof($post);
	$len=$count;
	$last=false;
	$items=array();
	$temp=array();
	$tempA=array();
	$tempB=array();
	$keys=array();
	$sub=array();
	$subsub=array();
	$groups=array();
	$groupA=array();
	$groupB=array();
	$returnvalue=array();

	# extract only the non-null post items
	#
	for($i=0;$i<$len;$i++){

		if( $post[$action['attributes'][$i]['name']] != "NULL" ){


			if(isset($action['attributes'][$i]['def'])&&
				$action['attributes'][$i]['def']=="DB"){

				$xsplit1=explode("+", $action['attributes'][$i]['name']);
				$xsplit2=explode(":", $post[$action['attributes'][$i]['name']]);

				for($j=0;$j<sizeof($xsplit1);$j++){
					$sub[$j]['name']=$xsplit1[$j];
					$sub[$j]['value']=$xsplit2[$j];
					$sub[$j]['group']=$action['attributes'][$i]['group'];
				}

				$xsplit1=$xsplit2=null;

				$keys['key']=$sub;	

				$groups[]=$keys;

				$sub=$keys=null;				

			}
			else if(isset($action['attributes'][$i]['def'])&&
				($action['attributes'][$i]['def']=="DATE")){

				$xsplit=explode("+",$action['attributes'][$i]['name']);

				$temp['name']=$xsplit[0];
				$temp['value']=$post[$action['attributes'][$i]['name']];
				$temp['temporal_relation']=$xsplit[1];

				$items[]=$temp;
				$temp=null;				
			}
			else if(isset($action['attributes'][$i]['def'])&&
				($action['attributes'][$i]['def']=="BOOLEAN")){
				
				$temp['name']=$action['attributes'][$i]['name'];
				#$temp['value']=$post[$action['attributes'][$i]['name']];
				$temp['value']='0000-00-00';

				$temp['closed']='true';

				$items[]=$temp;
				$temp=null;


			} else {
				$temp['name']=$action['attributes'][$i]['name'];
				$temp['value']=$post[$action['attributes'][$i]['name']];

				$items[]=$temp;
				$temp=null;				

			}
		}
	}
	if($debug['params']){
		showdebug($groups,'args');
	}

	for($i=0;$i<sizeof($groups);$i++){
		if (	  $groups[$i]['key'][0]['group']=='A'){
			$groupA[]=$groups[$i];
		}else if ($groups[$i]['key'][0]['group']=='B'){
			$groupB[]=$groups[$i];
		}
	}

	if(isset($groupA)){
		if(sizeof($groupA)>=1){
			$tempA=array_pop($groupA);
		}
	}
	if(isset($groupB)){
		if(sizeof($groupB)>=1){
			$tempB=array_pop($groupB);
		}
	}
	if($debug['params']){
		showdebug($tempA,'get');
		showdebug($tempB,'post');
	}

	if(isset($tempA)&&(sizeof($tempA)>0)){

		$items[]=$tempA;
	}
	if(isset($tempB)&&(sizeof($tempB)>0)){

		$items[]=$tempB;
	}
	$groups=$temp=$tempA=$tempB=NULL;

	$len=sizeof($items);

	if($debug['variables']){
		showdebug($items,'vars');
	}

	#report($items);

	if($len>0){
		# Set up SQL select statement for first item:
		if(isset($items[0]['key'])&&(sizeof($items[0]['key'])>0)){

			#$sqlc="SELECT count(*) FROM";

			$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s'", 
					$view['name'], 
					$items[0]['key'][0]['name'], 
					$items[0]['key'][0]['value']);

			for($j=1;$j<sizeof($items[0]['key']);$j++){
					
				$sql=sprintf("%s AND %s='%s' ", 
					$sql,
					$items[0]['key'][$j]['name'],
					$items[0]['key'][$j]['value']);
			}
		}
		else if(isset($items[0]['temporal_relation'])&&($items[0]['temporal_relation']=='from')){

			$sql=sprintf("SELECT * FROM `%s` WHERE %s>'%s'", $view['name'], $items[0]['name'], $items[0]['value']);

		}else if(isset($items[0]['temporal_relation'])&&($items[0]['temporal_relation']=='until')){

			$sql=sprintf("SELECT * FROM `%s` WHERE %s<'%s'", $view['name'], $items[0]['name'], $items[0]['value']);

		}else if(isset($items[0]['closed'])&&($items[0]['closed']=='true')){

			$sql=sprintf("SELECT * FROM `%s` WHERE %s!='%s'", $view['name'], $items[0]['name'], $items[0]['value']);

		}else{
			$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s'", $view['name'], $items[0]['name'], $items[0]['value']);
		}
			       
		# Set up SQL select statement for subsequent items:
		for($i=1;$i<$len;$i++){

			if(isset($items[$i]['key'])&&(sizeof($items[$i]['key'])>0)){
				for($j=0;$j<sizeof($items[$i]['key']);$j++){
						
					$sql=sprintf("%s AND %s='%s' ", 
						$sql,
						$items[$i]['key'][$j]['name'],
						$items[$i]['key'][$j]['value']);
				}
			} 
			else if(isset($items[$i]['temporal_relation'])&&($items[$i]['temporal_relation']=='from')){

				$sql=sprintf("%s AND %s>'%s'", $sql,$items[$i]['name'],$items[$i]['value']);
			}
			else if(isset($items[$i]['temporal_relation'])&&($items[$i]['temporal_relation']=='until')){

				$sql=sprintf("%s AND %s<'%s'", $sql,$items[$i]['name'],$items[$i]['value']);

			}else if(isset($items[$i]['closed'])&&($items[$i]['closed']=='true')){

				$sql=sprintf("%s AND %s!='%s'",$sql, $items[$i]['name'], $items[$i]['value']);
			}
			else{
				$sql=sprintf("%s AND %s='%s'", $sql,$items[$i]['name'],$items[$i]['value']);
			}
		}

		$sqlnolimit=$sql;
			
		# include the ORDER BY part of the SQL select statement:
		if(isset($view['order'])&&($view['order'])){
			$sql=sprintf("%s ORDER BY %s", $sql, $view['order']);
		}


		# Complete the SQL select statement:
		#if(isset($table['limit'])&&($table['limit'])){
		if(isset($_SESSION['displaystyle'])&&($_SESSION['displaystyle']!='csv')){
			$sql=sprintf("%s LIMIT %d, %d", $sql, $skip, $limit);
		}
		#$sql=sprintf("%s;", $sql);

	}else{

		$sql=sprintf("SELECT * FROM `%s`", $view['name']);

		$sqlnolimit=$sql;

		if(isset($view['order'])&&($view['order'])){
			$sql=sprintf("%s ORDER BY %s", $sql, $view['order']);
		}


		if(isset($view['limit'])&&($view['limit'])){
			if(isset($_SESSION['displaystyle'])&&($_SESSION['displaystyle']!='csv')){
				$sql=sprintf("%s LIMIT %d, %d ", $sql, $skip, $limit);
			}
			else{
				$sql=sprintf("%s ", $sql);
			}
		}
	}

	$returnvalue['sql']=$sql;
	$returnvalue['sqlnolimit']=$sqlnolimit;

	return $returnvalue;
}

/* HS1 */
function showdebug($data, $style){

	global $debug;

	if($debug['functions']){
		$thisFunction ="showdebug(data, style:[".$style."])";
		echo_functionname($thisFunction);
	}
	echo "<pre class=\"".$style."\">";
	#echo $style;
	print_r($data);
	#var_dump($data);
	echo "</pre>\n";

	return true;
}

/* HS1 */
function debugcolorkey(){

	global $debug;
	global $debugcolors;

	if($debug['functions']){
		$thisFunction ="debugcolorkey()";
		echo_functionname($thisFunction);
	}
	#echo "<div class=\"debug\">\n";
	for($i=0;$i<sizeof($debugcolors);$i++){
		echo "\t<pre class=\"".$debugcolors[$i]['name']."\">".$debugcolors[$i]['name']."</pre>\n";
	}
	#echo "</div>\n";

	return true;
}

/* HS1 */
function debugcolors(){

	global $debug;
	global $debugcolors;

	if($debug['functions']){
		$thisFunction ="debugcolors()";
		echo_functionname($thisFunction);
	}
	echo "<style type=\"text/css\">\n";
	for($i=0;$i<sizeof($debugcolors);$i++){
		echo "\tpre.".$debugcolors[$i]['name']."{ color:".$debugcolors[$i]['color']."; }\n";
	}
	echo "</style>\n";

	return true;
}

/* HS1 */
function form_filter_simple($actions,$templateid){

	global $debug;
	global $thisPage;
	global $views;
	global $displaylimit;
	global $limitrange;

	if($debug['functions']){
		$thisFunction ="form_filter_simple(actions,templateid:[".$templateid."])";
		echo_functionname($thisFunction);
	}

	if($debug['args']){
		showdebug($actions[$templateid]['name'],'args');
	}

	zerosessionvars();

	echo "<form name=\"select_activity\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>".$actions[$templateid]['label']."</legend>\n";


	for($i=0;$i<sizeof($actions[$templateid]['attributes']);$i++){

		echo "<p>\n";
		echo "<label for=\"".$actions[$templateid]['attributes'][$i]['name']."\">".$actions[$templateid]['attributes'][$i]['label']."</label>\n";
		#echo "<label for=\"".$action['attributes'][$i]['name']."_check\" class=\"tinylabel\">?</label>\n";
		#echo "<input type=\"checkbox\" name=\"".$action['attributes'][$i]['name']."_check\"/>\n";
		#
	

		if(strstr($actions[$templateid]['attributes'][$i]['inputtype'],"checkbox")){

			echo "<input type=\"checkbox\" id=\"".$actions[$templateid]['attributes'][$i]['name']."\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\" 
				onChange=\"updateSelection('".$actions[$templateid]['attributes'][$i]['name']."');
			\"/>\n";
		}
		else if(strstr($actions[$templateid]['attributes'][$i]['inputtype'],"radio")){
				$xsplit=explode("/",$actions[$templateid]['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$actions[$templateid]['attributes'][$i]['options']);
				$itemname=$actions[$templateid]['attributes'][$i]['name'];
				radio_selector($itemname,$optionslist,$optionsvalues);
				$itemname="";
		}
		else if(strstr($actions[$templateid]['attributes'][$i]['inputtype'],"select")){

				$xsplit=explode("/",$actions[$templateid]['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$actions[$templateid]['attributes'][$i]['options']);
				
				#showdebug($actions[$templateid]['attributes'][$i],'args');

				echo "<select id=\"".$actions[$templateid]['attributes'][$i]['name']."\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\" 
					onChange=\"updateSelection('".$actions[$templateid]['attributes'][$i]['name']."');
				\">\n";	
				echo "\t<option value=\"\"></option>\n";

				if($optionslist[0]=='db'){
					$data="";
					$data=action($actions[$templateid],$actions[$templateid]['attributes'][$i]['sql']);
					$len=sizeof($data);
					if($debug['variables']){
						#showdebug($len,'vars');
					}
					if($debug['args']){
				#		showdebug($action[$actions_array[$action['name']]]['attributes'],'vars');
						#showdebug($actions[$templateid]['attributes'],'vars');
					}

					for($n=0;$n<sizeof($data);$n++){
						echo "\t<option value=\"";
						# Put in the Portfolio.Project.Workpackage reference
						if($actions[$templateid]['attributes'][$i]['table']=='viewprojects'){

							echo $data[$n]['portfolio'];
							echo ":";

						}else if($actions[$templateid]['attributes'][$i]['table']=='viewworkpackages'){

							echo $data[$n]['portfolio'];
							echo ":";
							echo $data[$n]['project'];
							echo ":";
						}
						echo	$data[$n]['ref'];
						echo "\">";

						if($actions[$templateid]['attributes'][$i]['table']=='viewprojects'){

							echo $data[$n]['portfolio'];
							echo ".";

						}else if($actions[$templateid]['attributes'][$i]['table']=='viewworkpackages'){

							echo $data[$n]['portfolio'];
							echo ".";
							echo $data[$n]['project'];
							echo ".";

						}
						echo $data[$n]['ref']." ".$data[$n]['info']." ";

						echo "</option>\n";
					}

				}else{
						for($k=0;$k<sizeof($optionslist);$k++){
							echo "\t<option value=\"".$optionsvalues[$k]."\">".$optionslist[$k]."</option>\n";
						}	
				}
				echo "</select>\n";
		}else if(strstr($actions[$templateid]['attributes'][$i]['inputtype'],"date")){
			# 0-0-0 gives a blank date with NULL values for YYYY-MM-DD
			# 1-1-1 gives dates set to earliest available date, ie $beginYYYY, Jan 01
			# 2-2-2 gives dates set to TODAY's date
			#select_date($actions[$templateid]['attributes'][$i]['name'],"YYYY-Mmm-DD","1-1-1");
			#echo "Dates from  ";	
			#$date_name_from=$actions[$templateid]['attributes'][$i]['name']."_from";
			#select_date_blank($date_name_from,"YYYY-MM-DD");
			#$date_name_until=$actions[$templateid]['attributes'][$i]['name']."_until";
			#echo "  until ";	
			select_date_blank($actions[$templateid]['attributes'][$i]['name'],"YYYY-MM-DD");
			#select_date_blank($date_name_until,"YYYY-MM-DD");
			#echo "";echo "\n";
			#echo "<label for=\"".$actions[$templateid]['attributes'][$i]['name']."_relative\" class=\"radiolabel\"> Leave empty for exact date</label>\n";
			#echo "<label for=\"".$actions[$templateid]['attributes'][$i]['name']."_relative\" class=\"radiolabel\"> Before/After </label>\n";
			#echo "<p>leave blank for date shown only</p>\n";
			#echo "<input type=\"radio\" name=\"".$actions[$templateid]['attributes'][$i]['name']."_relative\" value=\"before\">\n";
			#echo "<br/>\n";
			#echo "<label for=\"".$action['attributes'][$i]['name']."_relative\" class=\"radiolabel\">After</label>\n";
			#echo "<input type=\"radio\" name=\"".$actions[$templateid]['attributes'][$i]['name']."_relative\" value=\"after\"/>\n";
			#echo "<br/>\n";
			#echo "<label for=\"".$action['attributes'][$i]['name']."\">Or from date until</label>\n";
			#echo "<label for=\"".$action['attributes'][$i]['name']."_check\" class=\"tinylabel\">?</label>\n";
			#echo "<input type=\"checkbox\" name=\"".$action['attributes'][$i]['name']."_check\"/>\n";
			#select_date($action['attributes'][$i]['name'],"YYYY-Mmm-DD","0-0-0");
			
		}else{
			if($debug['ajax']){
				echo "<input onblur=\"getData(this.value)\" type=\"text\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\"/>\n";
			}else{
				echo "<input type=\"text\" name=\"".$actions[$templateid]['attributes'][$i]['name']."\"/>\n";
			}
		}

		echo "<br/>\n";	
		echo "</p>\n";
	}
	echo "<hr>";
	echo "<p>";
	echo "<label for=\"limit\" class=\"label\">Maximum records per page ?</label>\n";
	echo "<select name=\"limit\" id=\"limit\" onChange=\"updateSelection('limit');\">\n";
	for($i=0;$i<sizeof($limitrange);$i++){
		if($limitrange[$i]==$displaylimit['limit']){
			echo "<option value=\"".$limitrange[$i]."\" selected >".$limitrange[$i]."</option>\n";
		}else{
			echo "<option value=\"".$limitrange[$i]."\">".$limitrange[$i]."</option>\n";
		}
	}
	echo "</select>\n";
	echo "</p>";	
	echo "<br/>\n";

	echo "<p>";	
	echo "<label for=\"csv\"><strong>OR</strong> <u>selected</u> records in CSV format?</label>\n";
	echo "<input name=\"csv\" id=\"csv\" type=\"checkbox\" onChange=\"updateSelection('csv');\"/><br/>\n";
	echo "</p>";	
	echo "<input name=\"templateid\" value=\"".$templateid."\" type=\"hidden\"/>\n";
	echo "<input name=\"skip\" value=\"0\" type=\"hidden\"/>\n";
	echo "<input name=\"cmd\" value=\"criteriaselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"go\" type=\"submit\"/>\n";
	echo "<input name=\"reset\" value=\"clear form\" type=\"reset\"/>\n";
	echo "</fieldset>\n";
	echo "</form><br/>\n";

	return true;
}

/* HS1 */
function form_select_table($pageid){

	global $debug;
	global $thisPage;
	global $tables;
	global $displaylimit;
	global $limitrange;

	if($debug['functions']){
		$thisFunction ="form_select_table(".$pageid.")";
		echo_functionname($thisFunction);
	}

	zerosessionvars();

	echo "<form name=\"select_table\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>Manage Tables</legend>\n";
	echo "<p>";
	echo "<label for=\"table\" class=\"label\">View, Edit or Delete from Table</label>\n";
	echo "<select name=\"templateid\">\n";
	for($i=0;$i<sizeof($tables);$i++){
		echo "<option value=\"".$i."\">".$tables[$i]['name']."</option>\n";
	}
	echo "</select><br/>\n";
	echo "<br/>\n";
	echo "</p>";

	echo "<p>";
	echo "<label for=\"limit\" class=\"label\">Records per page ?</label>\n";
	echo "<select name=\"limit\">\n";
	for($i=0;$i<sizeof($limitrange);$i++){
		if($limitrange[$i]==$displaylimit['limit']){
			echo "<option value=\"".$limitrange[$i]."\" selected >".$limitrange[$i]."</option>\n";
		}else{
			echo "<option value=\"".$limitrange[$i]."\">".$limitrange[$i]."</option>\n";
		}
	}
	echo "</select>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	echo "</p>";

	echo "<p>";
	echo "<label for=\"insert\" class=\"label\">Insert a new record ?</label>\n";
	echo "<input type=\"checkbox\" name=\"insert\" value=\"true\"/>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	echo "</p>";
	echo "<input name=\"pageid\" value=\"".$pageid."\" type=\"hidden\"/>\n";
	echo "<input name=\"skip\" value=\"0\" type=\"hidden\"/>\n";
	echo "<input name=\"cmd\" value=\"templateselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"submit\" type=\"submit\"/>\n";
	echo "<input name=\"reset\" value=\"reset\" type=\"reset\"/>\n";
	echo "</fieldset>\n";
	echo "</form>\n";

	return true;
}

/* HS1 */
function form_select_view(){

	global $debug;
	global $thisPage;
	global $views;
	global $displaylimit;
	global $limitrange;

	$skip=$displaylimit['skip'];
	$limit=$displaylimit['maxlimit'];


	if($debug['functions']){
		$thisFunction ="form_select_view()";
		echo_functionname($thisFunction);
	}

	zerosessionvars();

	echo "<form name=\"select_view\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>Manage Dependencies</legend>\n";
	echo "<p>";
	#echo "<label for=\"table\" class=\"label\">View, Edit or Delete from View</label>\n";
	echo "<label for=\"table\" class=\"label\">View, Edit or Delete from</label>\n";
	echo "<select name=\"templateid\">\n";
	for($i=0;$i<sizeof($views);$i++){
		if(isset($views[$i]['basetables'])&&($views[$i]['basetables']['a']['name']=="dependencies")){
			echo "<option value=\"".$i."\">".$views[$i]['label']."</option>\n";
		}
	}
	echo "</select><br/>\n";
	echo "<br/>\n";
	echo "</p>";


	echo "<p>";
	echo "<label for=\"limit\" class=\"label\">Records per page ?</label>\n";
	echo "<select name=\"limit\">\n";
	for($i=0;$i<sizeof($limitrange);$i++){
		if($limitrange[$i]==$displaylimit['limit']){
			echo "<option value=\"".$limitrange[$i]."\" selected >".$limitrange[$i]."</option>\n";
		}else{
			echo "<option value=\"".$limitrange[$i]."\">".$limitrange[$i]."</option>\n";
		}
	}
	echo "</select>\n";
	echo "<br/>\n";
	echo "<br/>\n";
	echo "</p>";

	#echo "<p>";
	#echo "<label for=\"insert\" class=\"label\">Insert a new record ?</label>\n";
	#echo "<input type=\"checkbox\" name=\"insert\" value=\"true\"/>\n";
	#echo "<br/>\n";
	echo "<br/>\n";
	#echo "</p>";
	echo "<input name=\"skip\" value=\"0\" type=\"hidden\"/>\n";
	echo "<input name=\"cmd\" value=\"templateselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"submit\" type=\"submit\"/>\n";
	echo "<input name=\"reset\" value=\"reset\" type=\"reset\"/>\n";
	echo "</fieldset>\n";
	echo "</form>\n";



	return true;
}

/* HS1 */
function form_assign_dependencies($view){

	global $debug;
	global $thisPage;

	if($debug['functions']){
		$thisFunction ="form_assign_dependencies(view)";
		echo_functionname($thisFunction);
	}

	$a=view($view);
	#$b=view($view);

	if($debug['data']){
		showdebug($a,'data');
	}

	echo "<form name=\"assign_dependencies\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<label for=\"assign_dependencies_from\">Workpackage</label>\n";
	echo "<select name=\"assign_dependencies_workpackage\">\n";

	for($i=0;$i<sizeof($a);$i++){
		echo "\t<option value=\"".$a[$i]['workpackageid']."\">".$a[$i]['fpw']."</option>\n";
	}

	echo "</select><br/>\n";
	echo "<label for=\"assign_dependencies\">Depends on</label>\n";
	echo "<select name=\"assign_dependencies_dependson\">\n";

	for($i=0;$i<sizeof($a);$i++){
		echo "\t<option value=\"".$a[$i]['workpackageid']."\">".$a[$i]['fpw']."</option>\n";
	}

	echo "</select><br/>\n";
	echo "<input name=\"cmd\" value=\"linkselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"submit\" type=\"submit\"/>\n";
	echo "</form>\n";

	return true;
}
/* HS1 */
function form_select_link(){

	global $debug;
	global $thisPage;

	if($debug['functions']){
		$thisFunction ="form_select_link()";
		echo_functionname($thisFunction);
	}

	echo "<form name=\"select_link\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<label for=\"link_table\">Assign Manager to: </label>\n";
	echo "<select name=\"link_table\">\n";
	echo "<option value=\"f\">Portfolio</option>";
	echo "<option value=\"p\">Project</option>";
	echo "<option value=\"w\">Workpackage</option>";
	echo "</select><br/>\n";
	echo "<input name=\"cmd\" value=\"linkselected\" type=\"hidden\"/>\n";
	echo "<input name=\"submit\" value=\"submit\" type=\"submit\"/>\n";
	echo "</form>\n";

	return true;
}

/* HS1 */
function validate_internal_external_values(){

	global $debug;
	global $errors;


	if($debug['functions']){
		$thisFunction ="validate_internal_external_values()";
		echo_functionname($thisFunction);
	}
/*
 * EXTERNAL dependson values must be 158 (12.0.0)
 * INTERNAL dependency values must have external id of 29
 * */

	$map=array(0,0,0);
	# 000 = External
	# 111 = Internal
	# 011 -> change to Internal

	if(($_POST['internal_external']=='E')){
		$map[0]=0;
	}else{
		$map[0]=1;
	}
	if(($_POST['dependson']==158)){
		$map[1]=0;
	}else{
		$map[1]=1;
	}
	if(($_POST['externalid']!=29)){
		$map[2]=0;
	}else{
		$map[2]=1;
	}

	if($debug['data']){
		showdebug($map,'data');
	}

	if(($map[0]==$map[1])&&($map[0]==$map[2])){

		if($map[0]=1){
		#	echo "INTERNAL";
			$retval=true;
		}else{
		#	echo "EXTERNAL";
			$retval=true;
		}
	}
	else if(($map[0]==0)&&($map[1]==1)&&($map[2]==1)){
	#Here we consider that the user has mistakenly selected 'E' when they meant to select 'I'	
		$_POST['internal_external']='I';
		#echo "INTERNAL";
		$retval=true;
	}
	else if(($map[0]==0)&&($map[1]==0)&&($map[2]==1)){
	#Here we consider that the user has forgotten to specify 'Eurostar' so we helpfully correct the problem
		$_POST['externalid']=29;
		$retval=true;
	}
	else{
		#echo "ERROR";
		$retval=false;
	}

	return $retval;
}

/* HS1 */
function process_post_for_dates($table,$templateid,$insert){

	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction ="process_post_for_dates(table:[".$table."],templateid:[".$templateid."]),insert:[".$insert."]";
		echo_functionname($thisFunction);
	}

	$yyyy="0000";
	$mm="00";
	$dd="00";

	$return_data=array();

	if($debug['post']){
		showdebug($_POST,'post');
	}
	if($debug['table']){
		showdebug($table,'tabl');
	}

	#if($insert){
	#	$ret=validate_internal_external_values();
#
#		if(!$ret){
#			return false;
#		}
#	}

	for($i=0;$i<sizeof($table['attributes']);$i++){

		if(isset($table['attributes'][$i]['def'])&&($table['attributes'][$i]['def']=="DATE")){

			$yyyy=$_POST[$table['attributes'][$i]['name']."_yyyy"];
			$mm=$_POST[$table['attributes'][$i]['name']."_mm"];
			$dd=$_POST[$table['attributes'][$i]['name']."_dd"];

			if(($yyyy=="")||($mm=="")||($dd=="")){
				# ignore this one	
				if($debug['data']){
					showdebug($errors['0009'],'para');
				}
				$return_data[$table['attributes'][$i]['name']]='NULL';

			}else{
				$return_data[$table['attributes'][$i]['name']]=sprintf("%s-%s-%s",$yyyy,$mm,$dd);

				if($debug['variables']){
					echo "<p>".$i.": ";
					echo $yyyy."-".$mm."-".$dd." ";
					echo $table['name']." ";
					echo $table['attributes'][$i]['name'];
					echo " ";
					echo $table['attributes'][$i]['def'];
					echo "</p>\n";
				}
			}
		}
		else if(isset($table['attributes'][$i]['def'])&&($table['attributes'][$i]['def']=="BOOLEAN")){
			if(isset($_POST[$table['attributes'][$i]['name']])&&($_POST[$table['attributes'][$i]['name']]=="on")){
				$return_data[$table['attributes'][$i]['name']]=$_POST[$table['attributes'][$i]['name']];
			}
			else{
				$return_data[$table['attributes'][$i]['name']]='NULL';
			}
			
		}
		else{
			if(isset($_POST[$table['attributes'][$i]['name']])&&($_POST[$table['attributes'][$i]['name']]=="")){
				$return_data[$table['attributes'][$i]['name']]='NULL';
			}
			else{
				$return_data[$table['attributes'][$i]['name']]=$_POST[$table['attributes'][$i]['name']];
			}
		}
		#if(strstr($post[$i], "_mm")){
		#	$mm=$post[$i];
		#	echo $mm;
		#}
		#if(strstr($post[$i], "_dd")){
		#	$dd=$post[$i];
		#	echo $dd;
		#}

	}

	return $return_data;
}

function insert_error_page($arg){

	global $thisPage;
	global $debug;

	if($debug['functions']){
		$thisFunction ="insert_error_page()";
		echo_functionname($thisFunction);
	}

	echo "<h1>The data submitted is incorrect</h1>\n";
	echo "<p>Please go <a href=\"".$thisPage."\">back</a> and check the ".$arg."</p>\n";

	return true;
}

function completion($message){

	global $thisPage;
	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction ="completion()";
		echo_functionname($thisFunction);
	}

	echo $message; 
	echo "<a href=\"".$thisPage."\">back</a>\n";

	return true;
}

/* HS1 */
function build_insert_query($table,$data){

	global $thisPage;
	global $mysql;
	global $debug;

	if($debug['functions']){
		$thisFunction ="build_insert_query(table,data)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data,'data');
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	$sql=sprintf("INSERT INTO `%s` VALUES (%s ",
		$table['name'], 
		quote_smart($data[$table['attributes'][0]['name']])
	);

	for($i=1;$i<sizeof($table['attributes']);$i++){

		$sql=sprintf("%s, %s",
			$sql,
			quote_smart($data[$table['attributes'][$i]['name']])
		);
	}					
	
	$sql=sprintf("%s);", $sql);

	/* Close the MySQL link opened for the mysql_real_escape_string function */
	mysql_close($link);

	return $sql;
}
/* HS1 */
function build_update_query($table,$data){

	global $thisPage;
	global $debug;
	global $mysql;

	$datavalue="";

	$pkeylen=0;

	if($debug['functions']){
		$thisFunction ="build_update_query(table,data)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data,'data');
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	$sql=sprintf("UPDATE `%s` SET ",
		$table['name'] 
	);

	$cols=sizeof($table['attributes']);
	

	for($i=0;$i<$cols;$i++){
		if($data[$table['attributes'][$i]['name']]=='NULL'){
			$datavalue="";
		}else{
			$datavalue=$data[$table['attributes'][$i]['name']];
			#quote_smart($datavalue);
		}

		if(isset($table['attributes'][$i]['key'])&&($table['attributes'][$i]['key']==true)){
			# item is part of the primary key of 
			# the table therefore do not add it 
			# as part of the insert data - skip it instead
			;
			$pkeylen++;
		}else if($i+1==$cols){


			$sql=sprintf("%s %s=%s",
				$sql,
				$table['attributes'][$i]['name'],
				#$data[$table['attributes'][$i]['name']]
				quote_smart($datavalue)
			);
			
		}else{
			$sql=sprintf("%s %s=%s, ",
				$sql,
				$table['attributes'][$i]['name'],
				#$data[$table['attributes'][$i]['name']]
				quote_smart($datavalue)
			);
		}
	}					
	
	$sql=sprintf("%s WHERE `%s`=%s", 
		$sql, 
		$table['pkey'][0],
		quote_smart($data[$table['pkey'][0]]));

	for($i=1;$i<$pkeylen;$i++){
		$sql=sprintf("%s AND `%s`=%s ", 
			$sql, 
			$table['pkey'][$i],
			quote_smart($data[$table['pkey'][$i]]));
	}

	$sql=sprintf("%s;", $sql);

	/* Close the MySQL link opened for the mysql_real_escape_string function */
	mysql_close($link);

	return $sql;
}

/* HS1 */
function build_update_view_query($view,$data){

	global $thisPage;
	global $debug;
	global $tables;
	global $tables_array;
	global $mysql;
	

	$pkeylen=0;

	if($debug['functions']){
		$thisFunction ="build_update_view_query(view,data)";
		echo_functionname($thisFunction);
	}

	if($debug['view']){
		showdebug($view,'view');
	}
	if($debug['data']){
		showdebug($data,'data');
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	$sql=sprintf("UPDATE `%s` SET ",
		$view['name'] 
	);

	#$cols=sizeof($tables[$tables_array[$view]]['attributes']);
	

	for($i=0;$i<$cols;$i++){

		if(isset( $tables[$tables_array[$view]]['attributes'][$i]['key'])&&
			( $tables[$tables_array[$view]]['attributes'][$i]['key'])){
			# item is part of the primary key of 
			# the view therefore do not add it 
			# as part of the insert data - skip it instead
			;
			$pkeylen++;
		}else if($i+1==$cols){
			$sql=sprintf("%s %s=%s",
				$sql,
				$tables[$tables_array[$view]]['attributes'][$i]['name'],
				quote_smart($data[$tables[$tables_array[$view]]['attributes'][$i]['name']])
			);
		}else{
			$sql=sprintf("%s %s=%s, ",
				$sql,
				$tables[$tables_array[$view]]['attributes'][$i]['name'],
				quote_smart($data[$view['attributes'][$i]['name']])
			);
		}
	}					
	
	#$sql=sprintf("%s WHERE `%s`='%s'", 
	#	$sql, 
	#	$view['pkey'][0],
	#	$data[$view['pkey'][0]]);

	#for($i=1;$i<$pkeylen;$i++){
	#	$sql=sprintf("%s AND `%s`='%s' ", 
	#		$sql, 
	#		$view['pkey'][$i],
	#		$data[$view['pkey'][$i]]);
	#}

	$sql=sprintf("%s;", $sql);

	/* Close the MySQL link opened for the mysql_real_escape_string function */
	mysql_close($link);

	return $sql;
}

/* HS1 */
function display_selected_view_record($view,$params){

	global $mysql;
	global $thisPage;
	global $debug;
	global $mysql_mode;
	global $tables;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="display_selected_view_record(view,params)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($view,'view');
	}
	if($debug['params']){
		showdebug($params,'para');
	}

	$len=sizeof($view['attributes']);
	
	$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s' ",
		$view['basetables']['a']['name'], 
		$view['basetables']['a']['key'][0], 
		$params[0]
	);

	for($i=1;$i<sizeof($view['basetables']['a']['key']);$i++){
		$sql=sprintf("%s AND %s='%s' ", 
			$sql,$view['basetables']['a']['key'][$i],
			$params[$i]);
	}

	#$sql=sprintf("%s;", $sql);

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$data=mysql_data($sql,$mysql_mode['assoc']);

	if($debug['data']){
		showdebug($data,'data');
	}

	echo "<fieldset>\n<legend>selected record from ".$view['basetables']['a']['name']." table</legend>\n";

	echo "<dl>\n";

	for($i=0;$i<sizeof($tables[0]['attributes']);$i++){

		echo "<dt>".$tables[0]['attributes'][$i]['label']."</dt>\n";

		if($data[0][$tables[0]['attributes'][$i]['name']]==""){
			echo	"<dd>&nbsp;</dd>\n";
		}else{
			echo	"<dd>".$data[0][$tables[0]['attributes'][$i]['name']]."</dd>\n";
		}

	}

	echo "</dl>";

	echo "</fieldset>\n";

	return true;
}


/* HS1 */
function display_selected_record($table,$params){

	global $mysql;
	global $thisPage;
	global $debug;
	global $mysql_mode;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="display_selected_record(table,params)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['params']){
		showdebug($params,'para');
	}

	$len=sizeof($table['attributes']);
	
	$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s' ",$table['name'], $table['pkey'][0], $params[0]);

	for($i=1;$i<sizeof($table['pkey']);$i++){
		$sql=sprintf("%s AND %s=%s ", $sql,$table['pkey'][$i],$params[$i]);
	}

	#$sql=sprintf("%s;", $sql);

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$data=mysql_data($sql,$mysql_mode['assoc']);

	if($debug['data']){
		showdebug($data,'data');
	}

	echo "<fieldset>\n<legend>selected record from ".$table['name']." table</legend>\n";

	echo "<dl>\n";

	for($i=0;$i<sizeof($table['attributes']);$i++){

		echo "<dt>".$table['attributes'][$i]['label']."</dt>\n";

		if($data[0][$table['attributes'][$i]['name']]==""){
			echo	"<dd>&nbsp;</dd>\n";
		}else{
			echo	"<dd>".$data[0][$table['attributes'][$i]['name']]."</dd>\n";
		}

	}

	echo "</dl>";

	echo "</fieldset>\n";

	return TRUE;
}

/* HS1 */
function process_table_operations($table,$templateid){

	global $mysql;
	global $thisPage;
	global $debug;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="process_table_operations(table,templateid)";
		echo_functionname($thisFunction);
	}
	
	if($debug['general']){
		echo "<p>operation <i>".$_GET['operation']."</i> selected</p>\n";
	}

	if($debug['get']){
		showdebug($_GET,'get');
	}
	if(isset($_GET['delete'])){
		if($_GET['delete']=="true"){

			echo "<p>Deleting record ".$_GET['id']." from table ".$table['name']."</p>\n";	
			echo "<a href=\"".$thisPage."\">back</a>\n";	

			$string=sprintf("WHERE %s=%s ", $table['pkey'][0], $_GET[$table['pkey']['0']]);
			for($i=1;$i<sizeof($table['pkey']);$i++){
				$string=sprintf("%s AND %s=%s ", $string,$table['pkey'][$i],$_GET[$table['pkey'][$i]]);
			}
			$sql="DELETE FROM `".$table['name']."` ".$string." ";

			if($debug['sql']){
				showdebug($sql,'sql');
			}

			mysql_data($sql,$mysql_mode['assoc']);

		}elseif($_GET['delete']=="false"){

			echo "<p>NOT Deleting record ".$_GET['id']." from table ".$table['name']."</p>";	
		}
	}else if(isset($_GET['update'])&&($_GET['update']=="true")){
		;
	}else if(isset($_GET['view'])&&($_GET['view']=="true")){
		;
	}else{
		get_selected_record($table,$templateid,$_GET);
	}
	return true;
}

/* HS1 */
function process_view_operations($view,$templateid){

	global $mysql;
	global $mysql_mode;
	global $thisPage;
	global $debug;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="process_view_operations(view,templateid)";
		echo_functionname($thisFunction);
	}
	
	if($debug['general']){
		echo "<p>operation <i>".$_GET['operation']."</i> selected</p>\n";
	}

	if($debug['params']){
		showdebug($_GET,'get');
	}
	if(isset($_GET['delete'])){
		if($_GET['delete']=="true"){

			if(isset($_GET['id'])){
				echo "<p>Deleting record ".$_GET['id']."</p>";	
			}else if(isset($_GET['workpackageid'])){
				echo "<p>Deleting record ";
				echo $_GET['workpackageid'];
				echo "-";
				echo $_GET['dependson'];
				echo "-";
				echo $_GET['dependid'];
				echo " from ".$view['basetables']['a']['name']."</p>\n";	
			}

			echo "<a href=\"".$thisPage."\">back</a>\n";	

			$string=sprintf("WHERE %s=%s ", $view['basetables']['a']['key'][0], 
				$_GET[$view['basetables']['a']['key'][0]]);
			for($i=1;$i<sizeof($view['basetables']['a']['key']);$i++){
				$string=sprintf("%s AND %s=%s ", 
					$string,
					$view['basetables']['a']['key'][$i],
					$_GET[$view['basetables']['a']['key'][$i]]
				);
			}
			$sql="DELETE FROM `".$view['basetables']['a']['name']."` ".$string." ";

			if($debug['sql']){
				showdebug($sql,'sql');
			}


			mysql_data($sql,$mysql_mode['assoc']);

		}elseif($_GET['delete']=="false"){
			if(isset($_GET['id'])){
				echo "<p>NOT deleting record ".$_GET['id']."</p>\n";	
			}else if(isset($_GET['workpackageid'])){
				echo "<p>NOT deleting record ";
				echo $_GET['workpackageid'];
				echo "-";
				echo $_GET['dependson'];
				echo "-";
				echo $_GET['dependid'];
				echo " from ".$view['basetables']['a']['name']."</p>\n";	
			}
			echo "<a href=\"".$thisPage."\">back</a>\n";	
		}
	}else if(isset($_GET['update'])&&($_GET['update']=="true")){
		echo "<p>UPDATE</p>";
		;
	}else if(isset($_GET['view'])&&($_GET['view']=="true")){
		echo "<p>VIEW</p>";
		;
	}else{
		get_selected_view_record($view,$templateid);
	}

	return true;
}

/* HS1 */
function generate_update_form($table,$templateid,$params){

	global $mysql;
	global $mysql_mode;
	global $thisPage;
	global $debug;
	global $date_format;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="generate_update_form(table,templateid,params)";
		echo_functionname($thisFunction);
	}

	if($debug['params']){
		showdebug($params,'para');
	}
	if($debug['table']){
		showdebug($table,'tabl');
	}

	$len=sizeof($table['attributes']);
	
	$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s' ",$table['name'], $table['pkey'][0], $params[0]);

	for($i=1;$i<sizeof($table['pkey']);$i++){
		$sql=sprintf("%s AND %s=%s ", $sql,$table['pkey'][$i],$params[$i]);
	}

	#$sql=sprintf("%s;", $sql);

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$data=mysql_data($sql,$mysql_mode['assoc']);

	if($debug['data']){
		showdebug($data,'data');
	}

	echo "<form name=\"update-".$table['name']."-record\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>update ".$table['name']." table</legend>\n";

	for($i=0;$i<sizeof($table['attributes']);$i++){
		$xsplit=array('');
		$optionslist=array('');
		
		echo "<p>\n";
		echo "<label for=\"".$table['attributes'][$i]['name']."\">".$table['attributes'][$i]['label']."</label>\n";
		if(isset($table['attributes'][$i]['key'])&&($table['attributes'][$i]['key']==true)){
			
			# DON'T MAKE ALLOW EDITABLE IF PART OF PKEY
			#echo "<dt>".$table['attributes'][$i]['label']."</dt>\n";
			#echo "<dt>Primary Key element: </dt>\n";
			echo "&nbsp;<strong>".$data[0][$table['attributes'][$i]['name']]."</strong>\n";
			echo "<input type=\"hidden\" name=\"".$table['attributes'][$i]['name']."\" value=\"".$data[0][$table['attributes'][$i]['name']]."\" />\n";

		}else if(strstr($table['attributes'][$i]['inputtype'],"select")){
			echo "<select name=\"".$table['attributes'][$i]['name']."\">\n";	
				$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$table['attributes'][$i]['options']);
				#print_r($optionslist);
				for($j=0;$j<sizeof($optionslist);$j++){
					if($optionsvalues[$j]==$data[0][$table['attributes'][$i]['name']]){
						echo "\t<option value=\"".$optionsvalues[$j]."\" selected>".$optionslist[$j]."</option>\n";
					}else{	
						echo "\t<option value=\"".$optionsvalues[$j]."\">".$optionslist[$j]."</option>\n";
					}
				}	
			echo "</select>\n";
		}else if(strstr($table['attributes'][$i]['inputtype'],"textarea")){
			$itemname=$table['attributes'][$i]['name'];
			echo "<textarea name=\"".$table['attributes'][$i]['name']."\">\n";	
				echo $data[0][$table['attributes'][$i]['name']];
			echo "</textarea>\n";
			$itemname="";
		}else if(strstr($table['attributes'][$i]['inputtype'],"date")){
			$itemname=$table['attributes'][$i]['name'];
			list($yyyy,$mm,$dd)=split('[/.-]',$data[0][$table['attributes'][$i]['name']]);	
			
			#echo "<p>";
			#echo "</p>";

			#date_selector($itemname,"digits",1,1,1,$yyyy,$mm,$dd);
		
			select_date($itemname,"YYYY-Mmm-DD",$data[0][$table['attributes'][$i]['name']]);

			$itemname="";
		}else if(strstr($table['attributes'][$i]['inputtype'],"radio")){
			$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
			$optionslist=explode(":", $xsplit[1]);
			$optionsvalues=explode(":",$table['attributes'][$i]['options']);
			$itemname=$table['attributes'][$i]['name'];
			radio_selector($itemname,$optionslist,$optionsvalues);
			$itemname="";
		}else{
			echo "<input type=\"".$table['attributes'][$i]['inputtype']."\" name=\"".$table['attributes'][$i]['name']."\" value=\"".$data[0][$table['attributes'][$i]['name']]."\"/>";
			#echo $data[0][$table['attributes'][$i]['name']];
		}
		echo "\n<br/>\n</p>\n";
	}
	echo "<p>";
	echo "<input name=\"templateid\" type=\"hidden\" value=\"".$templateid."\"/>\n";
	echo "<input name=\"update\" type=\"hidden\" value=\"true\"/>\n";
	echo "<input name=\"cmd\" type=\"submit\" value=\"submit\"/>\n";
	echo "<input name=\"clear\" type=\"reset\" value=\"reset\"/>\n";

	echo "</p>\n";
	echo "</fieldset>\n";
	echo "</form>\n";

	echo "<br/>";
	echo "<br/>";

	return TRUE;
}

function get_ppw_sql($viewname,$workpackageid){

	global $thisPage;
	global $debug;
	global $mysql;
	global $mysql_mode;

	if($debug['functions']){
		$thisFunction ="get_ppw_sql(viewname:[".$viewname."],workpackageid:[".$workpackageid."])";
		echo_functionname($thisFunction);
	}
	$get_ppw_sql=sprintf("SELECT portfolio,project,ref,name,info FROM `viewworkpackages` where id='%d'", $workpackageid);

	if($debug['sql']){
		showdebug($get_ppw_sql,'sql');
	}
	#$result=mysql_data($get_ppw_sql);
	$data=mysql_data($get_ppw_sql,$mysql_mode['assoc']);

	return $data;
}

/* HS1 */
function generate_update_view_form($view,$templateid,$params,$basetable){

	global $mysql;
	global $mysql_mode;
	global $thisPage;
	global $debug;
	global $date_format;
	

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="generate_update_view_form(view,templateid:[".$templateid."],params,basetable:[".$basetable['name']."])";
		echo_functionname($thisFunction);
	}

	if($debug['params']){
		showdebug($params,'para');
	}
	if($debug['view']){
		showdebug($view,'tabl');
	}
	if($debug['get']){
		showdebug($_GET,'get');
	}

	$len=sizeof($view['attributes']);
	
	$sql=sprintf("SELECT * FROM `%s` WHERE %s='%s' ",
		$view['basetables']['a']['name'], 
		$view['basetables']['a']['key'][0], 
		$params[0]
	);

	for($i=1;$i<sizeof($view['basetables']['a']['key']);$i++){
		$sql=sprintf("%s AND %s=%s ", $sql,$view['basetables']['a']['key'][$i],$params[$i]);
	}
	

	#$sql=sprintf("%s;", $sql);

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$data=mysql_data($sql,$mysql_mode['assoc']);

	#echo "<p>".$view['name']."</p>";
	#echo "<p>".$data[0][$basetable['attributes'][0]['name']]."</p>";

	$ppw_data_dependency=get_ppw_sql($view['name'], $data[0][$basetable['attributes'][0]['name']]);
	$ppw_data_dependency_supplier=get_ppw_sql($view['name'], $data[0][$basetable['attributes'][1]['name']]);

	if($debug['args']){
		showdebug($ppw_data_dependency,'args');
		showdebug($ppw_data_dependency_supplier,'args');
		#showdebug($data,'data');
	}

	echo "<form name=\"update-".$view['basetables']['a']['name']."-record\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>update ".$view['basetables']['a']['name']." view</legend>\n";

	for($i=0;$i<sizeof($basetable['attributes']);$i++){
		$xsplit=array('');
		$optionslist=array('');
		
		echo "<p>\n";
		echo "<label for=\"".$basetable['attributes'][$i]['name']."\">".$basetable['attributes'][$i]['label']."</label>\n";
		if(isset($basetable['attributes'][$i]['key'])&&($basetable['attributes'][$i]['key']==true)){

			# Here put the data from the $ppw_data_dependency SQL query:
			if($i==0){
					echo "<input type=\"hidden\" name=\"workpackageid\" value=\"".$_GET['workpackageid']."\"/>\n";
					echo "&nbsp;<strong>".$ppw_data_dependency[0]['portfolio'].".".$ppw_data_dependency[0]['project'].".".$ppw_data_dependency[0]['ref']." : ".$ppw_data_dependency[0]['info'].", ".$ppw_data_dependency[0]['name'].".</strong>\n";
			}else if($i==1){
					echo "<input type=\"hidden\" name=\"dependson\" value=\"".$_GET['dependson']."\"/>\n";
					echo "&nbsp;<strong>".$ppw_data_dependency_supplier[0]['portfolio'].".".$ppw_data_dependency_supplier[0]['project'].".".$ppw_data_dependency_supplier[0]['ref']." : ".$ppw_data_dependency_supplier[0]['info'].", ".$ppw_data_dependency_supplier[0]['name'].".</strong>\n";
			}else if($i==2){
					echo "&nbsp;<strong>".$ppw_data_dependency[0]['portfolio'].".".$ppw_data_dependency[0]['project'].".".$ppw_data_dependency[0]['ref']." - ";

				# DON'T ALLOW fields to be EDITABLE IF PART OF PKEY!!! that does not make any sense at all!
				#echo "<dt>".$view['attributes'][$i]['label']."</dt>\n";
				#echo "<dt>Primary Key element: </dt>\n";
				echo $data[0][$basetable['attributes'][$i]['name']]."</strong>\n";
				echo "<input type=\"hidden\" name=\"".$basetable['attributes'][$i]['name']."\" value=\"".$data[0][$basetable['attributes'][$i]['name']]."\" />\n";
			}else{
				;
			}

		}else if(strstr($basetable['attributes'][$i]['inputtype'],"select")){
			echo "<select name=\"".$basetable['attributes'][$i]['name']."\">\n";	
				$xsplit=explode("/",$basetable['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$basetable['attributes'][$i]['options']);
				#print_r($optionslist);
				for($j=0;$j<sizeof($optionslist);$j++){
					if($optionsvalues[$j]==$data[0][$basetable['attributes'][$i]['name']]){
						echo "\t<option value=\"".$optionsvalues[$j]."\" selected>".$optionslist[$j]."</option>\n";
					}else{	
						echo "\t<option value=\"".$optionsvalues[$j]."\">".$optionslist[$j]."</option>\n";
					}
				}	
			echo "</select>\n";
		}else if(strstr($basetable['attributes'][$i]['inputtype'],"textarea")){
			$itemname=$basetable['attributes'][$i]['name'];
			echo "<textarea name=\"".$basetable['attributes'][$i]['name']."\">\n";	
				echo $data[0][$basetable['attributes'][$i]['name']];
			echo "</textarea>\n";
			$itemname="";
		}else if(strstr($basetable['attributes'][$i]['inputtype'],"date")){
			$itemname=$basetable['attributes'][$i]['name'];
			list($yyyy,$mm,$dd)=split('[/.-]',$data[0][$basetable['attributes'][$i]['name']]);	
			
			#echo "<p>";
			#echo "</p>";

			#date_selector($itemname,"digits",1,1,1,$yyyy,$mm,$dd);
		
			#select_date_blank($itemname,"YYYY-Mmm-DD",$data[0][$basetable['attributes'][$i]['name']]);
			#select_date_blank($itemname,"YYYY-MM-DD",$data[0][$basetable['attributes'][$i]['name']]);
			select_date_or_blank($itemname,"YYYY-Mmm-DD",$data[0][$basetable['attributes'][$i]['name']]);

			$itemname="";
		}else if(strstr($basetable['attributes'][$i]['inputtype'],"radio")){
			$xsplit=explode("/",$basetable['attributes'][$i]['inputtype']);
			$optionslist=explode(":", $xsplit[1]);
			$optionsvalues=explode(":",$basetable['attributes'][$i]['options']);
			$itemname=$basetable['attributes'][$i]['name'];
			radio_selector($itemname,$optionslist,$optionsvalues);
			$itemname="";
		}else{
			echo "<input type=\"".$basetable['attributes'][$i]['inputtype']."\" name=\"".$basetable['attributes'][$i]['name']."\" value=\"".$data[0][$basetable['attributes'][$i]['name']]."\"/>";
			#echo $data[0][$basetable['attributes'][$i]['name']];
		}
		echo "<br/>\n</p>\n";
		#echo "\n</p>\n";
		
	}
	echo "<p>";
	echo "<input name=\"templateid\" type=\"hidden\" value=\"".$templateid."\"/>\n";
	echo "<input name=\"update\" type=\"hidden\" value=\"true\"/>\n";
	echo "<input name=\"table\" type=\"hidden\" value=\"".$view['basetables']['a']['name']."\"/>\n";
	echo "<input name=\"cmd\" type=\"submit\" value=\"submit\"/>\n";
	echo "<input name=\"clear\" type=\"reset\" value=\"reset\"/>\n";

	echo "</p>\n";
	echo "</fieldset>\n";
	echo "</form>\n";

	echo "<br/>";
	echo "<br/>";

	return TRUE;
}

/* HS1 */
function get_selected_record($table,$templateid,$data){

	global $debug;
	global $errors;
	global $thisPage;

	if($debug['functions']){
		$thisFunction="get_selected_record(table,templateid,data)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data,'data');
	}

	$pkeylen=sizeof($table['pkey']);
	$parameters="";
	$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$data['templateid'],$table['pkey'][0],$data[$table['pkey'][0]]);
	$parameter_array=array();
	$parameter_array[]=$data[$table['pkey'][0]];
	# *** DUNCAN *** Be careful here - the pkey values are taken as the first 'n' items in the row 
	# Not necessarily the ACTUAL pkey values...! Not ideal, and needs to be addressed
	# in next version
	for($k=1;$k<$pkeylen;$k++){
		$parameters=sprintf("%s&amp;%s=%s",
			$parameters,
			$table['pkey'][$k],
			$data[$table['pkey'][$k]]

		);
		$parameter_array[]=$data[$table['pkey'][$k]];
	}

	if($debug['variables']){
		showdebug($parameters,'vars');
	}


	/* Decide what to do based on the 
	 * selected "operation" from the 
	 * submitted data 
	 * */	

	#echo "<p>";
	if($data['operation']=="delete"){
		if($debug['general']){	
			echo "Operation selected is DELETE<br/>\n";
		}	
		echo "<p>";
		echo "Are you sure you want to delete record  ".$data[$table['pkey'][0]]." from ".$table['name']."?</p>\n";
		echo "<p>";
		echo "<a href=\"".$thisPage."?operation=delete&amp;delete=true".$parameters."\">Yes</a> | <a href=\"".$thisPage."?operation=delete&amp;delete=false".$parameters."\">No</a>\n";
		echo "</p>";
	}else if($data['operation']=="view"){
		if($debug['general']){	
			echo "Operation is SELECT<br/>\n";
		}
		display_selected_record($table,$parameter_array);

	}else if($data['operation']=="update"){
		if($debug['general']){	
			echo "Operation is UPDATE<br/>\n";
		}
		generate_update_form($table,$templateid,$parameter_array);
	}

	#$sql=sprintf("%s * FROM %s WHERE %s=%s;",
	#	$data['operation'],
	#	$table['name'],
	#	$table['attributes'][0]['name'],
	#	$data['pkey0']);

	#mysql_data($sql);
	#echo $sql;
	#echo "</p>\n";

	return true;	
}


/* HS1 */
function get_selected_view_record($view,$templateid){

	global $debug;
	global $errors;
	global $thisPage;
	global $tables;

	if($debug['functions']){
		$thisFunction="get_selected_view_record(view,templateid)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['get']){
		showdebug($_GET,'get');
	}

	$pkeylen=sizeof($view['basetables']['a']['key']);
	$parameters="";
	$parameters=sprintf("&amp;table=%s&amp;templateid=%s&amp;%s=%s",
		$view['basetables']['a']['name'],
		$_GET['templateid'],
		$view['basetables']['a']['key'][0],
		$_GET[$view['basetables']['a']['key'][0]]
	);
	$parameter_array=array();
	$parameter_array[]=$_GET[$view['basetables']['a']['key'][0]];
	# *** DUNCAN *** Be careful here - the pkey values are taken as the first 'n' items in the row 
	# Not necessarily the ACTUAL pkey values...! Not ideal, and needs to be addressed
	# in next version
	for($k=1;$k<$pkeylen;$k++){
		$parameters=sprintf("%s&amp;%s=%s",
			$parameters,
			$view['basetables']['a']['key'][$k],
			$_GET[$view['basetables']['a']['key'][$k]]
		);
		$parameter_array[]=$_GET[$view['basetables']['a']['key'][$k]];
	}

	if($debug['variables']){
		showdebug($parameters,'vars');
	}

	/* Decide what to do based on the 
	 * selected "operation" from the 
	 * submitted data 
	 * */	

	#echo "<p>";
	if($_GET['operation']=="delete"){
		if($debug['general']){	
			echo "Operation selected is DELETE<br/>\n";
		}	
		echo "<p>";
		echo "Are you sure you want to delete this record from the ".$view['basetables']['a']['name']." database?</p>\n";
		echo "<p>";

		if($debug['usedelform']){
			echo "<form id=\"delete_confirm\" action=\"".$thisPage."\" method=\"post\">\n";
			echo "<input type=\"hidden\" name=\"operation\" value=\"delete\"/>\n";
			echo "<input type=\"hidden\" name=\"delete\" value=\"true\"/>\n";
			echo "<input type=\"submit\" name=\"deletebutton\" value=\"yes\"/>\n";
			echo "<input type=\"reset\" name=\"nodeletebutton\" value=\"no\"/>\n";
			echo "</form>\n";
		}else{
			echo "<a href=\"".$thisPage."?operation=delete&amp;delete=true".$parameters."\">Yes</a> | ";
			echo "<a href=\"".$thisPage."?operation=delete&amp;delete=false".$parameters."\">No</a>\n";
		}
		echo "</p>";
	}else if($_GET['operation']=="view"){
		if($debug['general']){	
			echo "Operation is SELECT<br/>\n";
		}
		display_selected_view_record($view,$parameter_array);

	}else if($_GET['operation']=="update"){
		if($debug['general']){	
			echo "Operation is UPDATE<br/>\n";
		}

		generate_update_view_form(
			$view,
			$templateid,
			$parameter_array,
			$tables[0]
		);
	}

	return true;	
}

function display_table_rows_with_operations_rationalised($table,$templateid,$skip,$limit){

	global $thisPage;
	global $mysql;
	global $debug;
	global $errors;
	global $settings;
	global $displaylimit;
	global $limitrange;

	$pkeylen=0;

	if($debug['functions']){
		$thisFunction="display_table_rows_with_operations_rationalised(table,templateid,skip:[".$skip."],limit:[".$limit."])";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}

	if($settings['csv']){
		$file="db/".$table['name'].".csv";
		$handle=fopen($file,'w');
	}

	$recordcount=$showcount=$len=$linecount=0;

	$ret=array(0,0);

	if(isset($_SESSION['recordcount'])){
		$recordcount=$_SESSION['recordcount'];
	}

	skiplimit($templateid,$skip,$limit,$recordcount);

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql="";

	/* select only fields that are set as "show=1" */
	$len=sizeof($table['attributes']);

	for($i=0;$i<$len;$i++){
		if($table['attributes'][$i]['show']){
			$showcount++;
		}
	}
	if($debug['variables']){
		echo "<p>showcount:";
		echo $showcount;
		echo ", len:";
		echo $len;
		echo "<p>";
	}
	if($showcount==0){
		echo $errors['0005'];
		return (-1);
	}
	if($showcount==$len){

		
	#	$sqlcount=sprintf("SELECT count(*) FROM `%s` ", $table['name']);

		$sql=sprintf("SELECT * FROM `%s` ", $table['name']);
		if(isset($table['order'])&&($table['order'])){
			$sql=sprintf("%s ORDER BY %s ", $sql, $table['order']);
		}
		if(isset($table['limit'])&&($table['limit'])){
			$sql=sprintf("%s LIMIT %d, %d ", $sql, $skip,$limit);
		}
		$sql=sprintf("%s;", $sql);
	}else{
		$sql=sprintf("SELECT ");
		#$sqlcount=sprintf("SELECT count(*) ");

		for($i=0;$i<$len;$i++){
			if($debug['variables']){
				echo "<p>i:";
				echo $i; 
				echo " show:";
				echo $table['attributes'][$i]['show'];
				echo " len:"; 
				echo $len;
				echo " showcount:";
				echo $showcount;
				echo "</p>";
			}

			if($table['attributes'][$i]['show']){
				$showcount--;
				if($showcount==0){	
					#$sqlcount=sprintf("%s `%s` ", $sqlcount, $table['attributes'][$i]['name']);
					$sql=sprintf("%s `%s` ", $sql, $table['attributes'][$i]['name']);
				}else{
					#$sqlcount=sprintf("%s `%s` ", $sqlcount, $table['attributes'][$i]['name']);
					$sql=sprintf("%s `%s`, ", $sql, $table['attributes'][$i]['name']);
				}
			}
		}
		$sqlcount=sprintf("%s FROM `%s` ", 
			$sqlcount, 
			$table['name']
		);
		$sql=sprintf("%s FROM `%s` ", 
			$sql, 
			$table['name']
		);
		if(isset($_SESSION['sqlnolimit'])){
			$sql="";
			$sql=$_SESSION['sqlnolimit'];;
		}
		if(isset($table['order'])&&($table['order'])){
			$sql=sprintf("%s ORDER BY %s", $sql, $table['order']);
		}

		if(isset($table['limit'])&&($table['limit'])){

			$n=sizeof($limitrange)-2;
			if($limit=="ALL"){
				$limit=$displaylimit['maxlimit'];
			}
			if($limit>$limitrange[$n]){
				;	
			}else{
				$sql=sprintf("%s LIMIT %d, %d", $sql, $skip, $limit);
			}
		}

		#if(isset($table['limit'])&&($table['limit'])){
		#	$sql=sprintf("%s LIMIT %d, %d ", $sql, $displaylimit['skip'],$displaylimit['maxlimit']);
		#}

		#$sqlcount=sprintf("%s;", $sqlcount);
		#$sql=sprintf("%s;", $sql);
	}
	if($debug['sql']){
		showdebug($sql,'sql');
	}
	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}	

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());
	
	if(isset($data)&&($data)){	
		echo "<tbody>\n";

	}
	$linecount=0;
	if(isset($table['pkey'])){
		$pkeylen=sizeof($table['pkey']);
	}
	if($debug['variables']){
		echo "<p>Keylen: ";
		echo $pkeylen;
		echo "</p>";
	}
	for($i=0;$line = mysql_fetch_array($result, MYSQL_NUM);$i++){
		$len=sizeof($line);

		echo "<tr>";
		echo "<td>";

		$parameters="";
		if(isset($table['pkey'])){
			$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$templateid,$table['pkey'][0],$line[0]);
		}

		# *** DUNCAN *** Be careful here - the pkey values are taken as the first 'n' items in the row 
		# Not necessarily the ACTUAL pkey values...! Not ideal, and needs to be addressed
		# in next version
		if(isset($table['pkey'])){
			for($k=1;$k<$pkeylen;$k++){
				$parameters=sprintf("%s&amp;%s=%s",
					$parameters,
					$table['pkey'][$k],
					$line[$k]
				);
			}
		}
		$parameters=sprintf("%s&amp;%s=%s",$parameters,'templateid',$templateid);
		echo "<a href=\"".$thisPage."?operation=view".$parameters."\">view</a>";
		echo "</td> ";
		echo "<td>";
		echo "<a href=\"".$thisPage."?operation=update".$parameters."\">update</a>";
		echo "&nbsp;";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;";
		echo "<a href=\"".$thisPage."?operation=delete".$parameters."\">delete</a>";
		echo "</td>";

		for($j=0;$j<$len;$j++){
			if($table['name']=="dependencies"){
				if($table['attributes'][$j]['name']=="rag"){
					if($line[$j]=='Red'){
						echo "<td class=\"red\">";
					}else if($line[$j]=='Amber'){
						echo "<td class=\"amber\">";
					}else if($line[$j]=='Green'){
						echo "<td class=\"green\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="criticality"){
					if($line[$j]=='Y'){
						echo "<td class=\"critical\">";
					}else if($line[$j]=='N'){
						echo "<td class=\"noncritical\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="internal_external"){
					if($line[$j]=='I'){
						echo "<td class=\"internal\">";
					}else if($line[$j]=='E'){
						echo "<td class=\"external\">";
					}else{
						echo "<td>";
					}

				}else if($table['attributes'][$j]['name']=="acceptancedate"){
					if($line[$j]=='Matched'){
						echo "<td class=\"matched\">";
					}else if($line[$j]=='Unmatched'){
						echo "<td class=\"unmatched\">";
					}else if($line[$j]=='TBC'){
						echo "<td class=\"tbc\">";
					}else if($line[$j]=='Closed'){
						echo "<td class=\"closed\">";
					}else{
						echo "<td>";
					}

				}else{
					echo "<td>";
				}
			}else{
				echo "<td>";
			}
			echo $line[$j];
			echo "</td>";
			if($settings['csv']){
				fprintf($handle,"%s,", $line[$j]);
			}
		}
		#echo "<td>";
		#echo "</form>\n";
		#echo "</td>";
		echo "</tr>\n";
		$linecount++;
		if($settings['csv']){fprintf($handle,"\n");}
	}
	if(isset($data)&&($data)){	
		echo "</tbody>\n";
	}

	mysql_close($link);

	if($settings['csv']){
		fclose($handle);
	}

	$ret[0]=$len;
	$ret[1]=$linecount;


	return $ret;
}

/* HS1 */
function display_view_rows_with_operations_rationalised($view,$templateid,$keys,$skip,$limit){

	global $thisPage;
	global $mysql;
	global $debug;
	global $errors;
	global $settings;
	global $displaylimit;
	global $limitrange;

	$pkeylen=0;
	$grouplen=3;
	$groupcount=0;

	$blankValue=false;

	if($debug['functions']){
		$thisFunction="display_view_rows_with_operations_rationalised(view,templateid:[".$templateid."],skip:[".$skip."],limit:[".$limit."])";
		echo_functionname($thisFunction);
	}

	if($debug['view']){
		showdebug($view,'tabl');
	}
	if($debug['get']){
		showdebug($keys,'get');
	}

	if($settings['csv']){
		$file="db/".$view['name'].".csv";
		$handle=fopen($file,'w');
	}

	$recordcount=$showcount=$len=$linecount=0;

	$ret=array(0,0);

	if(isset($_SESSION['recordcount'])){
		$recordcount=$_SESSION['recordcount'];
	}

	skiplimit($templateid,$skip,$limit,$recordcount);

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql="";

	/* select only fields that are set as "show=1" */
	$len=sizeof($view['attributes']);

	for($i=0;$i<$len;$i++){
		if($view['attributes'][$i]['show']){
			$showcount++;
		}
	}
	if($debug['variables']){
		echo "<p>showcount:";
		echo $showcount;
		echo ", len:";
		echo $len;
		echo "<p>";
	}
	if($showcount==0){
		echo $errors['0005'];
		return (-1);
	}
	#	if($showcount==$len){


	if(isset($_SESSION['sqlnolimit'])){
		$sql="";
		$sql=$_SESSION['sqlnolimit'];
	}
	else{	
		$sql=sprintf("SELECT * FROM `%s`", $view['name']);
	}

	if(isset($view['order'])&&($view['order'])){
		$sql=sprintf("%s ORDER BY %s", $sql, $view['order']);
	}

	if(isset($view['limit'])&&($view['limit'])){

		$n=sizeof($limitrange)-2;
		if($limit=="ALL"){
			$limit=$displaylimit['maxlimit'];
		}
		if($limit>$limitrange[$n]){
			;	
		}else{
			$sql=sprintf("%s LIMIT %d, %d", $sql, $skip, $limit);
		}
	}
	#$sql=sprintf("%s;", $sql);
#	}else{
#		$sql=sprintf("SELECT ");
#
#		for($i=0;$i<$len;$i++){
#			if($debug['variables']){
#				echo "<p>i:";
#				echo $i; 
#				echo " show:";
#				echo $view['attributes'][$i]['show'];
#				echo " len:"; 
#				echo $len;
#				echo " showcount:";
#				echo $showcount;
#				echo "</p>";
#			}
#
#			if($view['attributes'][$i]['show']){
#				$showcount--;
#				if($showcount==0){	
#					$sql=sprintf("%s `%s` ", $sql, $view['attributes'][$i]['name']);
#				}else{
#					$sql=sprintf("%s `%s`, ", $sql, $view['attributes'][$i]['name']);
#				}
#			}
#		}
#		$sql=sprintf("%s FROM `%s` ", 
#			$sql, 
#			$view['name']
#		);
#		if(isset($view['order'])&&($view['order'])){
#			$sql=sprintf("%s ORDER BY %s ", $sql, $view['order']);
#		}
#		if(isset($view['limit'])&&($view['limit'])){
#			$sql=sprintf("%s LIMIT %d, %d ", $sql, $displaylimit['skip'],$displaylimit['maxlimit']);
#		}
#		$sql=sprintf("%s;", $sql);
#	}
	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}	

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	if(isset($data)&&($data)){	
		echo "<tbody>\n";
	}
	$linecount=0;
	if(isset($view['basetables']['a']['key'])){
		$pkeylen=sizeof($view['basetables']['a']['key']);
	}
	if($debug['variables']){
		echo "<p>Keylen: ";
		echo $pkeylen;
		echo "</p>";
	}
	for($i=0;$line = mysql_fetch_array($result, MYSQL_NUM);$i++){

		$len=sizeof($line);
		$odd_or_even = ($i % 2);

		echo "<tr class=\"linestyle_".$odd_or_even."\">";
		echo "<td>";

		$parameters="";
		if(isset($view['basetables']['a']['key'][0])){
			#$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$templateid,$view['basetables']['a']['key'][0],$line[0]);
		#}
		#if($keys){
			#$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$templateid,$keys[0],$line[0]);
			$parameters=sprintf("&amp;templateid=%s&amp;table=%s&amp;%s=%s",
				$templateid,
				$view['basetables']['a']['name'], 
				$view['basetables']['a']['key'][0],
				$line[0]
			);
		}

		# *** DUNCAN *** Be careful here - the pkey values are taken as the first 'n' items in the row 
		# Not necessarily the ACTUAL pkey values...! Not ideal, and needs to be addressed
		# in next version
		if(isset($view['basetables']['a']['key'][0])){
			for($k=1;$k<$pkeylen;$k++){
				$parameters=sprintf("%s&amp;%s=%s",
					$parameters,
					$view['basetables']['a']['key'][$k],
					$line[$k]
				);
			}
		}
		#$parameters=sprintf("%s&amp;%s=%s",$parameters,'templateid',$templateid);
		echo "<a href=\"".$thisPage."?operation=view".$parameters."\">view</a>";
		echo "&nbsp;";
		#echo "<br/>";
		#echo "<br/>";
		echo "</td> ";
		echo "<td>";
		echo "<a href=\"".$thisPage."?operation=update".$parameters."\">update</a>";
		echo "&nbsp;";
		#echo "<br/>";
		#echo "<br/>";
		echo "</td>";
		echo "<td>";
		echo "<a href=\"".$thisPage."?operation=delete".$parameters."\">delete</a>";
		echo "&nbsp;";
		echo "<br/>";
		echo "</td>";

		for($j=0;$j<$len;$j++){
			if(($view['name']=="viewdependenciesa")||
				($view['name']=="viewdependenciesb")||
				($view['name']=="viewdependenciesmonitor")||
				($view['name']=="viewdependenciesmonitora")||
				($view['name']=="viewdependenciesdelivered")){

				/* START */
				if($view['attributes'][$j]['show']==0){
					;	
				}else{
				# Blank certain values for clarity
				if($view['attributes'][$j]['inputtype']=="date"){
					if($line[$j]=='0000-00-00'){
						$blankValue=true;
					}
				}
				else if($line[$j]=="NULL"){
						$blankValue=true;
				}
				if($view['attributes'][$j]['name']=="externalsupplier"){
					if($line[$j]=='Eurostar'){
						$blankValue=true;
					}
				}
				if($view['attributes'][$j]['name']=="dependsonfid"){
					$blankFlag=false;
					if($line[$j]=='12'){
						$blankValue=true;
						$blankFlag=true;
					}
				}	
				if($view['attributes'][$j]['name']=="dependsonpid"){
					if(($line[$j]=='0')&&($blankFlag)){
						$blankValue=true;
						$blankFlag=true;
					}
				}	
				if($view['attributes'][$j]['name']=="dependsonwid"){
					if(($line[$j]=='0')&&($blankFlag)){
						$blankValue=true;
						$blankFlag=false;
					}
				}	
				if(isset($view['attributes'][$j]['group'])){
					
					if($groupcount==0){
						echo "<td colspan=\"".$grouplen."\""; # tag left open to allow for class attributes for colours etc!
					}
					$groupcount++;
				}else{
					$groupcount=0;
					echo "<td";
				} 
				/* END */

				if($view['attributes'][$j]['name']=="rag"){
					if($line[$j]=='Red'){
						echo " class=\"red\" ";
					}else if($line[$j]=='Amber'){
						echo " class=\"amber\" ";
					}else if($line[$j]=='Green'){
						echo " class=\"green\" ";
					}
					#echo ">";
					#echo $line[$j];
					#echo "</td>";
				}else if($view['attributes'][$j]['name']=="criticality"){
					if($line[$j]=='Y'){
						echo " class=\"critical\" ";
					}else if($line[$j]=='N'){
						echo " class=\"noncritical\" ";
					}
					#echo ">";
					#echo $line[$j];
					#echo "</td>";
				}else if($view['attributes'][$j]['name']=="internal_external"){
					if($line[$j]=='I'){
						echo " class=\"internal\" ";
					}else if($line[$j]=='E'){
						echo " class=\"external\" ";
					}

					#echo ">";
					#echo $line[$j];
					#echo "</td>";
				}else if($view['attributes'][$j]['name']=="acceptance"){
					if($line[$j]=='Matched'){
						echo " class=\"matched\" ";
					}else if($line[$j]=='Unmatched'){
						echo " class=\"unmatched\" ";
					}else if($line[$j]=='Closed'){
						echo " class=\"closed\" ";
					}else if($line[$j]=='TBC'){
						echo " class=\"tbc\" ";
					}
					#echo ">";
					#echo $line[$j];
					#echo "</td>";
				}else{
				# 	echo ">";
				#	echo $line[$j];
				#	echo "</td>";
				}
				if($blankValue){
					if(!$blankFlag){
						echo ">";
						echo "&nbsp;</td>";
					}else{
						;
					}
					$blankFlag=false;
					$blankValue=false;
				}else{
					if(isset($view['attributes'][$j]['group'])){
						if(($groupcount==1)){
							echo ">";
							#echo "<a href=\"".$thisPage."\" onMouseover=\"showtip(this,event,'Portfolio')\" onMouseout=\"hidetip()\";>\n";
							echo $line[$j];
							#echo "</a>";
						}else if(($groupcount>1)&&($groupcount<$grouplen)){
							echo ".";
							#echo "<a href=\"".$thisPage."\" onMouseover=\"showtip(this,event,'Project')\" onMouseout=\"hidetip()\";>\n";
							echo $line[$j];
							#echo "</a>";
						}else if($groupcount==$grouplen){
							echo ".";
							#echo "<a href=\"".$thisPage."\" onMouseover=\"showtip(this,event,'Workpackage')\" onMouseout=\"hidetip()\";>\n";
							echo $line[$j];
							$groupcount=0;
							#echo "</a>";
							echo "</td>\n";
						}
					}else{
						echo ">";
						echo $line[$j];
						echo "</td>\n";
					}
				}
			}
		}else{
			echo "<td>";
			echo $line[$j];
			echo "</td>";
		}

		if($settings['csv']){
			fprintf($handle,"%s,", $line[$j]);
		}
	}
		#echo "<td>";
		#echo "</form>\n";
		#echo "</td>";
		echo "</tr>\n";
		$linecount++;
		if($settings['csv']){fprintf($handle,"\n");}
	}
	if(isset($data)&&($data)){	
		echo "</tbody>\n";
	}

	mysql_close($link);

	if($settings['csv']){
		fclose($handle);
	}

	$ret[0]=$len;
	$ret[1]=$linecount;


	echo "<div id=\"tooltip\" style=\"position:absolute;visibility:hidden\"></div>\n";

	return $ret;
}

function display_view_rows_with_operations_rationalised_old($view,$templateid,$keys){

	global $thisPage;
	global $mysql;
	global $debug;
	global $errors;
	global $settings;
	global $displaylimit;

	$pkeylen=0;

	if($debug['functions']){
		$thisFunction="display_view_rows_with_operations_rationalised_old(view,templateid,keys)";
		echo_functionname($thisFunction);
	}

	if($debug['view']){
		showdebug($view,'tabl');
	}
	if($debug['get']){
		showdebug($keys,'get');
	}

	if($settings['csv']){
		$file="db/".$view['name'].".csv";
		$handle=fopen($file,'w');
	}

	$showcount=$len=$linecount=0;

	$ret=array(0,0);



	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql="";

	/* select only fields that are set as "show=1" */
	$len=sizeof($view['attributes']);

	for($i=0;$i<$len;$i++){
		if($view['attributes'][$i]['show']){
			$showcount++;
		}
	}
	if($debug['variables']){
		echo "<p>showcount:";
		echo $showcount;
		echo ", len:";
		echo $len;
		echo "<p>";
	}
	if($showcount==0){
		echo $errors['0005'];
		return (-1);
	}
#	if($showcount==$len){
		$sql=sprintf("SELECT * FROM `%s` ", $view['name']);
		if(isset($view['order'])&&($view['order'])){
			$sql=sprintf("%s ORDER BY %s ", $sql, $view['order']);
		}
		if(isset($view['limit'])&&($view['limit'])){
			$sql=sprintf("%s LIMIT %d, %d ", $sql, $displaylimit['skip'],$displaylimit['maxlimit']);
		}
		#$sql=sprintf("%s;", $sql);
#	}else{
#		$sql=sprintf("SELECT ");
#
#		for($i=0;$i<$len;$i++){
#			if($debug['variables']){
#				echo "<p>i:";
#				echo $i; 
#				echo " show:";
#				echo $view['attributes'][$i]['show'];
#				echo " len:"; 
#				echo $len;
#				echo " showcount:";
#				echo $showcount;
#				echo "</p>";
#			}
#
#			if($view['attributes'][$i]['show']){
#				$showcount--;
#				if($showcount==0){	
#					$sql=sprintf("%s `%s` ", $sql, $view['attributes'][$i]['name']);
#				}else{
#					$sql=sprintf("%s `%s`, ", $sql, $view['attributes'][$i]['name']);
#				}
#			}
#		}
#		$sql=sprintf("%s FROM `%s` ", 
#			$sql, 
#			$view['name']
#		);
#		if(isset($view['order'])&&($view['order'])){
#			$sql=sprintf("%s ORDER BY %s ", $sql, $view['order']);
#		}
#		if(isset($view['limit'])&&($view['limit'])){
#			$sql=sprintf("%s LIMIT %d, %d ", $sql, $displaylimit['skip'],$displaylimit['maxlimit']);
#		}
#		$sql=sprintf("%s;", $sql);
#	}
	if($debug['sql']){
		showdebug($sql,'sql');
	}
	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}	

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	if(isset($data)&&($data)){	
		echo "<tbody>\n";

	}
	$linecount=0;
	if(isset($view['basetables']['a']['key'])){
		$pkeylen=sizeof($view['basetables']['a']['key']);
	}
	if($debug['variables']){
		echo "<p>Keylen: ";
		echo $pkeylen;
		echo "</p>";
	}
	for($i=0;$line = mysql_fetch_array($result, MYSQL_NUM);$i++){
		$len=sizeof($line);

		echo "<tr>";
		echo "<td>";

		$parameters="";
		if(isset($view['basetables']['a']['key'][0])){
			#$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$templateid,$view['basetables']['a']['key'][0],$line[0]);
		#}
		#if($keys){
			#$parameters=sprintf("&amp;templateid=%s&amp;%s=%s",$templateid,$keys[0],$line[0]);
			$parameters=sprintf("&amp;templateid=%s&amp;table=%s&amp;%s=%s",
				$templateid,
				$view['basetables']['a']['name'], 
				$view['basetables']['a']['key'][0],
				$line[0]
			);
		}

		# *** DUNCAN *** Be careful here - the pkey values are taken as the first 'n' items in the row 
		# Not necessarily the ACTUAL pkey values...! Not ideal, and needs to be addressed
		# in next version
		if(isset($view['basetables']['a']['key'][0])){
			for($k=1;$k<$pkeylen;$k++){
				$parameters=sprintf("%s&amp;%s=%s",
					$parameters,
					$view['basetables']['a']['key'][$k],
					$line[$k]
				);
			}
		}
		#$parameters=sprintf("%s&amp;%s=%s",$parameters,'templateid',$templateid);
		echo "<a href=\"".$thisPage."?operation=view".$parameters."\">view</a>";
		echo "&nbsp;";
		#echo "<br/>";
		#echo "<br/>";
		echo "</td> ";
		echo "<td>";
		echo "<a href=\"".$thisPage."?operation=update".$parameters."\">update</a>";
		echo "&nbsp;";
		#echo "<br/>";
		#echo "<br/>";
		echo "</td>";
		echo "<td>";
		echo "<a href=\"".$thisPage."?operation=delete".$parameters."\">delete</a>";
		echo "&nbsp;";
		echo "<br/>";
		echo "</td>";

		for($j=0;$j<$len;$j++){
			if(($view['name']=="viewdependenciesa")||
				($view['name']=="viewdependenciesb")||
				($view['name']=="viewdependenciesmonitor")||
				($view['name']=="viewdependenciesmonitora")||
				($view['name']=="viewdependenciesdelivered")){
				if($view['attributes'][$j]['show']==0){
				
				}else if($view['attributes'][$j]['name']=="rag"){
					if($line[$j]=='Red'){
						echo "<td class=\"red\">";
					}else if($line[$j]=='Amber'){
						echo "<td class=\"amber\">";
					}else if($line[$j]=='Green'){
						echo "<td class=\"green\">";
					}else{
						echo "<td>";
					}
					echo $line[$j];
					echo "</td>";
				}else if($view['attributes'][$j]['name']=="criticality"){
					if($line[$j]=='Y'){
						echo "<td class=\"critical\">";
					}else if($line[$j]=='N'){
						echo "<td class=\"noncritical\">";
					}else{
						echo "<td>";
					}
					echo $line[$j];
					echo "</td>";
				}else if($view['attributes'][$j]['name']=="internal_external"){
					if($line[$j]=='I'){
						echo "<td class=\"internal\">";
					}else if($line[$j]=='E'){
						echo "<td class=\"external\">";
					}else{
						echo "<td>";
					}

					echo $line[$j];
					echo "</td>";
				}else if($view['attributes'][$j]['name']=="acceptancedate"){
					if($line[$j]=='Matched'){
						echo "<td class=\"matched\">";
					}else if($line[$j]=='Unmatched'){
						echo "<td class=\"unmatched\">";
					}else if($line[$j]=='Closed'){
						echo "<td class=\"closed\">";
					}else if($line[$j]=='TBC'){
						echo "<td class=\"tbc\">";
					}else{
						echo "<td>";
					}
					echo $line[$j];
					echo "</td>";
				}else{
					echo "<td>";
					echo $line[$j];
					echo "</td>";
				}

			}else{
				echo "<td>";
				echo $line[$j];
				echo "</td>";
			}

			if($settings['csv']){
				fprintf($handle,"%s,", $line[$j]);
			}
		}
		#echo "<td>";
		#echo "</form>\n";
		#echo "</td>";
		echo "</tr>\n";
		$linecount++;
		if($settings['csv']){fprintf($handle,"\n");}
	}
	if(isset($data)&&($data)){	
		echo "</tbody>\n";
	}

	mysql_close($link);

	if($settings['csv']){
		fclose($handle);
	}

	$ret[0]=$len;
	$ret[1]=$linecount;


	return $ret;
}

/* HS1 */
function display_table_with_operations($table,$templateid,$skip,$limit){

	global $debug;

	#echo "<h2>".$table['name']." ".$templateid."</h2>\n";
	echo "<h2>".$table['name']."</h2>\n";

	if($debug['functions']){
		$thisFunction="display_table_with_operations(table,templateid,skip[".$skip."],limit[".$limit."])";
		echo_functionname($thisFunction);
	}
	if($debug['table']){
		#showdebug($table,'tabl');
	}
	if($debug['args']){
		showdebug($templateid,'args');
	}

	if(!(isset($_SESSION['recordcount']))){
		$sqlz=sprintf("SELECT * FROM %s", $table['name']);
		$_SESSION['recordcount']=countrecords($sqlz,$table['name']);
	}

	$recordcount=$_SESSION['recordcount'];

	echo "<table>\n<thead>\n";
	echo "<tr>\n";

	echo "<th>View</th>";
	echo "<th>Edit</th>";
	echo "<th>Delete</th>";

	/* <tfoot> <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr> </tfoot> */

	/* only show fields selected as show=1 */

	for($i=0;$i<sizeof($table['attributes']);$i++){
		
		if($table['attributes'][$i]['show']){
			echo "<th>";
			echo $table['attributes'][$i]['label'];
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $table['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $table['attributes'][$i]['def'];
				
			}
			echo "</th>\n";
		}
	}
	#echo "<th>&nbsp;</th>\n";
	echo "</thead>\n";

	$result=display_table_rows_with_operations_rationalised($table,$templateid,$skip,$limit);

	echo "</table>\n";

	skiplimit($templateid,$skip,$limit,$recordcount);

	if($debug['variables']){
		if(isset($result)){
			if($result[0]!=0){ 
				echo "<p>Fields: ".$result[0]."</p>\n";
			}else{
				echo "<p>No fields</p>\n";
			}
			if($result[1]!=0){
				echo "<p>Records: ".$result[1]."</p>\n";
			}else{
				echo "<p>No records</p>\n";
			}
		}
	}
	return true;
}

/* HS1 */
function display_view_with_operations($view,$templateid,$skip,$limit){

	global $debug;

	$grouplen=3;
	$groupcount=0;
	$recordcount=0;

	$keys=array();

	if($debug['functions']){
		$thisFunction="display_view_with_operations(view,templateid:[".$templateid."],skip:[".$skip."],limit:[".$limit.")";
		echo_functionname($thisFunction);
	}

	#echo "<h2>".$view['name']." ".$templateid."</h2>\n";
	echo "<h2>".$view['label']."</h2>\n";
	$from=$skip+1;
	$to=($from+$limit)-1;
	#echo "<p>Showing records ".$from." to ".$to."</p>\n";

	if($debug['view']){
		#showdebug($view,'tabl');
	}
	if($debug['args']){
		showdebug($templateid,'args');
	}


	if(!(isset($_SESSION['recordcount']))){
		$_SESSION['recordcount']=countrecords($view['sql'],$view['name']);
	}

	$recordcount=$_SESSION['recordcount'];

	echo "<table>\n";
	echo "<thead>\n";
	echo "<tr>\n";

	echo "<th>View</th>";
	echo "<th>Update</th>";
	echo "<th>Delete</th>";

	/* <tfoot> <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr> </tfoot> */

	/* only show fields selected as show=1 */

	for($i=0;$i<sizeof($view['attributes']);$i++){
		
		if(isset($view['attributes'][$i]['show'])&&
			($view['attributes'][$i]['show']==1)){

			if(isset($view['attributes'][$i]['group'])){
				if($groupcount==0){
					echo "<th colspan=\"".$grouplen."\">";
				}
				$groupcount++;
			}else{
				#$groupcount=0;
				echo "<th>";
			}
			echo $view['attributes'][$i]['label'];
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $view['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $view['attributes'][$i]['def'];
				
			}
			if(isset($view['attributes'][$i]['group'])&&($groupcount<$grouplen)){
				echo "<br/>&nbsp;";

			}else{
				echo "</th>\n";	
				$groupcount=0;
			}

		}else if(isset($view['attributes'][$i]['show'])
				&&($view['attributes'][$i]['show']==0)){
			#echo "<th>";
			$keys[]=$view['attributes'][$i]['name'];	
			#echo "<input type=\"hidden\" name=\"".$view['attributes'][$i]['name']."/>";
			#echo $view['attributes'][$i]['label'];
			#echo "</th>\n";
		}
	}
	#echo "<th>&nbsp;</th>\n";
	echo "</tr>\n";
	echo "</thead>\n";
	$result=display_view_rows_with_operations_rationalised($view,$templateid,$keys,$skip,$limit);

	echo "</table>\n";

	skiplimit($templateid,$skip,$limit,$recordcount);

	if($debug['variables']){
		if(isset($result)){
			if($result[0]!=0){ 
				echo "<p>Fields: ".$result[0]."</p>\n";
			}else{
				echo "<p>No fields</p>\n";
			}
			if($result[1]!=0){
				echo "<p>Records: ".$result[1]."</p>\n";
			}else{
				echo "<p>No records</p>\n";
			}
		}
	}
	return true;
}

/* HS1 */
function insert_link_record($linktable,$data){

	global $debug;
	global $mysql;
	global $errors;
	global $mysql_mode;
	 
	if($debug['functions']){
		$thisFunction="insert_link_record(linktable,data)";
		echo_functionname($thisFunction);
	}


	#$created=date('Y-m-d H:i:s');
	#$lastaccess=date('Y-m-d H:i:s');
	#
	if($debug['data']){
		showtable($linktable);
		showtable($data);
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	$sql=sprintf("INSERT INTO `%s` (
		`%s`,
		`%s`) 
		VALUES(%s,%s)",
			$linktable['name'],
			$linktable['attributes'][0]['name'],
			$linktable['attributes'][1]['name'],
			quote_smart($data[$linktable['attributes'][0]['name']]),
			quote_smart($data[$linktable['attributes'][1]['name']])
		);

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	if($debug['dbOn']){

		if($retval=mysql_data($sql,$mysql_mode['assoc'])){
			$sql="";
			if($debug['sql']){
				echo "<p>database insert OK</p>";
			}
		}
	}
	else{
		echo "<p>Database is off</p>";
	}

	/* Close the MySQL link opened for the mysql_real_escape_string function */
	mysql_close($link);

	return true;
}


/* HS1 */
function view($view){

	global $debug;
	global $mysql;
	global $errors;
	 
	if($debug['functions']){
		$thisFunction="view(view)";
		echo_functionname($thisFunction);
	}

	$data=array();

	if($debug['table']){
		showdebug($view,'tabl');
	}

#	echo "<h2>".$view['label']."</h2>\n";

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql=$view['sql'];

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}

	mysql_close($link);

	return $data;
}
/* HS1 */
function action($action,$sql){

	global $debug;
	global $mysql;
	global $errors;
	 
	if($debug['functions']){
		$thisFunction="action(action,sql)";
		echo_functionname($thisFunction);
	}

	$data=array();

	if($debug['table']){
		showdebug($action,'tabl');
	}

	#echo "<h2>".$view['label']."</h2>\n";

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	if($debug['sql']){
		showdebug($sql,'sql');
	}

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}

	mysql_close($link);

	return $data;
}

/* HS1 */
function display_data($table,$data){
	
	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction="display_data(table,data)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data[0],'data');
	}

	$tablerowlen=sizeof($table['attributes']);
	$rowlen=sizeof($data[0]);
	$datalen=sizeof($data);

	if($rowlen==0){
		echo $errors['0001'];
		return (-1);
	}else if(($datalen!=0)&&($tablerowlen!=$rowlen)){
		echo $errors['0003'];
		return (-1);
	}else{ # all ok
		if($debug['sql']){
			echo "<p>";
			echo $datalen;
			echo " rows returned</p>\n";
		}
		echo "<table>\n";
		echo "<thead>\n";
		echo "<tr>";
		for($i=0;$i<$tablerowlen;$i++){
			echo "<th>";
			echo $table['attributes'][$i]['label'];
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $table['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $table['attributes'][$i]['def'];
			}
			echo "</th>";	
		}
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		for($i=0;$i<sizeof($data);$i++){
			echo "<tr>";
			for($j=0;$j<$rowlen;$j++){
				echo "<td>";
				echo $data[$i][$table['attributes'][$j]['name']];
				echo "</td>";
			}
			echo "</tr>\n";
		}
		echo "</tbody>\n";	
		echo "</table>\n";
		echo "<br/>\n";
		echo "<br/>\n";


	}
}

/* HS1 */
function display_data_simple($table,$data){
	
	global $debug;
	global $errors;

	$blankValue=false;

	if($debug['functions']){
		$thisFunction="display_data_simple(table,data)";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data[0],'data');
	}

	$tablerowlen=sizeof($table['attributes']);
	$rowlen=sizeof($data[0]);
	$datalen=sizeof($data);

	if($rowlen==0){
		echo $errors['0001'];
		return (-1);
	}else if(($datalen!=0)&&($tablerowlen!=$rowlen)){
		echo $errors['0003'];
		return (-1);
	}else{ # all ok
		if($debug['sql']){
			echo "<p>";
			echo $datalen;
			echo " rows returned</p>\n";
		}
		echo "<table>\n";
		echo "<thead>\n";
		echo "<tr>";
		for($i=0;$i<$tablerowlen;$i++){
			echo "<th>";
			echo $table['attributes'][$i]['label'];
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $table['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $table['attributes'][$i]['def'];
			}
			echo "</th>";	
		}
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";
		for($i=0;$i<sizeof($data);$i++){
			echo "<tr>";
			for($j=0;$j<$rowlen;$j++){
			if($table['name']=="viewdependenciesa"){
				if($table['attributes'][$j]['inputtype']=="date"){
					if($data[$i][$table['attributes'][$j]['name']]=='0000-00-00'){
						$blankValue=true;
					}
					#echo "<td>";
				}
				else if($data[$i][$table['attributes'][$j]['name']]=="NULL"){
						$blankValue=true;
					#echo "<td>";
				}
				if($table['attributes'][$j]['name']=="externalsupplier"){
					if($data[$i][$table['attributes'][$j]['name']]=='Eurostar'){
						$blankValue=true;
						#echo "<td>";
					}
					else{
						#echo "<td class=\"violet\">";

					}
				}
				if($table['attributes'][$j]['name']=="dependsonfid"){
					if($data[$i][$table['attributes'][$j]['name']]=='12'){
						$blankValue=true;
					}
				}
				if($table['attributes'][$j]['name']=="rag"){
					if($data[$i][$table['attributes'][$j]['name']]=='Red'){
						echo "<td class=\"red\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Amber'){
						echo "<td class=\"amber\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Green'){
						echo "<td class=\"green\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="criticality"){
					if($data[$i][$table['attributes'][$j]['name']]=='Y'){
						echo "<td class=\"violet\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='N'){
						echo "<td class=\"lemon\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="internal_external"){
					if($data[$i][$table['attributes'][$j]['name']]=='I'){
						echo "<td class=\"silver\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='E'){
						echo "<td class=\"blue\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="acceptance"){
					if($data[$i][$table['attributes'][$j]['name']]=='Matched'){
						echo "<td class=\"brown\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Unmatched'){
						echo "<td class=\"orange\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Closed'){
						echo "<td class=\"azure\">";
					}else{
						echo "<td>";
					}
				}else{
					echo "<td>";
				}
			}else if(($table['name']=="viewdependenciesmonitor")||
				($table['name']=="viewdependenciesmonitora")){
				if($table['attributes'][$j]['inputtype']=="date"){
					if($data[$i][$table['attributes'][$j]['name']]=='0000-00-00'){
						$blankValue=true;
					}
					#echo "<td>";
				}
				else if($data[$i][$table['attributes'][$j]['name']]=="NULL"){
						$blankValue=true;
					#echo "<td>";
				}
				if($table['attributes'][$j]['name']=="externalsupplier"){
					if($data[$i][$table['attributes'][$j]['name']]=='Eurostar'){
						$blankValue=true;
						#echo "<td>";
					}
					else{
						#echo "<td class=\"violet\">";

					}
				}
				if($table['attributes'][$j]['name']=="dependsonfid"){
					if($data[$i][$table['attributes'][$j]['name']]=='12'){
						$blankValue=true;
					}
				}
				if($table['attributes'][$j]['name']=="rag"){
					if($data[$i][$table['attributes'][$j]['name']]=='Red'){
						echo "<td class=\"red\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Amber'){
						echo "<td class=\"amber\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Green'){
						echo "<td class=\"green\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="criticality"){
					if($data[$i][$table['attributes'][$j]['name']]=='Y'){
						echo "<td class=\"violet\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='N'){
						echo "<td class=\"lemon\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="internal_external"){
					if($data[$i][$table['attributes'][$j]['name']]=='I'){
						echo "<td class=\"silver\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='E'){
						echo "<td class=\"blue\">";
					}else{
						echo "<td>";
					}
				}else if($table['attributes'][$j]['name']=="acceptance"){
					if($data[$i][$table['attributes'][$j]['name']]=='Matched'){
						echo "<td class=\"brown\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Unmatched'){
						echo "<td class=\"orange\">";
					}else if($data[$i][$table['attributes'][$j]['name']]=='Closed'){
						echo "<td class=\"azure\">";
					}else{
						echo "<td>";
					}
				}else{
					echo "<td>";
				}
			
			} else{
				echo "<td>";
			}
			if($blankValue){
				echo "&nbsp;";
				$blankValue=false;
			}else{
				echo $data[$i][$table['attributes'][$j]['name']];
			}
				echo "</td>";
			}
			echo "</tr>\n";
		}
		echo "</tbody>\n";	
		echo "</table>\n";
	}
}

function report($items){

	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction="report(items)";
		echo_functionname($thisFunction);
	}

	if($debug['params']){
		showdebug($items,'post');
	}

	echo "<h2>Dependency records:</h2>\n";
	#echo "<h3>";
	
	#for($i=0;$i<sizeof($items);$i++){
	#	if(isset($items[$i]['key'])){
	#		for($j=0;$j<sizeof($items[$i]['key']);$j++){
	#			echo "<strong>'".$items[$i]['key'][$j]['name']."'</strong>, ";
	#			echo "[<strong>'".$items[$i]['key'][$j]['value']."'</strong>]</p>\n";
	#		}
	#	}
	#	echo "'".$items[$i]['name']."', ";
	#	echo "['".$items[$i]['value']."']</p>\n";
	#}
	#echo "</h3>\n";

	return true;
}

function determine_lookup_direction(){

	global $debug;
	global $thisPage;
	global $limitrange;

	$newskip=0;
	$newlimit=0;

	$retval=array();

	if($debug['functions']){
		$thisFunction="determine_lookup_direction()";
		echo_functionname($thisFunction);
	}

	if(isset($_POST['next'])&&($_POST['next']=='>')){ 
		$direction='forward';
	}
	if(isset($_POST['prev'])&&($_POST['prev']=='<')){ 
		$direction='back';
	}

	if($debug['args']){
		showdebug($direction, 'args');
		showdebug($_SESSION, 'get');
	}

	if($direction=='forward'){
		$_SESSION['skip']=(($_SESSION['skip'])+($_SESSION['limit']));
	}else if($direction=='back'){
		$_SESSION['skip']=(($_SESSION['skip'])-($_POST['limit']));
		if($_SESSION['skip']<0){$_SESSION['skip']=0;}
	}

	if($_POST['limit']=='ALL'){
		$_POST['limit']='99999';
	}

	$_SESSION['limit']=$_POST['limit'];

	$newskip=$_SESSION['skip'];
	$newlimit=$_SESSION['limit'];

	if($newskip<0){$newskip=0;} // doesn't makes sense to have negative value here
	if($newlimit<=0){$newlimit=1;} // doesn't makes sense to have negative value here

	$retval[]=$newskip;
	$retval[]=$newlimit;

	if($debug['args']){
		showdebug($direction, 'args');
		showdebug($_SESSION, 'get');
	}


	return $retval;
}

function skiplimit($templateid,$skip,$limit,$recordcount){

	global $debug;
	global $errors;
	global $thisPage;
	global $limitrange;

	if($debug['functions']){
		$thisFunction="skiplimit(templateid:[".$templateid."],skip:[".$skip."],limit:[".$limit."],recordcount:[".$recordcount."])";
		echo_functionname($thisFunction);
	}

	#if($limit>$limitrange[sizeof($limitrange)-1]){
	#	$limit=6;
	#}

	#if($skip>$recordcount){
	#	$skip=0;
	#	$_SESSION['skip']=$skip;
	#}

	#echo "<br/>\n";
	echo "<form name=\"skiplimit_".$templateid."_".$skip."_".$limit."\" action=\"".$thisPage."\" method=\"post\">\n";
	#echo "<fieldset>\n<legend> Prev/Next </legend>\n";
	echo "<p>";
	echo "<input name=\"prev\" type=\"submit\" value=\"<\"/>\n";
	echo "<input name=\"next\" type=\"submit\" value=\">\"/>\n";
	echo "<label for=\"limit\" class=\"label\">Records per page ?</label>\n";
	echo "<select name=\"limit\">\n";
	for($i=0;$i<sizeof($limitrange);$i++){
		if($limitrange[$i]==$limit){
			echo "<option value=\"".$limitrange[$i]."\" selected >".$limitrange[$i]."</option>\n";
		}else{
			echo "<option value=\"".$limitrange[$i]."\">".$limitrange[$i]."</option>\n";
		}
	}
	echo "</select>\n";
	#echo "</p>";
	#echo "<br/>\n";
	#echo "<p>";
	#echo "<label class=\"smalllabel\" for=\"previous\">prev</label>\n";
	#echo "<input name=\"prev\" type=\"submit\" value=\"<\"/>\n";
	#echo "</p>\n";
	#echo "<br/>\n";
	#echo "<p>";
	#echo "<input name=\"next\" type=\"submit\" value=\">\"/>\n";
	#echo "<label class=\"smalllabel\" for=\"next\">next</label>\n";
	echo "</p>";
	echo "<input name=\"skip\" type=\"hidden\" value=\"".$skip."\"/>\n";
	echo "<input name=\"templateid\" type=\"hidden\" value=\"".$templateid."\"/>\n";
	echo "<input name=\"cmd\" type=\"hidden\" value=\"displaynextorprev\"/>\n";

	#echo "<input name=\"nextlimit\" type=\"hidden\" value=\"".$nextlimit.\"/>\n";

	#echo "</fieldset>\n";
	echo "</form>\n";
	echo "<br/>\n";

	$from=$skip+1;
	$to=($from+$limit)-1;

	if($recordcount>0){
		if($recordcount<$to){
			$to=$recordcount;
		}
		if($from>$recordcount){
			$from=$recordcount;
			echo "<p>No more records</p>\n";
		}else{
			echo "<p>Showing records ".$from." to ".$to." of ".$recordcount."</p>\n";
		}
	}
	else if($recordcount==0){
			echo $errors['0010'];
	}
	else{
		echo "<p>Showing records ".$from." to ".$to."</p>\n";
	}
	#echo "<br/>\n";

	return true;
}

/* HS1 */
function display_data_simple_new($table,$templateid,$data,$skip,$limit){
	
	global $debug;
	global $errors;

	$grouplen=3;
	$groupcount=0;
	$recordcount=0;

	$blankValue=false;

	if($debug['functions']){
		$thisFunction="display_data_simple_new(table,templateid,data,skip:[".$skip."],limit:[".$limit."])";
		echo_functionname($thisFunction);
	}

	if($debug['table']){
		showdebug($table,'tabl');
	}
	if($debug['data']){
		showdebug($data[0],'data');
	}

	$tablerowlen=sizeof($table['attributes']);
	$rowlen=sizeof($data[0]);
	$datalen=sizeof($data);

	if($rowlen==0){
		echo $errors['0001'];
		return (-1);
	}else if(($datalen!=0)&&($tablerowlen!=$rowlen)){
		echo $errors['0003'];
		return (-1);
	}else{ # all ok
		#if($debug['sql']){
			echo "<p>";
			echo $datalen;
			echo " dependencies</p>\n";
			#}
			#


		skiplimit($templateid,$skip,$limit,$recordcount);

		echo "<table>\n";
		echo "<thead>\n";
		echo "<tr>";
		for($i=0;$i<$tablerowlen;$i++){

			if(isset($table['attributes'][$i]['group'])){
				if($groupcount==0){
					echo "<th colspan=\"".$grouplen."\">";
				}
				$groupcount++;
			}else{
				echo "<th>";
			}
			echo $table['attributes'][$i]['label'];
			echo "<br/>";
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $table['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $table['attributes'][$i]['def'];
			}
			if(isset($table['attributes'][$i]['group'])&&($groupcount<$grouplen)){
				echo "&nbsp;";

			}else{
				echo "</th>\n";	
				$groupcount=0;
			}
		}
		echo "</tr>\n";
		echo "</thead>\n";
		echo "<tbody>\n";

		for($i=0;$i<sizeof($data);$i++){ # looping through rows

			echo "<tr>";
			for($j=0;$j<$rowlen;$j++){ # looping through columns

				if(($table['name']=="viewdependenciesa")||
					($table['name']=="viewdependenciesb")||
					($table['name']=="viewdependenciesmonitor")||
					($table['name']=="viewdependenciesmonitora")||
					($table['name']=="viewdependenciesdelivered")){
					
					# Blank certain values for clarity
					if($table['attributes'][$j]['inputtype']=="date"){
						if($data[$i][$table['attributes'][$j]['name']]=='0000-00-00'){
							$blankValue=true;
						}
					}
					else if($data[$i][$table['attributes'][$j]['name']]=="NULL"){
							$blankValue=true;
					}
					if($table['attributes'][$j]['name']=="externalsupplier"){
						if($data[$i][$table['attributes'][$j]['name']]=='Eurostar'){
							$blankValue=true;
						}
					}
					if($table['attributes'][$j]['name']=="dependsonfid"){
					#	if($data[$i][$table['attributes'][$j]['name']]=='12'){
					#		$blankValue=true;
					#	}
					}


					if(isset($table['attributes'][$j]['group'])){
						
						if($groupcount==0){
							echo "<td colspan=\"".$grouplen."\""; # tag left open to allow for class attributes for colours etc!
						}
						$groupcount++;
					}else{
						echo "<td";
					} 

					# Colours for specific columns and values:
					if($table['attributes'][$j]['name']=="rag"){
						if($data[$i][$table['attributes'][$j]['name']]=='Red'){
							echo " class=\"red\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='Amber'){
							echo " class=\"amber\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='Green'){
							echo " class=\"green\" ";
						}
						#echo ">"; // closes the TD cell
					}else if($table['attributes'][$j]['name']=="criticality"){
						if($data[$i][$table['attributes'][$j]['name']]=='Y'){
							echo " class=\"critical\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='N'){
							echo " class=\"noncritical\" ";
						}
						#echo ">"; // closes the TD cell
					}else if($table['attributes'][$j]['name']=="internal_external"){
						if($data[$i][$table['attributes'][$j]['name']]=='I'){
							echo " class=\"internal\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='E'){
							echo " class=\"external\" ";
						}
						#echo ">"; // closes the TD cell
					}else if($table['attributes'][$j]['name']=="acceptance"){
						if($data[$i][$table['attributes'][$j]['name']]=='Matched'){
							echo " class=\"matched\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='Unmatched'){
							echo " class=\"unmatched\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='Closed'){
							echo " class=\"closed\" ";
						}else if($data[$i][$table['attributes'][$j]['name']]=='TBC'){
							echo " class=\"tbc\" ";
						}
						#echo ">"; // closes the TD cell
					}else{
						#echo ">"; // closes the TD cell without having added a class attribute
					}
					
					# Now put the relevant value in the cell:
						

					if($blankValue){
						echo ">";
						echo "&nbsp;";
						$blankValue=false;
					}else{
						if(isset($table['attributes'][$j]['group'])){
							if(($groupcount==1)){
								echo ">";
								echo $data[$i][$table['attributes'][$j]['name']];
							}else if(($groupcount>1)&&($groupcount<$grouplen)){
								echo ".";
								echo $data[$i][$table['attributes'][$j]['name']];
							}else if($groupcount==$grouplen){
								echo ".";
								echo $data[$i][$table['attributes'][$j]['name']];
								$groupcount=0;
								echo "</td>\n";
							}
						}else{
							echo ">";
							echo $data[$i][$table['attributes'][$j]['name']];
							echo "</td>\n";
						}
						#echo $data[$i][$table['attributes'][$j]['name']];
					}

				/*	if(isset($table['attributes'][$j]['group'])){
						if(($groupcount==0)){
							#echo ">";
							echo "";	
						}
						if(($groupcount<$grouplen)){
							echo ".";	
						}
						else if($groupcount==$grouplen){
							echo "";	
							$groupcount=0;
							echo "</td>";
						}
					}else{
						echo "</td>";
					}
				 */
				} # End check for correct table 

			}
			echo "</tr>\n";
		}
		echo "</tbody>\n";	
		echo "</table>\n";

		skiplimit($templateid,$skip,$limit,$recordcount);
	}

	return true;
}

/* HS1 */
function radio_selector($name,$options,$values){
	# 
	# Creates a group of radio buttons
	# given an array of options
	#
	global $debug;
	if($debug['functions']){
		$thisFunction="radio_selector(name,options,values)";
		echo_functionname($thisFunction);
	}
	
	#echo "<fieldset>\n";
	#echo "<legend>".$name."</legend>\n";;
	
	echo "&nbsp;";
	for ($i=0;$i<sizeof($options);$i++){
		#echo "<label for=\"".$options[$i]."\" class=\"smalllabel\">".$options[$i]."</label><br/>";
		echo "<label class=\"radiolabel\">".$options[$i]."</label>";
		echo "<input type=\"radio\" name=\"".$name."\" value=\"".$values[$i]."\" class=\"smallinput\"/>";
		echo "<br/>\n";
	}
	#echo "</fieldset>\n";
}

/* HS1 */
function generate_form($table,$templateid,$pageid){

	global $mysql;
	global $debug;
	global $settings;
	global $thisPage;

	$visiblefieldcount=0;
	$itemname="";

	if($debug['functions']){
		$thisFunction ="generate_form(table,".$templateid.",".$pageid.")";
		echo_functionname($thisFunction);
	}

	$len=sizeof($table['attributes']);

	echo "<h1>".$thisPage." ".$table['name']."</h1>";

	echo "<form name=\"insert-".$table['name']."-record\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>".$table['name']."</legend>\n";

	for($i=0;$i<sizeof($table['attributes']);$i++){
		$xsplit=array('');
		$optionslist=array('');

		if($table['attributes'][$i]['show']==1){
			$visiblefieldcount++;
			echo "<p>\n";
			echo "<label for=\"".$table['attributes'][$i]['name']."\">".$table['attributes'][$i]['label']."</label>\n";
			if(strstr($table['attributes'][$i]['inputtype'],"select")){
				echo "<select name=\"".$table['attributes'][$i]['name']."\">\n";	
					$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
					$optionslist=explode(":", $xsplit[1]);
					$optionsvalues=explode(":",$table['attributes'][$i]['options']);

					#print_r($optionslist);
					for($j=0;$j<sizeof($optionslist);$j++){
						echo "\t<option value=\"".$optionsvalues[$j]."\">".$optionslist[$j]."</option>\n";
					}	
				echo "</select>\n";
			}else if(strstr($table['attributes'][$i]['inputtype'],"textarea")){
				$itemname=$table['attributes'][$i]['name'];
				echo "<textarea name=\"".$table['attributes'][$i]['name']."\">\n";	
				echo "</textarea>\n";
				$itemname="";
			}else if(strstr($table['attributes'][$i]['inputtype'],"date")){
				$itemname=$table['attributes'][$i]['name'];
				#date_selector($itemname,"text",1,1,1,0,0,0);

				select_date_blank($itemname,"YYYY-Mmm-DD","1-1-1");

				$itemname="";
			}else if(strstr($table['attributes'][$i]['inputtype'],"radio")){
				$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$table['attributes'][$i]['options']);
				$itemname=$table['attributes'][$i]['name'];
				radio_selector($itemname,$optionslist,$optionsvalues);
				$itemname="";
			}else{
				echo "<input type=\"".$table['attributes'][$i]['inputtype']."\" name=\"".$table['attributes'][$i]['name']."\">\n";
			}
			echo "<br/></p>\n";
		}
	}
	#echo "<br/>";

	echo "<p>";

	echo "<input name=\"templateid\" type=\"hidden\" value=\"".$templateid."\"/>\n";
	echo "<input name=\"tablename\" type=\"hidden\" value=\"".$table['name']."\"/>\n";
	echo "<input name=\"pageid\" type=\"hidden\" value=\"".$pageid."\"/>\n";
	echo "<input name=\"cmd\" type=\"submit\" value=\"insert\"/>\n";
	echo "<input name=\"clear\" type=\"reset\" value=\"reset\"/>\n";

	echo "</p>\n";
	echo "</fieldset>\n";
	echo "</form>\n";



	echo "<br/>";
	echo "<br/>";

	if($debug['data']){
		if($visiblefieldcount < $i){
			echo "<p>[NB: ";
			echo $table['name'];
			echo " has ";
			echo $i-$visiblefieldcount;
			echo " hidden field(s)";
			echo "]</p>";
		}
	}

	return true;
}

/* HS1 */
function link_tables($tablea,$tableb,$linktable){

	global $mysql;
	global $debug;

	if($debug['functions']){
		$thisFunction="link_tables(tablea,tableb,linktable)";
		echo_functionname($thisFunction);
	}
	return true;
}

function form_assign_link($from,$to,$linktable){

	global $mysql;
	global $debug;

	if($debug['functions']){
		$thisFunction="form_assign_link(from,to,linktable)";
		echo_functionname($thisFunction);
	}

	if($debug['general']){	
		echo "<p>>>> link from: ";
		echo $from['name'];
		echo " to ";
		echo $to['name'];
		echo " writing to: ";
		echo $linktable['name'];
		echo "</p>\n";
	}
	#generate_form($linktable);
	//DUNCAN
	#form_link($from);
	$fromdata=db_lookup_multiple($from);
	$todata=db_lookup_multiple($to);

	#display_data($from,$fromdata);
	#display_data($to,$todata);
	
	#display_table($from);
	#display_table($to);
	
	#form_link($to);
	#
	assign___($fromdata,$todata,$linktable);

	return true;
}


/* HS1 */
function assign___($data1,$data2,$linktable){

	global $mysql;
	global $debug;
	global $errors;
	global $thisPage;

	if($debug['functions']){
		$thisFunction="assign___(data1,data2,linktable)";
		echo_functionname($thisFunction);
	}

	#$a=array();
	#$b=array();

	#$a=view($data1);
	#$b=view($views[1]);

	if($debug['table']){
		showdebug($linktable,'tabl');
	}

	echo "<form name=\"form_".$linktable['name']."\" action=\"".$thisPage."\" method=\"post\">\n";
	echo "<fieldset>\n<legend>".$linktable['name']."</legend>\n";

		echo "<label for=\"".$linktable['attributes'][0]['name']."\">".$linktable['attributes'][0]['label']."</label>\n";
		echo "<select name=\"".$linktable['attributes'][0]['name']."\">\n";

		echo "\t<option value=\"0\"> - </option>\n";

		for($i=0;$i<sizeof($data1);$i++){
			echo "\t<option value=\"".$data1[$i]['id']."\">"
				#.$a[$i]['requestor']." "
				#.$a[$i]['supplier']." "
				.$data1[$i]['id']." - "
				.$data1[$i]['firstname']." "
				.$data1[$i]['lastname']."</option>\n";
		}
		echo "</select><br/>\n";
		#echo "<input name=\"requestor\" type=\"text\"/><br/>\n";
		#echo "<label for=\"portfolios\">Portfolios</label>\n";
		echo "<label for=\"".$linktable['attributes'][1]['name']."\">".$linktable['attributes'][1]['label']."</label>\n";
		echo "<select name=\"".$linktable['attributes'][1]['name']."\">\n";
		echo "\t<option value=\"0\"> - </option>\n";
		for($i=0;$i<sizeof($data2);$i++){
			if(strstr($linktable['name'], "workpackage")){
				echo "\t<option value=\"".$data2[$i]['id']."\">"
					.$data2[$i]['id'].", "
					#.$data2[$i]['projectid'].", "
					.$data2[$i]['workpackage'].", "
					.$data2[$i]['workpackagename']."</option>\n";
			}else if(strstr($linktable['name'], "project")){
				echo "\t<option value=\"".$data2[$i]['id']."\">"
					.$data2[$i]['id'].", "
					.$data2[$i]['portfolioid'].", "
					.$data2[$i]['project'].", "
					.$data2[$i]['projectname']."</option>\n";
			}else {
				echo "\t<option value=\"".$data2[$i]['id']."\">"
					.$data2[$i]['id'].", "
					.$data2[$i]['name']."</option>\n";
			}
		}
		echo "</select>\n";
		#echo "<input name=\"supplier\" type=\"text\"/><br/>\n";
		echo "<input name=\"cmd\" type=\"hidden\" value=\"link\"/><br/>\n";
		echo "<input name=\"submit\" type=\"submit\" value=\"submit\"/>\n";
		echo "<input name=\"reset\" type=\"reset\" value=\"reset\"/><br/>\n";

	echo "</fieldset>\n";
	echo "</form>\n";	

	return true;
}

/* HS1 */
function assign_dependencies(){

	global $mysql;
	global $debug;
	global $errors;
	global $thisPage;

	global $views;
	global $tables;

	if($debug['functions']){
		$thisFunction="assign_dependencies()";
		echo_functionname($thisFunction);
	}

	$a=array();
	$b=array();

	$a=view($views[1]);
	#$b=view($views[1]);
	$b=$a;

	if($debug['data']){
		showdebug($a,'data');
	}
	echo "<table>";
	echo "<tr>\n";	
	echo "<form name=\"assignDependencies\" action=\"".$thisPage."\" method=\"post\">\n";

	echo "<td>";
	echo "<label for=\"requestor\">Requestor</label>\n";
		#echo "<select name=\"requestor\" id=\"\" class=\"\">\n";
		for($i=0;$i<sizeof($a);$i++){
		#	echo "\t<option value=\"".$a[$i]['id']."\">"
				#.$a[$i]['requestor']." "
				#.$a[$i]['supplier']." "
		#		.$a[$i]['seq']." "
			#		.$a[$i]['dependency']."</option>\n";
		echo "<input type=\"radio\" name=\"requestor\" value=\"".$a[$i]['id']."\"/>".$a[$i]['id']." ".$a[$i]['dependency']."<br/>\n";
		}
		#echo "</select>";
		#echo "<input name=\"requestor\" type=\"text\"/><br/>\n";
		echo "</td><td>";
		echo "<label for=\"supplier\">Supplier</label>\n";
		#echo "<select name=\"supplier\" id=\"\" class=\"\">\n";
		for($i=0;$i<sizeof($a);$i++){
		#echo "\t<option value=\"".$a[$i]['id']."\">"
		#		.$a[$i]['seq']." "
		#		.$a[$i]['dependency']."</option>\n";
		echo "<input type=\"radio\" name=\"supplier\" value=\"".$a[$i]['id']."\"/>".$a[$i]['id']." ".$a[$i]['dependency']."<br/>\n";
		}
		#echo "</select>";
		#echo "<input name=\"supplier\" type=\"text\"/><br/>\n";
		echo "<input name=\"cmd\" type=\"hidden\" value=\"submit\"/>\n";
		echo "<input name=\"submit\" type=\"submit\" value=\"submit\"/>\n";

	echo "</td></tr></form></table>\n";	

	return true;
}

/* HS1 */
function assign_manager_to_project(){

	global $mysql;
	global $debug;

	if($debug['functions']){
		$thisFunction="assign_manager_to_project()";
		echo_functionname($thisFunction);
	}
	return true;
}

function get_table_data($tableid){

	global $debug;
	global $mysql;
	global $tables;

	$data=array();

	if($debug['functions']){
		$thisFunction="get_table_data(tableid:[".$tableid."])";
		echo_functionname($thisFunction);
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql="";

	/* select only fields that are set as "show=1" */
	$len=sizeof($tables[$tableid]['attributes']);

	$sql=sprintf("SELECT * FROM %s", $tables[$tableid]['name']);
	
	if($tables[$tableid]['order']){
		$sql=sprintf("%s ORDER BY %s;", $sql, $tables[$tableid]['order']);

	}
#	else{
#		$sql=sprintf("%s;", $sql);
#	}

	if($debug['sql']){
		showdebug($sql,'sql');
	}
	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}	

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	mysql_close($link);

	return $data;
}

/* HS1 */
function display_table_rows($table){

	global $mysql;
	global $debug;
	global $settings;
	global $errors;

	if($debug['functions']){
		$thisFunction="display_table_rows(table)";
		echo_functionname($thisFunction);
	}

	$showcount=$len=$linecount=0;

	$ret=array(0,0);

	/* Write csv file of all data in tables to <name>.csv if configured to do so */
	if($settings['csv']){
		$file="db/".$table['name'].".csv";
		$handle=fopen($file,'w');
	}

	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password'])
		or die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database ' . mysql_error());

	$sql="";

	/* select only fields that are set as "show=1" */
	$len=sizeof($table['attributes']);

	for($i=0;$i<$len;$i++){
		if($table['attributes'][$i]['show']){
			$showcount++;
		}
	}
	if($debug['variables']){
		echo "<p>showcount:";
		echo $showcount;
		echo ", len:";
		echo $len;
		echo "<p>";
	}
	if($showcount==0){
		echo $errors['0004'];
		return (-1);
	}
	if($showcount==$len){
		$sql=sprintf("SELECT * FROM `%s` ", $table['name']);
	}else{
		$sql=sprintf("SELECT ");

		if($debug['table']){
			showdebug($table,'tabl');
		}

		for($i=0;$i<$len;$i++){
			if($debug['variables']){
				echo "<p>i:";
				echo $i; 
				echo " show:";
				echo $table['attributes'][$i]['show'];
				echo " len:"; 
				echo $len;
				echo " showcount:";
				echo $showcount;
				echo "</p>";
			}

			if($table['attributes'][$i]['show']){
				$showcount--;
				if($showcount==0){	
					$sql=sprintf("%s `%s` ", $sql, $table['attributes'][$i]['name']);
				}else{
					$sql=sprintf("%s `%s`, ", $sql, $table['attributes'][$i]['name']);
				}
			}
		}
		$sql=sprintf("%s FROM `%s` ", 
			$sql, 
			$table['name']
		);
	}
	# ORDER BY
	if($table['order']){
		$sql=sprintf("%s ORDER BY %s;", $sql, $table['order']);

	}else{
		$sql=sprintf("%s;", $sql);
	}

	if($debug['sql']){
		showdebug($sql,'sql');
	}
	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	for($i=0;($line = mysql_fetch_array($result, MYSQL_ASSOC));$i++) {
		$data[$i]=$line;
	}	

	$result = mysql_query($sql) or die('Query failed: '.mysql_error());

	if(!empty($data)){	
		echo "<tbody>\n";
	}

	while ( $line = mysql_fetch_array($result, MYSQL_NUM)){
		$linecount++;
		$len=sizeof($line);
		echo "<tr>";
		for($i=0;$i<sizeof($line);$i++){
			echo "<td>".$line[$i]."</td>";
			if($settings['csv']){
				fprintf($handle,"%s,", $line[$i]);
			}
		}
		if($settings['csv']){fprintf($handle,"\n");}
		echo "</tr>\n";
	}
	if(!empty($data)){	
		echo "</tbody>\n";
	}

	mysql_close($link);

	$ret[0]=$len;
	$ret[1]=$linecount;

	if($settings['csv']){
		fclose($handle);
	}

	return $ret;
}

/* HS1 */
function display_table($table){

	global $debug;

	echo "<h2>".$table['name']."</h2>\n";

	if($debug['functions']){
		$thisFunction="display_table(table)";
		echo_functionname($thisFunction);
	}

	$i=0;

	echo "<table>\n<thead>\n";
	echo "<tr>\n";

	/* <tfoot> <tr> <td>&nbsp;</td> <td>&nbsp;</td> </tr> </tfoot> */

	/* only show fields selected as show=1 */

	for($i=0;$i<sizeof($table['attributes']);$i++){

		if($table['attributes'][$i]['show']){
			echo "<th>";
			echo $table['attributes'][$i]['label'];
			if($debug['attributetypes']){
				echo "<br/>\n";
				echo $table['attributes'][$i]['name'];
				echo "<br/>\n";
				echo $table['attributes'][$i]['def'];
			}
			echo "</th>\n";
		}
	}
	echo "</thead>\n";

	$result=display_table_rows($table);

	echo "</table>\n";

	if($debug['variables']){
		if(isset($result)){
			if($result[0]!=0){ 
				echo "<p class=\"vars\">Fields: ".$result[0]."</p>\n";
			}else{
				echo "<p class=\"vars\">No fields</p>\n";
			}
			if($result[1]!=0){
				echo "<p class=\"vars\">Records: ".$result[1]."</p>\n";
			}else{
				echo "<p class=\"vars\">No records</p>\n";
			}
		}
	}
	return true;
}

/* HS1 */
function generate_create_views_script($views_definition){
	
	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction="generate_create_views_script(views_definition)";
		echo_functionname($thisFunction);
	}

	$file="db/create_views.sql";
	#$file="create_views.sql";

	$string=array('','','','');

	$handle=fopen($file,'w');

	echo "<h1>Writing ".$file."</h1>";

	for($i=0;$i<sizeof($views_definition);$i++){	
		if($debug['table']){
			showdebug($views_definition[$i],'tabl');
		}

		echo "<h2>table: ".$views_definition[$i]['name']."</h2>\n";
		#$sql="SELECT a.id,a.portfolio, a.project, a.workpackage, a.name, b.firstname, b.lastname\n\tFROM projects a,managers b, manager_project c\n\tWHERE a.id=c.projectid\n\tAND b.id=c.managerid\n\tORDER by a.id;";

		$string[0]=sprintf("CREATE OR REPLACE VIEW `%s` AS\n\t%s", 
			$views_definition[$i]['name'],
			$views_definition[$i]['sqlx']);
		fprintf($handle,"%s\n\n", $string[0]);
		$string[0]="";
		echo "<p class=\"scr\">";

		for($j=0;$j<sizeof($views_definition[$i]['attributes']);$j++){
			echo " ".$views_definition[$i]['attributes'][$j]['name']." ";
			#echo " [".$views_definition[$i]['attributes'][$j]['def']."] ";
			#echo " [".$views_definition[$i]['attributes'][$j]['label']."] ";
			echo " [".$views_definition[$i]['attributes'][$j]['show']."] ";
			#echo " [".$views_definition[$i]['attributes'][$j]['inputtype']."] ";
			#$string[1]=sprintf("`%s` ", $views_definition[$i]['attributes'][$j]['name']);
			#$string[2]=sprintf("%s,", $views_definition[$i]['attributes'][$j]['def']);
			#preg_replace("\`","\'",$string[2]);
			#fprintf($handle,"\t%s %s\n", $string[1], $string[2]);
			#$string[1]="";
			#$string[2]="";
		}
		echo " ";
		if(isset($views_definition[$i]['basetables'])){
			for($j=0;$j<sizeof($views_definition[$i]['basetables']);$j++){
				echo $views_definition[$i]['basetables'][$j];
				echo ", ";
			}
		}
		echo "\n\n";
		#echo " OR: ".$views_definition[$i]['basetables']."\n";
		echo "</p>\n";

		#$string[3]=sprintf("\tPRIMARY KEY (`%s`",$views_definition[$i]['pkey'][0]);
		
		#for($j=1;$j<sizeof($views_definition[$i]['pkey']);$j++){
		#	$string[3]=sprintf("%s, `%s`",$string[3], $views_definition[$i]['pkey'][$j]);
		#}	

		#$string[3]=sprintf("%s)\n)\nENGINE=%s;\n",$string[3],$views_definition[$i]['engine']);
		#$string[3]=sprintf("%s)\n)\nENGINE=%s;\n",$string[0],$views_definition[$i]['engine']);

		#fprintf($handle,"%s\n", $string[3]);
		#$string[3]=""; 
	}

	fclose($handle);	
	echo "<p>".$file." written</p>";

	return true;
}
/* HS1 */
function generate_create_views_sql_commands($views){
	
	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction="generate_create_views_sql_commands(views)";
		echo_functionname($thisFunction);
	}

	echo "<h1>generating SQL create view script ".$file."</h1>";

	for($i=0;$i<sizeof($views);$i++){

		echo "<h2>table: ".$views[$i]['name']."</h2>\n";
		$sql=sprintf("CREATE OR REPLACE VIEW `%s` AS\n\t%s", 
			$views[$i]['name'],
			$views[$i]['sqlx']);

		echo "<p>";
		echo $sql;
		echo "</p>\n";

		$data=mysql_data($sql,$mysql_mode['assoc']);
	}

	echo "<p>SQL create view commands written ".$data."</p>";

	return true;
}
/* HS1 */
function generate_create_tables_script($tables_definition){
	
	global $debug;
	global $errors;

	if($debug['functions']){
		$thisFunction="generate_create_tables_script(tables_definition)";
		echo_functionname($thisFunction);
	}


	$path="\db\\create_tables.sql";
	$file="db/create_tables.sql";
	#$file=$path;
	#
	#
	$string=array('','','','');

	$handle=fopen($file,'w');

	echo "<h1>Writing ".$file."</h1>";

	for($i=0;$i<sizeof($tables_definition);$i++){	
		if($debug['table']){
			showdebug($tables_definition[$i],'tabl');
		}

		echo "<h2>table: ".$tables_definition[$i]['name']."</h2>\n";

		$string[0]=sprintf("DROP TABLE IF EXISTS `%s`;\n", $tables_definition[$i]['name']);
		fprintf($handle,"%s\n", $string[0]);
		$string[0]="";
		$string[0]=sprintf("CREATE TABLE `%s`(", $tables_definition[$i]['name']);
		fprintf($handle,"%s\n", $string[0]);
		$string[0]="";
		echo "<p class=\"scr\">";
		for($j=0;$j<sizeof($tables_definition[$i]['attributes']);$j++){
			echo " ".$tables_definition[$i]['attributes'][$j]['name']." ";
			echo " [".$tables_definition[$i]['attributes'][$j]['def']."] ";
			#echo " [".$tables_definition[$i]['attributes'][$j]['label']."] ";
			echo " [".$tables_definition[$i]['attributes'][$j]['show']."]<br/> ";
			#echo " [".$tables_definition[$i]['attributes'][$j]['inputtype']."] ";
			$string[1]=sprintf("`%s` ", $tables_definition[$i]['attributes'][$j]['name']);
			$string[2]=sprintf("%s,", $tables_definition[$i]['attributes'][$j]['def']);
			#preg_replace("\`","\'",$string[2]);
			fprintf($handle,"\t%s %s\n", $string[1], $string[2]);
			$string[1]="";
			$string[2]="";
		}
		echo " PKEY: ";
		for($j=0;$j<sizeof($tables_definition[$i]['pkey']);$j++){
			echo $tables_definition[$i]['pkey'][$j];
			echo ", ";
		}
		echo "\n";
		echo " ENGINE: ".$tables_definition[$i]['engine']."\n";
		echo "</p>\n";

		$string[3]=sprintf("\tPRIMARY KEY (`%s`",$tables_definition[$i]['pkey'][0]);
		
		for($j=1;$j<sizeof($tables_definition[$i]['pkey']);$j++){
			$string[3]=sprintf("%s, `%s`",$string[3], $tables_definition[$i]['pkey'][$j]);
		}

		$string[3]=sprintf("%s)\n)\nENGINE=%s;\n",$string[3],$tables_definition[$i]['engine']);

		fprintf($handle,"%s\n", $string[3]);
		$string[3]=""; 
	}

	fclose($handle);	
	echo "<p>".$file." written</p>";

	return true;
}

function mysql_data($query, $mode){

	global $mysql;
	global $debug;

	$data=array();

	if($debug['functions']){
		$thisFunction="mysql_data(query:[".$query."],mode:[".$mode."])";
		echo_functionname($thisFunction);
	}

	if($debug['mysqlvariables']){
		showdebug($mysql,'sql');
	}
	//connect to database:
	$link = mysql_connect($mysql['host'], $mysql['user'], $mysql['password']) or  die('Could not connect: ' . mysql_error());

	mysql_select_db($mysql['database']) or die('Could not select database' . mysql_error());

	// SQL query
	$result = mysql_query($query);
       
	if($result){

		if($debug['mysqlvariables']){
			if($result){
				$displaystring=sprintf("MySQL \"RESULT\":[%s]", $result); 
				showdebug($displaystring,'vars');
			}
			showdebug($mode,'data');
		}

		// DO THIS ONLY FOR SELECT, SHOW, DESCRIBE or EXPLAIN queries - 
		// otherwise (ie for DELETE and UPDATE queries) its meaningless 
		// and causes PHP warnings 
		if(($result)&&($result!=1)){
			for($i=0;$line=mysql_fetch_array($result,MYSQL_ASSOC);$i++) {
				$data[$i]=$line;
			}
			// Free resultset
			mysql_free_result($result);
		}

		// Closing connection
		mysql_close($link);

		if(isset($data)&&(!$data)){ $data=true; }

		$retval=$data;
	}else{
		echo('Query failed: ' . mysql_error());	
		$retval=false;
	}

	return $retval;
}

/* HS1 */
function input_form($table,$templateid){

	global $debug;
	global $thisPage;
	global $views;
	#include "views_array.php";
	global $views_array;
	global $tables_array;

	$visiblefieldcount=0;

	$xsplit=array('');
	$optionslist=array('');

	$data=array();

	if($debug['functions']){
		$thisFunction="input_form(table,templateid)";
		echo_functionname($thisFunction);
	}

	zerosessionvars();

	$data=view($views[$views_array['viewfpw']]);

	$data2=get_table_data($tables_array['externalsuppliers']);

	if($debug['data']){
	#	showdebug($data2,'data');
	}
	#$data=action($actions[$templateid],$actions[$templateid]['attributes'][$i]['sql']);

	echo "<form name=\"".$table['name']."\" action=\"".$thisPage."\" method=\"post\">\n";
	#echo "<fieldset>\n<legend>".$table['label']."</legend>\n";
	echo "<fieldset>\n<legend>".$views[$views_array['viewfpw']]['label']."</legend>\n";

	echo "<p>\n";
	#echo "<label for=\"".$table['attributes'][0]['name']."\">".$table['attributes'][0]['label']."</label>\n";
	echo "<label for=\"".$table['attributes'][0]['name']."\">Workpackage</label>\n";
	echo "<select id=\"".$table['attributes'][0]['name']."\" name=\"".$table['attributes'][0]['name']."\">\n";
	for($i=0;$i<sizeof($data);$i++){
		echo "<option value=\"".$data[$i]['id']."\">".$data[$i]['fpw']." ".$data[$i]['info']."</option>\n";
	}
	echo "</select>\n";

	echo "<br/></p>";

	echo "<p>\n";
	#echo "<label for=\"".$table['attributes'][0]['name']."\">".$table['attributes'][0]['label']."</label>\n";
	echo "<label for=\"".$table['attributes'][1]['name']."\">depends on Workpackage</label>\n";
	echo "<select id=\"".$table['attributes'][1]['name']."\" name=\"".$table['attributes'][1]['name']."\" onChange=\"updateInputSelection('".$table['attributes'][1]['name']."');\">\n";
	for($i=0;$i<sizeof($data);$i++){
		echo "<option value=\"".$data[$i]['id']."\">".$data[$i]['fpw']." ".$data[$i]['info']."</option>\n";
		#echo "<option value=\"".$data[$i]['id']."\">".$data[$i]['fpw']."</option>\n";
	}
	echo "</select>\n";

	echo "<br/></p>";

	for($i=2;$i<sizeof($table['attributes']);$i++){
		$xsplit=array('');
		$optionslist=array('');
		if($table['attributes'][$i]['show']==1){
			$visiblefieldcount++;
			echo "<p>\n";
			echo "<label for=\"".$table['attributes'][$i]['name']."\">".$table['attributes'][$i]['label']."</label>\n";
			if(strstr($table['attributes'][$i]['inputtype'],"select")){
				echo "<select id=\"".$table['attributes'][$i]['name']."\" name=\"".$table['attributes'][$i]['name']."\" onChange=\"updateInputSelection('".$table['attributes'][$i]['name']."');\">\n";	
					$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
					$optionslist=explode(":", $xsplit[1]);
					$optionsvalues=explode(":",$table['attributes'][$i]['options']);

					#print_r($optionslist);
					for($j=0;$j<sizeof($optionslist);$j++){
						echo "\t<option value=\"".$optionsvalues[$j]."\">".$optionslist[$j]."</option>\n";
					}	
					echo "</select>\n";
			} else if(strstr($table['attributes'][$i]['inputtype'],"SELECTDB")){
				echo "<select id=\"".$table['attributes'][$i]['name']."\" name=\"".$table['attributes'][$i]['name']."\" onChange=\"updateInputSelection('".$table['attributes'][$i]['name']."');\" >\n";	
				echo "\t<option value=\"\"> - </option>\n";
			
				for($j=0;$j<sizeof($data2);$j++){
					echo "\t<option value=\"".$data2[$j]['id']."\">".$data2[$j]['name']."</option>\n";
				}	
				echo "</select>\n";
			}else if(strstr($table['attributes'][$i]['inputtype'],"textarea")){
				$itemname=$table['attributes'][$i]['name'];
				echo "<textarea name=\"".$table['attributes'][$i]['name']."\">\n";	
				echo "</textarea>\n";
				$itemname="";
			}else if(strstr($table['attributes'][$i]['inputtype'],"date")){
				$itemname=$table['attributes'][$i]['name'];
				#date_selector($itemname,"text",1,1,1,0,0,0);

				select_date_blank($itemname,"YYYY-Mmm-DD","1-1-1");

				$itemname="";
			}else if(strstr($table['attributes'][$i]['inputtype'],"radio")){
				$xsplit=explode("/",$table['attributes'][$i]['inputtype']);
				$optionslist=explode(":", $xsplit[1]);
				$optionsvalues=explode(":",$table['attributes'][$i]['options']);
				$itemname=$table['attributes'][$i]['name'];
				radio_selector($itemname,$optionslist,$optionsvalues);
				$itemname="";
			}else{
				echo "<input type=\"".$table['attributes'][$i]['inputtype']."\" name=\"".$table['attributes'][$i]['name']."\">\n";
			}
			echo "<br/></p>\n";
		}
	}
	#echo "<br/>";

	echo "<p>";

	echo "<input name=\"templateid\" type=\"hidden\" value=\"".$templateid."\"/>\n";
	echo "<input name=\"tablename\" type=\"hidden\" value=\"".$table['name']."\"/>\n";
	echo "<input name=\"cmd\" type=\"submit\" value=\"insert\"/>\n";
	echo "<input name=\"clear\" type=\"reset\" value=\"reset\"/>\n";

	echo "</p>\n";
	echo "</fieldset>\n";
	echo "</form>\n";

	echo "<br/>";
	echo "<br/>";

	return true;
}
?>
