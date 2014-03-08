<?php

$data = json_decode(file_get_contents("php://input"));

$query = "UPDATE `stu_portal`.`users`
		  SET nick='$data->nick', bgroup='$data->bgroup', email='$data->email', contact='$data->contact', room='$data->room', hostel='$data->hostel'
		  WHERE username like '$data->username'";
$result=mysql_query($query) or trigger_error(mysql_error());

echo '<script>
              function userreload_SubmitCtrl($scope,GetResponse, $location, UserData){
                UserData.request(); 
                GetResponse.request({ location: \'/user\', cache: false, method: \'POST\' });
				  }
          </script>
          <div ng-controller = \'userreload_SubmitCtrl\'><br><br> <br><center><h2>Updating Profile</h2> </center>  </div>';
