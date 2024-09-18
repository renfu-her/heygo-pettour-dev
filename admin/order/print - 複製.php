<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../common.func.php";

$edit_no	=	$_GET['no'];

$sql="SELECT * 
FROM `order_form` 
where order_no=:edit_no;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':edit_no', $edit_no, PDO::PARAM_INT);
$result->execute();
$rows = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>後台管理系統</title>  
<?PHP include '../include_head.php';?> 
<!-- 表單css -->
<link rel="stylesheet" href="/admin/style_form.css">  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?PHP include '../phpinclude_body.php';?>
<div class="wrapper">
<?PHP include '../head.php';?> 
  <!-- Left side column. contains the logo and sidebar -->
<?PHP include '../menu.php';?> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">  
</section>
<!-- Main 內容開始 -->
<section class="content">
  <div class="row">
    <div class=" col-xs-12 col-md-12 col-sm-12 col-xs-12">
      <div class="info-box txt_main">
<div class="box-header txt_12"><span>|| 後台管理介面 > 訂單管理列表</span>
  <div class="box-tools"></div>
</div>
<span class="txt_12_red">
        <?PHP 
		//取得資料新增修改刪除狀態
		if(isset($_GET['msg'])){
			$msg	= $_GET['msg'];
			switch($msg){
				case 'add':
					echo $msg='【資料狀態】：&nbsp;&nbsp;新增成功';
				break;
				case 'updata':
					echo $msg='【資料狀態】：&nbsp;&nbsp;修改成功';
				break;
				case 'del':
					echo $msg='【資料狀態】：&nbsp;&nbsp;刪除成功';
				break;
	}		
}
		?>
 </span>
<form  class="form-horizontal" name="form1" method="post" action="print_ok.php?no=<?=$edit_no?>" id="form" data-toggle="validator"  enctype="multipart/form-data"> 

<div class="text-center txt_title" style="margin-bottom: 20px;"><strong>訂單管理列表</strong></div>
<div class="text-right" style="padding-right: 15px;"><i class="fa fa-clock-o"></i>訂購日期： <?=mb_strimwidth($rows["order_buydate"], 0, 10, '', 'UTF-8'); ?></div>
<div class="box-body">
<div class="box">
           
           
            <div class="well" style="margin-bottom: 0px;">
                     
                  
            <!-- /.box-header -->
            
            <div class="box-body no-padding">
             <style>
				td, th {
					padding: 3px  !important;
				}
				</style>
                  
              <table width="100%" align="center">   
                 <tr>
                  <td  width="150" valign="top" class="text-right">訂單編號：</td>
                  <td><?=$order_cart=$rows["order_cart"];?></td>                 
                </tr>
               	<tr>
                  <td  width="150" valign="top" class="text-right">收件人：</td>
                  <td><?=$rows["order_client"];?></td>                 
                </tr>
                 <tr>
                  <td  width="150" valign="top" class="text-right">電子郵件：</td>
                  <td><?=$rows["order_email"];?></td>                 
                </tr>  
                
                              <tr>
                  <td  width="150" valign="top" class="text-right">連絡電話：</td>
                  <td><?=$rows["order_phone"];?></td>                 
                </tr>
                 <tr>
                  <td  width="150" valign="top" class="text-right">運送方式：</td>
                  <td><?=$rows["order_shipping"];?></td>                 
                </tr>
                 <tr>
                  <td  width="150" valign="top" class="text-right">付款方式：</td>
                  <td><?=$rows["order_payment"];?></td>                 
                </tr>
                 <?PHP if($rows["order_payment"]=='ATM繳費'){?>
                              <tr>
                  <td  width="150" valign="top" class="text-right">ATM後五碼：</td>
                  <td><?=$rows["order_atm5"];?></td>                 
                </tr>  
                <?PHP }?> 
                <?PHP if($rows["order_shipping"]=='宅配'){?>
                              <tr>
                  <td  width="150" valign="top" class="text-right">地址：</td>
                  <td><?=$rows["order_city"];?><?=$rows["order_district"];?><?=$rows["order_address"];?></td>                 
                </tr>  
                <?PHP }?>  
                <?PHP if($rows["order_shipping"]=='店到店'){?>
                <tr>
                  <td  width="150" valign="top" class="text-right">廠商交易編號：</td>
                  <td><?=$rows["MerchantTradeNo"];?></td>                 
                </tr>  
                <tr>
                  <td  width="150" valign="top" class="text-right">超商名稱：</td>
                  <td><?=$rows["CVSStoreName"];?></td>                 
                </tr> 
                <tr>
                  <td  width="150" valign="top" class="text-right">寄貨編號：</td>
                  <td><?=$rows["CVSPaymentNo"];?></td>                 
                </tr> 
                <?PHP }?>                                                                              
                                                                            
                 <tr>
                  <td  width="150" valign="top" class="text-right">其他備註：</td>
                  <td><?=nl2br($rows["order_note"]);?>
                  	 
                  </td>                 
                </tr>
         
               <tr>
                  <td  width="150" valign="top" class="text-right">狀態：</td>
                  <td>
		<select name="order_status" id="order_status" required data-error="請選擇狀態" style="width: 150px">
		   <option value="已收到訂單" <?PHP if($rows["order_status"]=='已收到訂單') echo 'selected'; ?>>已收到訂單</option>
		   <option value="已收款" <?PHP if($rows["order_status"]=='已收款') echo 'selected'; ?>>已收款</option>
		   <option value="已出貨" <?PHP if($rows["order_status"]=='已出貨') echo 'selected'; ?>>已出貨</option>
		   <option value="已完成" <?PHP if($rows["order_status"]=='已完成') echo 'selected'; ?>>已完成</option>
	    </select>
               </td>                 
                </tr>
                <tr>
                  <td  width="150" valign="top" class="text-right">訂單備註：</td>
                  <td>
		<textarea name="order_note2"><?=$rows["order_note2"];?></textarea>
	   <input type="submit" name="Submit2" value="儲存修改" class="btn btn-info btn_bt" />
               </td>                 
                </tr>
              
              </table>

            </div>
            <div class="box-body no-padding" style="margin-top: 20px;">
            
              <table width="100%" align="center">   
                 <tr>
                  <td width="12%" align="center" valign="top" bgcolor="#D4D4D4">圖片</td>
                  <td align="center" valign="top" bgcolor="#D4D4D4">品名</td>
                  <td align="center" valign="top" bgcolor="#D4D4D4">規格</td>
                  <td width="12%" align="center" valign="top" bgcolor="#D4D4D4">數量</td>
                  <td width="12%" align="center" valign="top" bgcolor="#D4D4D4">單價</td>
                  </tr>
                  <tr>
                  <td colspan="5" align="center" valign="top" height="12"></td>
                  </tr>
                  <?PHP 
  
//列出內容
$no_id=0;
$sql_main="
SELECT * FROM order_cart 
where cart_order_no=:order_cart
ORDER BY `cart_no` DESC
";
		  
$result_main = $db->prepare("$sql_main");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result_main->bindValue(':order_cart', $order_cart, PDO::PARAM_STR);

$result_main->execute();
$counts_main=$result_main->rowCount();//算出總筆數

if($counts_main<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows_main = $result_main->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
?>	
                   <tr>
                  <td align="center" valign="middle"> <img class="img-fluid" src="../cart_pic/<?=$rows_main["cart_pdt_pic"];?>" alt="<?=$rows_main["cart_pdt_name"]; ?>"  width="80" style="aspect-ratio: 250/250"></td>
                  <td align="left" valign="middle" ><?=$rows_main["cart_pdt_name"]; ?></td>
                  <td align="left" valign="middle" ><?=$rows_main["cart_class_name"]; ?></td>
                  <td align="center" valign="middle" ><?=$rows_main["cart_number"]; ?></td>
                  <td align="right" valign="middle"><?=$rows_main["cart_class_money2"]; ?>元</td>
                  </tr>
                   <tr>
                  <td colspan="5" align="center" valign="top" height="1"><hr style="border-top:1px dashed #D4D4D4;"/></td>
                  </tr>
 <?php	
}
}
?>             
               
               <tr>
                  <td colspan="5" align="right" valign="top">小計：<?=$rows["order_subtotal"]; ?> 元</td>
                  </tr>
                   <tr>
                  <td colspan="5" align="right" valign="top">運費：<?=$rows["order_freight"]; ?> 元</td>
                  </tr>
                   <tr>
                  <td colspan="5" align="right" valign="top"><span class="txt_12_red txt_16"><strong>訂單總金額：<?=$rows["order_total"]; ?> 元</strong></span>                    </td>
                  </tr>
              </table>
            </div>
            
            <!-- /.box-body -->
          </div>
      <div style="margin-bottom: 20px;">發送IP位置：<?=$rows["order_ip"];?></div>
     <!--按鈕-->
     <div  >
    	
        <div class="col-xs-12 text-center"> 
     		<input type="button" value="返回" class="btn btn-default btn_bt"  onclick="location.href='./index.php'"/>
        </div> 
     </div>
     <!--按鈕-->
</div>


</form>


 
  
       
      </DIV>
    </DIV>
  </DIV>
</section>
<!-- Main 內容結束 -->

</div>
<!-- /.content-wrapper -->
<?PHP include '../footer.php';?> 
<?PHP include '../include_js.php';?>  
<!--引用 Validator-->
<script src="../js/validator.min.js"></script>

<!--執行 Validator-->
<script>
$('#form').validator().on('submit', function(e) {
if (e.isDefaultPrevented()) { // 未驗證通過 則不處理
return;
} else { // 通过后，送出表单
//alert("已送出表單");
}
//e.preventDefault();  防止原始 form 提交表单
});
</script>

<script type="text/javascript">
$(document).ready(function(){
//  $("#title").focus();
});
</script>

<!--檢查上傳檔案-->
<?PHP include '../include/chkfile_size.php';?> 
<!--檢查上傳檔案-->

<!--預覽區塊-->	
		<script>  
		 $('#imgfile').change(function() {
		  var file = $('#imgfile')[0].files[0];
		  var reader = new FileReader;
		  reader.onload = function(e) {
			$('#view_uppic').attr('src', e.target.result);
		  };
		  reader.readAsDataURL(file);
		});
		</script>  
<!--預覽區塊--> 

<!-- 啟用 CKEitor--> 
<script src="../ck_editor/ckeditor.js"></script>
<script type="text/javascript">
    // 啟用 CKEitor 的上傳功能，使用了 CKFinder 插件	
    CKEDITOR.replace( 'content', {
		allowedContent: true,//不吃字
		height: '400px', width: '100%',
        filebrowserBrowseUrl        : '../ck_finder/ckfinder.html',
        filebrowserImageBrowseUrl   : '../ck_finder/ckfinder.html?Type=Images',
        filebrowserFlashBrowseUrl   : '../ck_finder/ckfinder.html?Type=Flash',
        filebrowserUploadUrl        : '../ck_finder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl   : '../ck_finder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl   : '../ck_finder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
		
    });

</script>
</div> 
</body>
</html>
