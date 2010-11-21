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
  'menutmp'=>'tmp/menutmp.php'
);

// packages.inc
// philosophy.inc

$pages=array(
  'title'=>'SK Nutrition',
  'layout'=>'info',
  'showtitle'=>true,
  'include'=>'inc/mainbody.inc',
  '0'=>array(
    'title'=>'SK Nutrition',
    'showtitle'=>true,
    'include'=>'inc/reasons.inc',
    'layout'=>'info',
    'xmlfile'=>'xml/nutrition.xml',
    '0.0'=>array(
      'title'=>'Consultations',
      'showtitle'=>true,
      'include'=>'inc/consultation.inc',
      'layout'=>'info',
    ),
    '0.1'=>array(
      'title'=>'Booking',
      'showtitle'=>true,
      'include'=>'inc/bookings.inc',
      'layout'=>'info',
    ),
    '0.2'=>array(
      'title'=>'Fees',
      'showtitle'=>true,
      'include'=>'inc/fees.inc',
      'layout'=>'info',
    ),
    '0.3'=>array(
      'title'=>'Nutritionist Dietitian',
      'showtitle'=>true,
      'include'=>'inc/nutritionist_dietitian.inc',
      'layout'=>'info',
    ),
    '0.4'=>array(
      'title'=>'Packages',
      'showtitle'=>true,
      'include'=>'inc/packages.inc',
      'layout'=>'info',
    ),
    '0.5'=>array(
      'title'=>'Philosophy',
      'showtitle'=>true,
      'include'=>'inc/philosophy.inc',
      'layout'=>'info',
    )
  ),
  '1'=>array(
    'title'=>'Nutrition and Health',
    'showtitle'=>true,
    'include'=>'inc/reasons.inc',
    'layout'=>'info',
    'xmlfile'=>'xml/nutrition.xml',
    '1.0'=>array(
      'title'=>'Type 2 Diabetes',
      'showtitle'=>true,
      'include'=>'inc/type2_diabetes.inc',
      'layout'=>'info',
    ),
    '1.1'=>array(
      'title'=>'Heart Health',
      'showtitle'=>true,
      'include'=>'inc/heart_health.inc',
      'layout'=>'info',
    ),
    '1.2'=>array(
      'title'=>'Fertility',
      'showtitle'=>true,
      'include'=>'inc/fertility.inc',
      'layout'=>'info',
    ),
    '1.3'=>array(
      'title'=>'Weight Management',
      'showtitle'=>true,
      'include'=>'inc/weight_management.inc',
      'layout'=>'info',
    )
  ),
  '2'=>array(
    'title'=>'Information Links',
    'showtitle'=>true,
    'include'=>'inc/information_links.inc',
    'layout'=>'info',
  ),
  '3'=>array(
    'title'=>'Insurance Providers',
    'showtitle'=>true,
    'include'=>'inc/insurance_providers.inc',
    'layout'=>'info',
    '3.0'=>array(
      'title'=>'Weight Management',
      'showtitle'=>true,
      'include'=>'inc/weight_management.inc',
      'layout'=>'info',
    )
  ),
  '4'=>array(
    'title'=>'Medical',
    'showtitle'=>true,
    'include'=>'inc/medical.inc',
    'layout'=>'info',
    '4.0'=>array(
      'title'=>'Weight Management',
      'showtitle'=>true,
      'include'=>'inc/weight_management.inc',
      'layout'=>'info',
    )
  ),
  '5'=>array(
    'title'=>'Other Services',
    'showtitle'=>true,
    'include'=>'inc/other_services.inc',
    'layout'=>'info',
    '5.0'=>array(
      'title'=>'Weight Management',
      'showtitle'=>true,
      'include'=>'inc/weight_management.inc',
      'layout'=>'info',
    )
  )
);

$itingline="\n<a href=\"mailto:itingdesign@gmail.com\" class=\"capt\">web design &copy; iting design ".$year." all rights reserved</a>\n";
$sknutritionline="\n<a href=\"mailto:itingdesign@gmail.com\" class=\"capt\">site content &copy; sk nutrition ".$year." all rights reserved</a>\n";
/* images */
$logo="images/logo.gif";
$logoBlank="images/blank_logo.gif";
$logoline="<a href=\"index.php\"><img src=\"img/logo.png\" alt=\"SK Nutrition\"/></a>";
$nologoline="";

/* links */
$Url00="http://www.iting.co.uk/";
$Url01="http://www.iting.co.uk";

/* alt text */
$Alt00="SK Nutrition";

?>
