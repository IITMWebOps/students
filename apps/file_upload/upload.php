<?php
$allowedExts = array("gif", "jpeg", "jpg", "png","csv","pdf");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "text/csv")
|| ($_FILES["file"]["type"] == "application/pdf")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 15000000)
&& in_array($extension, $allowedExts))
  {
if ($_FILES["file"]["error"] > 0)
  {
   echo "{'error' : '".$_FILES["file"]["error"]."'}";
  
  
  }
else
  {
  
 
  }
   $random_string = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 50) , 15) .substr( md5( time() ), mt_rand(0,12), 15) ;
      $_FILES["file"]["name"]=$random_string.$extension;
   if (file_exists($_FILES["file"]["name"]))
      {
       echo "{'error' : '"."file already exists"."'}";
      }
    else
      {
        echo "{'name' : '".$_FILES["file"]["name"]."'}";


      if(move_uploaded_file($_FILES["file"]["tmp_name"],FILE_DIR_ROOT."/".$_FILES["file"]["name"]))
      echo "test";
      
      }
  }
  else
  {
   echo "{'error' : '"."wrong file type or file too large"."'}";
  
  }
  $query= "INSERT INTO `stu_portal`.`attachments` (`filename`,`created_by`,`created_at`) VALUES('".$_FILES["file"]["name"]."','".$current_user->id."', CURRENT_TIMESTAMP)";
  $result=mysql_query($query)or trigger_error(mysql_error());
?>
