<?php

#include "file_inventory_array.php";
#
date_default_timezone_set('GMT');

$now=date("l d F Y");
$year=date("Y");
$timestamp=date('Y-m-d H:i:s');
$sitename="Duncan Smith";
$found=FALSE;
$foundx=FALSE;
$depth=0;
$flm=0;
$final_menu="";
$menu_cell=array(
  'width'=>140,
  'height'=>20
);
$menu_array=array();
$pagekeys=array();
$menulevels=array();
$pagetitles=array();
$tabs=array();
$xmlfile="";

$var=1;

# -----------------------
#
$files=array(
  'itemsxml'=>"xml/nutrition.xml",
  'itemsxml2'=>"xml/nutrition.xml",
  'pagesxml'=>'gen/pages.xml',
  'productsxml'=>'gen/products.xml',
  'menuintermed'=>'tmp/menuintmed.inc',
  'menu'=>'gen/menu.inc',
  'tabs'=>'gen/tabs.inc',
  // ***NB*** 
  // The number of sidebar links corresponds to the pages array with their sub-arrays below***
  'menutmp'=>'tmp/menutmp.php'
);
// packages.inc
// philosophy.inc
/* 'include'=>'inc/philosophy.inc',
   'include'=>'inc/consultation.inc',
   'include'=>'inc/mainbody.inc',
   'include'=>'inc/reasons.inc',
   'include'=>'inc/bookings.inc',
   'include'=>'inc/fees.inc',
   'include'=>'inc/nutritionist_dietitian.inc',
   'include'=>'inc/packages.inc',
   'include'=>'inc/type2_diabetes.inc',
   'include'=>'inc/heart_health.inc',
   'include'=>'inc/fertility.inc',
   'include'=>'inc/weight_management.inc',
   'include'=>'inc/information_links.inc',
   'include'=>'inc/insurance_providers.inc',
 */
$pages=array(
  'title'=>'South East Nutrition and Health',
  'layout'=>'info',
  'showtitle'=>true,
  'sidebar_file' => 'gen/sidebar.inc',
  '0'=>array(
    'title'=>'Home',
    'showtitle'=>true,
    'include'=>'inc/philosophy.inc',
    'layout'=>'info',
    'xmlfile'=>'xml/nutrition.xml',
    'sidebar_file' => 'gen/sidebar_0.inc',
    '0.0'=>array(
      'title'=>'Why see a dietician?',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/reasons.inc',
      'sidebar_file' => 'gen/sidebar_0_0.inc'
    ),
    '0.1'=>array(
      'title'=>'Differences between Dieticians and Nutritionists',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/nutritionist_dietitian.inc',
      'sidebar_file' => 'gen/sidebar_0_1.inc'
    ),
    '0.2'=>array(
      'title'=>'Packages',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/packages.inc',
      'sidebar_file' => 'gen/sidebar_0_2.inc',
    ),
    '0.3'=>array(
      'title'=>'Booking and Fees',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/bookingsandfees.inc',
      'sidebar_file' => 'gen/sidebar_0_3.inc',
    )
  ),
  '1'=>array(
    'title'=>'Your Health',
    'showtitle'=>true,
    'layout'=>'info',
    'xmlfile'=>'xml/nutrition.xml',
    'include'=>'inc/consultation.inc',
    'sidebar_file' => 'gen/sidebar_1.inc',
    '1.0'=>array(
      'title'=>'Healthy eating for families',
      'showtitle'=>true,
      'layout'=>'info',
      'sidebar_file' => 'gen/sidebar_1_0.inc',
    ),
    '1.1'=>array(
      'title'=>'Vegetarian/Vegan',
      'showtitle'=>true,
      'layout'=>'info',
      'sidebar_file' => 'gen/sidebar_1_1.inc',
    ),
    '1.2'=>array(
      'title'=>'Diabetes',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/type2_diabetes.inc',
      'sidebar_file' => 'gen/sidebar_1_2.inc',
    ),
    '1.3'=>array(
      'title'=>'Heart Health',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/heart_health.inc',
      'sidebar_file' => 'gen/sidebar_1_3.inc',
    ),
    '1.4'=>array(
      'title'=>'Food allergy or intolerance',
      'showtitle'=>true,
      'layout'=>'info',
      'sidebar_file' => 'gen/sidebar_1_4.inc',
    ),
    '1.5'=>array(
      'title'=>'Irritable Bowel Syndrome',
      'showtitle'=>true,
      'layout'=>'info',
      'sidebar_file' => 'gen/sidebar_1_5.inc',
    ),
    '1.6'=>array(
      'title'=>'Weight Loss',
      'showtitle'=>true,
      'layout'=>'info',
      'include'=>'inc/weight_management.inc',
      'sidebar_file' => 'gen/sidebar_1_6.inc',
    ),
    '1.7'=>array(
      'title'=>'Mineral and Vitamin Deficiency',
      'showtitle'=>true,
      'layout'=>'info',
      'sidebar_file' => 'gen/sidebar_1_7.inc',
    )
  ),
  '2'=>array(
    'title'=>'Your Organisation',
    'showtitle'=>true,
    'layout'=>'info',
    'sidebar_file' => 'gen/sidebar_2.inc',
  ),
  '3'=>array(
    'title'=>'About Us',
    'showtitle'=>true,
    'layout'=>'info',
    'sidebar_file' => 'gen/sidebar_3.inc',
  ),
  '4'=>array(
    'title'=>'Contact Us',
    'showtitle'=>true,
    'layout'=>'info',
    'sidebar_file' => 'gen/sidebar_4.inc',
  ),
  '5'=>array(
    'title'=>'Other Services',
    'showtitle'=>true,
    'layout'=>'info',
    'sidebar_file' => 'gen/sidebar_5.inc',
  )
);

$itingline="\n<a href=\"mailto:itingdesign@gmail.com\" class=\"capt\">web design &copy; iting design ".$year." all rights reserved</a>\n";
$sknutritionline="\n<a href=\"mailto:senh@gmail.com\" class=\"capt\">site content &copy; sk nutrition ".$year." all rights reserved</a>\n";
/* images */
$logo="images/logo.gif";
$logoBlank="images/blank_logo.gif";
$logoline="<a href=\"index.php\"><img src=\"img/senh_logo.png\" alt=\"SK Nutrition\"/></a>";
$nologoline="";

/* alt text */
$Alt00="SK Nutrition";

?>
