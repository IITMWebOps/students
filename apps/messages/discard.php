<?php


if( !$current_user->login() ) redirect_to('/user/login', true);

$result = mysql_query( "SELECT * FROM stu_portal.pages_temp WHERE id = ".$_GET['q']." LIMIT 1" ) or trigger_error( mysql_error() );
if ( !$result )
  http_response_code(500);

$row = mysql_fetch_object($result);

if( $current_user->has_active_post('Secretary') != $row->post_id and $current_user->por[0]['post_id'] != $row->post_id ){
  render_alert("Permission Denied");
  include(PUBLIC_ROOT . DS . '403.html');
  exit();
}

$query_result = mysql_query("SELECT * FROM stu_portal.pages WHERE id = '".$row->id."'");
$row_pages = mysql_fetch_object($query_result);

$delete_query = "DELETE FROM `stu_portal`.`pages_temp` WHERE `pages_temp`.`id` = '".$row->id."'";

$update_query="UPDATE `stu_portal`.`pages_temp` SET `content` = '".$row_pages->content."', `staged_changes` = '0' WHERE `pages_temp`.`id` = '".$row->id."'";

if ( mysql_num_rows($query_result) > 0 )
  $query = $update_query;
else
  $query = $delete_query;

$result = mysql_query($query) or trigger_error( mysql_error()  );
if( $result ){
  render_alert('Successfully Discarded');
  redirect_to('/messages/mypages', true);
}
else
  http_response_code(500);
?>
