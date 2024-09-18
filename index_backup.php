<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
$_SESSION["bt"]='0';

if(!empty($_POST['ExtraData'])){
    $_SESSION["cart"] = $_POST['ExtraData'];
}

$order_no = $_SESSION["cart"];//訂單編號 

include "./admin/common.func.php";

$sql="SELECT * FROM `webinfo`";
$result = $db->prepare("$sql");//防sql注入攻擊
$result->execute();
$rows = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-Hant">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="<?=$rows["keywords"];?>" />
<meta name="description" content="<?=$rows["description"];?>" />
<meta name="author" content="">
<meta property="og:title" content="<?=$rows["conpany"];?>"/>
<meta property="og:description" content="<?=$rows["description"];?>"/>
<meta property="og:type" content="website"/>
<meta property="og:site_name" content="<?=$rows["conpany"];?>" />
<meta property="og:image" content="https://<?=$_SERVER['HTTP_HOST']?>/admin/goods_pic/<?=$rows["share_pic"]; ?>"/>
<link rel="image_src" href="https://<?=$_SERVER['HTTP_HOST']?>/admin/goods_pic/<?=$rows["share_pic"]; ?>" />	
<title><?=$rows["conpany"];?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- FontAwesome core CSS -->
  <link href="vendor/fontawesome/css/all.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/onepage.css" rel="stylesheet">
<script>
	window.onload = function() {
    showme();//開啟網頁時就執行一次	
  };
  function showme() {
<?PHP 
//列出內容
$sql_cart="SELECT * FROM cart where cart_order_no=:order_no ORDER BY `cart_no` DESC";
	  
$result_cart = $db->prepare("$sql_cart");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_cart->bindValue(':order_no', $order_no, PDO::PARAM_STR);

$result_cart->execute();
$counts_cart=$result_cart->rowCount();//算出總筆數

?>
    var $count = <?=$counts_cart?>; // 商品總數量
	var $free_freight = <?=$rows["free_freight"];?>; // 免運門檻	  
    var $subtotal = 0; // 小計金額
	var $buy_total_number = 0; // 計算總共訂購的商品加總數量

    for (var $i = 1; $i <= $count; $i++) {
      var $no_price_tmp = document.getElementById('no_price_' + $i).value; // 抓出每次迴圈的單價
      var $buy_number_tmp = document.getElementById('buy_number_' + $i).value; // 抓出每次迴圈的數量

      // 限制輸入最大只能到100
      if ($buy_number_tmp > 100) {
        document.getElementById('buy_number_' + $i).value = 100;
        return false;
      }

      // 限制輸入最小只能到1
      if ($buy_number_tmp < 1) {
        document.getElementById('buy_number_' + $i).value = 1;
        return false;
      }

      $subtotal += parseFloat($no_price_tmp) * parseFloat($buy_number_tmp);
	  $buy_total_number +=parseFloat($buy_number_tmp); // 計算總共訂購的商品加總數量
    }
	  
//小計顯示
    var subtotalElement = document.getElementById("txt_subtotal");
    subtotalElement.innerHTML = "$" + $subtotal.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	  
	var subtotalElement = document.getElementById("txt_subtotal2");
    subtotalElement.innerHTML = "$" + $subtotal.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	  

//小計傳送值	  
var subtotalInput = document.querySelector("input[name='subtotal']");
subtotalInput.value = $subtotal;


	  
	  
// 計算總共訂購的商品加總數量
// 初始隱藏 C 區塊711_div隱藏
document.getElementById('711_div').style.display = 'none';
	  
var buy_total_number = document.querySelector("input[name='buy_total_number']");
buy_total_number.value = $buy_total_number;

   // 判斷條件
    if ($buy_total_number >= 2) {
		// 預設地址資訊要填寫
		document.getElementById('711_div').style.display = 'none';
		document.getElementById('address_div').style.display = 'block';
		document.getElementById('addr01').setAttribute('required', 'required');
		document.getElementById('addr02').setAttribute('required', 'required');
		document.getElementById('address').setAttribute('required', 'required');
		
      // 當 #buy_total_number 大於 2 時，設定店到店選項不可點擊
      document.getElementById('shipping2').disabled = true;
      
      // 將宅配設為預設選項
      document.getElementById('shipping1').checked = true;
		
		// 點擊 A 按鈕顯示 C 區塊
			document.getElementById('711_show').addEventListener('click', function() {
					// 跳出訊息
					alert("您的商品已超過門市材積限制,請改選宅配運送。");
					document.getElementById('711_div').style.display = 'none';
					document.getElementById('address_div').style.display = 'block';
					document.getElementById('addr01').setAttribute('required', 'required');
					document.getElementById('addr02').setAttribute('required', 'required');
					document.getElementById('address').setAttribute('required', 'required');
		  });
        
          return false;
		
    } else {
		// 跳出訊息
  		//alert("關閉"+ $buy_total_number);
      // 當 #buy_total_number 小於等於 2 時，店到店選項可點擊
      
      // 取消店到店選項的不可點擊狀態
      document.getElementById('shipping2').disabled = false;
      
      // 將宅配設為預設選項
      document.getElementById('shipping1').checked = true;	
		
				 // 取貨門市和地址顯示隱藏

				  // 點擊 A 按鈕顯示 C 區塊
				  document.getElementById('711_show').addEventListener('click', function() {
					document.getElementById('711_div').style.display = 'block';
					document.getElementById('address_div').style.display = 'none';
					document.getElementById('addr01').removeAttribute('required');
					document.getElementById('addr02').removeAttribute('required');
					document.getElementById('address').removeAttribute('required');
					 
				  });

				  // 點擊 B 按鈕隱藏 C 區塊
				  document.getElementById('711_hide').addEventListener('click', function() {
					document.getElementById('711_div').style.display = 'none';
					document.getElementById('address_div').style.display = 'block';
					document.getElementById('addr01').setAttribute('required', 'required');
					document.getElementById('addr02').setAttribute('required', 'required');
					document.getElementById('address').setAttribute('required', 'required');
			
				  });
				//取貨門市和地址顯示隱藏
    }	  

// 計算總共訂購的商品加總數量
	  

  
	  
	  
	  
//運費	  
	  
	  // 是否免运
if ($subtotal >= $free_freight) {
  $freight = 0; // 免运
} else {
  // 根据配送方式设置运费
  var shippingRadio = document.querySelector('input[name="shipping"]:checked');
  if (shippingRadio.value == "宅配") {
    $freight = 150;
  } else if (shippingRadio.value == "店到店") {
    $freight = 60;
  }
}
	  
    //運費顯示
	var freight = document.getElementById("txt_freight");
    freight.innerHTML = "$" + $freight.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    //小計傳送值
	var freight = document.querySelector("input[name='freight']");
	freight.value = $freight;

	  
	  
    //總金額
	 $total = parseFloat($subtotal) + parseFloat($freight); 
	  
    //總金額顯示
	var total = document.getElementById("txt_total");
    total.innerHTML = "$" + $total.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    //總金額傳送值	  
	var total = document.querySelector("input[name='total']");
	total.value = $total;
	  
	  
  }

</script>
</head>

<body>

  <!-- Header -->
  <header class="sale-top">
      <h3 class="font-weight-bold mb-0">全館購物 滿$
      		<?PHP		  
		    $number = $rows["free_freight"];
			$formattedNumber = number_format($number);
			echo $formattedNumber; // 输出：1,234,567
		  	?>免運費</h3>
  </header>

  <!-- Page Content -->
  <div class="container">

    <div class="edm-top"  id="img-responsive">
       <?PHP
		$sql_about="SELECT * FROM `about`";
		$result_about = $db->prepare("$sql_about");//防sql注入攻擊
		$result_about->execute();
		$rows_about = $result_about->fetch(PDO::FETCH_ASSOC);
		?>
   		<?=$rows_about["content"]; ?>
    </div>

    <!-- Marketing Icons Section -->
    <div id="item-row" class="items">
      <div class="row">
      <?php
//使用分頁控制必備變數--開始						
$Day = date("Y-m-d H:i:s");//今天日期

include "./admin/include/pages.php";
$pagesize='9999';//設定每頁顯示資料量
$phpfile = 'index.php';//使用頁面檔案
$page= isset($_GET['page'])?$_GET['page']:1;//如果沒有傳回頁數，預設為第1頁


//查詢
$sql_main="
SELECT * FROM goods_item 
WHERE goods_item_hide=1 
";//算總頁數用
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if ($page>$counts_main) $page = $counts_main;//輸入值大於總數則顯示最後頁
else $page = intval($page);//當前頁面-避免非數字頁碼
$getpageinfo = page($page,$counts_main,$phpfile,$pagesize);//將函數傳回給pages.php處理
$page_sql_start=($page-1)*$pagesize;//資料庫查詢起始資料
?>
<?PHP 
//列出內容
$no_id=$no_id+$start+(($page-1)*$pagesize);//流水號

$sql_main="
SELECT * FROM goods_item 
WHERE goods_item_hide=1 
ORDER BY `goods_item_sort` ,`goods_item_no` DESC 
LIMIT :page_sql_start , :pagesize";
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->bindValue(':page_sql_start', $page_sql_start, PDO::PARAM_INT);
$result_main->bindValue(':pagesize', $pagesize, PDO::PARAM_INT);
$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if($counts_main<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows_main = $result_main->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
?>	   
       <!---->
        <div class="col-lg-4 col-12 mb-md-5 mb-4">
          <div class="card h-100">
            <img class="card-img-top" src="./admin/goods_pic/<?=$rows_main["goods_item_pic_s"];?>" alt="<?=$rows_main["goods_item_title"]; ?>"  style="aspect-ratio: 250/250">
            <form id="myForm" action="cart.php" method="post">
            <div class="card-body">
              <h5 class="card-title"><?=$rows_main["goods_item_title"]; ?></h5>
              <p class="card-text"><?=$rows_main["goods_item_description"]; ?></p>              
              
             <?PHP if($rows_main["goods_item_class"]<>",") { //有選規格才顯示購物資訊?>
               <div class="dropdown mb-3">
              
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  請選規格
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                 <?PHP 	
					$goods_item_class=substr($rows_main["goods_item_class"], 1, -1);//包含的類別,去掉前後的逗號
					//列出內容
					$sql_left="SELECT * 
							FROM `goods_class` 
								where goods_class_hide=1 AND goods_class_no IN ($goods_item_class)
							ORDER BY `goods_class_sort` ,`goods_class_no` DESC 
					 ";

					$result_left = $db->prepare("$sql_left");//防sql注入攻擊
					// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
					//$result->bindValue(':id', $id, PDO::PARAM_INT);
					$result_left->execute();

					$counts_left=$result_left->rowCount();//算出總筆數
					if($counts_left<>0){//如果判斷結果有值才跑回圈抓資料
					   while($rows_left = $result_left->fetch(PDO::FETCH_ASSOC)) {
					$no_id=$no_id+1;
					?>
                  <span class="dropdown-item"><?=$rows_left["goods_class_name"]; ?></span>
                  <?php	
					}
					}
					?>
                </div>
              </div>
              <div class="price-row">
               
               <?PHP // 先預設選一個最低價的顯示
				$sql_money="SELECT * 
							FROM `goods_class` 
								where goods_class_hide=1 AND goods_class_no IN ($goods_item_class)
							ORDER BY `goods_class_sort` ,`goods_class_no` DESC ";
				$result_money = $db->prepare("$sql_money");//防sql注入攻擊
				$result_money->execute();
				$rows_money = $result_money->fetch(PDO::FETCH_ASSOC);
				?>
				
                <h5 class="ori-price mb-2"><s>原價 <span>$<?=$rows_money["goods_class_money"]; ?></span></s></h5>
                <h5 class="promo-price mb-2">優惠價 <span>$<?=$rows_money["goods_class_money2"]; ?></span></h5>  
              </div>
              <input type="hidden" name="class_name" value="<?=$rows_money["goods_class_name"]; ?>">
              <input type="hidden" name="class_money" value="<?=$rows_money["goods_class_money"]; ?>">
              <input type="hidden" name="class_money2" value="<?=$rows_money["goods_class_money2"]; ?>">
              <input type="hidden" name="pdt_no" value="<?=$rows_main["goods_item_no"]; ?>">
              <input type="hidden" name="pdt_pic" value="<?=$rows_main["goods_item_pic_b"]; ?>">
              <input type="hidden" name="pdt_name" value="<?=$rows_main["goods_item_title"]; ?>">
              <input type="hidden" name="pdt_description" value="<?=$rows_main["goods_item_description"]; ?>">
			<?PHP } //有選規格才顯示購物資訊?>	
            </div>
            <?PHP if($rows_main["goods_item_class"]<>",") { //有選規格才顯示購物資訊?> 
            <div class="card-footer">
				<button type="submit" class="btn btn-main btn-block btn-rounded">
				  <h5 class="font-weight-bold text-white mb-0 p-2">我要訂購</h5>
				</button>
			</div>
            <?PHP } //有選規格才顯示購物資訊?>	
            </form>
          </div>
        </div>
       <!---->
<?php	
}
}
?>       
      </div>
      <!-- /.row -->  
    </div>
<?PHP if($counts_cart>0){ //有訂購商品才顯示?>
    <form action="./order_ok.php?cart=<?=$_SESSION["cart"]?>" method="post"  name="form_order" id="form_order">       
    <!-- Checkout Section -->
    <div id="checkout" class="checkout row mb-0 py-5">
     
      <div class="col-md-12">
        <div class="checkout-top mb-5">
          <h3 class="mid-title px-5">已選購商品</h3>
          <hr class="mid-line">
        </div>
        <!--給jquery點擊時觸發計算用showme();-->
		<DIV id="autoclickme"  onclick="showme();" style="display:none">觸發</DIV>
		<!--給jquery點擊時觸發計算用showme();-->
 <?PHP 
  
//列出內容
$no_id=0;
$sql_main="
SELECT * FROM cart 
where cart_order_no=:order_no
ORDER BY `cart_no` DESC
";
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->bindValue(':order_no', $order_no, PDO::PARAM_STR);

$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if($counts_main<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows_main = $result_main->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
?>	
 <!--buy item-->
  <div class="row checkout-row align-items-center mb-md-4 mb-3">
    <div class="col-md-2 col-4 px-md-3 pr-0">
      <img class="img-fluid" src="./admin/cart_pic/<?=$rows_main["cart_pdt_pic"];?>" alt="<?=$rows_main["cart_pdt_name"]; ?>"  style="aspect-ratio: 250/250">
    </div>
    <div class="col px-md-3 pr-0">
      <div class="d-flex flex-column justify-content-end h-100">
        <h5><?=$rows_main["cart_pdt_name"]; ?></h5>
        <p class="text-muted"><?=$rows_main["cart_class_name"]; ?></p>    
        <h4 class="price my-auto" name="price_<?=$no_id?>">$<?=$rows_main["cart_class_money2"]; ?></h4>
        <input type="hidden" name="no_price_<?=$no_id?>" id="no_price_<?=$no_id?>"  value="<?=$rows_main["cart_class_money2"]; ?>"/>
      </div>
    </div>
    <div class="col-md-5 col-12 py-3 pr-md-5">
      <div class="input-group">
        <span class="input-group-prepend">
          <button type="button" class="btn btn-outline-secondary btn-number px-md-5 minus-btn" data-type="minus" data-field="quant[1]" >
            <span class="fa fa-minus"></span></button>
        </span>
        <input type="text" name="buy_number_<?=$no_id?>" id="buy_number_<?=$no_id?>" class="form-control input-number text-center py-md-5 input-field" value="1" min="1"  style="background: #fff"  onchange="showme();">
        <span class="input-group-append">
          <button type="button" class="btn btn-outline-secondary btn-number px-md-5 plus-btn" data-type="plus" data-field="quant[1]">
            <span class="fa fa-plus"></span>
          </button>
        </span>
      </div>
    </div>
    <a href="cart_del_ok.php?no=<?=$rows_main["cart_no"]; ?>"><span class="close">&#10005;</span></a>
  </div>
  <!--buy item-->
  <?php	
}
}else{
?>
購物車暫無商品。
<?PHP }?>



        <div class="row total-row flex-column align-items-md-end align-items-center pr-md-5">
          <div class="d-flex justify-content-center align-items-center w-240 ">
    <h4 class="font-weight-bold">小計</h4>
    <h2 class="price font-weight-bold pl-3" id="txt_subtotal">$0</h2>    
  </div>
         <div  class="row total-row flex-column align-items-md-end align-items-center pr-md-5 mb-4" style="font-size: 26px;color: #c30d23"><strong>(滿$<?=number_format($rows["free_freight"], 0, '.', ',')?>免運費)</strong></div>
          
          <span class="btn btn-main btn-rounded w-240 px-5" data-toggle="modal" data-target="#checkoutModal"><h5 class="font-weight-bold text-white mb-0 p-2">立即結帳</h5></span>
          
          
<!--結帳畫面-->
          <!-- Modal -->

          <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
              <div class="modal-content">
                <div class="modal-header border-0">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-md-5">
                  <div class="row">
                    <div class="col-12 mb-4">
                      <h4>1.運送方式 </h4>
                      <div class="row ship-row align-items-center mb-4">
                        <div class='col-auto text-center' id="711_hide">
                          <input type="radio" name="shipping" id="shipping1" class="d-none imgbgchk" value="宅配" checked>
                          <label for="shipping1">
                            <img src="./img/shipping01.png" alt="宅配">
                            <span class="pl-2">宅配</span> 
                          </label>
                        </div>
						  
                        <div class='col-auto text-center' id="711_show">
                          <input type="radio" name="shipping" id="shipping2" class="d-none imgbgchk" value="店到店" >
                          <label for="shipping2">
                            <img src="./img/shipping02.png" alt="店到店"> 
                            <span class="pl-2">店到店</span>
                          </label>
                        </div>
						  
                      </div>
                      <input type="text" name="buy_total_number" id="buy_total_number" value="">
                      <span  style="color: #c30d23">【2筆訂單以上不可選店到店】</span>
                      <hr>
                    </div>

                    <div class="col-12 mb-4">
                      <h4>2.付款方式</h4>
                      <div class="row ship-row align-items-center mb-4">
                        <!-- 價格談不攏，作廢 -->
                        <!--
                        <div class='col-auto text-center'>
                          <input type="radio" name="payment" id="payment1" class="d-none imgbgchk" value="">
                          <label for="payment1">
                            <img src="./img/payment01.png" alt="線上刷卡">
                            <span class="pl-2">線上刷卡</span> 
                          </label>
                        </div> 
                        -->
                        <div class='col-auto text-center'>
                          <input type="radio" name="payment" id="payment2" class="d-none imgbgchk" value="貨到付款" checked>
                          <label for="payment2" id="atm_hide">
                            <img src="./img/payment02.png" alt="貨到付款">
                            <span class="pl-2">貨到付款</span> 
                          </label>
                        </div>
                        <div class='col-auto text-center'>
                          <input type="radio" name="payment" id="payment3" class="d-none imgbgchk" value="ATM繳費" >
                          <label for="payment3"  id="atm_show">
                            <img src="./img/payment03.png" alt="繳費"> 
                            <span class="pl-2">繳費</span>
                          </label>
                        </div>
                      </div>

                      <div class="row transfer-info-row mb-4" id="atm_div">
                        <div class='col-12'>
                          <div class="d-flex flex-md-row flex-column checkout-row align-items-md-center w-100">
                            <h4 class="text-center px-md-5">匯款資料</h4>
                            <ul class="list-unstyled mb-0">
                              <li class="mb-2">代碼 : 822</li>
                              <li class="mb-2">銀行 : 富邦銀行</li>
                              <li class="mb-2">帳號 : 901540650970</li>
                              <li class="mb-2">戶名 : 富御寢飾有限公司</li>
                            </ul>
                          </div>
                        </div>
                        
                      </div>
                      
                      <hr>
                    </div>

                    <div class="col-12 mb-4">
                      <h4>3.填寫收件人資料</h4>

                      <div class="row">
                        <div class='col-12 py-4'>
                          
                            <div class="form-group row">
                              <label for="email" class="col-md-2 col-12 col-form-label text-md-right">Email <span class="required">(必填)</span></label>
                              <div class="col-md-9 col-12">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="client" class="col-md-2 col-12 col-form-label text-md-right">收件人 <span class="required">(必填)</span></label>
                              <div class="col-md-9 col-12">
                                <input type="text" class="form-control form-control-lg" id="client" name="client" required>
                              </div>
                            </div>
                            <div class="form-group row">
                              <label for="phone" class="col-md-2 col-12 col-form-label text-md-right">連絡電話 <span class="required">(必填)</span></label>
                              <div class="col-md-9 col-12">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" required>
                              </div>
                            </div>
                            <div id="address_div">
                            <div class="form-group row">
                              <label for="inputAddress" class="col-md-2 col-12 col-form-label text-md-right" required>地址 <span class="required">(必填)</span></label>
                              <div class="col-md-9 col-12">
                                <div class="row">
                                  <div class="col-6 mb-3">
                                    <select class="custom-select custom-select-lg" id="addr01" name="city" onchange="updateDistricts()" required>
                                      <option value="" selected>縣市</option>
                                      <option value="基隆市">基隆市</option>
                                      <option value="台北市">台北市</option>
                                      <option value="新北市">新北市</option>
                                      <option value="桃園市">桃園市</option>
                                      <option value="新竹市">新竹市</option>
                                      <option value="新竹縣">新竹縣</option>
                                      <option value="苗栗縣">苗栗縣</option>
                                      <option value="台中市">台中市</option>
                                      <option value="彰化縣">彰化縣</option>
                                      <option value="南投縣">南投縣</option>
                                      <option value="雲林縣">雲林縣</option>
                                      <option value="嘉義市">嘉義市</option>
                                      <option value="嘉義縣">嘉義縣</option>
                                      <option value="台南市">台南市</option>
                                      <option value="高雄市">高雄市</option>
                                      <option value="屏東縣">屏東縣</option>
                                      <option value="宜蘭縣">宜蘭縣</option>
                                      <option value="花蓮縣">花蓮縣</option>
                                      <option value="台東縣">台東縣</option>
                                      <option value="澎湖縣">澎湖縣</option>
                                      <option value="金門縣">金門縣</option>
                                      <option value="連江縣">連江縣</option>
                                    </select>
  </div>
  <div class="col-6 mb-3">
    <select class="custom-select custom-select-lg" id="addr02" name="district" required>
      <option value="" selected>區域</option>
      <!-- 區域選項將在 JavaScript 中動態生成 -->
    </select>
  </div>
                                  <div class="col-12">
                                    <input type="text" class="form-control form-control-lg" id="address" name="address" required>
                                  </div>
                                </div>
                              </div>
                            </div>
                            </div>
                            <div id="711_div">
                            <div class="form-group row">
                              <label for="inputPickUpStore" class="col-md-2 col-12 col-form-label text-md-right">取貨門市 <span class="required">(必填)</span></label>
                              <div class='col-auto text-center'>
                                <a href="map.php" class="btn btn-lg btn-store">
                                  <img style="width: 30px;" src="./img/shipping02.png" alt="選擇門市"> 
                                  <span class="pl-2">選擇門市</span>
                                </a>&nbsp;&nbsp;
                                <span><?php echo $_POST['CVSStoreName']; ?></span>
                                <input name="CVSStoreName" type="hidden" id="CVSStoreName" value="<?php echo $_POST['CVSStoreName']; ?>">
                                <input name="MerchantTradeNo" type="hidden" id="MerchantTradeNo" value="<?php echo $_POST['MerchantTradeNo']; ?>">
                                <input name="CVSStoreID" type="hidden" id="CVSStoreID" value="<?php echo $_POST['CVSStoreID']; ?>">
                                <input name="CVSAddress" type="hidden" id="CVSAddress" value="<?php echo $_POST['CVSAddress']; ?>">
                                <input name="CVSTelephone" type="hidden" id="CVSTelephone" value="<?php echo $_POST['CVSTelephone']; ?>">
                              </div>  
                            </div>
                            </div>
                            <div class="form-group row">
                              <label for="note" class="col-md-2 col-12 col-form-label text-md-right">其他備註</label>
                              <div class="col-md-9 col-12">
                                <textarea class="form-control" id="note" name="note" aria-label="With textarea"></textarea>
                              </div>
                            </div>

                            <hr class="mt-5">
                            
                            <div class="row">
                              <div class="col-md-9 offset-md-2">
                                <div class="row">
                                  <div class="col-auto ml-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                      <h4 class="total-text">小計</h4>                                       
                                      <h2 class="price font-weight-bold pl-3" id="txt_subtotal2">$0</h2>
                                      <input name="subtotal" type="text" class="style20" id="subtotal" style="width:100px; border:#FFF 0px;"  value="0" readonly />
                                    </div> 
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                      <h4 class="total-text" >運費</h4> 
                                      <h2 class="price font-weight-bold text-right pl-3"  id="txt_freight"></h2>
                                      <input name="freight" type="text" class="style20" id="freight" style="width:100px; border:#FFF 0px;"  value="0" readonly />
                                    </div> 
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                      <h4 class="total-text">總計</h4> 
                                      <h2 class="price font-weight-bold text-right pl-3"  id="txt_total" ></h2>
                                      <input name="total" type="text" class="style20" id="total" style="width:100px; border:#FFF 0px;"  value="0" readonly />
                                    </div>
                                  </div>
                                </div>
                                <input name="cart" type="hidden" id="cart" value="<?php echo $_SESSION["cart"]; ?>">
                                <input type="submit" value="送出訂單" class="btn btn-main btn-rounded btn-block px-5" id="send-order" style="font-weight: 700!important;font-size: 1.25rem; padding-top: 10px; padding-bottom: 10px;">
                              
                                 
								
                              </div>
                            </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
</form>      
<?PHP }//有訂購商品才顯示?>      
      
      
    </div>

  </div>
  <!-- /.container -->
  
  <aside class="sidebar">
    <ul class="list-unstyled">
      <li><a href="https://www.facebook.com/enbiliving2018" target="_blank"><img class="side_ic" src="./img/side_ic01.png" alt="恩比Facebook官方粉絲團"></a></li>
      <li><a href="tel:02-24321008"><img class="side_ic" src="./img/side_ic02.png" alt="聯絡恩比"></a></li>
      <li><a href="#item-row"><img class="side_ic" src="./img/side_ic03.png" alt="直接購買"></a></li>
    </ul>
  </aside>

  <!-- Footer -->
  <footer class="text-center py-5">
    <div class="container">
      <ul class="list-inline mb-5">
        <li class="list-inline-item"><a href="https://enbi.com.tw" target="_blank"><img class="footer_ic" src="./img/footer_ic01.png"></a></li>
        <li class="list-inline-item"><a href="https://www.1717go.tw" target="_blank"><img class="footer_ic" src="./img/footer_ic02.png"></a></li>
        <li class="list-inline-item"><a href="https://www.facebook.com/enbiliving2018" target="_blank"><img class="footer_ic" src="./img/footer_ic03.png"></a></li>
        <li class="list-inline-item"><a href="https://line.me/ti/p/~@pnq6802i" target="_blank"><img class="footer_ic" src="./img/footer_ic04.png"></a></li>
        <li class="list-inline-item"><a href="https://www.instagram.com/enbiliving/?hl=zh-tw" target="_blank"><img class="footer_ic" src="./img/footer_ic05.png"></a></li>
      </ul>
      <ul class="company-detail list-inline mb-2">
        <li class="list-inline-item">富御寢飾有限公司</li>
        <li class="list-inline-item">TEL: (02)24321008</li>
        <li class="list-inline-item">FAX: (02)24321081</li>
      </ul>
      <p class="m-0 text-center"> &copy; 2023 All Rights Reversed. Fu Yu Bedding Co., Ltd. All rights reserved.</p>
      
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="./county.js"></script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/fontawesome/js/all.min.js"></script>
<!--購物車+- --> 
<script>
    $(document).ready(function() {
      $(".input-group").each(function() {
        var inputField = $(this).find(".input-field");
        var minusBtn = $(this).find(".minus-btn");
        var plusBtn = $(this).find(".plus-btn");

        minusBtn.on("click", function() {
          var value = parseInt(inputField.val());
          if (value > 1) {
            inputField.val(value - 1);
          }
          if (inputField.val() === "1") {
            minusBtn.prop("disabled", true);
          }
          plusBtn.prop("disabled", false);
			
			showme(); // 在點擊 minusBtn 後執行 showme() 函式
        });

        plusBtn.on("click", function() {
          var value = parseInt(inputField.val());
          inputField.val(value + 1);
          if (inputField.val() !== "0") {
            minusBtn.prop("disabled", false);
          }
			
			showme(); // 在點擊 minusBtn 後執行 showme() 函式
        });
      });
    });
  </script>   
<!--購物車+- --> 

<!--產品表單--> 
<script>
	
  // 获取所有下拉菜单按钮元素
  var dropdownButtons = document.querySelectorAll(".dropdown-toggle");

  // 遍历所有下拉菜单按钮
  dropdownButtons.forEach(function(button) {
    // 为每个下拉菜单按钮添加点击事件处理程序
    button.addEventListener("click", function() {
      // 获取当前下拉菜单按钮的父级容器
      var dropdownContainer = this.parentNode;

      // 获取当前下拉菜单选项容器
      var dropdownMenu = dropdownContainer.querySelector(".dropdown-menu");

      // 显示或隐藏下拉菜单选项
      dropdownMenu.classList.toggle("show");
    });
  });

  // 获取所有下拉菜单选项元素
  var dropdownItems = document.querySelectorAll(".dropdown-item");

  // 遍历所有下拉菜单选项
  dropdownItems.forEach(function(item) {
    // 为每个下拉菜单选项添加点击事件处理程序
    item.addEventListener("click", function() {
      // 获取当前点击的选项文本
      var selectedOption = this.innerText;

      // 获取当前下拉菜单选项的父级容器
      var dropdownContainer = this.parentNode.parentNode.parentNode;

      // 获取当前下拉菜单按钮元素
      var dropdownButton = dropdownContainer.querySelector(".dropdown-toggle");

      // 将下拉菜单按钮的文本设置为当前选项文本
      dropdownButton.innerText = selectedOption;

      // 隐藏下拉菜单选项
      dropdownContainer.querySelector(".dropdown-menu").classList.remove("show");
    });
  });
</script>
<!--產品表單--> 
<!--產品表單--> 
<script>
  // 获取所有下拉菜单选项元素
  var dropdownItems = document.querySelectorAll(".dropdown-item");

  // 遍历所有下拉菜单选项
  dropdownItems.forEach(function(item) {
    // 为每个下拉菜单选项添加点击事件处理程序
    item.addEventListener("click", function() {
      // 获取当前点击的选项文本
      var selectedOption = this.innerText;

      // 获取当前选项所在的父级卡片元素
      var card = this.closest(".card-body");

      // 在当前卡片内查找对应的价格元素
      var oriPrice = card.querySelector(".ori-price span");
      var promoPrice = card.querySelector(".promo-price span");

      <?PHP 	
		
		//列出內容
		$sql_left="SELECT * 
				FROM `goods_class` 
				where goods_class_hide=1
				ORDER BY `goods_class_sort` ,`goods_class_no` DESC 
		 ";

		$result_left = $db->prepare("$sql_left");//防sql注入攻擊
		// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
		//$result->bindValue(':id', $id, PDO::PARAM_INT);
		$result_left->execute();

		$counts_left=$result_left->rowCount();//算出總筆數
		if($counts_left<>0){//如果判斷結果有值才跑回圈抓資料
		   while($rows_left = $result_left->fetch(PDO::FETCH_ASSOC)) {
		$no_id=$no_id+1;
		?>
       
			   if (selectedOption === "<?=$rows_left["goods_class_name"]; ?>") {
				oriPrice.innerText = "<?=$rows_left["goods_class_money"]; ?>";
				promoPrice.innerText = "<?=$rows_left["goods_class_money2"]; ?>";
			   } 
		<?php	
		}
		}
		?>
		  // 根据选项文本更新价格
		
		// 在当前卡片内查找对应的输入框元素
      var classNameInput = card.querySelector("input[name='class_name']");
      var classMoneyInput = card.querySelector("input[name='class_money']");
      var classMoney2Input = card.querySelector("input[name='class_money2']");

      // 将选项值赋给相应的输入框元素
      classNameInput.value = selectedOption;
      classMoneyInput.value = oriPrice.innerText;
      classMoney2Input.value = promoPrice.innerText;
      // 其他AJAX代码...
    });
  });
</script>
<!--產品表單--> 
<!--產品表單--> 
<script>
  // 获取所有表单元素
  var forms = document.querySelectorAll("form");

  // 遍历所有表单
  forms.forEach(function(form) {
    // 为每个表单添加提交事件处理程序
    form.addEventListener("submit", function(event) {
      // 获取当前表单中的下拉菜单选项
      var selectedOption = this.querySelector(".dropdown-toggle").innerText.trim();

      // 判断是否选择了规格
      if (selectedOption === "請選規格") {
        // 阻止表单提交
        event.preventDefault();

        // 提示用户选择规格
        alert("請選擇規格");

        // 可以根据需要进行其他操作，例如高亮显示未选择规格的表单项等
      }
    });
  });
</script>
<!--產品表單--> 
<!--匯款資料顯示隱藏-->
<script>
    $(document).ready(function() {
      // 初始隐藏C区块
      $('#atm_div').hide();

      // 点击A按钮显示C区块
      $('#atm_show').click(function() {
        $('#atm_div').show();
      });

      // 点击B按钮隐藏C区块
      $('#atm_hide').click(function() {
        $('#atm_div').hide();
      });
    });
</script>
<!--匯款資料顯示隱藏-->


<!--變更圖片class成為響應式大小-->
<script type="text/javascript">
	$(document).ready(function() {
		$("#img-responsive img")
		.addClass("img-responsive")//增加bootstrap內健RWD寬度
		.css("height",'');//高度清除
	});
</script>
<style>
.img-responsive,.thumbnail>img,.thumbnail a>img,.carousel-inner>.item>img,.carousel-inner>.item>a>img{display:block;max-width:100%;height:auto}
.video-wrapper iframe {  width: 100%; height: auto; aspect-ratio: 16/9;}/*youtube崁入自動100%*/
</style>
<!--變更圖片class成為響應式大小-->
    
<!-- 超商回傳 //-->
<script>
$(function(){
        
    //運費
    $("input[name='shipping']").on("change",function(){
        
        let freight   = $("input[name='shipping']:checked").val();
        let txt_total = parseInt($('#subtotal').val());
        
        if(freight=='店到店') {
            
            $('#txt_freight').html('$60');
            $('#freight').val('60');
            txt_total += 60;
            
        }else{
            
			if(txt_total>=3000){
				
				$('#txt_freight').html('$0');
				$('#freight').val('0');
			   
			}else{
				
				$('#txt_freight').html('$150');
				$('#freight').val('150');
				txt_total += 150;
			   
			}
			
        }
        
        $('#txt_total').html('$'+txt_total);
        $('#total').val(txt_total);
    
    });
    
    
    <?php if(isset($_POST['CVSStoreName'])) { ?>
    //超商回傳
    $('#checkoutModal').modal('show');
    
    $('#checkoutModal').on('shown.bs.modal', function (e) {
        
        let txt_total = parseInt($('#subtotal').val());
        
        $('#txt_freight').html('$60');
        $('#freight').val('60');
        txt_total += 60;
        
        $("#shipping2").attr('checked',true);
        
        $("#address_div").hide(0, function(){
            
            $('#addr01').removeAttr('required');
            $('#addr02').removeAttr('required');
            $('#address').removeAttr('required');
            
        });
        
        $("#711_div").show();
        $('#txt_total').html('$'+txt_total);
        $('#total').val(txt_total);
        
        
    });
    <?php } ?>  
    
});    
</script>  
<!-- 表單避免重複提交 -->
<script>
$(function(){
    
    
    // 點擊 A 按鈕顯示 C 區塊
    $('#711_hide').on('click', function (e) {
        
        $('#711_div').hide();
        
        $('#address_div').show(0, function(){
            
            $('#addr01').attr('required', 'required');
            $('#addr02').attr('required', 'required');
            $('#address').attr('required', 'required');
            
        });
        
    });
    
    // 點擊 B 按鈕隱藏 C 區塊
    $('#711_show').on('click', function (e) {
        
        $('#address_div').hide(0,function(){
            
            $('#addr01').removeAttr('required');
            $('#addr02').removeAttr('required');
            $('#address').removeAttr('required');
            
        });
        
        $('#711_div').show();
        
    });
    //取貨門市和地址顯示隱藏
    
   
    
   $('#form_order').on('submit', function (e) {
       
       e.preventDefault();
       let freight = $("input[name='shipping']:checked").val();
       
       if(freight=='店到店') {
          
            if($('#CVSStoreID').val()===''){
                alert('請選擇門市');
                return false;
            }
           
            $('#addr01').removeAttr('required');
            $('#addr02').removeAttr('required');
            $('#address').removeAttr('required');

       }
       
       // 在這裡添加文件上傳的代碼
      $.post("order_ok.php", $("#form_order").serialize(),
           function(data){
             alert(data);
             location.href="index.php";
      });
       
      $('#send-order').val('資料傳送中...').attr('disabled',true);
       
   });
    
    
  /*
  // 獲取具有 name="form_order" 的表單元素
  const form = document.querySelector('form[name="form_order"]');
  const submitBtn = form.querySelector('[type="submit"]');

  form.addEventListener('submit', (e) => {
      
    e.preventDefault();
 
    let freight = $("input[name='shipping']:checked").val();
    
      if(freight=='店到店') {
          
        if($('#CVSStoreID').val()===''){
            alert('請選擇門市');
            return false;
        }
                
      }
      
      // 在這裡添加文件上傳的代碼
      $.post("order_ok.php", $("#form_order").serialize(),
           function(data){
             alert(data);
             location.href="index.php";
      });
        
      submitBtn.disabled = true;
      submitBtn.value = '資料傳送中...';
 
  });
  */  
    
});
</script>
<!-- 表單避免重複發送 -->
</body>
</html>