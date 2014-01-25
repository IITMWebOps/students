<?php
  if( $current_user->login() ){
    $displayname = $current_user->nick ? $current_user->nick : $current_user->fullname ;
    echo '{ "login":true,
            "username": "'.$current_user->username.'",
            "fullname": "'.$current_user->fullname.'",
            "displayName": "'.$displayname.'",
            "room": "'.$current_user->room.'",
            "hostel": "'.$current_user->hostel.'",
            "nick": "'.$current_user->nick.'",
            "bgroup": "'.$current_user->bgroup.'",
            "contact": "'.$current_user->contact.'",
            "email": "'.$current_user->email.'" }';
  }
  else
    echo '{ "login":false,
            "username": "",
            "fullname": "",
            "displayName": "Student",
            "room": "",
            "hostel": "",
            "nick": "",
            "bgroup": "",
            "contact": "",
            "email": "" }';
?>
