<?php 
require "config.php";
include "simplehtmldom/simple_html_dom.php"; 


		$url = 'https://en.wikipedia.org/wiki/List_of_Indian_film_actors';

$html = file_get_html($url);
foreach($html->find("#mw-content-text .column-width ul li a") as $title)
		{
	
	$link = $title->href;
	$link2 = 'https://en.wikipedia.org'.$link;
	$namevie = $title->innertext;
	$namevie = str_replace("'","`",$namevie);
	$van = substr($namevie,0,1);
	$sql="INSERT INTO news ( cat_id, name_vie, url, van) 
    VALUES ('American', '$namevie', '$link2','$van')"; 
	mysql_query($sql) or die (mysql_error()); 
	echo 'ok';
}

?>