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

$pages_query = "UPDATE `stu_portal`.`pages` SET `trash` = '1' WHERE `id` = '".$row->id."' LIMIT 1";
$pages_temp_query = "UPDATE `stu_portal`.`pages_temp` SET `trash` = '1' WHERE `id` = '".$row->id."' LIMIT 1";

$pages_result = mysql_query($pages_query) or trigger_error(mysql_error() );
if ( $pages_result ){
  $pages_temp_result = mysql_query($pages_temp_query) or trigger_error(mysql_error() );
  if( $pages_temp_query )
    redirect_to('/pages/mypages',true );
  else
    http_response_code(500);
}
else
  http_response_code(500);
