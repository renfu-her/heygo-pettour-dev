<?PHP
if (!isset($_SESSION)) {
 	 session_start();
	}

session_unset();
session_destroy();
echo '<script language="javascript">';
echo 'location.href= ("../login.php");';
echo '</script>';

?>