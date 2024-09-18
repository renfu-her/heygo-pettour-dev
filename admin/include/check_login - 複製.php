<?PHP
if (!isset($_SESSION)) {
 	 session_start();
	}
include "../common.func.php";
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

//查詢
$sql="
SELECT * FROM member 
 ";
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->execute();
while($rows = $result->fetch(PDO::FETCH_ASSOC)) {	
	if(($_SESSION["id"]==$rows["member_id"]) and ($_SESSION["pw"]==$rows["member_pw"]))
	{
		$_SESSION["login"]='okey';
		$_SESSION["name"]=$rows["member_name"];
		$_SESSION["ptime"]=$rows["member_date"];
		$_SESSION["power"]=$rows["member_power"];
		
	}
}

if($_SESSION["login"]=='okey'){
		{
		ini_set('date.timezone','Asia/Taipei');  
		$id		=	$_SESSION["id"];
		$date	=	date("Y-m-d H:i:s");
		$ip		=	getenv(REMOTE_ADDR);
		$sql	=	"UPDATE `member` SET 
					`member_date` =:date,
					`member_ip` =:ip 
					WHERE `member_id` =:id;";
		$result = $db->prepare("$sql");//防sql注入攻擊
		// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
		$result->bindValue(':date', $date, PDO::PARAM_STR);
		$result->bindValue(':ip', $ip, PDO::PARAM_STR);
		$result->bindValue(':id', $id, PDO::PARAM_INT);
		$result->execute();
		
		$db = null;// 關閉連線
		
		echo '<script language="javascript">';
		echo 'location.href= ("../index.php");';
		echo '</script>';
		}
}
else{
		echo '<script language="javascript">';
		echo 'alertify.alert("帳號密碼錯誤,請重新登入");';
		echo 'location.href= ("../login.php");';
		echo '</script>';
}

//釋放
$db = null;// 關閉連線
	?>