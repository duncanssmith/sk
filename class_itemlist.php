<?PHP

class Itemlist{
	var $parser;
	var $record;
	var $current_field='';
	var $field_type;
	var $ends_record;
	var $records;

	function Itemlist($filename){

		global $debug;

		if($debug['xml_functions']){
			$thisFunction ="Itemlist::Itemlist($filename)";
			echo_functionname($thisFunction);
		}

		$this->parser = xml_parser_create();
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, 'start_element','end_element');
		xml_set_character_data_handler($this->parser, 'cdata');

		// 1 = single field, 2 = array field, 3 = record container

	$this->field_type = array(
		'item' => 3,
		'title' => 1,
		'artist' => 1,
		'date' => 1,
		'category' => 2,
		'pageid' => 1,
		'dimensions' => 2,
		'units' => 1,
		'height' => 1,
		'width' => 1,
		'depth' => 1,
		'media' => 1,
		'subtitle' => 1,
		'keyname' => 1,
		'id' => 1,
		'images' => 2,
		'image' => 1
	);

	$this->ends_record = array('item' => true);
	$x = join("", file($filename));
	xml_parse($this->parser, $x);
	xml_parser_free($this->parser);
	}

	function start_element($p,$element,$attributes){

	global $debug;

	if($debug['xml_functions']){
		$thisFunction ="Itemlist::start_element(".$p.", ".$element.", attributes)";
		#echo_functionname($thisFunction);
	}

	$element = strtolower($element);
	#echo "<h1>element: ".$element."</h1>\n";
	if($this->field_type[$element] != 0){
		$this->current_field = $element;
		#echo "<h2>current_field: ".$this->current_field."</h2>\n";
	}else{
	$this->current_field = '';    
		}
	}

function end_element($p,$element){

	global $debug;

	if($debug['xml_functions']){
		$thisFunction ="Itemlist::end_element(".$p.", ".$element.")";
		#echo_functionname($thisFunction);
	}

	$element = strtolower($element);
	if($this->ends_record[$element]){
	$this->records[] = $this->record;
	$this->record = array();
	}
	$this->current_field = '';    
}

function cdata($p,$text){

	global $debug;

	if($debug['xml_functions']){
	$thisFunction ="Itemlist::cdata(".$p.", ".$text.")";
#echo_functionname($thisFunction);
	}

	if($this->field_type[$this->current_field] == 2 ) {
	$this->record[$this->current_field][] = $text;
	}elseif($this->field_type[$this->current_field] == 1){ 
	$this->record[$this->current_field] .= $text;
	}
}

function show_list(){

		global $paypal_info;
		global $debug;
		global $pageid;
		global $scale;
		$i=1;

	if($debug['xml_functions']){
		$thisFunction ="Itemlist::show_list()";
		echo_functionname($thisFunction);
	}

		echo "<br/>";
		$columnsfactor=$scale['columns'][$pageid];

	echo "<table class=\"listtable\">\n";
	foreach ($this->records as $item){
		#if($i==1 || (($i)%(($scale['columns'][$pageid])))==1){
		if($i==1 || (($i)%(($columnsfactor))==1)){
			echo "<tr valign=\"top\">";
		}
		echo("<td class=\"listtable\" align=\"left\" valign=\"top\">");
		printf("<a href=\"%s\"><img src=\"%s\" width=\"%d\" height=\"%s\" alt=\"%s - %s\" border=\"0\"/></a>\n",
			$_SERVER['PHP_SELF'].'?pageid='. $item['pageid'],
			$item['image'],
			(((float)$item['width'])*($scale['listw'])),
			(((float)$item['height'])*($scale['listh'])),
			$item['artist'],
			$item['title']
	);
	printf("<br/><a href=\"%s\"><p>%s</p> <p>%s<br/><br/>%s<br/><br/>%s x %s %s</p></a></td>\n",
		$_SERVER['PHP_SELF'].'?pageid='.$item['pageid'],
		$item['title'],
		$item['media'],
		$item['date'],
		$item['height'],
		$item['width'],
		$item['units']
	);
	  
		#if((($i)%($scale['columns']))==0){
		if((($i)%($columnsfactor))==0){
			echo "</tr>\n";
		}
	$i++;
	}

	echo "</table><br/>\n";

}

function show_item($pageid){

	global $paypal_info;
	global $debug;
	global $zoom;
	global $scale;

	if($debug['xml_functions']){
	$thisFunction ="Itemlist::show_item($pageid)";
		echo_functionname($thisFunction);
	}

	foreach($this->records as $item){
		if($item['pageid'] !== $pageid){
			continue;
		}

		$dimensions=array(
			'h'=>$item['height'],
			'w'=>$item['width'],
			'd'=>$item['depth'],
			'u'=>$item['units']
		);

		printf("<br/><br/><br/><br/>\n");

		$sfactor=$pageid[0].$pageid[1].$pageid[2];

		#printf("<h1>sw: %d  sh: %d</h1>\n", 
		#$scale['adjust'][$sfactor],
		#$scale['adjust'][$sfactor]);

		#printf("<h1>w: %d  h: %d</h1>\n", 
		#(((float)$item['width'])*(($scale['itemw'])*($scale['adjust'][$sfactor]))),
		#(((float)$item['height'])*(($scale['itemh'])*($scale['adjust'][$sfactor]))));

	printf("<img src=\"%s\" alt=\"%s\" width=\"%d\" height=\"%d\"/>\n", 
		$item['image'], $item['title'], 
		(((float)$item['width'])*(($scale['itemw'])*($scale['adjust'][$sfactor]))),
		(((float)$item['height'])*(($scale['itemh'])*($scale['adjust'][$sfactor])))
	);
		printf("<br/><br/><br/><br/>\n");
		printf ("<h2>Duncan Smith - %s</h2>\n", $item['title'] );

	printf("<p>%s</p><p>%s x %s %s</p><p>%s</p>\n" ,
		$item['media'],
		$item['width'],
		$item['height'],
		$item['units'],
		$item['date']

	);

  #  echo "<table class=\"artwork\">\n<tr>\n";
          
  #  echo "<td>";
	  #printf("<img src=\"%s\" onClick=\"javascript: pop_zoom('%s','%s','%s','%s','%s');return false;\" alt=\"%s, %s\" height=\"240\"/>\n<br/><p>%s</p>\n",
		#$zoom_data[0],
		#$zoom_data[0],
		#$item['title'],
		#$zoom_more[0],
	#($item['height'] * 20),
	#($item['width'] * 20),
	#	$item['title'],
	#	$dimensions['h'],
	#	$zoom_more[0]
	#  );
	#			echo "</td>\n";

	#		  echo "</tr></table>\n<br/>\n";
	#
	$parent_page=$pageid[0].$pageid[1].$pageid[2];
	
	  echo "<p><a href=\"".$_SERVER['PHP_SELF']."?pageid=".$parent_page."\">Back to list</a></p>\n";
        }
     }
  };
?>
