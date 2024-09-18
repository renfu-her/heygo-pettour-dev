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
 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="40" align="left" valign="top"><form name="form1" method="post" action="edit_ok.php">
      <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td bgcolor="#CCCCCC"><table width="100%" cellpadding="1" cellspacing="1" class="table_01 stripe">
              <tbody>
                <tr>
                  <th height="25" colspan="2" align="center" background="../images/main_tt.jpg" class="txt_12_gl"><strong>網站基本資料設定</strong></th>
                </tr>
              </tbody>
            </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="1">
                <tr>
                  <td height="25" align="right" valign="top" bgcolor="#F0F0F0"><table width="110" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">公司網站名稱：</td>
                      </tr>
                  </table></td>
                  <td height="25" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <input name="conpany" type="text" id="conpany" value="<?=$rows["conpany"]; ?>" />
                  </span></td>
                </tr>
                <tr>
                  <td width="10%" rowspan="2" align="right" valign="top" bgcolor="#F0F0F0" class="txt_12_gl"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">關鍵字：</td>
                      </tr>
                  </table></td>
                  <td width="90%" height="25" valign="middle" bgcolor="#FFFFFF" ><span class="txt_12_gl1">
                    <textarea name="keywords" wrap="virtual" id="keywords" style="height:100px;"><?=$rows["keywords"]; ?></textarea>
                  </span></td>
                </tr>
                <tr>
                  <td height="25" valign="middle" bgcolor="#FFFFFF" class="txt_12_gl1" ><span class="txt_12_gl1">說明：</span>友好搜尋引擎最佳化SEO,每個關鍵字中間用,分隔,建議創10~20個關鍵字(範例:網頁設計,程式設計,網頁行銷)</td>
                </tr>
                <tr>
                  <td rowspan="2" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">網站簡介描述：</td>
                      </tr>
                  </table></td>
                  <td height="25" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <textarea name="description" wrap="virtual" id="description"  style="height:100px;"><?=$rows["description"]; ?></textarea></span></td>
                </tr>
                <tr>
                  <td height="25" valign="middle" bgcolor="#FFFFFF" class="txt_12_gl1"><span class="txt_12_gl1" >說明：友好搜尋引擎最佳化SEO,網頁內容簡述,介紹公司及商品等簡</span>單資訊</td>
                </tr>
                <tr>
                  <td height="12" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">跑馬燈文字：</td>
                      </tr>
                  </table></td>
                  <td height="12" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <textarea name="runtxt" wrap="virtual" id="runtxt" style="height:100px;"><?=$rows["runtxt"]; ?></textarea>
                  </span></td>
                </tr>
                <tr>
                  <td height="12" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="right" class="txt_12_gl">電話：</td>
                    </tr>
                  </table></td>
                  <td height="12" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <input name="tel" type="text" id="tel"  value="<?=$rows["tel"]; ?>" />
                  </span></td>
                </tr>
                <tr>
                  <td height="12" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">傳真：</td>
                      </tr>
                  </table></td>
                  <td height="12" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <input name="fax" type="text" id="fax" value="<?=$rows["fax"]; ?>" />
                  </span></td>
                </tr>
                <tr>
                  <td height="12" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="right" class="txt_12_gl">地址：</td>
                    </tr>
                  </table></td>
                  <td height="12" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <input name="address" type="text" id="address" value="<?=$rows["address"]; ?>"/>
                  </span></td>
                </tr>
                <tr>
                  <td height="25" align="right" valign="top" bgcolor="#F0F0F0"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="right" class="txt_12_gl">E-Mail：</td>
                      </tr>
                  </table></td>
                  <td height="25" valign="middle" bgcolor="#FFFFFF"><span class="txt_12_gl1">
                    <input name="email" type="text" id="email" value="<?=$rows["email"]; ?>"/>
                  </span></td>
                </tr>             
            </table></td>
        </tr>
      </table>
<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td height="50"><input type="submit" name="Submit2" value="送出" class="btn btn-default" /></td>
            </tr>
          </table>      
        </form>
  </td>
  </tr>
</table>    
       
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
</body>
</html>
