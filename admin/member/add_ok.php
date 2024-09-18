<?php
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?PHP
$name 	=	$_POST["name"];
$id 	=	$_POST["id"];
$pw  	=	hash("sha256",$_POST['pw']);
$power  =	$_POST["power"];
//檢查使用帳號是否重複開始
//查詢
$sql="SELECT * 
FROM `member` 
WHERE `member_id` = :id
";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':id', $id, PDO::PARAM_STR);

$result->execute();
$total=$result->rowCount();//算出總筆數

if ($total>=1)
{
	echo '<script language="javascript">';
	echo 'alert("帳號已被使用,請換個帳號重新申請");';
	echo 'location.href= ("./add.php");';
	echo '</script>';		
	exit();
}

//檢查使用帳號是否重複結束
else{

//新增使用者
$sql="insert into member (member_id,member_pw,member_power,member_name)	VALUES (:id,:pw,:power,:name)";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':id', $id, PDO::PARAM_STR);
	$result->bindValue(':pw', $pw, PDO::PARAM_STR);
	$result->bindValue(':power', $power, PDO::PARAM_STR);
	$result->bindValue(':name', $name, PDO::PARAM_STR);
	$result->execute();


$db = null;// 關閉連線
}	

?>
<script language="javascript">
location.href= ('./index.php?msg=add');
</script>





