<?PHP
if (!isset($_SESSION)) {
 	 session_start();
	}

if(!isset($_SESSION["login"])){
		header('Location: ../include/re_login.html');
		exit();
}

//取得當前連結 echo $_SERVER['HTTP_HOST'];
//取得當前連結 echo $_SERVER['PHP_SELF'];
	?>