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

$autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

$other = $_SESSION["cart"].'|'.$_GET['email'].'|'.$_GET['client'].'|'.$_GET['phone'].'|'.$_GET['note'].'|'.$_GET['payment'].'|'.$_GET['atm5'];

$input = [
    'MerchantID' => EC_MERCHANTID,
    'MerchantTradeNo' => 'enbi-'.time().uniqid(),
    'LogisticsType' => 'CVS',
    'LogisticsSubType' => 'UNIMARTC2C',
    'IsCollection' => 'N',
    'ServerReplyURL' => EC_REPLYURL,
    'ExtraData' => $other
];

$action = EC_MAPACTION;

echo $autoSubmitFormService->generate($input, $action);

?>