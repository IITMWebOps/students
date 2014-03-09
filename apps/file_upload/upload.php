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
  
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
  
  echo "Upload: " . $_FILES["file"]["name"] . "<br>";
  echo "Type: " . $_FILES["file"]["type"] . "<br>";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
  }
   if (file_exists($_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],FILE_ROOT."/".$_FILES["file"]["name"]);
      echo "Stored as: " . $_FILES["file"]["name"];
      }
  }
  else
  {
  echo "Invalid file";
  print_r( $_FILES["file"]["error"] );
  }
?>
