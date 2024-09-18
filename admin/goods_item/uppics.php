<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../common.func.php";

$no = $_GET['no'];
$uppics_class = 'goods';//所屬類別

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
<!--檢查上傳檔案-->
<?PHP include '../include/chkfile_size.php';?> 
<!--檢查上傳檔案-->
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
    <div class=" col-xs-12 col-md-12 col-sm-12 col-lg-12">
      <div class="info-box txt_main">

<div class="box-header txt_12">
<span>|| 後台管理介面 >管理圖檔</span></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="0" align="left" valign="top" class="txt_12_red">
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
    </td>
    </tr>

</table>

<?PHP  
$sql="
SELECT * FROM `goods_item` 
WHERE `goods_item_no` =:no";//sql語法


$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':no', $no, PDO::PARAM_INT);
$result->execute();
$rows = $result->fetch(PDO::FETCH_ASSOC);
?> 
 
<span class="txt_20" style="margin-left: 10px;"><strong><?=$rows["goods_item_title"]?></strong></span>
<hr>
 		

<section class="content">
<div class="row">
<!--已上傳圖檔-->

<form name="form2" method="post" action="uppics_sort.php">
<input name="uppics_class" type="hidden" id="uppics_class" value="<?=$uppics_class?>" />
<input type="hidden" name="no" id="no" value="<?=$no;//傳該案的編號?>">
<?PHP

$sql_pic="SELECT * FROM `uppics` 
WHERE `uppics_ing` = :no && `uppics_class` = :uppics_class
ORDER BY  `uppics_sort` ASC 
 ";
$result_pic = $db->prepare("$sql_pic");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result_pic->bindValue(':no', $no, PDO::PARAM_INT);
$result_pic->bindValue(':uppics_class', $uppics_class, PDO::PARAM_STR);
$result_pic->execute();
$total_pic=$result_pic->rowCount();//算出總筆數
//列出內容
$no_id=$no_id+$start;//流水號 
if($total_pic<>0){
?>
<div style="padding-top: 20px; border: 1px solid #ccc">
<?PHP 	
   while($rows_pic = $result_pic->fetch(PDO::FETCH_ASSOC)) {
$no_id=$no_id+1;
?>	
	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">		
		<div class="pic_border text-center">
		
  		<input type="hidden" name="ck_<?=$rows_pic["uppics_no"];?>" id="ck_<?=$rows_pic["uppics_no"];?>" value="<?=$rows_pic["uppics_sort"];?>" />
  	
	  	<input name="<?=$rows_pic["uppics_no"];?>" type="number" id="<?=$rows_pic["uppics_no"];?>" style="width:60px; text-align: center" value="<?=$rows_pic["uppics_sort"];?>"   /> <input type="submit" name="Submit2" value="更新排序" class="btn a_movetop" style="width: 80px;position: relative;top: -3px;" />
		 
		 
		 <div class="pic_bg" style="background-image: url(../goods_pic/<?=$rows_pic["uppics_pic_s"]; ?>);">
			 <a href="#"  data-toggle="modal" data-target="#exampleModalCenter_<?=$rows_pic["uppics_no"];?>" class="a_movetop" >			
				<img src="../images/pic_mask.png" width="100%" style="aspect-ratio: 5/3" alt="" class="a_img" />					
			</a>
		</div>
		 
		   <a href="uppics_del_ok.php?no=<?=$rows_pic["uppics_no"];?>&bpic=<?=$rows_pic["uppics_pic_b"];?>&spic=<?=$rows_pic["uppics_pic_s"];?>&bakno=<?=$no;?>" onClick="return confirm('確定要刪除?');">		 
					 <button class="btn btn-block  btn-danger btn-sm a_movetop"  value="Login"  type="button" style="width: 100%; margin-top: 3px; margin-bottom: : 3px;">刪除</button>
				  </a>
		  
		  <!-- Modal -->
<div class="modal fade" id="exampleModalCenter_<?=$rows_pic["uppics_no"];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
 
  <div class="modal-dialog modal-dialog-centered" role="document" >
    <div class="modal-content">
      <div class="modal-header">       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="../goods_pic/<?=$rows_pic["uppics_pic_b"]; ?>" width="100%"  onerror="this.src='../goods_pic/defpic.jpg'" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary a_movetop" data-dismiss="modal">關閉視窗</button>
      </div>
    </div>
  </div>
</div>
		</div>
	</div>
<?PHP
}
?>	
<?PHP
}
?>
</form>	
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr>
    <td height="5"></td>
  </tr>
</table>
<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
		<div class="text-start">
			<form name="form1" method="post" action="uppics_ok.php"  enctype="multipart/form-data" >    
				<h3 >上傳照片</h3>

				    <input type="hidden" name="no" id="no" value="<?=$no;//傳該案的編號?>">
				    <input name="uppics_class" type="hidden" id="uppics_class" value="<?=$uppics_class?>" />			
				 
				    <!--預覽區塊-->
					<label for="imgfile">
						<img id="view_uppic" src="../images/view_uppic.jpg" class="view_uppic" /> 
					</label>		
					<!--預覽區塊-->  
					<input name="imgfile" type="file" id="imgfile" size="40"  required="required" onChange="chkfile(this);" accept="image/gif, image/jpeg, image/png"/>

			  
				  <button class="btn btn-primary"  name="Submit" value="Login" type="Submit" style="width:120px; margin-top: 10px;" >上傳照片</button>  
				  <input type="button" value="返回" class="btn btn-default btn_bt"  onclick="location.href='./index.php'" style="width:120px; margin-top: 10px;"/>
				  					
			</form>			
		</div>
	</div>	


<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"> 
  <tr>
    <td height="15">&nbsp;</td>
  </tr>
</table>
	
</div>


	
<!--已上傳圖檔-->	

</section>
	

            
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
<script src="/admin/js/stripe.js"></script>
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
</head>
</div> 
</body>
</html>
