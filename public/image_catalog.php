<?php

include "images_titles_pageids_HASH.php";
include "images_20111009.php";
include "head.php";
?>
<body>
<p>
<?php

for($i=0;$i<sizeof($images);$i++){
  echo "<p>";
  echo "<h6>IMAGE NUMBER: [".$i."] <br />FILE: \"".$images[$i]."\"</h6>\n";
  #$s=sprintf("%d",$i);
  if(isset($images_on_page[$i])){
    echo "<h2>USED ON PAGE ";
    echo $images_on_page[$i]['page']." \"". $images_on_page[$i]['title']."\"</h2>";
  }else{
    echo "<h2>NOT USED CURRENTLY</h2>";
  }
  echo "</p>";
  echo "<img src=\"img/iStockPhoto/".$images[$i]."\" alt=\"".$images[$i]."\" />";
  echo "<hr />";
}

?>
</p>
</body>
</html>

