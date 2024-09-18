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