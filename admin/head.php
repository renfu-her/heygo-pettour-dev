<style>
.skin-blue .main-header .navbar .nav>li>a {
    color: #000;
}
</style>
   <header class="main-header">
    <!-- Logo -->
    <DIV class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?=$compony;?></span>
    </DIV>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">選單切換</span>
        
      </a>  
       
             <span class="txt_14 visible-lg visible-md pull-left" style="padding-top:12px; width:400px;">
      現在時間：
              <!------------ 插入日期碼區段開始 ------------>
              <script language="JavaScript" type="text/javascript">
var now = new Date();
var year = now.getYear();
if (year < 2000) year = year + 1900;
document.write(year + "年 ");

var enabled = 0; today = new Date();
var day; var date;
if(today.getDay()==0) day = "星期日"
if(today.getDay()==1) day = "星期一"
if(today.getDay()==2) day = "星期二"
if(today.getDay()==3) day = "星期三"
if(today.getDay()==4) day = "星期四"
if(today.getDay()==5) day = "星期五"
if(today.getDay()==6) day = "星期六"
date = "<span class='txt_14' align='left'> "+ (today.getMonth() + 1 ) + " 月 " + today.getDate() + " 日 " + " ( " + day + " ) " +"</span> &nbsp;";
document.write(date.fontsize(3));
  </script>
              <!------------ 插入日期控制碼區段結束 ------------>
              <!------------ 插入時間控制碼區段開始 ------------>
              <span id="digitalclock" class="styling"></span>
              <script>
<!--

var alternate=0
var standardbrowser=!document.all&&!document.getElementById

if (standardbrowser)
document.write('<form name="tick"><input type="text" name="tock" size="11"></form>')

function show(){
if (!standardbrowser)
var clockobj=document.getElementById? document.getElementById("digitalclock") : document.all.digitalclock
var Digital=new Date()
var hours=Digital.getHours()
var minutes=Digital.getMinutes()
var dn="AM"

if (hours==12) dn="PM" 
if (hours>12){ dn="PM"
hours=hours-12
}
if (hours==0) hours=12
if (hours.toString().length==1)
hours="0"+hours
if (minutes<=9)
minutes="0"+minutes

if (standardbrowser){
if (alternate==0)
document.tick.tock.value=hours+" : "+minutes+" "+dn
else
document.tick.tock.value=hours+"   "+minutes+" "+dn
}
else{
if (alternate==0)
clockobj.innerHTML=dn+" "+hours+"<font color='#cccccc'> : </font>"+minutes
else
clockobj.innerHTML=dn+" "+hours+"<font color='#ffffff'> : </font>"+minutes
}
alternate=(alternate==0)? 1 : 0
setTimeout("show()",600)
}
window.onload=show

//-->
  </script>
              <!------------ 插入時間控制碼區段結束 ------------>
              </span>
            
      <div class="navbar-custom-menu">
     
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
           <li class="dropdown messages-menu">
            <a href="/" target="_blank">
            <i class="fa fa-home"></i>
              前台首頁
            </a>
          </li>
          <li class="dropdown messages-menu">
            <a href="/admin/include/login_out.php" >
            <i class="fa fa-sign-out"></i>
              登出
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>