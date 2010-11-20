<?php

include "page.php";
include "configuration.php";
// included in configuration.php:
  #include "debug.php";
include "data.php";
include "functions.php";
// included in functions.php:
  #include "datefunctions.php";
include "head.php";
include "body.php";
#
#include "main_20101120.php"

// included in body.php:
  #include "menu.php";
  // included in menu.php:
    #include $files['co'];
    #include $menufile;
  #include "state.php";
  #include "login.php";
?>
