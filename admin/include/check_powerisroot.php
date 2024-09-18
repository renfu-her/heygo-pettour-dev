<?PHP	

if($_SESSION["power"]<>0){

		$hostweb_power='http://'.$_SERVER['HTTP_HOST'].'/admin/include/noroot.html';

		header("location: $hostweb_power");

		exit();

}	    

?>