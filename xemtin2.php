<html>
<head>
	<title>Auto News - Trang tu dong lay tin tuc</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<a href="http://chungcuchinhchu.vn/admin">Trở lại trang quản trị</a>


<?php 
set_time_limit(0);  
include ("laytinex.php"); 
$urlwebsite="http://vnexpress.net/tin-tuc/goc-nhin"; 
$website="http://vnexpress.net"; 
$links=Ex_TrangChu($urlwebsite, $website); 
foreach ($links as $td => $url){
	$tin=Ex_Lay1Tin($website,$url); 
	flush(); 
	LuuTinVaoDB($tin, $url,"vnexpress.net"); 
	next($links); 
} 
?>


</body>
</html>