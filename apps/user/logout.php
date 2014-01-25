<?php

page_title('Login');

  $current_user->logout();
  unset($_SESSION['id']);
  unset($_COOKIE['uid']);
  session_destroy();

  http_response_code('200');

echo '<script>
              function LogoutCtrl($scope, GetResponse,$location,$http,AppData, UserData){
                  UserData.request();
                  $location.url(GetResponse.history[1]);
              }
          </script>
          <div ng-controller = "LogoutCtrl"><br><br> <br><center><h2>Signing Out Students Portal</h2> </center>  </div>';


?>
