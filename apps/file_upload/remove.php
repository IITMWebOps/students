<?php
$file_name=$_GET["q"];
$check_name="SELECT created_by FROM 'stu_portal'.'attachments' where filename='$file_name'";
$results=mysql_query($check_name);

if($results->created_by==$current_user->id)
{
unlink('FILE_DIR_ROOT."/".$results');
$query="UPDATE 'stu_portal'.'attachments' SET status=0 where created_by='$current_user->id'";
$done=mysql_query($query);
echo "file deleted";
}
else{
echo " you cannot delete this file";
}
?>
