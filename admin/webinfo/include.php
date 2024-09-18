<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0結
include "../common.func.php";

$sql="SELECT * FROM `webinfo`";
$result = $db->prepare("$sql");//防sql注入攻擊
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
<div class="box-header txt_12">
<span>|| 後台管理介面 > 網站基本資料設定</span>
    <div class="box-tools">
    
    </div>
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
<form  class="form-horizontal" method="post" action="include_ok.php" name="form" id="form" data-toggle="validator">
<div class="text-center txt_title">網站語法崁入設定</div>
<div class="box-body">
	
      <div class="form-group">
   		<label class="col-md-2 control-label">head：</label>
    	<div class="col-md-10">       
    	 <textarea name="include_head" wrap="virtual" id="include_head"  style="height:100px;"><?=$rows["include_head"]; ?></textarea>
        <DIV class="txt_12_gl1" >說明：將程式碼崁入至＜head＞＜/head＞之間 </DIV>
   	 	</div>
      </div>	
    
      <div class="form-group">
   		<label class="col-md-2 control-label">body：</label>
    	<div class="col-md-10">       
    	 <textarea name="include_body" wrap="virtual" id="include_body"  style="height:100px;"><?=$rows["include_body"]; ?></textarea>
        <DIV class="txt_12_gl1" >說明：將程式碼崁入至＜body＞＜/body＞之間 </DIV>
   	 	</div>
      </div>
      
      <div class="form-group">
   		<label class="col-md-2 control-label">HTML：</label>
    	<div class="col-md-10">       
    	 <textarea name="include_footer" wrap="virtual" id="include_footer"  style="height:100px;"><?=$rows["include_footer"]; ?></textarea>
        <DIV class="txt_12_gl1" >說明：將程式碼崁入至＜/html＞之後 </DIV>
   	 	</div>
      </div>
     
     
    	 <div class="col-md-10 pull-right"> 
     	<input type="submit" name="Submit2" value="儲存修改" class="btn btn-info" style="width:150px;" />
        </div> 
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
<script src="../../js/validator.min.js"></script>

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
</div> 
</body>
</html>
