<?PHP
if (!isset($_SESSION)) {
 	 session_start();
}
include "./common.func.php";

$_SESSION['register_md5'] = hash("sha256",$_SERVER['HTTP_HOST']); //取得當前網址當加密用

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>後台登入系統</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="robots" content="noindex" />
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="style.css">
<style type="text/css">
@import url(https://fonts.googleapis.com/earlyaccess/notosanstc.css);
body {
	background-color: #ebebeb;
	font-family:'Noto Sans TC', sans-serif;
	letter-spacing:2px;
	color:#000;
}
.txt_maim_compony{
	font-size:30px;
	color:#000;
	}
.input11{
	font-size: 16px;
	color: #7c7c7c;
	height:30px;
	width:100%;
	text-decoration: none;
	background-color: #f4f4f4;
	border: 1px solid #e2e2e2;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	margin:5px 0px;
	text-indent:5px;
	}		
</style>
<!-- jQuery 3 -->
<script src="./bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="./bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--漸變-->
<link href="./include/assets/style.min.css" rel="stylesheet" />
<!--漸變-->
</head>
<body  onload="document.getElementById('id').focus()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="fade">
   <tr>
    <td height="60" align="center" valign="bottom"></td>
  </tr>
  <tr>
    <td height="110" align="center" valign="middle"><h1><img src="images/login.png" alt="後台登入管理系統"/></h1></td>
  </tr>
   <tr>
     <td align="center" class="txt_12 txt_bu">
     <table width="90%" border="0" cellspacing="0" cellpadding="0" style="max-width:250px;">

</table>

     </td>
   </tr>
  
   
     <td align="center">
<form  class="form-horizontal" name="form1" method="post" action="login_send.php" id="form" data-toggle="validator">
<div style="margin: 0 auto; background: #fff; padding: 30px; width: 310px;" >
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:250px;">

   <tr>
  <tr>
    <td>
       <div class="form-group" style="margin-bottom:0px;">帳號
        <input name="id" type="text"  id="id"   required="required" data-error="請輸入帳號" title="請輸入帳號"  class="input11">
        </div>
        </td>
  </tr>
  <tr>
    <td>
       <div class="form-group" style="margin-bottom:0px;">密碼
        <input name="pw" type="password"  id="pw"   required="required" data-error="請輸入密碼" title="請輸入密碼"  class="input11">
        </div>
        </td>
  </tr>
   <tr>
    <td>
       <div class="form-group" style="margin-bottom:0px;">認證碼[
                          <?php 
    			// 隨機產生系統驗證碼
   				 $SystemPassCode=rand(1111,9999); 
  				  echo $SystemPassCode; 
   				 ?> ]
        <input name="pc" type="number"   required="required"  class="input11" id="pc" title="請輸入密碼"  data-error="請輸入驗證碼">
        <input name="pc2" type="hidden" id="pc2" value="<?PHP echo $SystemPassCode; ?>">
        </div>
        </td>
  </tr>
  <tr>
    <td height="40" align="right" valign="bottom">
        <input type="submit" value="登入" class="btn btn-info" style="background: #00b0dc; width: 100%">
        </td>
  </tr>
  
</table>
</div>

</form>
     </td>
   </tr>
</table>

</body>
</html>
<!--引用 Validator-->
<script src="./js/validator.min.js"></script>

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


<!--漸變-->
<script src="./include/assets/placeholdem.min.js"></script>
<script>
			Placeholdem( document.querySelectorAll( '[placeholder]' ) );

			var fadeElems = document.body.querySelectorAll( '.fade' ),
				fadeElemsLength = fadeElems.length,
				i = 0,
				interval = 100;

				function incFade() {
					if( i < fadeElemsLength ) {
						fadeElems[ i ].className += ' fade-load';
						i++;
						setTimeout( incFade, interval );
					}
				}

				setTimeout( incFade, interval );
</script>
<!--漸變-->