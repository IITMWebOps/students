<?php

 if (!function_exists('upload_file')) {
        function upload_file($type = NULL, $size = NULL, $name = NULL, $previousf = NULL) {


          if ($type !== NULL) {

            $size = $size ? $size : '1024';


            $random_string = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 40) , 1) .substr( md5( time() ), mt_rand(0,12), 5) ;


?>

<div id="filediv<?=$random_string?>">
  <form id="fileform<?=$random_string?>" enctype="multipart/form-data">
	  <div class="small-12 columns" style="margin: 0; padding:0px;">	
		  <div id="filetarget<?=$random_string?>" class="row collapsed">
				<div id="filebup<?=$random_string?>" class="progress small-10 columns">
					<input id="fileinput<?=$random_string?>" name="file"  type="file" style="position:absolute;" class=" upload-input">					
					<span id="fileprogress<?=$random_string?>"  class="meter" style="width:0%" ></span>  
        		</div>
        		<div class="small-2 columns" style="margin:0px; padding:0px">
					<a id="filebutton<?=$random_string?>" onclick="UploadMainFunc<?=$random_string?>()"  class="button expand"><i class="fa fa-upload"></i></a>        		
        		</div> 
      </div> 	 	
	 </div>      
  </form>
</div>
   

<script>
            function UploadMainFunc<?=$random_string?>(){
              console.log('yay');
  var file = $('#fileinput<?=$random_string?>')[0].files[0];
  var dtypes = [<?php echo '"'.implode('","', $type).'"' ?>];
  console.log(dtypes);
          var name = file.name;
          var size = file.size;
          var type = file.type;
          if(!verifyType(type,dtypes) ) {
            return false;  
          }
          if(Number(size) > <?=$size?> ){
            alert('Maximum file size allowed is '+ Number(<?=$size?>) / 1024 +' Kb');
            return false;
          }

          if(size && name && type){
            console.log(name+"  n  "+size+"   x  "+"   y  "+type);
            upload_file_to_server<?=$random_string?>(name);
          }
          
}

function upload_file_to_server<?=$random_string?>(filenas){
  var formData = new FormData();
  formData.append('file', $('#fileinput<?=$random_string?>')[0].files[0]); 
  console.log(formData);
  $.ajax({
    url: '<?=APP_URL?>/file_upload/upload',  
    type: 'POST',
    xhr: function() {  
      var myXhr = $.ajaxSettings.xhr();
      if(myXhr.upload){ 
        myXhr.upload.addEventListener('progress',progressHandlingFunction<?=$random_string?>, false); 
      }
      return myXhr;
    },
//    beforeSend: beforeSendHandler,
      success: function(response){
        console.log(response);
        responseObj = $.parseJSON(response);
        DisplayFile<?=$random_string?>(responseObj,filenas);
      },
      error: function(response){
        responseObj = $.parseJSON(response);
        DisplayUpload<?=$random_string?>(responseObj,filenas);
      },
 
    data: formData,
    cache: false,
    contentType: false,
    processData: false
  });
}

function DisplayUpload<?=$random_string?>(response,filenas){
  if( response.error ) alert('We encountered an error while uploading file. Please try again');
  $('#filediv<?=$random_string?>').html("<form id='fileform<?=$random_string?>' enctype='multipart/form-data'> <div class='small-12 columns'  style='margin: 0; padding:0px;'><div id='filetarget<?=$random_string?>' class='row collapsed'>	<div id='filebup<?=$random_string?>' class='progress small-10 columns'><input id='fileinput<?=$random_string?>' name='file' type='file' style='position:absolute;' class=' upload-input'><span id='fileprogress<?=$random_string?>'  class='meter' style='width:0%' ></span> </div><div class='small-2 columns'  style='margin:0px; padding:0px'>	<a id='filebutton<?=$random_string?>' onclick='UploadMainFunc<?=$random_string?>()' class='button expand'><i class='fa fa-upload'></i></a> </div>  </div></div> </form>");
}

function DisplayFile<?=$random_string?>(response,filenas){
    $('#filediv<?=$random_string?>').html("<div class='small-12 columns' style='margin:0; padding:0px;'> \
          <div id='filetarget<?=$random_string?>' class='row collapsed'><div id='fileaup<?=$random_string?>'>\
          <input id='<?=$name?>' type='hidden' value='"+response.name+"'></input>\
          <a style='max-height:3.2rem; padding-bottom:3.2rem;' target='_blank'  value='"+response.name+"'  href='<?=FILE_ROOT?>/"+response.name+"' class='button  small-10 columns' style='text-align:left;'>Successfully Uploaded : "+filenas+"</a> <a onclick=\"removeFile<?=$random_string?>('"+response.name+"')\"  class='button alert small-2 columns' style='padding:1.0625rem 0 1rem;'><i class='fa fa-times'</i></i></a></div></div></div> ");
}

function verifyType(type,Dtype){
  var dtystr = '';
  for(var i=0; i < Dtype.length; i++){
    dtystr = dtystr + ' | ' + Dtype[i];
    console.log(dtystr + "  | " + type + "  | "+ Dtype[i]);
    if (type == Dtype[i]) return true;
  }
  alert('Only '+dtystr+' filetypes are allowed');
  return false;
}

function removeFile<?=$random_string?>(filenm){
  $.ajax({url:"<?=APP_URL?>/file_upload/remove?q="+filenm ,success: function(response){ DisplayUpload<?=$random_string?>({},0); }  });  
          }

function progressHandlingFunction<?=$random_string?>(e){
  if(e.lengthComputable){
    $('#fileprogress<?=$random_string?>').css("width",function(){
      console.log(100*e.loaded/e.total);
      return 100*e.loaded/e.total+'%';
    });
  }
          }

</script>

<?php
}
}
 }


//upload_file(array('image/jpeg','image/jpg', 'video/mp4'), 1024000000, 'fileas');
?>
