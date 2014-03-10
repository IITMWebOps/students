<?php
if( !$current_user->login() ) redirect_to('/user/login', true);
$data = json_decode(file_get_contents("php://input"));



$query = "UPDATE `stu_portal`.`nominations` 
          SET `post_instance_id` = '".$data->post_instance_id."', `image` = '".$data->image."' , `manifesto` = '".$data->manifesto."' , `writeup` = '".$data->writeup."' 
          WHERE `user_id` = '".$current_user->id."'";

$result = mysql_query($query) or die(mysql_error());


echo '<script>
              function manifesto_SubmitCtrl($scope,GetResponse, $location, UserData){
                UserData.request(); 
                GetResponse.request({ location: \'/elections\', cache: false, method: \'POST\' });
				  }
          </script>
          <div ng-controller = \'manifesto_SubmitCtrl\'><br><br> <br><center><h2>Uploading Manifesto</h2> </center>  </div>';
