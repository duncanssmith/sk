<?php


function validate_form(){
  global $debug;
  global $errors;


  if($debug['functions']){
    $thisFunction ="validate_form()";
    echo_functionname($thisFunction);
  }


  if(isset($_SESSION['enquiry_submitted'])&&
     ($_SESSION['enquiry_submitted'])){
    $errors['submitted']="You have already submitted the form";
#    return $errors;
  }
  
  #echo "<p class=\"mandatory_form_field_error\">\n";
  if(!strlen($_POST['enquiry']['lname'])){
    $errors['lname']="please enter your last name\n";
  #  echo "<br />\n";
  }
  if(!strlen($_POST['enquiry']['fname'])){
    $errors['fname']="please enter your first name or initial\n";
    #echo "<br />\n";
  }
  if(!strlen($_POST['enquiry']['email'])){
    $errors['email']="please enter your email address\n";
  #  echo "<br />\n";
  }elseif(!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $_POST['enquiry']['email'])){
    $errors['email_format']="email address entered is invalid, please re-enter\n";
  }
  if(!strlen($_POST['enquiry']['enquiry_text'])){
    $errors['enquiry_text']="please enter your enquiry\n";
  #  echo "<br />\n";
  }
  #echo "</p>";

  if(sizeof($errors) != 0){
    $errors['main']="Please note the form is incomplete and has not been submitted. Please check the details highlighted below, and click the \"submit\" button again:";
  }
  return $errors;
}


function save_uploaded_image_file(){
  global $debug;
  global $mail;
  global $fileUploadNewPathBase;
  global $fileUpload;

  $ret = false;

  if($debug['functions']){
    $thisFunction ="save_uploaded_image_file()";
    echo_functionname($thisFunction);
  }

  if(isset($_FILES['image_file'])&&
    ($_FILES['image_file']['error'] == UPLOAD_ERR_OK)){
    if($debug['files']){
      var_dump($_FILES['image_file']);
    }
    if(($_POST['enquiry']['fname'])&&
       ($_POST['enquiry']['lname'])){
      $cat_name = $_POST['enquiry']['fname'].$_POST['enquiry']['lname']."_";
    }
    # Make any uploaded file have a name related to the submitter!!
    $newPath = $fileUploadNewPathBase.basename($cat_name.$_FILES['image_file']['name']);
    $fileUpload=basename($cat_name.$_FILES['image_file']['name']);

    if($ret = move_uploaded_file($_FILES['image_file']['tmp_name'], $newPath)){
      printf("<br />File saved in %s<br />Retval: [%b]\n<br />", $newPath, $ret);
    }else{
      printf("<br />Couldn't move file from %s to %s!!<br />Retval: [%b]\n<br />", $_FILES['image_file']['tmp_name'], $newPath, $ret);
    }
  }else{
    #print "No valid file uploaded \n<br />";
  }


  return $ret;
}

function build_email_response(){
  global $debug;
  global $mailRecipients;
  $image_attachment=false;
  global $fileUpload;
  require 'Mailer.php';

  if($debug['functions']){
    $thisFunction ="build_email_response()";
    echo_functionname($thisFunction);
  }
#mail($mailto, $subject, $body, "From: $mailfrom");

				// RESPONSE TO USER
  		  $mailRecipients['user']['to']=$_POST['enquiry']['email'];
  		  $mailRecipients['user']['from']="noreply@southeastnutritionandhealth.co.uk";
				$mailRecipients['user']['subject']="South East Nutrition and Health: Your enquiry has been received. Thank you.";
				$mailRecipients['user']['body']=sprintf("Dear %s %s %s,\n\nThank you for your enquiry.\n\nYou wrote:\n\n\"%s\"\n\nWe will contact you shortly.\n\nSouth East Nutrition and Health\n",
				  $_POST['enquiry']['title'], 
				  $_POST['enquiry']['fname'], 
				  $_POST['enquiry']['lname'],
				  $_POST['enquiry']['enquiry_text']);

        $mail_to_user=new Mailer(
          $mailRecipients['user']['to'],
          $mailRecipients['user']['from'],
          $mailRecipients['user']['subject'],
          $mailRecipients['user']['body']);

  if($debug['mail']){
        print "Mailtest: USER: ".$mail_to_user->getMailDetails()."\n";
        print $mail_to_user->sendMailNow("USER")."\n<br/>";
  }else{
        $user_mail_retval = $mail_to_user->sendMailNow("USER")."\n<br/>";
  }

				// RESPONSE TO OWNER
  		  $mailRecipients['owner']['to'];
  		  $mailRecipients['owner']['from']="noreply@southeastnutritionandhealth.co.uk";
				$mailRecipients['owner']['subject']="South East Nutrition and Health: Enquiry received";
				$mailRecipients['owner']['body']=sprintf("%s %s %s\n%s\nEnquiry:\n\n%s\n\nSouth East Nutrition and Health\n",
				  $_POST['enquiry']['title'], 
				  $_POST['enquiry']['fname'], 
				  $_POST['enquiry']['lname'],
				  $_POST['enquiry']['email'],
				  $_POST['enquiry']['enquiry_text']);

        $mail_to_owner=new Mailer(
          $mailRecipients['owner']['to'],
          $mailRecipients['owner']['from'],
          $mailRecipients['owner']['subject'],
          $mailRecipients['owner']['body']);

  if($debug['mail']){
        print "Mailtest: OWNER: ".$mail_to_owner->getMailDetails()."\n<br/>";
        #print $mail_to_owner->sendMailNow("OWNER")."\n<br/>";
  }else{
        $owner_mail_retval = $mail_to_owner->sendMailNow("OWNER")."\n<br/>";
  }

				// RESPONSE TO BUSINESS OWNER
        // Was there an uploaded image file?
        if(isset($_FILES['image_file'])){
          $image_attachment = true;
          // attach image here
        }

				// RESPONSE TO TESTER
  		  $mailRecipients['test']['to'];
  		  $mailRecipients['test']['from']="noreply@southeastnutritionandhealth.co.uk";
				$mailRecipients['test']['subject']="South East Nutrition and Health Enquiry";
				$mailRecipients['test']['body']=sprintf("title: %s\nfname: %s\nlname: %s\nemail: %s\nenquiry_text: %s\n\nwww.southeastnutritionandhealth.co.uk\n",
				  $_POST['enquiry']['title'], 
				  $_POST['enquiry']['fname'], 
				  $_POST['enquiry']['lname'],
				  $_POST['enquiry']['email'],
				  $_POST['enquiry']['enquiry_text']);

        $mail_to_tester=new Mailer(
          $mailRecipients['test']['to'],
          $mailRecipients['test']['from'],
          $mailRecipients['test']['subject'],
          $mailRecipients['test']['body']);

   if($debug['mail']){
        print "Mailtest: TESTER: ".$mail_to_tester->getMailDetails()."\n<br/>";
        print $mail_to_tester->sendMailNow("TESTER");
   }else{
        $tester_mail_retval = $mail_to_tester->sendMailNow("TESTER");
   }
   
  return true;
}

function xml2array($xml) {
  global $debug;

  if($debug['functions']){
    $thisFunction ="xml2array(".$xml.")";
    echo_functionname($thisFunction);
  }

        $xmlary = array();
               
        $reels = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
        $reattrs = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

        preg_match_all($reels, $xml, $elements);

        foreach ($elements[1] as $ie => $xx) {
                $xmlary[$ie]["name"] = $elements[1][$ie];
               
                if ($attributes = trim($elements[2][$ie])) {
                        preg_match_all($reattrs, $attributes, $att);
                        foreach ($att[1] as $ia => $xx)
                                $xmlary[$ie]["attributes"][$att[1][$ia]] = $att[2][$ia];
                }

                $cdend = strpos($elements[3][$ie], "<");
                if ($cdend > 0) {
                        $xmlary[$ie]["text"] = substr($elements[3][$ie], 0, $cdend - 1);
                }

                if (preg_match($reels, $elements[3][$ie]))
                        $xmlary[$ie]["elements"] = xml2array($elements[3][$ie]);
                else if ($elements[3][$ie]) {
                        $xmlary[$ie]["text"] = $elements[3][$ie];
                }
        }

        return $xmlary;
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

  $file=fopen($f, "w+");

  fprintf($file,"<?php\n#generated file %s %s - do not edit\n\n  %s\n", $f, $timestamp, "\$tabs=array(");

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

  fprintf($file, "  %s\n", ");\n?>");
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
  global $sidebar_links;
  global $timestamp;

  if($debug['functions']){
	  $thisFunction ="generate_sidebar_links(".$p.")";
    echo_functionname($thisFunction);
  }

  $len=sizeof($p);
	$array_present = false;

  if($len > 0){
    $pk = array_keys($p); 

    for($i=0;$i<sizeof($p);$i++){
		  if(is_array($p[$pk[$i]])){
        $array_present = true;
      }
    }
    if($array_present){
      $file=fopen( $p['sidebar_file'], "w");
      fprintf($file,"\n<ul class=\"left_sidebar_links\">\n");
      for($i=0;$i<sizeof($p);$i++){
        if(is_array($p[$pk[$i]])){
         # if($pageid == $p[$i]){
         #   fprintf($file, "<li><a class=\"current\" href=\"index.php?pageid=%s\">%s</a></li>\n", $pk[$i], $p[$pk[$i]]['title']);
         # }else{
            $sidebar_links[]=array($pk[$i], $p[$pk[$i]]['title']);

            fprintf($file, "<li><a href=\"index.php?pageid=%s\">%s</a></li>\n", $pk[$i], $p[$pk[$i]]['title']);
         # }
          generate_sidebar_links($p[$pk[$i]]);
        }
      }
      fprintf($file, "</ul>\n");
		  fclose($file);
		}
  }
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

    fprintf($file1,"<?php\n#generated file %s - do not edit\n\n  %s\n", $timestamp, "\$menuindex=array(");
    for($i=0;$i<sizeof($combined1);$i++){
      fprintf($file1,"    %s\n",$combined1[$i]);
    }
    fprintf($file1,"  %s\n", ");\n?>");

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
      fprintf($file,"  %s\n",$final_menu[$i]);
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

#  $page=array();

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
    $thisFunction ="getlinks( ".$p.", $pageid, $d)";
    #echo_functionname($thisFunction);
  }

  if($debug['data']){
    echo "<pre>";
    print_r($p);
    echo "</pre>";
  }

  $pk=array_keys($p);

  if($foundx){
    if($debug['page']){
      echo "<pre>";
      print_r($p);
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
  global $pages;
  global $pageid;
  global $tabs;
  
  if($debug['functions']){
    $thisFunction ="tabs()";
    echo_functionname($thisFunction);
  }

  $pk=array_keys($tabs);
  
  if($debug['data']){
    echo "<pre>";
    print_r($pages[$pk[1]['title']]);
    echo "</pre>";
  }


  echo "     <ul>\n";
  
  for($i=0;$i<sizeof($tabs);$i++){

    if($pageid[0]==$pk[$i]){ 
        echo "       <li><a class=\"current\" href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
    }else{
        echo "       <li><a href=\"index.php?pageid=".$pk[$i]."\">".$tabs[$i]."</a></li>\n";
    }
  }
  echo "     </ul>\n";
  # echo "    </div>";

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
    echo "<br/>\n<ul>\n";  
  }

  for($i=0;$i<sizeof($p);$i++){
    if(is_array($p[$pk[$i]])){
      printf ("<li><a href=\"index.php?pageid=%s\"> %s </a></li>\n", $pk[$i], $p[$pk[$i]]['title']); 
    }
  }
  if(!empty($p['title'])&&(!empty($p['showtitle']))){
    echo "</ul>\n";  
  }

  return true;
}


function showpage($p,$cols){
  
  global $debug;
  global $settings;
	global $files;
	global $pages;

  if($debug['functions']){
    $thisFunction ="showpage(p,".$cols.")";
    echo_functionname($thisFunction);
  }
  #echo $p['include'];
  # echo "<pre>PAGE:";
  #  print_r($p);
  # echo "</pre>";
  #
  $pk = array_keys($p);
/*
  if(!empty($p['title'])&&(!empty($p['showtitle']))){
	  echo "<h1 id=\"pagetitle\">";
			if($p['parent'] != '/'){
		    echo "<a href=\"index.php?pageid=".$p['parent']."\">";
			  echo $pages[$p['parent']]['title'];
		    echo "</a>\n";
		    echo " > ";
			}
		echo "<a href=\"\">";
		echo $p['title'];
		echo "</a>\n";
		echo " ";
		for($i=0;$i<sizeof($pk);$i++){
	#					echo $pk[$i]." ";
		#				echo $p[$pk[$i]]." ";
		}
		echo " ";
		echo "</h1>\n";
  }
*/
  echo "<br />";
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

    if(isset($_GET['pageid']))
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

function showimages($p,$cols,$width){
  
  global $debug;
  global $settings;
  global $files;
  global $pages;

  if($debug['functions']){
    $thisFunction ="showimages(p,".$cols.")";
    echo_functionname($thisFunction);
  }

	$pk = array_keys($p);
	if(isset($p['image'])){
	  #printf("<img src=\"img/iStockPhoto_FINAL/%s\" alt=\"%s\" width=\"%d\" oncontextmenu=\"return false;\" />\n", 

          echo "<div id=\"main_image\">";
          printf("<img src=\"img/iStockPhoto_FINAL/%s\" alt=\"%s\" oncontextmenu=\"return false;\" />\n", 
            $p['image'], 
            $p['image_alt_text']
            #,$width
          ); 
          echo "</div>";

    if(isset($p['image_caption'])){
      printf("<p class=\"small\">%s</p>", $p['image_caption']);
    }
	}
  return true;
}

function getimages($p,$pageid,$d){

  global $debug;
  global $pageid;
  global $foundy;
  global $pages;
  $page="";

  if($debug['functions']){
    $thisFunction ="getimages( ".$p.", $pageid, $d)";
    echo_functionname($thisFunction);
  }

  if($debug['data']){
    echo "<pre>";
    print_r($p);
    echo "</pre>";
  }

  $pk=array_keys($p);

  if($foundy){
    if($debug['page']){
      echo "<pre>";
      print_r($p);
      echo "</pre>";
    }
  }else{
    for($i=0;$i<sizeof($p);$i++){
      if(is_array($p[$pk[$i]])){

        $pagestr=sprintf("%s", $pk[$i]);
        $pageidstr=sprintf("%s", $pageid);
  
        if($pagestr===$pageidstr){

          $foundy=TRUE;

          if(isset($p[$pk[$i]]['image_width'])){
            showimages($p[$pk[$i]],2, $p[$pk[$i]]['image_width']);
          }else{
            showimages($p[$pk[$i]],2, 360);
          }


          $page=$p[$pk[$i]];
          break;
        }else{
          $foundy==FALSE;
          $page=getimages($p[$pk[$i]],$pageid,$d+1);
        }
      }else{
        $page=$p;
      }
    }
  }
  return $page;
}

function getlayout($p,$pageid,$d){

  global $debug;
  global $pageid;
  global $foundz;
  global $page;

  if($debug['functions']){
    $thisFunction ="getlayout( p: ".$p.", pageid: ".$pageid.", depth: ".$d.")";
    echo_functionname($thisFunction);
  }

  if($debug['data']){
    echo "<pre>";
    print_r($p);
    echo "</pre>";
  }

  $pk=array_keys($p);

  if($foundz){
    if($debug['page']){
      echo "<pre>";
      print_r($p);
      echo "</pre>";
    }
  }else{
    for($i=0;$i<sizeof($p);$i++){
      if(is_array($p[$pk[$i]])){

        $pagestr=sprintf("%s", $pk[$i]);
        $pageidstr=sprintf("%s", $pageid);
  
        if($pagestr===$pageidstr){

          $foundz=TRUE;

          showlayout($p[$pk[$i]],2);

          $page=$p[$pk[$i]];

          break;

        }else{
          $foundz==FALSE;
          $page=getlayout($p[$pk[$i]],$pageid,$d+1);
        }
      }else{
        $page=$p;
      }
    }
  }
  return $page;
}

function showlayout($p,$cols){
  
  global $debug;
  global $settings;
  global $files;
  global $pages;

  if($debug['functions']){
    $thisFunction ="showlayout(p,".$cols.")";
    echo_functionname($thisFunction);
  }

	if(!empty($p['layout'])){
		printf("\n<body class=\"%s\">", $p['layout']); 
	}else{
		echo "\n<body>"; 
  }

  return true;
}


