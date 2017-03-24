<html>
<head>
	<title>Auto News - Trang tu dong lay tin tuc</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<a href="http://chungcuchinhchu.vn/admin">Trở lại trang quản trị</a>

<?php 
set_time_limit(0);  
include ("laytin.php"); 
$urlwebsite="http://dantri.com.vn/su-kien.htm"; 
$website="http://dantri.com.vn"; 
$links=DanTri_TrangChu($urlwebsite, $website); 
foreach ($links as $td => $url){
	$tin=DanTri_Lay1Tin($website,$url); 
	flush(); 
	LuuTinVaoDB($tin, $url,"dantri.com.vn"); 
	next($links); 
} 
?>



</body>
</html>