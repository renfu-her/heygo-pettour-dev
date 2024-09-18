<?php
session_start();

use Ecpay\Sdk\Factories\Factory;

require_once("./admin/common.func.php");
require_once("vendor/autoload.php");

$factory = new Factory([
    'hashKey' => EC_HASHKEY,
    'hashIv' => EC_HASHIV,
    'hashMethod' => 'md5',
]);

//查詢訂單
$order_cart = $_REQUEST['order_cart'];
$rs = $db->prepare("SELECT * FROM order_form WHERE order_cart = :order_cart");
$rs->bindValue(':order_cart', $order_cart, PDO::PARAM_STR);
$rs->execute();
$row = $rs->fetch(PDO::FETCH_ASSOC);

$postService = $factory->create('PostWithCmvEncodedStrResponseService');

$ny = ($row['order_payment']=='貨到付款')?'Y':'N';

$input = [
    'MerchantID' => EC_MERCHANTID,
    'MerchantTradeNo' => $row['MerchantTradeNo'],
    'MerchantTradeDate' => date('Y/m/d H:i:s'),
    'LogisticsType' => 'CVS',
    'LogisticsSubType' => 'UNIMARTC2C',
    'GoodsAmount' => $row['order_total'],
    'CollectionAmount' => $row['order_total'],
    'GoodsName' => $row['order_cart'],
    'SenderName' => EC_SEND_NAME,
    'SenderCellPhone' => EC_SEND_PHONE,
    'ReceiverName' => $row['order_client'],
    'ReceiverCellPhone' => $row['order_phone'],
    'ServerReplyURL' => EC_CREATE_REPLYURL,
    'ReceiverStoreID' =>  $row['CVSStoreID'],
    'ReceiverEmail' =>  $row['order_email'],
    'IsCollection' =>  $ny,
];

$url = EC_CREATEACTION;

$response = $postService->post($input, $url);

//先寫入綠界回傳紀錄
$ec_content = '';
$ec_date = date('Y-m-d H:i:s');

foreach($response as $key=>$val){
	$ec_content .= $key.':'.$val.'|';
}

$inst_rs = $db->prepare("INSERT `ec_log` (order_cart, MerchantTradeNo, ec_content, ec_date) VALUES(:order_cart, :MerchantTradeNo, :ec_content, :ec_date)");
$inst_rs->bindValue(':order_cart', $order_cart, PDO::PARAM_STR);
$inst_rs->bindValue(':MerchantTradeNo', $row['MerchantTradeNo'], PDO::PARAM_STR);
$inst_rs->bindValue(':ec_content', $ec_content, PDO::PARAM_STR);
$inst_rs->bindValue(':ec_date', $ec_date, PDO::PARAM_STR);
$inst_rs->execute();

$up_rs = $db->prepare("UPDATE order_form SET AllPayLogisticsID = :AllPayLogisticsID, CVSPaymentNo = :CVSPaymentNo, CVSValidationNo = :CVSValidationNo WHERE order_cart = :order_cart");
$up_rs->bindValue(':AllPayLogisticsID', $response['1|AllPayLogisticsID'], PDO::PARAM_STR);
$up_rs->bindValue(':CVSPaymentNo', $response['CVSPaymentNo'], PDO::PARAM_STR);
$up_rs->bindValue(':CVSValidationNo', $response['CVSValidationNo'], PDO::PARAM_STR);
$up_rs->bindValue(':order_cart', $order_cart, PDO::PARAM_STR);
$up_rs->execute();

//var_dump($response);
?>