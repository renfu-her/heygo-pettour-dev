<!-- jQuery 3 -->
<script src="/admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="/admin/bower_components/raphael/raphael.min.js"></script>
<script src="/admin/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin/bower_components/moment/min/moment.min.js"></script>
<script src="/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
<!-- 雙色表格 -->
<script src="/admin/js/stripe.js"></script>

<!-- ALERTIFY.js v0.3.11 JS彈出視窗美化-->
<link href="/admin/include/alertify/alertify.core.min.css" rel="stylesheet" />
<link href="/admin/include/alertify/alertify.default.min.css" rel="stylesheet" />
<script src="/admin/include/alertify/alertify.min.js"></script>
<!--表單避免重複發送-->
 <script>
    // 取得表單元素
    const form = document.querySelector('form');
    const submitBtn = form.querySelector('[type="submit"]');

    // 禁用送出按鈕
   form.addEventListener('submit', (e) => {
   e.preventDefault();
	  if (!form.checkValidity()) {
		// 如果表單未通過驗證，就不執行後續的程式碼
	  } else {
		submitBtn.disabled = true;
		submitBtn.value = '上傳中...';
		// 在這裡加入檔案上傳的程式碼
		form.submit(); // 手動送出表單
	  }
	});
</script>
<!--表單避免重複發送-->