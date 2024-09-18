<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "../include/check_all.php";//檢查登入權限和使用者是否被凍
include "../common.func.php";

	
if($_GET['clean']=='yes'){ //是否清除搜尋	
	$_SESSION["sh_name"]='';
}




if (isset($_POST['sh_name'])){
	$_SESSION["sh_name"]=$_POST['sh_name'];//搜尋商品
}


$sh_name=$_SESSION["sh_name"];//
	if ($sh_name<>"")
		$sql_where_name= "&& (`goods_item_title` like '%$sh_name%')";	
	else 
		$sql_where_name= "";


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
<?php
//使用分頁控制必備變數--開始
include "../include/pages.php";
$pagesize='20';//設定每頁顯示資料量
$phpfile = 'index.php';//使用頁面檔案
$page= isset($_GET['page'])?$_GET['page']:1;//如果沒有傳回頁數，預設為第1頁



//查詢
$sql="
SELECT *
FROM goods_item 
WHERE goods_item_no<>''
$sql_where_name 
ORDER BY `goods_item_sort` ASC ,`goods_item_no` DESC
 ";
		  
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
<span>|| 後台管理介面 > 商品管理列表</span>
    <div class="box-tools">
    <img src="../images/icon/off.gif" width="10" height="12"> 凍結中&nbsp;&nbsp;&nbsp; <img src="../images/icon/on.gif" width="10" height="12"> 正常使用
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

    <td width="52%" height="10" align="left" valign="bottom" class="txt_12_gl">目前有 <?PHP echo $counts;?> 筆資料</td>

    <td width="48%" align="right" valign="bottom"><a href="add.php" class="txt_12_gl a_movetop"><span class="label label-primary"><i class="fa f fa-plus-square"></i> 新增</span></td>

  </tr>

</table>

<div class="box-body table-responsive no-padding">
 
<table class="table">

  <tr>

    <td height="40" align="right" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><form name="form1" method="post" action="index.php">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="1%" align="right" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><table width="60" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="18" align="right" valign="bottom" class="txt_12_gl"  style="padding: 0px !important;">搜尋：</td>
                      </tr>
                  </table></td>
                  <td width="1%" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><input name="sh_name" type="text" id="sh_name" style="width:200px;" value="<?PHP echo $_SESSION["sh_name"]; ?>" Placeholder=" 商品名稱"></td>
                  <td width="95%" valign="middle" bgcolor="#CDCED1" class="txt_12_gl"><table width="71" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10" align="center" valign="middle" class="txt_12_gl1"  style="padding: 0px !important;"></td>
                      <td width="61" align="center" valign="middle" class="txt_12_gl1"  style="padding: 0px !important;"><input type="submit" name="Submit" value="查詢" class="btn btn-sm btn_bt btn-default"></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
            </form>
              <BR>
   <form name="form2" method="post" action="sort.php">         
			<table width="100%" cellpadding="1" cellspacing="1" class="table_01 stripe">

                <tbody>

                  <tr>				  

                    <th width="4%" align="center" bgcolor="#367FA9" class="txt_wt"><strong>NO</strong></th>
                    <th width="6%" align="center" bgcolor="#367FA9" class="txt_wt">圖片</th>

                    <th width="7%" align="center" bgcolor="#367FA9" class="txt_wt"><strong>類別</strong></th>
                    <th height="25" align="center" bgcolor="#367FA9" class="txt_wt">商品名稱</th>

                    <th width="5%" align="center" bgcolor="#367FA9" class="txt_wt">顯示</th>

                    <th width="6%" align="center" bgcolor="#367FA9" class="txt_wt">排序</th>
                    <th width="4%" align="center" bgcolor="#367FA9" class="txt_wt">修改</th>

                    <th width="8%" align="center" bgcolor="#367FA9" class="txt_wt">刪除</th>

                  </tr>
<?PHP 
//列出內容
$no_id=$no_id+$start+(($page-1)*$pagesize);//流水號

$sql="
SELECT *
FROM goods_item 
WHERE goods_item_no<>''
$sql_where_name 
ORDER BY  `goods_item_sort` ASC, `goods_item_no` DESC 
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
                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF"  class="txt_12_gl"><span class="text_item" style="text-indent:5px;">
                     <img src="../goods_pic/<?=$rows["goods_item_pic_s"]; ?>" height="50" border="1" style=" border-color:#666666; border-style:solid;" onerror="this.src='../goods_pic/defpic.jpg'" >
                    </span></td>

                    <td height="25" align="left" nowrap bgcolor="#FFFFFF" class="txt_12_gl" style="text-indent:3px;overflow:hidden;text-overflow:ellipsis;"><span class="text_item" style="text-indent:5px;">
                      <?PHP //顯示出商品分類
	//查詢	
	$sql_class="
	SELECT * FROM `goods_class` 
	ORDER BY `goods_class_sort`  
	";//DESC是遞減
					
	$result_class = $db->prepare("$sql_class");//防sql注入攻擊	
	$result_class->execute();
			
	 while($rows_class = $result_class->fetch(PDO::FETCH_ASSOC)) 
	{
	
		$string = $rows["goods_item_class"];
		$find = ','.$rows_class["goods_class_no"].',';
		if (strpos($string, $find) !== false) {
	?>
                      <span class="well" style="padding: 5px;"><?=$rows_class["goods_class_name"];?></span>
                      <?PHP
		}					
	}
	?> 
                    </span></td>
                    <td height="25" align="left" bgcolor="#FFFFFF" class="txt_12_gl" style="overflow:hidden;text-overflow:ellipsis;">
                      <?=$rows["goods_item_title"]; ?>
                    </td>

                    <td height="25" align="center" bgcolor="#FFFFFF" class="txt_12_gl">
                      <?PHP
						if($rows["goods_item_hide"]==0)
							echo'<img src="../images/icon/off.gif" width="10" height="12" border="0" title="隱藏"';
						else	 
							echo'<img src="../images/icon/on.gif" width="10" height="12" border="0" title="顯示"';
					 ?>
                    </td>

                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl">
                      <input type="hidden" name="ck_<?=$rows["goods_item_no"];?>" id="ck_<?=$rows["goods_item_no"];?>" value="<?=$rows["goods_item_sort"];?>">
                      <input name="<?=$rows["goods_item_no"];?>" type="text" id="<?=$rows["goods_item_no"];?>" style="width:40px;" value="<?=$rows["goods_item_sort"];?>">                    </td>
                    <td height="25" align="center" nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl"><a href="edit.php?no=<?=$rows["goods_item_no"];?>"  class="a_movetop"><span class="label label-success"><i class="fa fa-edit"></i> 修改</span></a></td>

                    <td height="25" align="center"nowrap="nowrap" bgcolor="#FFFFFF" class="txt_12_gl">
                    
                    <span class="label label-danger a_movetop" onclick ="return del_<?=$no_id?>()"  ><i class="fa fa-trash"></i> 刪除</span>
                      <input id="link_<?=$no_id?>" type="hidden" value="del_ok.php?no=<?=$rows["goods_item_no"];?>&bpic=<?=$rows["goods_item_pic_b"];?>&spic=<?=$rows["goods_item_pic_s"];?>"  />
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
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td height="20" align="right" valign="bottom"><span class="txt_12_gl1">排序方式：數字越小排在越前面(P.S.請輸入半形阿拉伯數字)</span></td>

          </tr>

          <tr>

            <td height="30" align="right" valign="bottom"><table width="100" border="0" align="right" cellpadding="0" cellspacing="0">

              <tr>

                <td><input type="submit" name="Submit2" value="重新排序" class="btn btn-info btn_bt" /></td>

              </tr>

                        </table></td>

          </tr>

        </table> 
    </form>       
           
            <section class="numberArea">
            <div style="margin-top: 100px;">
            	<?php
				echo $getpageinfo['pagecode'];//顯示分頁的html代碼
				?>
            </div>
            </section>
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

<!-- Main 內容結束 -->
</div>
<!-- /.content-wrapper -->
<?PHP include '../footer.php';?> 
<?PHP include '../include_js.php';?>  
<script src="/admin/js/stripe.js"></script></head>
</div> 
</body>
</html>
