<?php
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP
$edit_no		=	$_GET["no"];//傳回修改的編號
$order_status	=	$_POST["order_status"];
$order_note2	=	$_POST["order_note2"];

$sql="UPDATE `order_form` SET 
`order_status` =:order_status,
`order_note2`	 =:order_note2
WHERE `order_no` =:edit_no ;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':order_status', $order_status, PDO::PARAM_STR);
$result->bindValue(':order_note2', $order_note2, PDO::PARAM_STR);
$result->bindValue(':edit_no', $edit_no, PDO::PARAM_INT);
$result->execute();

$db = null;// 關閉連線
?>
<script language="javascript">
 location.href= ('./print.php?no=<?=$edit_no?>&msg=updata');
</script>





