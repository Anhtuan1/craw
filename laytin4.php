<?php 
require "config.php";
include "simplehtmldom/simple_html_dom.php"; 
for($i =2;$i<8;$i++) { 
$url = 'http://www.bola.net/profile/index'.($i-1).'.html';

$html = file_get_html($url);

foreach($html->find(".green_link ") as $title)
		{ 
			echo $url;
		
	$link = 'http://www.bola.net'.$title->href;
	$namevie = $title->innertext;
	$namevie = str_replace("'","`",$namevie);
	$van = substr($namevie,0,1);
	$sql="INSERT INTO news ( cat_id, name_vie, url, van) 
    VALUES ('Bola', '$namevie', '$link','$van')"; 
	mysql_query($sql) or die (mysql_error()); 
		}

}

?>