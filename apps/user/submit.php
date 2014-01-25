<?php

page_title('Login');

if( $current_user->login() ) redirect_to('/user/login', true);


$script = '<script>
              function SubmitCtrl($scope, GetResponse,$location,$http,AppData, UserData){
                  UserData.request();
                  $location.url(GetResponse.history[2]);
              }
          </script>
          <div ng-controller = "SubmitCtrl"><br><br> <br><center><h2>Signing Into Students Portal</h2> </center>  </div>';


$data = json_decode(file_get_contents("php://input"));

if (isset($data->username) and isset($data->password) ){

  if ( !empty($data->username) and !empty($data->password) ){

    $query = "SELECT `users`.`id` FROM `stu_portal`.`users` WHERE `username` LIKE '$data->username'";
    $result = mysql_query($query) or die(mysql_error());

    if (mysql_num_rows( $result) == 1 )

      $userRow = mysql_fetch_object($result);

    else

      http_response_code( 403,' Invalid Username and Password  ' );

    AppConfig::LDAP ? require_once 'ldaplogin.php' : require_once 'studentlogin.php';

    if ( $current_user->login() ) echo $script;
    else http_response_code(403, ' Invalid Username and Password ');

  }else

    http_response_code( 403,' Invalid Username and Password '  );

}else

  http_response_code( 403,' Invalid Username and Password '  );
?>
