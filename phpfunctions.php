<?php
function stripUnicode($str){
  if(!$str) return false;
   $unicode = array(
     'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
     'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
     'd'=>'đ',
     'D'=>'Đ',
     'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
   	  'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
   	  'i'=>'í|ì|ỉ|ĩ|ị',	  
   	  'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
     'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
   	  'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
     'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
   	  'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
     'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
     'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
   );
   foreach($unicode as $khongdau=>$codau) {
     	$arr=explode("|",$codau);
   	  $str = str_replace($arr,$khongdau,$str);
   }
return $str;
}

function LucNayLa() { // Chuyển giờ hệ thống sang tiếng Việt
$anh = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun","am","pm",":"); 
$viet = array ("Thứ hai","Thứ ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy", "Chủ nhật", " phút, sáng", " phút, chiều", " giờ " ); 
$timenow = gmdate("D, d/m/Y - g:i a.", time() + 7*3600); 
$t = str_replace( $anh, $viet, $timenow); 
return $t; 
}

function changeTitle($str){
	$str = stripUnicode($str);
	$str = mb_convert_case($str,MB_CASE_TITLE,'utf-8');
	// MB_CASE_UPPER / MB_CASE_TITLE / MB_CASE_LOWER
	$str = str_replace(' ','-',$str);
	$str = str_replace("'",' ',$str);
	$str = str_replace('"',' ',$str);
	return $str;
}
function CapNhatTenTL_KhongDau(){
	$sql="select idTL,TenTL from theloai";
	$rs=mysql_query($sql) or die(mysql_error());
	while($row_rs=mysql_fetch_assoc($rs))
	{
		$id=$row_rs['idTL'];
		$t=$row_rs['TenTL'];
		$kd=changeTitle($t);
		$kd=trim($kd);
		$sql="update theloai set TenTL_KhongDau='$kd' where idTL=$id";
		mysql_query($sql) or die(mysql_error());
	}
}
function CapNhatTen_KhongDau(){
	$sql="select idLT,Ten from loaitin";
	$rs=mysql_query($sql) or die(mysql_error());
	while($row_rs=mysql_fetch_assoc($rs))
	{
		$id=$row_rs['idLT'];
		$t=$row_rs['Ten'];
		$kd=changeTitle($t);
		$kd=trim($kd);
		$sql="update loaitin set Ten_KhongDau='$kd' where idLT=$id";
		mysql_query($sql) or die(mysql_error());
	}
}

function CapNhatTieuDe_KhongDau(){
	$sql="select idTin,TieuDe from tin";
	$rs=mysql_query($sql) or die(mysql_error());
	while($row_rs=mysql_fetch_assoc($rs))
	{
		$id=$row_rs['idTin'];
		$t=$row_rs['TieuDe'];
		$kd=changeTitle($t);
		$kd=trim($kd);
		$sql="update tin set TieuDe_KhongDau='$kd' where idTin=$id";
		mysql_query($sql) or die(mysql_error());
	}
}
// Hàm kiểm tra id đã có trong csdl chưa, nếu có thì trả về giá trị false
function CheckUsername($username){
	$sql="select idUser from users where username='{$username}'";
	$rs = mysql_query($sql);
	$row_rs= mysql_fetch_row($rs);
	if ($row_rs[0]>1) return false;
	else return true;
}
// Hàm kiểm tra mail đã có trong csdl chưa, nếu có thì trả về giá trị false
function CheckEmail($email){
	$sql="select idUser from users where email ='{$email}'";
	$rs = mysql_query($sql);
	$row_rs= mysql_fetch_row($rs);
	if ($row_rs[0]>1) return false;
	else return true;
}
// Hàm sử dụng cho gởi mật khẩu với chuỗi ngẫu nhiên
function ChuoiNgauNhien($sokytu){
$chuoi="ABCDEFGHIJKLMNOPQRSTUVWXYZWabcdefghijklmnopqrstuvwxyzw0123456789";
for ($i=0; $i < $sokytu; $i++){
	$vitri = mt_rand( 0 ,strlen($chuoi) );
	$giatri= $giatri . substr($chuoi,$vitri,1 );
}
return $giatri;
} 

function LuuFileHinhUser($username,$uploadDir, &$error ){
	$error="";	
	$choUpload = array("image/gif","image/jpeg","image/pjpeg");
	$maxsize = 1024*60; //60KB
	$f = $_FILES["hinhanh"];	
	$tmp_name = $f["tmp_name"];
	if ($tmp_name == "") return "";
	$kieuFile = $f["type"];
	$coCuaFile = $f["size"]; //Tinh bang byte		
	$error="";
	if (in_array($kieuFile,$choUpload)==false) $error = "<br>Kiểu file không chấp nhận";
	if ($coCuaFile>$maxsize) $error = "<br>Kích thước file quá lớn";
	if ($error!="") return "";
	
	if ($kieuCuaFile=="image/gif") $ext=".gif";  else $ext = ".jpg";

	$pathfile = $uploadDir . $username. $ext; 
	if (file_exists($uploadDir)==false) mkdir($uploadDir, NULL ,true);
	move_uploaded_file($tmp_name, $pathfile);	
	return $pathfile;
}

// Hàm gửi mail
function GoiMail($username, $matkhau,$hoten,$email , $tieude, $noidung){
$from = "admin@localhost.com";
$to = $email;
$opt="Content-type: text/html; charset=utf-8\r\nFrom: $from\r\nReply-to: $from";
mail( $to,  $tieude, $noidung, $opt );
}

// Hàm phân trang có giới hạn       echo pagesListLimit($totalRows,$pageSize);
function pagesListLimit($totalRows , $pageSize = 5, $offset = 5){
	if ($totalRows<=0) return "";
$totalPages = ceil($totalRows/$pageSize);
	if ($totalPages<=1) return "";
	$currentURL = $_SERVER['PHP_SELF'];
	if( isset($_GET["pageNum"]) == true)  $currentPage = $_GET["pageNum"];
	else $currentPage = 1;
	settype($currentPage,"int");	
	if ($currentPage <=0) $currentPage = 1;
	$querystring="";
	foreach($_GET as $k=> $v) {
		if ($k != 'pageNum') $querystring.= "&{$k}={$v}";
	}	
	$querystring = substr($querystring,1);

	$links = "Trang ";	
	$from = $currentPage - $offset;	
	$to = $currentPage + $offset;
	if ($from <=0) { $from = 1;   $to = $offset*2; }
if ($to > $totalPages) { $to = $totalPages; }
	for($j = $from; $j <= $to; $j++) {
	   if ($j == $currentPage) $links = $links . "<span>{$j}</span>";		
	   else{				
		$qt = $querystring. "&pageNum={$j}";
		$links= $links . "<a href = '$currentURL?{$qt}'>{$j}</a>";
	   } 	   
	} //for
	return $links;
} // function pagesListLimit

// Phân trang dạng trang đầu trang trước trang sau trang cuối echo pagesLinks($totalRows,$pageSize)
function pagesLinks($totalRows, $pageSize=5){	
if ($totalRows<=0) return "";
$totalPages = ceil($totalRows/$pageSize);
if ($totalPages<=1) return "";
	$currentURL = $_SERVER['PHP_SELF'];
	if( isset($_GET["pageNum"]) ==true)  $currentPage = $_GET["pageNum"];
	else $currentPage = 1;
	settype($currentPage,"int");	
	if ($currentPage <=0) $currentPage = 1;
	
	$querystring="";
	foreach($_GET as $k => $v) {
	    if ($k!='pageNum') $querystring = $querystring . "&{$k}={$v}";
	}		
$firstLink=""; $prevLink=""; $lastLink=""; $nextLink="";

	if ($currentPage>1) {
	$firstLink = "<a href={$currentURL}?{$querystring}>Trang đầu</a>";
  	$prevPage=$currentPage-1;
	$prevLink="<a href={$currentURL}?{$querystring}&pageNum={$prevPage}>Trang trước</a>";
	}
	if ($currentPage<$totalPages) { 
	$lastLink="<a href={$currentURL}?{$querystring}&pageNum={$totalPages}>Trangcuối</a>";
	$nextPage=$currentPage+1;
	$nextLink = "<a href={$currentURL}?{$querystring}&pageNum={$nextPage}>Trang kế</a>";
	} 
	$prev=$prevPage-1;
	$next=$nextPage+1;
	$link=$firstLink.$prevLink.' '.$prev.'-'.$prevPage.'-'.$currentPage.'-'.$nextPage.'-'.$next.' '.$nextLink.$lastLink;
	return $link;
} // function pagesLinks

?>