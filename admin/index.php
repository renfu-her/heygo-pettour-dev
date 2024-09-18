<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "./include/check_all.php";//檢查登入權限和使用者是否被凍
include "./common.func.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>後台登入系統</title>  
<?PHP include './include_head.php';?> 
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?PHP include './phpinclude_body.php';?>
<div class="wrapper">
<?PHP include './head.php';?> 
  <!-- Left side column. contains the logo and sidebar -->
<?PHP include './menu.php';?> 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <DIV>
    <ol class="breadcrumb txt_tt">
    <li><i class="fa fa-caret-right"></i> 網站基本資料設定修改</li>        
  </ol>
  </DIV>
</section>
<!-- Main 內容開始 -->
<section class="content">
  <div class="row">
    <div class=" col-xs-12 col-md-12 col-sm-12 col-xs-12">
      <div class="info-box txt_main txt_16">
        <p><strong>
          <?=$_SESSION["name"];?> 
          ，您好：</strong></p>
        <p><strong> 歡迎光臨 - <?=$compony;?>-後台管理系統</strong></p>
        <ul>
          <li> 您登入ID
            
            為：
            <?= $_SESSION["id"]; ?></li>
          <li>您的權限為：
            <?PHP include "./include/check_power.php";?>
          </li>
          <li><?PHP if($_SESSION["ptime"]<>''){?>
          您上次於 <?= $_SESSION["ptime"]; ?> 登入本系統
          <?PHP } else{ echo '您是第一次登入本系統';}?>
          </li>                
          <li><?=getenv('REMOTE_ADDR');?> 是您目前的IP位址 </li>
          <li class="txt_red">您的登入資訊已紀錄，請勿惡意破壞或修改本系統及資料以免觸法</li>
        </ul>
      </DIV>
    </DIV>
  </DIV>
</section>
<!-- Main 內容結束 -->
</div>
<!-- /.content-wrapper -->
<?PHP include './footer.php';?> 
<?PHP include './include_js.php';?>  

</div> 
</body>
</html>
