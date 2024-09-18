<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../common.func.php";

	
if($_GET['clean']=='yes'){ //是否清除搜尋
	$_SESSION["sh_name"]='';
	$_SESSION["sh_status"]='';
	
}




if (isset($_POST['sh_name'])){
	$_SESSION["sh_name"]=$_POST['sh_name'];//搜尋標題
}

$sh_name=$_SESSION["sh_name"];//
	if ($sh_name<>"")
		$sql_where_name= "AND ( `order_cart` LIKE  '%$sh_name%'
OR  `order_client` LIKE  '%$sh_name%'
OR  `order_email` LIKE  '%$sh_name%'
OR  `order_phone` LIKE  '%$sh_name%')";	
	else 
		$sql_where_name= "";


if (isset($_GET['sh_status'])){
	$_SESSION["sh_status"]=$_GET['sh_status'];//搜尋狀態
}

$sh_status=$_SESSION["sh_status"];//
	if ($sh_status<>"")
		$sql_where_status= "AND  `order_status` =  '$sh_status' ";	
	else 
		$sql_where_status= "";

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
<form name="form1" method="post" action="index.php">
<section class="content">
  <div class="row">
    <div class=" col-xs-12 col-md-12 col-sm-12 col-xs-12">
      <div class="info-box txt_main">
<?php
//使用分頁控制必備變數--開始
include "../include/pages.php";
$pagesize='30';//設定每頁顯示資料量
$phpfile = 'index.php';//使用頁面檔案
$page= isset($_GET['page'])?$_GET['page']:1;//如果沒有傳回頁數，預設為第1頁



//查詢
$sql="
SELECT * FROM order_form
WHERE order_no<>''
$sql_where_name
$sql_where_status
";//算總頁數用
		  
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result->execute();
$counts=$result->rowCount();//算出總筆數

if ($page>$counts) $page = $counts;//輸入值大於總數則顯示最後頁
else $page = intval($page);//當前頁面-避免非數字頁碼
$getpageinfo = page($page,$counts,$phpfile,$pagesize);//將函數傳回給pages.php處理
$page_sql_start=($page-1)*$pagesize;//資料庫查詢起始資料
?>

<div class="box-header txt_12">
<span>|| 後台管理介面 > 訂單管理列表</span>
    <div class="box-tools">
   
    </div>
</div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="0" colspan="2" align="left" valign="top"><span class="txt_12_red">
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
    </span></td>
    </tr>

  <tr>

    <td width="52%" height="10" align="left" valign="bottom" class="txt_12_gl">資料 <?PHP echo $counts;?> 筆</td>

    <td width="48%" align="right" valign="bottom"></td>

  </tr>

</table>
<div class="box-body table-responsive no-padding">
 

 
 
<table class="table">

  <tr>

    <td height="40" align="right" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="100%" cellpadding="0" cellspacing="0">
              <tr>
               
               <?PHP if($_SESSION["power"]==0){ //如果為最高權限?>
                <?PHP } //如果為最高權限?>
                
                
                <td width="1%" align="right" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><table width="60" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="18" align="right" valign="bottom" class="txt_12_gl"  style="padding: 0px !important;">搜尋：</td>
                  </tr>
                </table></td>
                <td width="1%" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><input name="sh_name" type="text" id="sh_name" style="width:250px;" value="<?PHP echo $_SESSION["sh_name"]; ?>" Placeholder=" 可查詢訂單編號、姓名、電話或E-Mail"></td>
                <td width="95%" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><table width="71" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="10" align="center" valign="middle" class="txt_12_gl1"  style="padding: 0px !important;"></td>
                    <td width="61" align="center" valign="middle" class="txt_12_gl1"  style="padding: 0px !important;"><input type="submit" name="Submit" value="查詢" class="btn btn-sm btn_bt btn-default"></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <BR>
            <a href="index.php?sh_status="><span class="a_movetop label <?PHP if($_SESSION["sh_status"]=='') echo ' label-warning'; else echo ' label-info';?>" style="width: 50px;">全部</span></a>　
            <a href="index.php?sh_status=已收到訂單"><span class="a_movetop label <?PHP if($_SESSION["sh_status"]=='已收到訂單') echo ' label-warning'; else echo ' label-info';?>" style="width: 50px;">已收到訂單</span></a>　
            <a href="index.php?sh_status=已收款"><span class="a_movetop label <?PHP if($_SESSION["sh_status"]=='已收款') echo ' label-warning'; else echo ' label-info';?>" style="width: 50px;">已收款</span></a>　
            <a href="index.php?sh_status=已出貨"><span class="a_movetop label <?PHP if($_SESSION["sh_status"]=='已出貨') echo ' label-warning'; else echo ' label-info';?>" style="width: 50px;">已出貨</span></a>　
            <a href="index.php?sh_status=已完成"><span class="a_movetop label <?PHP if($_SESSION["sh_status"]=='已完成') echo ' label-warning'; else echo ' label-info';?>" style="width: 50px;">已完成</span></a>　
            <BR>
            <BR>
            
<table width="100%" cellpadding="1" cellspacing="1" class="table_01 stripe">

                <tbody>

                  <tr>				  

                    <th width="4%" align="center" bgcolor="#367FA9" class="txt_wt"><strong>NO</strong></th>
                     <th width="8%" align="center" bgcolor="#367FA9" class="txt_wt">訂購日期</th>
                    <th width="12%" align="center" bgcolor="#367FA9" class="txt_wt">訂單編號</th>
                    <th width="12%"  align="center" bgcolor="#367FA9" class="txt_wt">姓名</th>

                    <th height="25" align="center" bgcolor="#367FA9" class="txt_wt"><p><strong>電話/E-Mail</strong></p></th>
                    <th width="12%" align="center" bgcolor="#367FA9" class="txt_wt">運送/付款</th>

                    <th width="8%" align="center" bgcolor="#367FA9" class="txt_wt">訂單金額</th>

                    <th width="10%" height="25" align="center" bgcolor="#367FA9" class="txt_wt"><strong>狀態</strong></th>

                   
                    <th width="6%" align="center" bgcolor="#367FA9" class="txt_wt">內容</th>

                    <th width="6%" align="center" bgcolor="#367FA9" class="txt_wt">刪除</th>

                  </tr>
<?PHP 
//列出內容
$no_id=$no_id+$start+(($page-1)*$pagesize);//流水號

$sql="
SELECT * FROM order_form 
WHERE order_no<>''
$sql_where_name
$sql_where_status
ORDER BY `order_no` DESC 
LIMIT $page_sql_start , $pagesize

 ";
		  
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
//$result->bindValue(':id', $id, PDO::PARAM_INT);
$result->execute();
$counts=$result->rowCount();//算出總筆數

if($counts<>0){//如果判斷結果有值才跑回圈抓資料
   while($rows = $result->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
?>
			  

                  <tr>

                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF"  class="txt_12_gl"><span class="text_item" style="text-indent:5px;">

                      <?=$no_id;?>

                    </span></td>
                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl">
					  <?=mb_strimwidth($rows["order_buydate"], 0, 10, '', 'UTF-8'); ?>
                     </td>
                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF"  class="txt_12_gl"><span class="text_item" style="text-indent:5px;">
                    <?=$rows["order_cart"]; ?>
                    </span></td>
                    <td height="25" align="left" nowrap="nowrap" bgcolor="#FFFFFF"  class="txt_12_gl">
					   <?=$rows["order_client"]; ?>
                    </td>

                    <td height="25" align="left" nowrap bgcolor="#FFFFFF" class="txt_12_gl" >
                     
                        <?=$rows["order_phone"]; ?>
                       <br>
                      <?=$rows["order_email"]; ?>                    </td>
                    <td height="25" align="left" nowrap bgcolor="#FFFFFF" class="txt_12_gl" >
					   <?=$rows["order_shipping"]; ?>
                        </span><br>
                      <?=$rows["order_payment"]; ?>  
                      </td>

                    <td height="25" align="right" bgcolor="#FFFFFF" class="txt_12_gl" style="overflow:hidden;text-overflow:ellipsis;">
                      <?=$rows["order_total"]; ?>元</td>

                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl">
                      <?=$rows["order_status"]; ?>
                    </td>

                    
                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl"><a href="print.php?no=<?=$rows["order_no"];?>"  class="a_movetop"><span class="label label-success"><i class="fa fa-file"></i> 觀看</span></a></td>

                    <td height="25" align="center"nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl">
                    <span class="label label-danger a_movetop" onclick ="return del_<?=$no_id?>()"  ><i class="fa fa-trash"></i> 刪除</span>
                      <input id="link_<?=$no_id?>" type="hidden" value="del_ok.php?no=<?=$rows["order_no"];?>&cart=<?=$rows["order_cart"];?>"  />
                      <input id="delno_<?=$no_id?>" type="hidden" value="確定要刪除第<?=$no_id?>筆紀錄?"  />
					  <script type="text/javascript" language="javascript">
						function del_<?=$no_id?>(y) {
							var link  = document.getElementById("link_<?=$no_id?>");//刪除超連結
							var delno = document.getElementById("delno_<?=$no_id?>");//刪除編號
							//alertify.alert(link.value);
							this.name = "mike";						
	
							alertify.confirm( delno.value, function (e) {
									if (e) {
										location.href=link.value;
									} else {
										return false;
									}
								});
						}
					  </script>   
                   
                   
                    </td>
                  </tr>
<?php	
}
}
?>                </tbody>
            </table>   
                     
            <div style="margin-top: 100px">
            	<?php
				echo $getpageinfo['pagecode'];//顯示分頁的html代碼
				?>
            </div>
            
            </td>
          </tr>
        </table>
</td></tr>
</table>
		  </div>        
      </DIV>
    </DIV>
  </DIV>
</section>
</form>
<!-- Main 內容結束 -->
</div>
<!-- /.content-wrapper -->
<?PHP include '../footer.php';?> 
<?PHP include '../include_js.php';?>  


  
  


<script src="/admin/js/stripe.js"></script></head>
</div> 
</body>
</html>
