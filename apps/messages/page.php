<?php

  function GetPostName($id){
    $result = mysql_query("SELECT * FROM `stu_portal`.`posts` WHERE `id` = '$id'") or trigger_error(mysql_error() );
    $row = mysql_fetch_object($result);
    return $row->post_name." ".$row->top_level_post_name;
  }

  $uri_paths = explode('/',$_SERVER['REQUEST_URI']); 

  $num_of_paths = count($uri_paths);
  if( $uri_paths[$num_of_paths-2] != 'messages' ){
    include PUBLIC_ROOT . DS . '404.html';
    exit();
  }
  else
    $requested_page = $uri_paths[$num_of_paths-1];

  $query = "SELECT * FROM `stu_portal`.`pages` WHERE `link` LIKE '$requested_page' AND `trash` = '0' LIMIT 1";
  $result = mysql_query($query) or trigger_error( mysql_error() );
  $num = mysql_num_rows($result);
  if ( $num == 0 ){
    include PUBLIC_ROOT . DS . '404.html';
    exit();
  }

  $row = mysql_fetch_object($result);

  page_title($row->name);

  echo"<br><br>$row->content <br><br>
    <strong>Created by</strong> : ".GetPostName($row->post_id)."<p class='text right'><strong>Updated at</strong> : ".$row->updated_at." </p> <br><br> 
    ";


if( $current_user->login() ){ 

    if( $current_user->has_active_post('Secretary') == $row->post_id or $current_user->por[0]['post_id'] == $row->post_id ){
        echo "<a href='#/messages/edit?q=".$row->id."' class='button small'>Edit This Page </a>
              <a href='#/messages/trash?q=".$row->id."' class='button small'> Trash This Page</a>   
              <a href='#/messages/new' class='button small right'>Create Page</a>&nbsp;
              <a href='#/messages/mypages' class='button small right'>My Pages</a>";
  }
}
?>
