<?php
if (!isset($_SESSION)) {//設定session起始
 	 session_start();
	}


include "./admin/common.func.php";
//require "include/config.php";//引入 網頁連結資料庫

echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$cart = $_GET["cart"];//訂單編號

//判斷訂單是否重複下單
//查詢
$sql="SELECT * 
FROM `order_form` 
WHERE `order_cart` = :cart
";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':cart', $cart, PDO::PARAM_STR);

$result->execute();
$total=$result->rowCount();//算出總筆數

if ($total>=1)
{
	$_SESSION["cart"]='';//刪除購物車
	echo '<script language="javascript">';
	echo 'alert("已順利送出資訊，我們將會盡快與您做聯繫，謝謝您!");';
	echo 'location.href= ("./index.php");';
	echo '</script>';		
	exit();
}
//判斷訂單是否重複下單

$shipping        = $_POST["shipping"];        //運送方式
$MerchantTradeNo = $_POST["MerchantTradeNo"]; //廠商交易編號
$CVSStoreID      = $_POST["CVSStoreID"];      //使用者選擇的超商店舖編號
$CVSStoreName    = $_POST["CVSStoreName"];    //使用者選擇的超商店舖名稱
$CVSAddress      = $_POST["CVSAddress"];      //使用者選擇的超商店舖地址
$CVSTelephone    = $_POST["CVSTelephone"];    //使用者選擇的超商店舖電話

$payment         = $_POST["payment"]; // 付款方式
$email	         = $_POST["email"]; // Email
$client	         = $_POST["client"]; // 收件人
$phone	         = $_POST["phone"]; // 連絡電話
$city	         = $_POST["city"]; // 縣市
$district        = $_POST["district"]; // 區域
$address         = $_POST["address"]; // 地址
$note	         = $_POST["note"]; // 其他備註
$subtotal        = $_POST["subtotal"];//商品加總金額
$freight         = $_POST["freight"];//運費
$total	         = $_POST["total"];//訂單總金額

if($shipping!='店到店'){
    
    $MerchantTradeNo = ''; //廠商交易編號
    $CVSStoreID      = ''; //使用者選擇的超商店舖編號
    $CVSStoreName    = ''; //使用者選擇的超商店舖名稱
    $CVSAddress      = ''; //使用者選擇的超商店舖地址
    $CVSTelephone    = ''; //使用者選擇的超商店舖電話
    
}

$status ='已收到訂單';//狀態


if (!empty($_SERVER['HTTP_CLIENT_IP']))
	$ip=$_SERVER['HTTP_CLIENT_IP'];
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
else
	$ip=$_SERVER['REMOTE_ADDR'];

putenv("TZ=Asia/Taipei");//調整時間為台北時區
		$t1 = date("Y")-1911; 
		$t2 = date("md"); 
		$date=(int)($t1.$t2);//訂單日期
		$time = date("his"); //訂單時間
		$buydate=$t1.'-'.date("m-d").' '.date("h:i:s");//購買時間
		$showdate=mb_strimwidth($buydate, 0, 10, '', 'UTF-8');//只傳送年月日



$sql="INSERT INTO `order_form` (
`order_no`, `order_cart`, `order_shipping`, `order_payment`, `order_email`, `order_client`, `order_phone`, `order_city`, `order_district`, `order_address`, `order_note`, `order_subtotal`, `order_freight`, `order_total`, `order_ip`, `order_buydate`, `order_status`, `MerchantTradeNo`, `CVSStoreID`, `CVSStoreName`, `CVSAddress`, `CVSTelephone`
) VALUES (
NULL, :cart, :shipping, :payment, :email, :client, :phone, :city, :district, :address, :note, :subtotal,:freight, :total, :ip, :buydate, :status, :MerchantTradeNo, :CVSStoreID, :CVSStoreName, :CVSAddress, :CVSTelephone );";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':cart', $cart, PDO::PARAM_STR);
	$result->bindValue(':shipping', $shipping, PDO::PARAM_STR);
	$result->bindValue(':payment', $payment, PDO::PARAM_STR);
	$result->bindValue(':email', $email, PDO::PARAM_STR);
	$result->bindValue(':client', $client, PDO::PARAM_STR);
	$result->bindValue(':phone', $phone, PDO::PARAM_STR);
	$result->bindValue(':city', $city, PDO::PARAM_STR);
	$result->bindValue(':district', $district, PDO::PARAM_STR);
	$result->bindValue(':address', $address, PDO::PARAM_STR);
	$result->bindValue(':note', $note, PDO::PARAM_STR);
	$result->bindValue(':subtotal', $subtotal, PDO::PARAM_STR);
	$result->bindValue(':freight', $freight, PDO::PARAM_STR);
	$result->bindValue(':total', $total, PDO::PARAM_STR);
	$result->bindValue(':ip', $ip, PDO::PARAM_STR);
	$result->bindValue(':buydate', $buydate, PDO::PARAM_STR);
    $result->bindValue(':status', $status, PDO::PARAM_STR);
    $result->bindValue(':MerchantTradeNo', $MerchantTradeNo, PDO::PARAM_STR);
    $result->bindValue(':CVSStoreID', $CVSStoreID, PDO::PARAM_STR);
    $result->bindValue(':CVSStoreName', $CVSStoreName, PDO::PARAM_STR);
    $result->bindValue(':CVSAddress', $CVSAddress, PDO::PARAM_STR);
    $result->bindValue(':CVSTelephone', $CVSTelephone, PDO::PARAM_STR);
	$result->execute();

//新增訂購商品資訊order_cart
  
//列出內容
$no_id=0;
$sql_main="
SELECT * FROM cart 
where cart_order_no=:cart
ORDER BY `cart_no` DESC
";
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->bindValue(':cart', $cart, PDO::PARAM_STR);

$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if($counts_main<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows_main = $result_main->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
	//列出內容	
	$order_no			=	$rows_main["cart_order_no"];//訂單編號
	$class_name			=	$rows_main["cart_class_name"];//商品選擇型號
	$class_money		=	$rows_main["cart_class_money"];//商品原價
	$class_money2		=	$rows_main["cart_class_money2"];//商品優惠價
	$pdt_no				=	$rows_main["cart_pdt_no"];//商品NO
	$pdt_name			=	$rows_main["cart_pdt_name"];//商品名稱
	$pdt_pic			=	$rows_main["cart_pdt_pic"];//商品照片
	$pdt_description	=	$rows_main["cart_pdt_description"];//商品描述
	$order_time			=	$rows_main["cart_order_time"];//加入時間
	   
	$number				=	$_POST["buy_number_$no_id"];//數量 從表單裡抓
	   
	//將購物車內容加入資料庫

	//新增
	$sql="INSERT INTO `order_cart` (
	`cart_order_no` ,
	`cart_class_name` ,
	`cart_class_money`,
	`cart_class_money2`,
	`cart_pdt_no`,
	`cart_pdt_name`,
	`cart_pdt_pic`,
	`cart_pdt_description`,
	`cart_order_time`,
	`cart_number`
	)	VALUES (
	:order_no,
	:class_name,
	:class_money,
	:class_money2,
	:pdt_no,
	:pdt_name,
	:pdt_pic,
	:pdt_description,
	:order_time,
	:number
	)";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':order_no', $order_no, PDO::PARAM_STR);
	$result->bindValue(':class_name', $class_name, PDO::PARAM_STR);
	$result->bindValue(':class_money', $class_money, PDO::PARAM_STR);
	$result->bindValue(':class_money2', $class_money2, PDO::PARAM_STR);
	$result->bindValue(':pdt_no', $pdt_no, PDO::PARAM_INT);
	$result->bindValue(':pdt_name', $pdt_name, PDO::PARAM_STR);
	$result->bindValue(':pdt_pic', $pdt_pic, PDO::PARAM_STR);
	$result->bindValue(':pdt_description', $pdt_description, PDO::PARAM_STR);
	$result->bindValue(':order_time', $order_time, PDO::PARAM_STR);
	$result->bindValue(':number', $number, PDO::PARAM_STR);
	$result->execute();  
	}
}
//新增訂購商品資訊order_cart


//刪除cart購物車商品
$sql="DELETE FROM cart WHERE cart_order_no =:cart;";
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':cart', $cart, PDO::PARAM_STR);
$result->execute();
//刪除cart購物車商品
?>
<?PHP
//發送通知信
	$sql="SELECT * FROM `webinfo`";
	$result = $db->prepare("$sql");//防sql注入攻擊
	$result->execute();
	$rows = $result->fetch(PDO::FETCH_ASSOC);

	$send_email=$rows["send_email"];//收件者	
	$send_conpany=$rows['conpany'];//公司名稱
	
	$HTTP_HOST=$_SERVER['HTTP_HOST'];//網址
	

	
	//Mail
			$message  ="
			<table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td height='61' align='center'><strong><font size='4'>$send_conpany</font></strong></td>
  </tr>
  <tr>
    <td height='44' align='right'>訂購日期 ： $showdate</td>
  </tr>
  <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>
  <tr>
    <td align='center'  height='30'>訂單明細</td>
  </tr>
   <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>
  <tr>
    <td align='left' height='30'>訂單編號 : $cart</td>
  </tr>
  <tr>
    <td align='left' height='30'>運送方式    ： $shipping </td>
  </tr>
  <tr>
    <td align='left' height='30'>付款方式    ： $payment </td>
  </tr>
  <tr>
    <td align='left' height='30'>收件人    ： $client </td>
  </tr>
  <tr>
    <td align='left' height='30'>電子郵件    ： $email </td>
  </tr>  
  <tr>
    <td align='left' height='30'>聯絡電話 ： $phone</td>
  </tr> 
";

if($shipping=='宅配'){
$message  .="  <tr>
    <td align='left' height='30'>地址 ： $city $district $address</td>
  </tr>  
";
}
$message  .="
  <tr>
    <td align='left'>&nbsp;</td>
  </tr>
  <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>
     <tr>
      <td align='left' height='30'>備註 :</td>
    </tr>
    <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>
    <tr>
      <td align='left' height='30'>".nl2br($note)."</td>
    </tr>
   
</table>
";


$message  .="<table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
   <tr>
      <td height='30' align='left'colspan='4'></td>
    </tr>
    <tr>
      <td height='2' align='left' bgcolor='#eeeeee' colspan='4'></td>
    </tr>
    <tr>
      <td align='center' height='30' width='90'>圖片</td>
      <td align='center'>品名</td>
	  <td align='center' width='90'>數量</td>
      <td align='center' width='100'>單價</td>
      
    </tr>
    <tr>
      <td height='2' align='left' bgcolor='#eeeeee' colspan='4'></td>
    </tr>";

	$no_id=0;
$sql_main="
SELECT * FROM order_cart 
where cart_order_no=:cart
ORDER BY `cart_no` DESC
";
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->bindValue(':cart', $cart, PDO::PARAM_STR);

$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if($counts_main<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows_item = $result_main->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;

		$message  .="
			<tr>
		 <td align='left' height='30'>
			  <img src='https://"
			.$_SERVER['HTTP_HOST'].
			"/admin/cart_pic/"
			.$rows_item["cart_pdt_pic"].
			"' width='80'  border='1' style='border-color:#666666; border-style:solid;' >
		 </td>
		  <td align='left'>"
			.$rows_item["cart_pdt_name"].
			"<BR>".
			$rows_item["cart_class_name"].	
			" </td>
			<td align='center'>"
			.$rows_item["cart_number"].			 			 
		  " </td>
		  <td align='right'>".$rows_item["cart_class_money2"]."元</td>
		  
		</tr>
		<tr>
      <td height='2' align='left' bgcolor='#eeeeee' colspan='4'></td>
    </tr>
		";
		
}
	}
	


$message  .="<tr>
      <td colspan='4' align='right' height='30'>
      運費：$freight 元
	</td>
    </tr>   
	<tr>
      <td colspan='4' align='right' height='30'>
      訂單總金額：$total 元
	</td>
    </tr>   
</table>";

//如果選擇ATM顯示轉帳資訊
if($payment=="ATM繳費"){
$message  .="
<table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center'  height='30'></td>
  </tr>
  <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>
  <tr>
    <td align='center'  height='30'>匯款資料</td>
  </tr>
   <tr>
    <td height='2' align='left' bgcolor='#eeeeee'></td>
  </tr>  
    <tr>
    <td align='left' height='30'>
		 代碼 : 822
    </td>
  </tr>  
    <tr>
    <td align='left' height='30'>		 
		 銀行 : 富邦銀行
    </td>
  </tr>  
    <tr>
    <td align='left' height='30'>		
		 帳號 : 901540650970
    </td>
  </tr> 
   <tr>
    <td align='left' height='30'>
		 戶名 : 富御寢飾有限公司
    </td>
  </tr> 
</table>";
}
//如果選擇ATM顯示轉帳資訊

$message  .="
<table width='700' border='0' align='center' cellpadding='0' cellspacing='0'>
  <tr>
      <td align='left'>      
      <BR><BR>購物網站：<a href='$HTTP_HOST'>$HTTP_HOST</a></td>
    </tr>  
</table>";


	//mail發送
	    //設定time out
		set_time_limit(120);
		//echo !extension_loaded('openssl')?"Not Available":"Available";

		require_once("./PHP_Mailer/PHPMailerAutoload.php"); //記得引入檔案 
		$mail = new PHPMailer;
		$mail->CharSet = "utf-8"; //郵件編碼
		//寄信的程式頁面加入這一行

	//$mail->SMTPDebug = 3; // 開啟偵錯模式
		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = "$PHP_Mailer_host"; // Specify main and backup SMTP servers
		$mail->SMTPAuth = "$PHP_Mailer_SMTPAuth"; // Enable SMTP authentication
		//$mail->Username = '寄件者gmail'; // SMTP username
		$mail->Username = "$PHP_Mailer_Username"; // SMTP username
		//$mail->Password = "寄件者gmail密碼"; // SMTP password
		$mail->Password = "$PHP_Mailer_Password"; // SMTP password
		$mail->SMTPSecure = "$PHP_Mailer_SMTPSecure"; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = "$PHP_Mailer_Port"; // TCP port to connect to

		//$mail->setFrom('寄件者gmail', '名字'); //寄件的Gmail
		$mail->setFrom("$PHP_Mailer_setFrom_mail", "$PHP_Mailer_setFrom_name"); //寄件的Gmail
		//$mail->addAddress('收件者信箱', '收件者名字'); // 收件的信箱
		
		$mail->addAddress("$email", "$email");//發給訂購者mail

		//多收件者處理
		$send_email_array = explode(",", $send_email); //根據,切割存陣列
		$send_email_count = count($send_email_array);//計算陣列數量
		$i=0;

		for ($i = 0; $i < $send_email_count; $i++) {
			$send_email_tmp = $send_email_array[$i]; // 收件者邮箱
			$mail->addBCC($send_email_tmp, $send_email_tmp); // 以密件副本方式添加收件人
		}
		//多收件者處理
		
	
		$mail->isHTML(true); // Set email format to HTML


		/*
			內文
		*/
	    
	    $mail->Subject = '=?utf-8?B?' . base64_encode("[ $send_conpany ] 訂單成立來信通知") . '?=';
		$mail->Body = "$message"; //郵件內容
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$_SESSION["cart"]='';//刪除購物車
//購買完成後刪除購物車內該筆訂單

		if(!$mail->send()) {
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		 	echo "<Script Language =\"Javascript\">";
			echo "alert('伺服器寄送失敗，或請直接來信或來電連繫，謝謝您!');";
			echo "location='./';";
			echo "</script>";
		} else {
			echo "<Script Language =\"Javascript\">";
			echo "alert('已順利送出資訊，我們將會盡快與您做聯繫，謝謝您!');";
			echo "location='./';";
			echo "</script>";	
		}
	    //mail發送
	
//是否為店到店
if($shipping=='店到店'){
    
    $url = 'https://shop.enbi.com.tw/CreateCvs.php?order_cart='.$cart;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);
    curl_close($ch);

}