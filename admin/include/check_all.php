<?PHP	
if (!isset($_SESSION)) {
 	 session_start();
	}

if($_SESSION["login"]<>'okey'){
		$hostweb_login='http://'.$_SERVER['HTTP_HOST'].'/admin/login.php';
		header("Location: $hostweb_login");		
		exit();
}

if($_SESSION["power"]=='2'){
		$hostweb_power='http://'.$_SERVER['HTTP_HOST'].'/admin/include/nopower.php';
		header("location: $hostweb_power");		
		exit();
}	    
?>