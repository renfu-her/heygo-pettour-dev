<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
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



<div class="">
<div class="">
  <div class="text-center txt_title">網站基本資料設定</div>
</div>

<form  class="form-horizontal" name="form1" method="post" action="edit_ok.php">
<div class="box-body">
	<div class="form-group">
   		<label class="col-md-2 control-label">公司網站名稱：</label>
    	<div class="col-md-10">       
    	<input name="conpany" type="text" id="conpany" value="<?=$rows["conpany"]; ?>" />
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">關鍵字：</label>
    	<div class="col-md-10">       
    	<textarea name="keywords" wrap="virtual" id="keywords" style="height:100px;"><?=$rows["keywords"]; ?></textarea>
        <DIV class="txt_12_gl1">說明：友好搜尋引擎最佳化SEO,每個關鍵字中間用,分隔,建議創10~20個關鍵字(範例:網頁設計,程式設計,網頁行銷)</DIV>
   	 	</div>
     </div>	
      <div class="form-group">
   		<label class="col-md-2 control-label">網站描述：</label>
    	<div class="col-md-10">       
    	 <textarea name="description" wrap="virtual" id="description"  style="height:100px;"><?=$rows["description"]; ?></textarea>
        <DIV class="txt_12_gl1" >說明：友好搜尋引擎最佳化SEO,網頁內容簡述,介紹公司及商品等簡單資訊</DIV>
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">跑馬燈文字：</label>
    	<div class="col-md-10">       
    	 <textarea name="runtxt" wrap="virtual" id="runtxt" style="height:100px;"><?=$rows["runtxt"]; ?></textarea>
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">電話：</label>
    	<div class="col-md-10">       
    	<input name="tel" type="text" id="tel"  value="<?=$rows["tel"]; ?>" />
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">傳真：</label>
    	<div class="col-md-10">       
    	<input name="fax" type="text" id="fax" value="<?=$rows["fax"]; ?>" />
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">地址：</label>
    	<div class="col-md-10">       
    	 <input name="address" type="text" id="address" value="<?=$rows["address"]; ?>"/>
   	 	</div>
     </div>	
     <div class="form-group">
   		<label class="col-md-2 control-label">E-Mail：</label>
    	<div class="col-md-10">       
    	<input name="email" type="text" id="email" value="<?=$rows["email"]; ?>"/>
   	 	</div>
     </div>	
     
    	 <div class="col-md-10 pull-right"> 
     	<input type="submit" name="Submit2" value="送出" class="btn btn-info" style="width:150px;" />
        </div> 
</div>


</form>

</div> 
 
  
       
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
  $("#conpany").focus();
});
</script>
</div> 
<!--引用 jQuery + Bootstrap-->

</body>
</html>
