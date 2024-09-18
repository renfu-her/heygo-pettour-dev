<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../include/check_powerisroot.php";//檢查有沒有最高權限=0結
include "../common.func.php";

$edit_no	=	$_GET['no'];

$sql="SELECT * 
FROM `member` 
where member_no=:edit_no;";

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
<div class="box-header txt_12"><span>|| 後台管理介面 > 修改帳號管理</span>
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
<form  class="form-horizontal" method="post" action="edit_ok.php" name="form"  id="form" data-toggle="validator">
<div class="text-center txt_title"><strong>修改帳號管理<input type="hidden" name="edit_no" value="<?=$edit_no?>"></strong></div>
<div class="box-body">
	<div class="form-group">
   		<label class="col-md-2 control-label">帳號：</label>
    	<div class="col-md-10 control-label" style="text-align: left">       
    	<?=$rows["member_id"]; ?>
                    
   	 	</div>
     </div>	
    <div class="form-group">
   		<label class="col-md-2 control-label">名稱：</label>
    	<div class="col-md-10">       
    	<input name="name" id="name" type="text" value="<?=$rows["member_name"]; ?>"  required="required" data-error="請填寫名稱" />
    	<div class="help-block with-errors"></div>
   	 	</div>
     </div>	     
     <div class="form-group">
   		<label class="col-md-2 control-label">權限：</label>
    	<div class="col-md-10">       
    	
	    <select name="power" id="power" required data-error="請選擇權限">
		   <option value="0" <?PHP if($rows["member_power"]==0) echo 'selected'; ?>>最高管理者</option>
		   <option value="1" <?PHP if($rows["member_power"]==1) echo 'selected'; ?>>操作人員</option>
		   <option value="2" <?PHP if($rows["member_power"]==2) echo 'selected'; ?>>凍結使用</option>
	    </select>
    	<div class="help-block with-errors"></div>
    	<div class="txt_12_gl1">權限說明：<BR>
		最高管理者：擁有所有後台所有管理介面的操控權。<BR>
		操作人員：除了"網站基本資料設定"、"網站語法崁入設定"和"管理者設定"外，其餘功能皆可操控。<BR>
		凍結使用：封鎖帳號，無法使用後台管理的全部功能。<BR>
  	 	</div>
   	 	</div>
     </div>	
     
     <!--按鈕-->
     <div  >
    	<div class="col-xs-6 text-right"> 
     		<input type="submit" name="Submit2" value="儲存修改" class="btn btn-info btn_bt" />
        </div> 
        <div class="col-xs-6 text-left"> 
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

<!-- Main 內容開始 -->
<section class="content">
  <div class="row">
    <div class=" col-xs-12 col-md-12 col-sm-12 col-xs-12">
      <div class="info-box txt_main">

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
<form  class="form-horizontal" method="post" action="edit_pw_ok.php" name="form2" id="form2" data-toggle="validator">
<div class="text-center txt_title"><strong>修改管理者密碼</strong></div>
<div class="box-body">
	
    
     <div class="form-group">
   		<label class="col-md-2 control-label"><input type="hidden" name="edit_no" value="<?=$edit_no?>">密碼：</label>
    	<div class="col-md-10">       
    	<input name="pw" id="pw" type="password" value="<?=$rows["conpany"]; ?>"  required="required" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{6,}$" data-error="請輸入含有英文字母及數字的密碼，至少六個字元。"  />
    	<div class="help-block with-errors"></div>
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">確認密碼：</label>
    	<div class="col-md-10">       
    	<input name="pw2"  id="pw2" type="password" value="<?=$rows["conpany"]; ?>"  required="required" data-match="#pw" data-error="密碼未吻合！" />
    	<div class="help-block with-errors"></div>
   	 	</div>
     </div>	   
     
    <!--按鈕-->
     <div  >
    	<div class="col-xs-6 text-right"> 
     		<input type="submit" name="Submit2" value="儲存修改密碼" class="btn btn-info btn_bt" />
        </div> 
        <div class="col-xs-6 text-left"> 
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
<script type="text/javascript">
$(document).ready(function(){
  $("#name").focus();
});
</script>
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
<script>
$('#form2').validator().on('submit', function(e) {
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
