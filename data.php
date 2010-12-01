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
$foundy=FALSE;
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

#    'image' => 'img/ist2_10645616-stethoscope-and-fruit.jpg',
#    'image' => 'img/ist2_11428565-what-should-i-cook-today.jpg',
#    'image' => 'img/ist2_12305890-healthy-lifestyle.jpg',
#    'image' => 'img/ist2_13881956-chef-s-hat.jpg',
#    'image' => 'img/ist2_14864083-peppers-on-green-platter.jpg',
#    'image' => 'img/ist2_14879429-long-red-pepper.jpg',
#    'image' => 'img/ist2_14889678-grapefruit-juice-and-fruits.jpg',
#    'image' => 'img/ist2_14891910-trail-mix-in-a-small-bowl.jpg',
#    'image' => 'img/ist2_14894484-blueberries.jpg',
#    'image' => 'img/ist2_14895251-half-of-a-nectarine.jpg',
#    'image' => 'img/ist2_14896264-red-tomato.jpg',
#    'image' => 'img/ist2_14896595-happy-woman.jpg',
#    'image' => 'img/ist2_14896628-happy-woman.jpg',
#    'image' => 'img/ist2_14897802-onion.jpg',
#    'image' => 'img/ist2_14897824-salad.jpg',
#    'image' => 'img/ist2_14897833-salmon.jpg',
#    'image' => 'img/ist2_14897849-tea.jpg',
#    'image' => 'img/ist2_14898318-milk.jpg',
#    'image' => 'img/ist2_14898397-eggs.jpg',
#    'image' => 'img/ist2_14898402-grapes.jpg',
#    'image' => 'img/ist2_14898404-fresh-rosemary-herb.jpg',
#    'image' => 'img/ist2_14899206-grape.jpg',
#    'image' => 'img/ist2_14900142-fennel.jpg',
#    'image' => 'img/ist2_14900196-nuts.jpg',
#    'image' => 'img/ist2_14900480-raspberries-and-flower-leaf-sprigs.jpg',
#    'image' => 'img/ist2_14900503-strawberry-fruit.jpg',
#    'image' => 'img/ist2_14900989-pomegranate.jpg',
#    'image' => 'img/ist2_14958241-young-businessman-with-his-team-in-the-background.jpg',
#    'image' => 'img/ist2_14966414-two-idaho-russet-baking-potatoes-against-white-background.jpg',
#    'image' => 'img/ist2_1770751-weighing-in.jpg',
#    'image' => 'img/ist2_4303867-human-stomach.jpg',
#    'image' => 'img/ist2_4441714-human-heart.jpg',
#    'image' => 'img/ist2_4718836-what-do-you-eat.jpg',
#    'image' => 'img/ist2_4946839-human-body-with-internal-organs.jpg',
#    'image' => 'img/ist2_6167844-healthy-eating.jpg',
#    'image' => 'img/ist2_6328544-bowl-of-blueberries.jpg',
#    'image' => 'img/ist2_8534640-internal-organs.jpg',
#    'image' => 'img/ist2_9148441-digestive-system.jpg',
#    'image' => 'img/ist2_9148464-digestive-system.jpg',
#    'image' => 'img/ist2_9462849-handfull-of-fruits.jpg',




'image' => 'img/ist2_4303867-human-stomach.jpg',
'image' => 'img/ist2_4441714-human-heart.jpg',
'image' => 'img/ist2_4946839-human-body-with-internal-organs.jpg',
'image' => 'img/ist2_8534640-internal-organs.jpg',
'image' => 'img/ist2_9148441-digestive-system.jpg',
'image' => 'img/ist2_9148464-digestive-system.jpg',
 */
$pages=array(
  'title'=>'South East Nutrition and Health',
  'layout'=>'info',
  'showtitle'=>true,
  'sidebar_file' => 'gen/sidebar.inc',
  '0'=>array(
    'title'=>'Home',
    'showtitle'=>true,
    'parent' => '/',
    'include'=>'inc/philosophy.inc',
    'layout'=>'info',
    'image' => 'img/ist2_9462849-handfull-of-fruits.jpg',
    #'image' => 'img/ist2_10645616-stethoscope-and-fruit.jpg',
    #'image'=>'img/img_main.jpg',
    'xmlfile'=>'xml/nutrition.xml',
    'sidebar_file' => 'gen/sidebar_0.inc',
    '0.0'=>array(
      'title'=>'Why see a dietician?',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => 'img/ist2_10645616-stethoscope-and-fruit.jpg',
      #'image'=>'img/torso_x-ray.jpg',
      'include'=>'inc/reasons.inc',
      'sidebar_file' => 'gen/sidebar_0_0.inc'
    ),
    '0.1'=>array(
      'title'=>'Differences between Dieticians and Nutritionists',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'include'=>'inc/nutritionist_dietitian.inc',
      'image' => 'img/ist2_12305890-healthy-lifestyle.jpg',
      #'image'=>'img/torso.jpg',
      'sidebar_file' => 'gen/sidebar_0_1.inc'
    ),
    '0.2'=>array(
      'title'=>'Packages',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => 'img/ist2_14894484-blueberries.jpg',
      'include'=>'inc/packages.inc',
      'sidebar_file' => 'gen/sidebar_0_2.inc',
    ),
    '0.3'=>array(
      'title'=>'Booking and Fees',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '0',
      'image' => 'img/ist2_1770751-weighing-in.jpg',
      'image' => 'img/ist2_14896595-happy-woman.jpg',
      'include'=>'inc/bookingsandfees.inc',
      'sidebar_file' => 'gen/sidebar_0_3.inc',
    )
  ),
  '1'=>array(
    'title'=>'Your Health',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'xmlfile'=>'xml/nutrition.xml',
    'image' => 'img/ist2_10645616-stethoscope-and-fruit.jpg',
    'include'=>'inc/consultation.inc',
    'sidebar_file' => 'gen/sidebar_1.inc',
    '1.0'=>array(
      'title'=>'Healthy eating for families',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_6167844-healthy-eating.jpg',
      'sidebar_file' => 'gen/sidebar_1_0.inc',
    ),
    '1.1'=>array(
      'title'=>'Vegetarian/Vegan',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => 'img/ist2_11428565-what-should-i-cook-today.jpg',
      'image' => 'img/ist2_14898404-fresh-rosemary-herb.jpg',
      'parent' => '1',
      'sidebar_file' => 'gen/sidebar_1_1.inc',
    ),
    '1.2'=>array(
      'title'=>'Diabetes',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_4718836-what-do-you-eat.jpg',
      'include'=>'inc/type2_diabetes.inc',
      'sidebar_file' => 'gen/sidebar_1_2.inc',
    ),
    '1.3'=>array(
      'title'=>'Heart Health',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_4441714-human-heart.jpg',
      'include'=>'inc/heart_health.inc',
      'sidebar_file' => 'gen/sidebar_1_3.inc',
    ),
    '1.4'=>array(
      'title'=>'Food allergy or intolerance',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_6167844-healthy-eating.jpg',
      'image' => 'img/ist2_9148441-digestive-system.jpg',
      'sidebar_file' => 'gen/sidebar_1_4.inc',
    ),
    '1.5'=>array(
      'title'=>'Irritable Bowel Syndrome',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_9148441-digestive-system.jpg',
      'image' => 'img/ist2_9148464-digestive-system.jpg',
      'sidebar_file' => 'gen/sidebar_1_5.inc',
    ),
    '1.6'=>array(
      'title'=>'Weight Loss',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_1770751-weighing-in.jpg',
      'include'=>'inc/weight_management.inc',
      'sidebar_file' => 'gen/sidebar_1_6.inc',
    ),
    '1.7'=>array(
      'title'=>'Mineral and Vitamin Deficiency',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_14900989-pomegranate.jpg',
      'sidebar_file' => 'gen/sidebar_1_7.inc',
    )
  ),
  '2'=>array(
    'title'=>'Your Organisation',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14958241-young-businessman-with-his-team-in-the-background.jpg',
    'sidebar_file' => 'gen/sidebar_2.inc',
  ),
  '3'=>array(
    'title'=>'About Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900196-nuts.jpg',
    'sidebar_file' => 'gen/sidebar_3.inc',
  ),
  '4'=>array(
    'title'=>'Contact Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900480-raspberries-and-flower-leaf-sprigs.jpg',
    'sidebar_file' => 'gen/sidebar_4.inc',
  ),
  '5'=>array(
    'title'=>'Other Services',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14898397-eggs.jpg',
    'sidebar_file' => 'gen/sidebar_5.inc',
  ),
  '6'=>array(
    'title'=>'Images',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'include'=>'inc/image_list.inc',
    'sidebar_file' => 'gen/sidebar_5.inc',
  )
);

$itingline="\n<a href=\"mailto:itingdesign@gmail.com\" class=\"capt\">&copy; iTing design ".$year." all rights reserved</a>\n";
$sknutritionline="\n<a href=\"mailto:senh@gmail.com\" class=\"capt\">&copy; South East Nutrition & Health ".$year." all rights reserved</a>\n";
/* images */
$logo="images/logo.gif";
$logoBlank="images/blank_logo.gif";
$logoline="<a href=\"index.php\"><img src=\"img/senh_logo.png\" alt=\"SK Nutrition\"/></a>";
$nologoline="";

/* alt text */
$Alt00="SK Nutrition";

?>
