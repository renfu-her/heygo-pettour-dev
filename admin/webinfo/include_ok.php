<?PHP
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0結
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP
$include_head	=	$_POST["include_head"];
$include_body	=	$_POST["include_body"];
$include_footer=	$_POST["include_footer"];
	
$sql="UPDATE `webinfo` SET 
`include_head` =:include_head,
`include_body` =:include_body,
`include_footer` =:include_footer
;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':include_head', $include_head, PDO::PARAM_STR);
$result->bindValue(':include_body', $include_body, PDO::PARAM_STR);
$result->bindValue(':include_footer', $include_footer, PDO::PARAM_STR);
$result->execute();

$db = null;// 關閉連線
?>

<script language="javascript">
 location.href= ('./include.php?msg=updata');
</script>