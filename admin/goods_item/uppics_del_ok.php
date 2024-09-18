<?php

include "../include/check_all.php";//檢查登入權限和使用者是否被凍結

include "../common.func.php";

$bakno		=	$_GET['bakno'];//返回原位時丟回原本查詢的goods_ing的no編號
$del_no		=	$_GET['no'];//刪除的編號
$bpic		=	$_GET['bpic'];//大圖
$spic		=	$_GET['spic'];//小圖
// is_file:判斷檔案是否存在並為正常檔案，傳回布林值
// unlink:刪除檔案，傳回布林值
$file="../goods_pic/".$bpic;
  if(is_file($file)){
    unlink($file);
   // echo "{$file}刪除大圖成功!"."<BR>";
 // }else{
  //  echo "{$file}大圖檔案不存在!"."<BR>";
  }

$file_s="../goods_pic/".$spic;
  if(is_file($file_s)){
    unlink($file_s);
 //   echo "{$file_s}刪除小圖成功!"."<BR>";
 // }else{
 //   echo "{$file_s}小圖檔案不存在!"."<BR>";
  }

$sql="DELETE FROM uppics WHERE uppics_no =:del_no;";

$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':del_no', $del_no, PDO::PARAM_INT);
$result->execute();

$db = null;// 關閉連線

?>

<script language="javascript">
	location.href= ('./uppics.php?no=<?=$bakno;?>&msg=del');

</script>
