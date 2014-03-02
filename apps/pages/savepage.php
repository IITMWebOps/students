
<?php
  
if( !$current_user->login() ) redirect_to('/user/login', true);

$result = mysql_query( "SELECT * FROM stu_portal.pages_temp WHERE id = ".$_POST['id']." LIMIT 1" ) or trigger_error( mysql_error() );
if ( !$result )
  http_response_code(500);

$row = mysql_fetch_object($result);

if( $current_user->has_active_post('Secretary') != $row->post_id and $current_user->por[0]['post_id'] != $row->post_id ){
  http_response_code(500);
  exit();
}

$update_query = "UPDATE `stu_portal`.`pages_temp` SET `content` = '".$_POST['htmldata']."', staged_changes = '1' WHERE `pages_temp`.`id` = ".$_POST['id']." LIMIT 1";
$update_result = mysql_query($update_query) or trigger_error(mysql_error());

?>
