<?php
if (!empty($_POST['UserInputPassCode'])) {

 if ($_POST['SystemPassCode'] != $_POST['UserInputPassCode'])
  {
    echo "<script language=\"JavaScript\"> ";
    echo "window.alert(\"隨機驗證碼比對結果，不相符合，請確認後再試!!\");";
    echo "history.back(-1);";
    echo "</script>";
    exit;
  }

