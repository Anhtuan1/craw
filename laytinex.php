<?php 
require "config.php"; 
include "simplehtmldom/simple_html_dom.php"; 
function LuuTinVaoDB($tin, $url, $source){ 
    $tieude = trim(mysql_real_escape_string(strip_tags($tin['tieude']))); 
    $tomtat = trim(mysql_real_escape_string(strip_tags($tin['tomtat']))); 
    $images = trim(mysql_real_escape_string(strip_tags($tin['images']))); 
    $content = trim(mysql_real_escape_string($tin['content'])); 

	$sql = "SELECT id from news where urlroot='{$url}'"; 
    $rs = mysql_query($sql) or die (mysql_error()); 
    if (mysql_num_rows($rs) >0 ) return false; 

    $sql="INSERT INTO news (title, introduction, images, content, urlroot,created,modified) 
        VALUES ('$tieude','$tomtat', '$images', '$content','$url','".date('Y-m-d', time())."','".date('Y-m-d', time())."')"; 
    mysql_query($sql) or die (mysql_error()); 
    return true; 
} 

function Ex_TrangChu($website, $url) { 
    $linkarray=array(); 
    $html = file_get_html($website); 
    foreach ($html->find(".title_news") as $link){             
        if ($link->href==NULL)  continue; 
        if ($link->plaintext==NULL) continue; 
        $text=str_replace("&nbsp;"," ",$link->plaintext); 
        $text=trim($text);         
        if ($text=="") continue; 
        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
    } 
    foreach ($html->find(".news_lead") as $link){             
        if ($link->href==NULL)  continue; 
        if ($link->plaintext==NULL) continue; 
        $text=str_replace("&nbsp;"," ",$link->plaintext); 
        $text=trim($text);         
        if ($text=="") continue; 
        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
    } 
     
     
	foreach ($html->find(".ul li a") as $link){             
		if ($link->href==NULL)  continue; 
		if ($link->plaintext==NULL) continue; 
		$text=str_replace("&nbsp;"," ",$link->plaintext); 
		$text=trim($text);         
		if ($text=="") continue; 
		if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
		if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
    } 
	foreach ($html->find(".fck_detail width_common") as $link){             
        if ($link->href==NULL)  continue; 
        if ($link->plaintext==NULL) continue; 
        $text=str_replace("&nbsp;"," ",$link->plaintext); 
        $text=trim($text);         
        if ($text=="") continue; 
        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
    } 
    $html->clear(); 
    unset($html); 
    return $linkarray; 
} 
function Ex_Lay1Tin($urlwebsite,$url) { 
    $html = file_get_html($url); 
    $tin = array();  
    $tin['images'] = "";  
    $td = $html->find('.title_news',0); 
    $tin['tieude'] = $td->innertext;  
    $tt = $html->find('.short_intro txt_666',0); 
    $tin['tomtat'] = $tt->innertext; 
    $content = $html->find('div.fck_detail width_common',0);         
     
    foreach( $content->find('img') as $key=>$img) {   
        if (substr($img->src,0,1) == "/")  
        $img->src = $urlwebsite.$img->src; 
		if($key == 0)
			$tin['images'] = $img->src; 
    } 
    foreach( $content->find('div.fck_detail width_common') as $tags) {
        $tags->innertext = ""; 
    }
    $tin['content'] = $content->innertext; 
    $html->clear(); 
    unset($html); 
    return $tin; 
} 
?>