<?PHP 
if (!isset($_SESSION)) {
 	 session_start();
	}


echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
include "./admin/common.func.php";

//訂單號碼
	//如果還沒有訂單號碼則產生一組
	putenv("TZ=Asia/Taipei");//調整時間為台北時區
	$t1 = date("Y")-1911; 
	$t2 = date("md"); 
	$date=(int)($t1.$t2);//訂單日期
	$time = date("his"); //訂單時間
	if(!isset($_SESSION["cart"])||$_SESSION["cart"]==''){
		$_SESSION["cart"] =date("Y").$t2.$time.rand(11,99);//訂單編號
			//清除超過60天以上的購物車內容
			$Day = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-60, date("Y"))); //取得60天前日期的方法
			
			
			$sql="DELETE FROM cart WHERE cart_order_time <= :Day;";
		

			$result = $db->prepare("$sql");//防sql注入攻擊
			// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
			$result->bindValue(':Day', $Day, PDO::PARAM_STR);
			$result->execute();
		
		
			//清除超過60天以上的購物車內容
	}
//訂單號碼

$order_no		=	$_SESSION["cart"];//訂單編號
$class_name		=	$_POST["class_name"];//商品選擇型號
$class_money	=	$_POST["class_money"];//商品原價
$class_money2	=	$_POST["class_money2"];//商品優惠價

$pdt_no			=	$_POST["pdt_no"];//商品NO
$pdt_name		=	$_POST["pdt_name"];//商品名稱
$pdt_pic		=	$_POST["pdt_pic"];//商品照片
$pdt_description=	$_POST["pdt_description"];//商品描述
$member 	=	"1";//訂購數量

$order_time	=	date("Y-m-d H:i:s");//訂購日期


//判斷該商品是否已加入過購物車
	$sql_cart="
	SELECT * FROM cart 
	WHERE `cart_pdt_no` = :pdt_no  AND `cart_class_name` = :class_name  AND  `cart_order_no` = :order_no
	";
	$result_cart = $db->prepare("$sql_cart");//防sql注入攻擊.
	$result_cart->bindValue(':order_no', $order_no, PDO::PARAM_STR);
	$result_cart->bindValue(':class_name', $class_name, PDO::PARAM_STR);
	$result_cart->bindValue(':pdt_no', $pdt_no, PDO::PARAM_INT);

	$result_cart->execute();
	$counts_cart=$result_cart->rowCount();//算出總筆數

	if($counts_cart!=0){//代表購物車已加入過該商品的包裝方式
		echo '<script language="javascript">';
					
				echo 'alert("此商品已加入過購物車!");';
				echo "location.href= ('./index.php#item-row');";
				
				
		echo '</script>';
		exit();
		
    }

//判斷該商品是否已加入過購物車
	

//複製圖片
$sourceImagePath = $_SERVER['DOCUMENT_ROOT'] .'/admin/goods_pic/'.$pdt_pic;
$destinationImagePath = $_SERVER['DOCUMENT_ROOT'] .'/admin/cart_pic/'.$pdt_pic;

if (copy($sourceImagePath, $destinationImagePath)) {
   // echo "图片复制成功!";
} else {
   // echo "图片复制失败!";
}
//複製圖片


//將購物車內容加入資料庫

//新增
$sql="INSERT INTO `cart` (
`cart_order_no` ,
`cart_class_name` ,
`cart_class_money`,
`cart_class_money2`,
`cart_pdt_no`,
`cart_pdt_name`,
`cart_pdt_pic`,
`cart_pdt_description`,
`cart_order_time`
)	VALUES (
:order_no,
:class_name,
:class_money,
:class_money2,
:pdt_no,
:pdt_name,
:pdt_pic,
:pdt_description,
:order_time
)";

	$result = $db->prepare("$sql");//防sql注入攻擊
	// 數值PDO::PARAM_INT  字串PDO::PARAM_STR
	$result->bindValue(':order_no', $order_no, PDO::PARAM_STR);
	$result->bindValue(':class_name', $class_name, PDO::PARAM_STR);
	$result->bindValue(':class_money', $class_money, PDO::PARAM_STR);
	$result->bindValue(':class_money2', $class_money2, PDO::PARAM_STR);
	$result->bindValue(':pdt_no', $pdt_no, PDO::PARAM_INT);
	$result->bindValue(':pdt_name', $pdt_name, PDO::PARAM_STR);
	$result->bindValue(':pdt_pic', $pdt_pic, PDO::PARAM_STR);
	$result->bindValue(':pdt_description', $pdt_description, PDO::PARAM_STR);

	$result->bindValue(':order_time', $order_time, PDO::PARAM_STR);


	$result->execute();


$db = null;// 關閉連線


	echo '<script language="javascript">';
	//echo 'alert("商品已加入購物車!");';
	echo "location.href= ('./index.php#checkout');";
	echo '</script>';
	
?>

