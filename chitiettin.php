<?php 
require "config.php";
include "simplehtmldom/simple_html_dom.php"; 
$conn=mysql_connect("localhost","root","","profile");
mysql_select_db("profile", $conn);
$result = mysql_query("SELECT url,cat_id FROM news WHERE cat_id = 'Indonesia' AND url LIKE 'http://www.kapanlagi.com/indonesia%' LIMIT 5 OFFSET 0",$conn);
while($row = mysql_fetch_array($result))
{
$url = $row['url'];
$html = file_get_html($url);
foreach($html->find("#v6-profile-bio") as $content)
		{
	echo 'ok';
	$noidung = $content;	
	$noidung = str_replace("'","`",$noidung);
	$sql="UPDATE news SET content_vie='$noidung' WHERE url = '$url'"; 
	mysql_query($sql) or die (mysql_error()); 
}
foreach($html->find(".image img") as $images)
{
	$anh = $images->src;
	$anh2 = $anh;
	$sql="UPDATE news SET images2='$anh2' WHERE url = '$url' LIMIT 1"; 
	mysql_query($sql) or die (mysql_error()); 
}
}
?>