<?PHP

include "../include/check_all.php";//檢查登入權限和使用者是否被凍結 

include "../common.func.php";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP

$content=$_POST["content"]; 


$sql="UPDATE `about` SET 
	`content` =:content
	;";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':content', $content, PDO::PARAM_STR);
	$result->execute();

	$db = null;// 關閉連線

?>



<script language="javascript">

 location.href= ('./index.php?msg=updata');

</script>