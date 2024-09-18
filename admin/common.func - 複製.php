<?php
//如果有開https就自動連上
if ($_SERVER["HTTPS"] <> "on")
{
    $xredir="https://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    header("Location: ".$xredir);
}
//如果有開https就自動連上
//取得目前網址
$PAGE_URL='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


//取得目前網址
$compony='恩比寢飾';
$year='2023';
$version='3.0.0';

//上傳檔案大小設定
$Upload_File_MaxSize='2048';//1024=1M
$Upload_File_MaxSizetxt='檔案過大，請重新上傳小於2M圖檔';//文字說明大小
$UpLoadPicMax_b='1920';//大圖縮圖
$UpLoadPicMax_s='600';//大圖縮圖


//我不是機器人設定
$google_data_sitekey="6LfAeFUmAAAAAC_dZrhMzzybJWsaMCbf9RJkz8Q4";
$google_secretKey="6LfAeFUmAAAAACIKmSopNi8aBpm8CVsY3rRB1OMe";

//PHP_Mailer設定檔
		$PHP_Mailer_host="smtp.gmail.com"; // Specify main and backup SMTP servers
		$PHP_Mailer_SMTPAuth="true"; // Enable SMTP authentication
		$PHP_Mailer_Username="bloomami2022@gmail.com"; // SMTP username
		$PHP_Mailer_Password="owectxuwfbapejsn"; // SMTP password
		$PHP_Mailer_SMTPSecure="tls"; // Enable TLS encryption, `ssl` also accepted
		$PHP_Mailer_Port="587"; // TCP port to connect to
		//$mail->setFrom('寄件者gmail', '名字'); //寄件的Gmail
		$PHP_Mailer_setFrom_mail="bloomami2022@gmail.com";
		$PHP_Mailer_setFrom_name="恩比居家活動專案(系統發送通知信件，請勿直接回信)"; //寄件的Gmail


//連線
putenv("TZ=Asia/Taipei");//設定時區
ini_set('date.timezone','Asia/Taipei');  
$Day = date("Y-m-d");//今天日期

//綠界設定
/*
測試特店資料：C2C
特店編號(MerchantID)：2000933
廠商後台登入帳號：LogisticsC2CTest
廠商後台登入密碼：test1234
廠商後台登入統一編號：59780857
串接金鑰HashKey：XBERn1YOvpM9nfZc
串接金鑰HashIV：h1ONHk4P4yqbl5LK

門市電子地圖API介接網址
測試環境：https://logistics-stage.ecpay.com.tw/Express/map
正式環境：https://logistics.ecpay.com.tw/Express/map

門市訂單建立API介接網址
測試環境：https://logistics-stage.ecpay.com.tw/Express/Create
正式環境：https://logistics.ecpay.com.tw/Express/Create
*/

//正式用
/*
define('EC_HASHKEY','RCnxE6Fe9vHA6tDJ');
define('EC_HASHIV','VgNv25C46IWzYem4');
define('EC_MERCHANTID','3080892');
define('EC_REPLYURL','https://shop.enbi.com.tw/index.php');
define('EC_MAPACTION','https://logistics.ecpay.com.tw/Express/map');
define('EC_CREATE_REPLYURL','https://shop.enbi.com.tw/CreateOk.php');
define('EC_CREATEACTION','https://logistics.ecpay.com.tw/Express/Create');
define('EC_SEND_NAME','恩比居家'); //店到店寄件名稱
define('EC_SEND_PHONE','0912345678'); //店到店寄件電話
*/

//測試用
define('EC_HASHKEY','XBERn1YOvpM9nfZc');
define('EC_HASHIV','h1ONHk4P4yqbl5LK');
define('EC_MERCHANTID','2000933');
define('EC_REPLYURL','https://shop.enbi.com.tw/index.php');
define('EC_MAPACTION','https://logistics-stage.ecpay.com.tw/Express/map');
define('EC_CREATE_REPLYURL','https://shop.enbi.com.tw/CreateOk.php');
define('EC_CREATEACTION','https://logistics-stage.ecpay.com.tw/Express/Create');
define('EC_SEND_NAME','恩比居家'); //店到店寄件名稱
define('EC_SEND_PHONE','0912345678'); //店到店寄件電話


/* MySQL設定 */
define('DB_NAME','goodwayt_Enbi_shop');
define('DB_USER','enbi_shop');
define('DB_PASSWD','9Crt>N+b!+6Q5b]');
define('DB_HOST','localhost');
define('DB_TYPE','mysql');

try {
	
	$db = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	//禁用預處理語句的模擬防注入攻擊
	
}catch(PDOException $e) {
	
	header("Content-Type:text/html; charset=utf-8");
	print_r($e->getMessage());
	die('<p><a href="https://www.webg.tw/" target="_blank">系統出現錯誤，請點此與管理員聯絡!!</a></p>');
	
}

?>