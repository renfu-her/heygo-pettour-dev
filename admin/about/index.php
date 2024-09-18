<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../common.func.php";

$sql="SELECT * FROM `about`";
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
<span>|| 後台管理介面 > 商品介紹區塊設定</span>
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
 <form name="form1" method="post" action="edit_ok.php">
 <table width="100%" cellpadding="1" cellspacing="1" class="table_01 stripe" style="table-layout:fixed">
<tbody>
  <tr>
	<th height="25" colspan="2" align="center" class="txt_20"><strong>商品介紹區塊設定</strong></th>
  </tr>
	<tr>
	<th height="10" colspan="2" ></th>
  </tr>
</tbody>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
  <td height="40" align="left" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
	<tr>
	  <td bgcolor="#FFFFFF" >
	   <textarea name="content" id="content"><?=$rows["content"];?></textarea>
	   </td>
	</tr>

  </table>
  </td>
</tr>
</table>
<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td height="50"><input type="submit" name="Submit2" value="儲存修改" class="btn btn-info" style="width:150px;" /></td>
	</tr>
</table> 
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
<!-- 啟用 CKEitor--> 
<!-- 啟用 tinymce--> 
<script src="/tiny_mce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: "#content",
    height: '300px',
	//selector: "#textarea,#textarea2",//單獨選擇id
    theme : "modern",
	fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
    language : "zh_TW" ,
    plugins: [
    "advlist autolink lists link image charmap print preview anchor colorpicker textcolor lineheight",
    "searchreplace visualblocks code fullscreen",
    "insertdatetime media table contextmenu paste jbimages youTube",
  ],
	

  toolbar: "insertfile undo redo | styleselect | bold italic strikethrough forecolor backcolor | fontselect | fontsizeselect | lineheightselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages youTube | code",
  relative_urls: false
});
	
</script>
<!-- 啟用 tinymce--> 

</div> 
</body>
</html>
