<?PHP
if($_GET['menu_bt']<>''){
$_SESSION["admin_menu_bt"]=$_GET['menu_bt'];//按鈕停佇頁//記錄左手邊停靠選單 treeview active menu-open
}
?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">       
        <!--列表-->
        
         
                  
        <li <?PHP if($_SESSION['admin_menu_bt']==13) echo ' class="active"';?>>
          <a href="/admin/goods_class2/index.php?menu_bt=13&clean=yes">
            <i class="fa fa-cog fa-fw"></i> <span>商品類別</span>
          </a>
        </li>  
       
         <li <?PHP if($_SESSION['admin_menu_bt']==20) echo ' class="active"';?>>
          <a href="/admin/goods_class/index.php?menu_bt=20&clean=yes">
            <i class="fa fa-cog fa-fw"></i> <span>商品規格設定</span>
          </a>
        </li>     
        <li <?PHP if($_SESSION['admin_menu_bt']==10) echo ' class="active"';?>>
          <a href="/admin/goods_item/index.php?menu_bt=10&clean=yes">
            <i class="fa fa-cog fa-fw"></i> <span>商品管理</span>
          </a>
        </li> 
         <li <?PHP if($_SESSION['admin_menu_bt']==11) echo ' class="active"';?>>
          <a href="/admin/order/index.php?menu_bt=11&clean=yes&sh_status=已收到訂單">
            <i class="fa fa-cog fa-fw"></i> <span>訂單管理</span>
          </a>
        </li> 
        <li <?PHP if($_SESSION['admin_menu_bt']==0) echo ' class="active"';?>>
          <a href="/admin/webinfo/index.php?menu_bt=0">
            <i class="fa fa-cog fa-fw"></i> <span>網站資料設定</span>  
          </a>
        </li>
        
         <?PHP if($_SESSION["power"]<=0){?>
        <li <?PHP if($_SESSION['admin_menu_bt']==2) echo ' class="active"';?>>
          <a href="/admin/member/index.php?menu_bt=2">
            <i class="fa fa-cog fa-fw"></i> <span>帳號管理</span>  
            
          </a>
        </li>
         <?PHP }?>
        <!--列表--> 
         
        <!--登入資訊 
		<div class="well" style="padding: 10px; margin: 40px 20px 10px 20px; background: #e3e3e3;font-size: 12px;">
				<strong style=" font-size: 15px;">登入資訊</strong>
				<hr style="margin: 5px 0px;border-top: 1px solid #bbb;">
				<strong style="font-size: 14px;">帳號:</strong>
				<?= $_SESSION["id"]; ?>
			<hr style="margin: 5px 0px;border-top: 1px solid #bbb;">					
					<strong style="font-size: 14px;">名稱:</strong>
					<?= $_SESSION["name"]; ?>           		   		          
				<hr style="margin: 5px 0px;border-top: 1px solid #bbb;">
					<strong style="font-size: 14px;">權限:</strong>
<?PHP
					 switch ($_SESSION["power"]) {
					   case '0': 
							echo '最高管理者'; 
							break;
					   case '1':
							 echo '操作人員'; 
							break;
					   case '2':
							 echo '凍結使用'; 
							break;
					}	  
					?> 
				<hr style="margin: 5px 0px;border-top: 1px solid #bbb;">
				<strong style="font-size: 14px;">登入IP:</strong>
					<?=getenv('REMOTE_ADDR');?>        
				<hr style="margin: 5px 0px;border-top: 1px solid #bbb;">
			</div>
        <!--登入資訊-->  
        <!--創億網頁設計客服中心          
            <li class="txt_wt txt_16" style="margin-top: 30px; background: #367FA9; padding: 15px;text-align: center;">
			<strong>創億網頁設計客服中心</strong> </li>       
			<li class="txt_wt" style="margin: 0 auto;background: #333;  padding: 20px; line-height: 150%">
				<div><strong style="font-size: 14px;">聯絡人</strong>：小羅<span  style="font-size: 10px;padding-left: 4px;">設計師</span></div> 
				<div><strong style="font-size: 14px;">電話</strong>：<a href="#" onclick="location.href='tel:04-35080005'">(04)3508-0005</a></div>
				<div><strong style="font-size: 14px;">信箱</strong>：<a href="mailto:service@webg.tw" target="_blank">service@webg.tw</a></div>
				<div><strong style="font-size: 14px;">網址</strong>：<a href="https://www.webg.tw" target="_blank">www.Webg.tw</a></div>
			</li>   
        <!--創億網頁設計客服中心--> 
      </ul> 
       
       
        
     
    </section>
    <!-- /.sidebar -->
  </aside>