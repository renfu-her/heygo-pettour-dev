<?php
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../common.func.php";


$del_no		=	$_GET['no'];
$del_cart	=	$_GET['cart'];//訂單編號


$sql="DELETE FROM order_form WHERE order_no =:del_no;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':del_no', $del_no, PDO::PARAM_INT);
$result->execute();

//刪除購物車
$sql="DELETE FROM order_cart WHERE cart_order_no = :del_cart;";		

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':del_cart', $del_cart, PDO::PARAM_STR);
	$result->execute();
//刪除購物車

$db = null;// 關閉連線
?>
<script language="javascript">
	location.href= ('./index.php?msg=del');
</script>
