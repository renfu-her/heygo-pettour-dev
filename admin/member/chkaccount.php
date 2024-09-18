<?php
$host ="localhost";
$user="bossily";
$pass="2rxiadil";
$database="webadmin";
$link=mysql_connect($host,$user,$pass) or die("無法連結資料庫".mysql_error());
$db=mysql_select_db($database,$link) or die("資料庫錯誤".mysql_error());

//解決phpMyAdmin亂碼問題
mysql_query('SET NAMES utf8');
mysql_query('SET CHARACTER_SET_CLIENT=utf8');
mysql_query('SET CHARACTER_SET_RESULTS=utf8');


$account = $_GET["q"];;
//查詢資料表算出總筆數
$sql="SELECT * 
FROM `member` 
WHERE `member_id` = '$account'
";
$result_total=mysql_query($sql);
$total=mysql_num_rows($result_total);//算出總筆數

if ($total>=1)
	{
	echo '<font color="#ff0000">'.'帳號已有人使用,請換新的帳號繼續'.'</font>';	
	}
	
else {
	echo '';
	}

?>
