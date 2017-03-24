<?php 
require "config.php";
include "simplehtmldom/simple_html_dom.php"; 

$url = 'http://www.kapanlagi.com/indonesia/index.html';

$html = file_get_html($url);

foreach($html->find(".celebrity-abjad ul li a") as $title)
		{ 
	
	$link = $title->href;
	$namevie = $title->innertext;
	$namevie = str_replace("'","`",$namevie);
	$van = substr($namevie,0,1);
	$sql="INSERT INTO news ( cat_id, name_vie, url, van) 
    VALUES ('Indonesia', '$namevie', '$link','$van')"; 
	mysql_query($sql) or die (mysql_error()); 
	
}


?>