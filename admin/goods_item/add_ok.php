<?PHP
include "../include/check_all.php";//檢查登入權限和使用者是否被凍結
include "../common.func.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?PHP
$title 	=	$_POST["title"];
$description=	$_POST["description"];
$sort	=	'0';
$edituser   =	$_SESSION["id"];//發布者
$edittime   =	date("Y-m-d H:i:s");//新增時間

//發布狀態：有勾選傳回:1
if ( isset($_POST["hide"]) && $_POST["hide"] != '' ) { $hide = '1'; }
else { $hide = '0'; }

//class
$class = $_POST['class'];
  foreach ($class as $class_tmp) {
    //echo $class_tmp . "<br>";
	  $class_txt = $class_txt.','. $class_tmp;
  }
$class_txt=$class_txt.',';
//class
//class2
$class2 = $_POST['class2'];
  foreach ($class2 as $class2_tmp) {
    //echo $class_tmp . "<br>";
	  $class2_txt = $class2_txt.','. $class2_tmp;
  }
$class2_txt=$class2_txt.',';
//class2


//圖片上傳判斷JPG還是PNG
//取副檔名
$filename=$_FILES['imgfile']['name'];//上傳檔案原始名稱
$ext = strrchr($filename, "."); //附檔名

//以時間取得時間亂數當成檔名.副檔名
putenv("TZ=Asia/Taipei");//調整時間為台北時區
$t1 = date("Y")-1911; 
$t2 = date("md"); 
$date=(int)($t1.$t2);
$time = date("his"); 
$pic_s =$date.$time.'_s'.$ext;//時間間亂檔名小圖
$pic_b =$date.$time.$ext;//時間間亂檔名大圖


//處理 jpg圖檔
if(($ext=='.jpg')||($ext=='.jpeg')||($ext=='.JPG')||($ext=='.JPEG'))
{
		
	// 取得上傳圖片
	$src = imagecreatefromjpeg($_FILES['imgfile']['tmp_name']);
	
	// 取得來源圖片長寬
	$src_w = imagesx($src);
	$src_h = imagesy($src);
	
	//如果寬度大於700才縮圖
	if($src_w > $UpLoadPicMax_b){
	// 假設要長寬 小圖不超過90*90  大圖不超過600*600
	//if($src_w > $src_h){
	  $thumb_b_w = $UpLoadPicMax_b;
	  $thumb_b_h = intval($src_h / $src_w * $UpLoadPicMax_b);
	
	  $thumb_s_w = $UpLoadPicMax_s;
	  $thumb_s_h = intval($src_h / $src_w * $UpLoadPicMax_s);
	}
	
	else{//圖的原長和寬
	  $thumb_b_w = $src_w;//圖的原寬
	  $thumb_b_h = $src_h;//圖的原高
	
	  $thumb_s_w = $UpLoadPicMax_s;
	  $thumb_s_h = intval($src_h / $src_w * $UpLoadPicMax_s);
		}
	
	// 建立縮圖
	$thumb_s = imagecreatetruecolor($thumb_s_w, $thumb_s_h);
	$thumb_b = imagecreatetruecolor($thumb_b_w, $thumb_b_h);
	
	// 開始縮圖
	imagecopyresampled($thumb_s, $src, 0, 0, 0, 0, $thumb_s_w, $thumb_s_h, $src_w, $src_h);
	imagecopyresampled($thumb_b, $src, 0, 0, 0, 0, $thumb_b_w, $thumb_b_h, $src_w, $src_h);
	
	// 儲存縮圖到指定goods_banner3目錄
	imagejpeg($thumb_s, "../goods_pic/".$pic_s,100);//小圖
	imagejpeg($thumb_b, "../goods_pic/".$pic_b,90);//大圖

}
//處理 jpg圖檔

//處理png檔
if(($ext=='.png')||($ext=='.PNG'))
{
	//獲取源圖gd圖像識別字
	$srcImg = imagecreatefrompng($_FILES['imgfile']['tmp_name']);
	
	// 取得來源小圖片長寬
	$src_w = imagesx($srcImg);
	$src_h = imagesy($srcImg);

	
	//如果寬度大於700才縮圖
	if($src_w > $UpLoadPicMax_b){
	// 假設要長寬 小圖不超過90*90  大圖不超過600*600
	//if($src_w > $src_h){
	  $thumb_b_w = $UpLoadPicMax_b;
	  $thumb_b_h = intval($src_h / $src_w * $UpLoadPicMax_b);
	
	  $thumb_s_w = $UpLoadPicMax_s;
	  $thumb_s_h = intval($src_h / $src_w * $UpLoadPicMax_s);
	}
	
	else{//圖的原長和寬
	  $thumb_b_w = $src_w;//圖的原寬
	  $thumb_b_h = $src_h;//圖的原高
	
	  $thumb_s_w = $UpLoadPicMax_s;
	  $thumb_s_h = intval($src_h / $src_w * $UpLoadPicMax_s);
	}
	
	
	//創建新圖
	$newImg_b = imagecreatetruecolor($thumb_b_w, $thumb_b_h);
	$newImg_s = imagecreatetruecolor($thumb_s_w, $thumb_s_h);
	
	
	//分配顏色 + alpha，將顏色填充到新圖上
	$alpha_b = imagecolorallocatealpha($newImg_b, 0, 0, 0, 127);
	imagefill($newImg_b, 0, 0, $alpha_b);
	
	$alpha_s = imagecolorallocatealpha($newImg_s, 0, 0, 0, 127);
	imagefill($newImg_s, 0, 0, $alpha_s);
	
	 
	//將源圖拷貝到新圖上，並設置在保存 PNG 圖像時保存完整的 alpha 通道資訊
	imagecopyresampled($newImg_b, $srcImg, 0, 0, 0, 0, $thumb_b_w, $thumb_b_h, $src_w, $src_h);
	imagesavealpha($newImg_b, true);
	
	imagecopyresampled($newImg_s, $srcImg, 0, 0, 0, 0, $thumb_s_w, $thumb_s_h, $src_w, $src_h);
	imagesavealpha($newImg_s, true);
	
	
	
	
	
	// 儲存縮圖到指定goods_banner3目錄
	imagepng($newImg_b, "../goods_pic/".$pic_b);
	imagepng($newImg_s, "../goods_pic/".$pic_s);
}

//處理gif檔不縮圖，所以大小圖同一張

if(($ext=='.GIF')||($ext=='.gif'))
{
	//上傳檔案
	//上傳到的地點(請已"/"結束)
	$upload_path = '../goods_pic/';
	
	//可接受的最大檔案大小(單位: bytes)
	//不設代表可以接受任意大小
	$max_size = '';
	
	/* 上傳程序開始 */
	
	//檢查是否有錯誤
	if(isset($_FILES['imgfile']) && sizeof($_FILES['imgfile']) > 0)
	{
	if($_FILES['imgfile']['error'] > 0)
	{
	//發生錯誤
	//錯誤代碼資訊可以上php官網看:
	//http://tw.php.net/manual/en/features.file-upload.errors.php
	echo '上傳錯誤代碼: ' . $_FILES['imgfile']['error'] . '<br />';
	exit;
	}
	
	//是否有限制檔案大小?
	if(($max_size > 0) && ($_FILES['imgfile']['size'] > $max_size))
	{
	//檔案過大
	echo '您上傳的檔案大小大於系統可接受的範圍<p>';
	echo '<input type="button" class="input" style="CURSOR:hand; height:25px; width:100px;" onclick="history.back()" value="Back" />';
	exit;
	}
	
	//檢查檔案是否已存在
	if(file_exists($upload_path . basename($_FILES['imgfile']['name'])))
	{
	echo '檔案已存在,請重新選擇上傳檔案<p>';
	echo '<input type="button" class="input" style="CURSOR:hand; height:25px; width:100px;" onclick="history.back()" value="Back" />';
	exit;
	}
	
	//檢查目錄是否存在, 不存在的話新增一個
	if(!is_dir($upload_path) && !mkdir($upload_path))
	{
	//目錄不存在, 無法新增資料夾
	echo '系統無法新增資料夾';
	exit;
	}
	

	//移動已上傳的檔案
	$file_name=$pic_b;//檔案名稱
	$pic_s=$pic_b;//應為沒縮圖，所以讓大小圖都存同一個檔名
	
	move_uploaded_file($_FILES['imgfile']['tmp_name'], $upload_path . $file_name);
	}
	//上傳檔案
	
}
//處理gif檔不縮圖，所以大小圖同一張


//圖片上傳
//判斷是否有上傳檔案沒有就不寫入資料庫了//看扣除附檔名長度有沒有小於13和15
if(strlen($pic_s)<16)
	$pic_s='';
if(strlen($pic_b)<14)
	$pic_b='';

//判斷是否有上傳檔案沒有就不寫入資料庫了//看扣除附檔名長度有沒有小於13和15


//新增使用者
$sql="insert into goods_item (	
goods_item_title,
goods_item_sort,
goods_item_class,
goods_item_class2,
goods_item_description,
goods_item_hide,
goods_item_pic_s,
goods_item_pic_b,
goods_item_edituser,
goods_item_edittime
)	VALUES (
:title,
:sort,
:class_txt,
:class2_txt,
:description,
:hide,
:pic_s,
:pic_b,
:edituser,
:edittime
)";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':title', $title, PDO::PARAM_STR);
	$result->bindValue(':sort', $sort, PDO::PARAM_INT);
	$result->bindValue(':class_txt', $class_txt, PDO::PARAM_INT);
	$result->bindValue(':class2_txt', $class2_txt, PDO::PARAM_INT);
	$result->bindValue(':description', $description, PDO::PARAM_STR);
	$result->bindValue(':hide', $hide, PDO::PARAM_INT);
	$result->bindValue(':pic_s', $pic_s, PDO::PARAM_STR);
	$result->bindValue(':pic_b', $pic_b, PDO::PARAM_STR);

	$result->bindValue(':edittime', $edittime, PDO::PARAM_STR);
	$result->bindValue(':edituser', $edituser, PDO::PARAM_STR);


	$result->execute();


$db = null;// 關閉連線


?>
<script language="javascript">
location.href= ('./index.php?msg=add');
</script>





