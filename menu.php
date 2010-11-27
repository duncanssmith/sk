<?php 
#---------------------------------------------------------------------
# Here we are generating an XML file containing the given PHP array 
# definition 
#---------------------------------------------------------------------
  if($control['generate_pages_xml']){
    $filename=$files['pagesxml'];
    generate_xml($pages, $filename);
  }
  if($control['generate_products_xml']){
    $filename=$files['productsxml'];
    generate_xml($products, $filename);
  }

#---------------------------------------------------------------------
# Here we are writing a text file generated from the main pages array
# This text file is included and forms the MENU navigation
# This generated file requires an intermediate temp file also
#---------------------------------------------------------------------
  if($control['generate_menu']){ 
    generate_menu($pages);
  }

  if($control['generate_tabs']){
    generate_tabs($pages,$files['tabs']);
  }elseif($control['include_tabs']){
    #include "include/tabs.inc";
    include $files['tabs'];
    tabs();
  }
?>

<?php
#---------------------------------------------------------------------
# Here we are writing a set of text files generated from the pages array
# This text file is included and forms the SUBMENU navigation for the sidebar
# This generated files require an intermediate temp file also
#---------------------------------------------------------------------
  if($control['generate_sidebar_links']){ 
    generate_sidebar_links($pages);
  }

?>

<script type='text/javascript'>

<?php
  if($control['generate_menu']){
    output_menu();
  }
  
  if($control['include_menu']){
    $file=$files['menu'];
    include $file;

    // please note the closing brace 
    // of this conditional "if" statement 
    // is AFTER the following section
    // of JavaScript Menu code

    include "js/menu_base.js";
  }
?>
</script>
<noscript>Your browser does not support javascript</noscript>


