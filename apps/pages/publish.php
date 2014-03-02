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

$insert_query = "INSERT INTO `stu_portal`.`pages` VALUES ('".$row->id."','".$row->link."','".$row->name."','".$row->content."','".$row->post_id."','".$row->created_position_of_responsibility_id."','".$row->updated_position_of_responsibility_id."','0','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."' )";

$update_query="UPDATE `stu_portal`.`pages` SET `content` = '".$row->content."', `updated_position_of_responsibility_id` = '".$row->updated_position_of_responsibility_id."' WHERE `pages`.`id` = '".$row->id."'";

$count = mysql_query("SELECT COUNT(link) FROM stu_portal.pages WHERE id = '".$row->id."'");
$count_result = mysql_fetch_array($count);
if ( $count_result[0]["COUNT(link)"] > 0 )
  $query = $update_query;
else
  $query = $insert_query;

$result = mysql_query($query) or trigger_error( mysql_error()  );
if( $result ){
  $mark_staged_changes = mysql_query("UPDATE `stu_portal`.`pages_temp` SET `staged_changes` = '0' WHERE `id` = ".$row->id." LIMIT 1") or trigger_error(mysql_error() );
  render_alert('Successfully Published');
  redirect_to('/pages/'.$row->link, true);
}
else
  http_response_code(500);
?>
