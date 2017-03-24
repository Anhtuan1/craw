<?php
	$conn=mysql_connect("localhost","root","","profile");
	mysql_select_db("profile", $conn);
	mysql_query("set names 'utf8'");
?>