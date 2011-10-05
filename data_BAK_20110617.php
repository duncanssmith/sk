<?php

#include "file_inventory_array.php";
include "images.php";

date_default_timezone_set('GMT');

$now=date("l d F Y");
$year=date("Y");
$timestamp=date('Y-m-d H:i:s');
$sitename="Duncan Smith";

$found=FALSE;
$foundx=FALSE;
$foundy=FALSE;
$foundz=FALSE;

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
$sidebar_links=array();
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
    'title'=>'Our Service',
    'showtitle'=>true,
    'parent' => '/',
    'include'=>'inc/philosophy.inc',
    'layout'=>'info',
    'image' => $images[42],
    'xmlfile'=>'xml/nutrition.xml',
    'sidebar_file' => 'gen/sidebar_0.inc',
    '0.0'=>array(
      'title'=>'Why see a dietician?',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => $images[14],
      'include'=>'inc/reasons.inc',
      'sidebar_file' => 'gen/sidebar_0_0.inc'
    ),
    '0.1'=>array(
      'title'=>'Differences between Dieticians and Nutritionists',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'include'=>'inc/nutritionist_dietitian.inc',
      'image' => $images[11],
      'sidebar_file' => 'gen/sidebar_0_1.inc'
    ),
    '0.2'=>array(
      'title'=>'Packages',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => $images[17],
      'include'=>'inc/packages.inc',
      'sidebar_file' => 'gen/sidebar_0_2.inc',
    ),
    '0.3'=>array(
      'title'=>'Booking and Fees',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '0',
      'image' => $images[20],
      'include'=>'inc/bookingsandfees.inc',
      'sidebar_file' => 'gen/sidebar_0_3.inc',
    )
  ),
  '1'=>array(
    'title'=>'Your Health',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => $images[34],
    'xmlfile'=>'xml/nutrition.xml',
    'include'=>'inc/consultation.inc',
    'sidebar_file' => 'gen/sidebar_1.inc',
    '1.0'=>array(
      'title'=>'Diabetes',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_4718836-what-do-you-eat.jpg',
      'include'=>'inc/type2_diabetes.inc',
      'sidebar_file' => 'gen/sidebar_1_0.inc',
    ),
    '1.1'=>array(
      'title'=>'Heart Health',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_4441714-human-heart.jpg',
      'include'=>'inc/heart_health.inc',
      'sidebar_file' => 'gen/sidebar_1_1.inc',
    ),
    '1.2'=>array(
      'title'=>'Irritable Bowel Syndrome',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_9148441-digestive-system.jpg',
      'image' => 'img/ist2_9148464-digestive-system.jpg',
      'include'=>'inc/ibs.inc',
      'sidebar_file' => 'gen/sidebar_1_2.inc',
    ),
    '1.3'=>array(
      'title'=>'Mineral and Vitamin Deficiency',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_14900989-pomegranate.jpg',
      'image' => $images[37],
      'include'=>'inc/mineral_and_vitamin_deficiency.inc',
      'sidebar_file' => 'gen/sidebar_1_3.inc',
    ),
    '1.4'=>array(
      'title'=>'Food allergy or intolerance',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_6167844-healthy-eating.jpg',
      'image' => 'img/ist2_9148441-digestive-system.jpg',
      'include'=>'inc/food_allergy_and_intolerance.inc',
      'sidebar_file' => 'gen/sidebar_1_4.inc',
    ),

    '1.5'=>array(
      'title'=>'Weight Loss',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_1770751-weighing-in.jpg',
      'include'=>'inc/weight_management.inc',
      'sidebar_file' => 'gen/sidebar_1_5.inc',
    ),

    '1.6'=>array(
      'title'=>'Healthy eating for families',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => $images[30],
      'include'=>'inc/healthy_eating_for_families.inc',
      'sidebar_file' => 'gen/sidebar_1_6.inc',
    ),
    '1.7'=>array(
      'title'=>'Vegetarian/Vegan',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => 'img/ist2_11428565-what-should-i-cook-today.jpg',
      'image' => 'img/ist2_14898404-fresh-rosemary-herb.jpg',
      'image' => $images[23],
      'parent' => '1',
      'include'=>'inc/vegetarian_and_vegan.inc',
      'sidebar_file' => 'gen/sidebar_1_7.inc',
    ),
    '1.8'=>array(
      'title'=>'Cancer',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => 'img/ist2_11428565-what-should-i-cook-today.jpg',
      'image' => 'img/ist2_14898404-fresh-rosemary-herb.jpg',
      'image' => $images[18],
      'parent' => '1',
      'include'=>'inc/cancer.inc',
      'sidebar_file' => 'gen/sidebar_1_7.inc',
    )

  ),
  '2'=>array(
    'title'=>'Your Organisation',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14958241-young-businessman-with-his-team-in-the-background.jpg',
    'include'=>'inc/your_organisation.inc',
    'sidebar_file' => 'gen/sidebar_2.inc',
    '2.0'=>array(
      'title'=>'Catering',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[27],
      'parent' => '2',
      'sidebar_file' => 'gen/sidebar_2_0.inc',
    ),
    '2.1'=>array(
      'title'=>'Restaurants',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[23],
      'parent' => '2',
      'sidebar_file' => 'gen/sidebar_2_1.inc',
    )
  ),
  '3'=>array(
    'title'=>'About Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900196-nuts.jpg',
    'include'=>'inc/about.inc',
    'sidebar_file' => 'gen/sidebar_3.inc',
    '3.0'=>array(
      'title'=>'Dieticians',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[47],
      'parent' => '3',
      'sidebar_file' => 'gen/sidebar_3_0.inc',
    ),
    '3.1'=>array(
      'title'=>'Our Practice',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[16],
      'parent' => '3',
      'sidebar_file' => 'gen/sidebar_3_1.inc',
    )

  ),
  '4'=>array(
    'title'=>'Contact Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900480-raspberries-and-flower-leaf-sprigs.jpg',
    'image' => $images[36],
    'include'=>'inc/contact_us.inc',
    'sidebar_file' => 'gen/sidebar_4.inc',
    '4.0'=>array(
      'title'=>'UK Wide',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[42],
      'parent' => '4',
      'sidebar_file' => 'gen/sidebar_4_0.inc',
    ),
    '4.1'=>array(
      'title'=>'South East',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[43],
      'parent' => '4',
      'sidebar_file' => 'gen/sidebar_4_1.inc',
    ),
    '4.2'=>array(
      'title'=>'South West',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[41],
      'parent' => '4',
      'sidebar_file' => 'gen/sidebar_4_2.inc',
    )
  ),
  '5'=>array(
    'title'=>'Other Services',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14898397-eggs.jpg',
    'sidebar_file' => 'gen/sidebar_5.inc',
    '5.0'=>array(
      'title'=>'Medical Tests',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[44],
      'parent' => '5',
      'sidebar_file' => 'gen/sidebar_5_0.inc',
    ),
    '5.1'=>array(
      'title'=>'Food Allergies',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[32],
      'parent' => '5',
      'sidebar_file' => 'gen/sidebar_5_1.inc',
    )
//  ),
//  '6'=>array(
//    'title'=>'Images',
//    'showtitle'=>true,
//    'layout'=>'wide',
//    'parent' => '/',
//    'include'=>'inc/image_list.inc',
//    'sidebar_file' => 'gen/sidebar_5.inc',
  )
);

$itingline="\n<a href=\"mailto:itingdesign@gmail.com\" class=\"capt\">&copy; iTing design ".$year." all rights reserved</a>\n";
$sknutritionline="\n<a href=\"mailto:senh@gmail.com\" class=\"capt\">&copy; South East Nutrition & Health ".$year." all rights reserved</a>\n";
/* images */
$logo="images/logo.gif";
$logoBlank="images/blank_logo.gif";
$logoline="<a href=\"index.php\"><img src=\"img/senh_logo.png\" alt=\"SK Nutrition\"/></a>";
$phonelogoline="<a href=\"index.php\"><img src=\"img/phone_logo.png\" alt=\"SK Nutrition\"/></a>";
$nologoline="";

/* alt text */
$Alt00="SK Nutrition";

?>