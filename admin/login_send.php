<?PHP
if (!isset($_SESSION)) {
 	 session_start();
	}

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

//判斷認証碼開始

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

if($_POST['pc']<>$_POST['pc2']){

		echo '<script language="javascript">';

		echo 'alert("認證碼錯誤,請重新登入");';

		echo 'location.href= ("./login.php");';

		echo '</script>';
		exit();

  }

//判斷認証碼結束	

$md5_pw=hash("sha256",$_POST['pw']);
$_SESSION["id"]=$_POST['id'];
$_SESSION["pw"]=$md5_pw;
?>
<script language="javascript">
location.href= ('./include/check_login.php');
</script>