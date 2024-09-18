<script>
    function chkfile(target) {
     var fileSize = 0;         
     if (!target.files) {     
       var filePath = target.value;     
       var fileSystem = new ActiveXObject("Scripting.FileSystemObject");        
       var file = fileSystem.GetFile (filePath);     
       fileSize = file.Size;    
     } else {    
      fileSize = target.files[0].size;     
      }   
      var size = fileSize / <?=$Upload_File_MaxSize?>;    
      if(size><?=$Upload_File_MaxSize?>){  
       alert("<?=$Upload_File_MaxSizetxt?>");
       target.value="";
       return
      }
     
		reg = /.(jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF)$/;
	if (!target.value.match(reg)){
			alertify.alert('您選擇的檔案不是jpg、png或gif格式!!!');
			target.value="";
		}
		
    } 
  </script>