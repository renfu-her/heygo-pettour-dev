<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

require 'class.phpmailer.php';
mb_internal_encoding('UTF-8');
try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$body             = "郵件內容";
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP server port
	$mail->Host       = "smtp.gmail.com"; // SMTP server
	$mail->Username   = "webgsandmail@gmail.com";     // SMTP server username
	$mail->Password   = "2rxiadil";            // SMTP server password

	$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("bossily@gmail.com","First Last");

	$mail->From       = "webgsandmail@gmail.com";
	$mail->FromName   = "測試郵件名";

	$to = "bossily@gmail.com";

	$mail->AddAddress($to);

	$mail->Subject  = "郵件標題";

	$mail->AltBody    = "要查看郵件，請使用HTML兼容的郵件閱讀器！"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo '訊息已送出';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>