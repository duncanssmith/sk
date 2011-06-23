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
    'include'=>'inc/our_service.inc',
    'layout'=>'info',
    'image' => $images[42],
    'xmlfile'=>'xml/nutrition.xml',
    'sidebar_file' => 'gen/sidebar_0.inc',
    '0.0'=>array(
      'title'=>'Overview of Dietetics',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => $images[14],
      'include'=>'inc/consultation.inc',
      'include'=>'inc/reasons.inc',
      'include'=>'inc/overview_of_dietetics.inc',
      'sidebar_file' => 'gen/sidebar_0_0.inc'
    ),
    '0.1'=>array(
      'title'=>'Consultation',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => $images[14],
      'include'=>'inc/consultation.inc',
      'sidebar_file' => 'gen/sidebar_0_0.inc'
    ),
    '0.2'=>array(
      'title'=>'Other Services',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '0',
      'image' => 'img/ist2_14898397-eggs.jpg',
      'include'=>'inc/other_services.inc',
      'sidebar_file' => 'gen/sidebar_0_2.inc'
    ),
    '0.3'=>array(
      'title'=>'Packages',
      'showtitle'=>true,
      'parent' => '0',
      'layout'=>'info',
      'image' => $images[17],
      'include'=>'inc/packages.inc',
      'sidebar_file' => 'gen/sidebar_0_2.inc'
    )
  ),
  '1'=>array(
    'title'=>'Your Health',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => $images[34],
    'xmlfile'=>'xml/nutrition.xml',
    'include'=>'inc/your_health.inc',
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
      'title'=>'Weight loss',
      'showtitle'=>true,
      'layout'=>'info',
      'parent' => '1',
      'image' => 'img/ist2_1770751-weighing-in.jpg',
      'include'=>'inc/weight_loss.inc',
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
      'image' => $images[23],
      'parent' => '1',
      'include'=>'inc/vegetarian_and_vegan.inc',
      'sidebar_file' => 'gen/sidebar_1_7.inc',
    ),
    '1.8'=>array(
      'title'=>'Cancer',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[18],
      'parent' => '1',
      'include'=>'inc/cancer.inc',
      'sidebar_file' => 'gen/sidebar_1_8.inc',
    ),
    '1.9'=>array(
      'title'=>'Coeliac disease',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[19],
      'parent' => '1',
      'include'=>'inc/coeliac.inc',
      'sidebar_file' => 'gen/sidebar_1_9.inc',
    ),
    '1.10'=>array(
      'title'=>'PCOS',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[34],
      'parent' => '1',
      'include'=>'inc/pcos.inc',
      'sidebar_file' => 'gen/sidebar_1_10.inc',
    ),
    '1.11'=>array(
      'title'=>'Nutrition for the elderly',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[38],
      'parent' => '1',
      'include'=>'inc/elderly.inc',
      'sidebar_file' => 'gen/sidebar_1_11.inc',
    ),
    '1.12'=>array(
      'title'=>'Lethargy and loss of vitality',
      'showtitle'=>true,
      'layout'=>'info',
      'image' => $images[58],
      'parent' => '1',
      'include'=>'inc/lethargy_vitality.inc',
      'sidebar_file' => 'gen/sidebar_1_12.inc',
    )
  ),
  '2'=>array(
    'title'=>'Your Organisation',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14958241-young-businessman-with-his-team-in-the-background.jpg',
    'sidebar_file' => 'gen/sidebar_2.inc',
    'include'=>'inc/your_organisation.inc'
  ),
  '3'=>array(
    'title'=>'About Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900196-nuts.jpg',
    'sidebar_file' => 'gen/sidebar_3.inc',
    'include'=>'inc/about.inc'
  ),
  '4'=>array(
    'title'=>'Contact Us',
    'showtitle'=>true,
    'layout'=>'info',
    'parent' => '/',
    'image' => 'img/ist2_14900480-raspberries-and-flower-leaf-sprigs.jpg',
    'image' => $images[36],
    'sidebar_file' => 'gen/sidebar_4.inc',
    'include'=>'inc/contact_us.inc'
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
