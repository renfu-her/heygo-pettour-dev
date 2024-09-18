<?php
include "admin/common.func.php";
$del_no		=	$_GET["no"];///傳回刪除商品編號no



$sql="DELETE FROM cart 
WHERE `cart_no` =:del_no;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':del_no', $del_no, PDO::PARAM_INT);
$result->execute();

$db = null;// 關閉連線

?>

<!-- 將頁面導回-->
<script language="javascript">
 location.href= ('./index.php#checkout');
</script>
<!-- 將頁面導回-->



