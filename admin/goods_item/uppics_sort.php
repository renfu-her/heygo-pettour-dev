<?PHP 
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?PHP
$no_back		=	$_POST["no"];
$uppics_class	=$_POST["uppics_class"];//上傳多圖的類別

//取出資料庫中no的最大值
$sql="
SELECT MAX(uppics_no) FROM uppics WHERE uppics_class= :uppics_class
";
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':uppics_class', $uppics_class, PDO::PARAM_STR);
$result->execute();
$rows = $result->fetch(PDO::FETCH_ASSOC);
$max_no = $rows["MAX(uppics_no)"];//取出資料庫中no的最大值


//取出資料庫中no的最小值
$sql="
SELECT MIN(uppics_no) FROM uppics WHERE uppics_class=:uppics_class
";
$result = $db->prepare("$sql");//防sql注入攻擊
// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
$result->bindValue(':uppics_class', $uppics_class, PDO::PARAM_STR);
$result->execute();
$rows = $result->fetch(PDO::FETCH_ASSOC);
$min_no = $rows["MIN(uppics_no)"];//取出資料庫中no的最小值



//將每個no從最小跑到最大，對應到的no就變更他該有的排序值

for ($no=$min_no;$no<=$max_no;$no++){
	$ck_no='ck_'.$no;
	$uppics_sort_ck	=	$_POST["$ck_no"];//取原本資料庫的值
	$uppics_sort	=	$_POST["$no"];//取設定的值
	
	if($uppics_sort_ck<>$uppics_sort){//如果原值和傳遞值不同，代表排序有變，則更新排序
	//echo '編號'.$no.'-'.$ck_no.'值等於='.$uppics_sort.'原值='.$uppics_sort_ck.'<br>';
		$sql="UPDATE uppics SET uppics_sort = :uppics_sort 
			WHERE uppics_no =:no &&   uppics_class= :uppics_class
		;";

		$result = $db->prepare("$sql");//防sql注入攻擊
		// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
		$result->bindValue(':uppics_sort', $uppics_sort, PDO::PARAM_INT);
		$result->bindValue(':no', $no, PDO::PARAM_INT);
		$result->bindValue(':uppics_class', $uppics_class, PDO::PARAM_STR);
		$result->execute();

	}
}

//釋放
$db = null;// 關閉連線
?>
<script language="javascript">
 location.href= ('./uppics.php?msg=updata&no=<?=$no_back?>');
</script>
