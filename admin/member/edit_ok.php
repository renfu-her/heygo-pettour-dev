<?php
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP
$edit_no=	$_POST["edit_no"];//傳回修改的編號
$name 	=	$_POST["name"];
$power  =	$_POST["power"];

$sql="UPDATE `member` SET 
`member_name` =:name,
`member_power`	 =:power
WHERE `member_no` =:edit_no ;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':name', $name, PDO::PARAM_STR);
$result->bindValue(':power', $power, PDO::PARAM_STR);
$result->bindValue(':edit_no', $edit_no, PDO::PARAM_INT);
$result->execute();

$db = null;// 關閉連線
?>
<script language="javascript">
 location.href= ('./index.php?msg=updata');
</script>





