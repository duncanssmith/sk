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

		if($debug['methods']){
			$thisFunction ="Itemlist::Itemlist($filename)";
			echo_functionname($thisFunction);
		}

		$this->parser = xml_parser_create();
		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, 'start_element','end_element');
		xml_set_character_data_handler($this->parser, 'cdata');

		// 1 = single field, 2 = array field, 3 = record container

	$this->field_type = array(
		'pageid' => 1,
	);

	$this->ends_record = array('item' => true);
	$x = join("", file($filename));
	xml_parse($this->parser, $x);
	xml_parser_free($this->parser);
	}

	function start_element($p,$element,$attributes){

	global $debug;

	if($debug['methods']){
		$thisFunction ="Itemlist::start_element(".$p.", ".$element.", attributes)";
	}

	$element = strtolower($element);
	if($this->field_type[$element] != 0){
		$this->current_field = $element;
	}else{
	$this->current_field = '';    
		}
	}

function end_element($p,$element){

	global $debug;

	if($debug['methods']){
		$thisFunction ="Itemlist::end_element(".$p.", ".$element.")";
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

	if($debug['methods']){
		$thisFunction ="Itemlist::cdata(".$p.", ".$text.")";
		echo_functionname($thisFunction);
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

	if($debug['methods']){
		$thisFunction ="Itemlist::show_list()";
		echo_functionname($thisFunction);
	}

		echo "<br/>";
		$columnsfactor=$scale['columns'][$pageid];

	echo "<table class=\"listtable\">\n";
	foreach ($this->records as $item){
		#if($i==1 || (($i)%(($scale['columns'][$pageid])))==1){

		if(($columnsfactor)&&($columnsfactor!=0)){
			if($i==1 || (($i)%(($columnsfactor))==1)){
				echo "<tr valign=\"top\">\n";
			}
		}
		echo("<td class=\"listtable\" align=\"left\" valign=\"top\">\n");
		printf("<a href=\"%s\"><img src=\"%s\" alt=\"%s - %s %s\" width=\"%d\" height=\"%d\" border=\"0\"/></a>\n",
			$_SERVER['PHP_SELF'].'?pageid='. $item['pageid'],
			$item['image'],
			$item['artist'],
			$item['title'],
			$item['date'],
			(($item['width'][0])*($scale['listw'])),
			(($item['height'][0])*($scale['listh']))
		);

		if(($columnsfactor)&&($columnsfactor!=0)){
			if((($i)%($columnsfactor))==0){
				echo "</tr>\n";
			}
		}
	$i++;
	}

	echo "</table>\n<br/>\n";
}

function show_item($pageid){

	global $paypal_info;
	global $debug;
	global $zoom;
	global $scale;

	if($debug['methods']){
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

	#printf("<br/><br/><br/><br/>\n");
	#printf("<br/>\n");

  $sfactor=$pageid[0].$pageid[1].$pageid[2];
# $sfactor=$pageid;
		if($debug['xmlitems']){
			echo "<pre>:item:\n";
			print_r($item);
			echo $sfactor;
			echo "</pre>";
		}

  printf("<h3 class=\"arttitle\">%s</h3>\n", $item['title']);

	printf("<img src=\"%s\" alt=\"%s\" width=\"%f\" height=\"%f\"/>\n", 
		$item['image'], $item['title'], 
		(((float)$item['width'][0])*(($scale['itemw'])*($scale['adjust'][$sfactor]))),
		(((float)$item['height'][0])*(($scale['itemh'])*($scale['adjust'][$sfactor])))
	);
		#printf("<br/><br/><br/><br/>\n");
		printf("<br/><br/>\n");
		#printf("<br/>\n");
		#printf ("<h2>%s</h2>\n", $item['title'] );

	printf("<p class=\"arttitle\">%s</p><p class=\"arttitle\">%s x %s %s</p><p class=\"arttitle\">%s</p>\n" ,
		$item['media'],
		$item['width'][0],
		$item['height'][0],
		$item['units'][0],
		$item['date']

	);

	$parent_page=$pageid[0].$pageid[1].$pageid[2];
	
			  echo "<p><a href=\"".$_SERVER['PHP_SELF']."?pageid=".$parent_page."\">Back to list</a></p>\n";
        }
     }
  };
?>
