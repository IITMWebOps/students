<?php

$data = json_decode(file_get_contents("php://input"));

$query = "INSERT INTO `students`.`nominations (user_id, post_instance_id, image, manifesto, writeup)
		  VALUES ($data->user_id, $data->post_instance_id, $data->image, $data->manifesto, $data->writeup)";

$result = mysql_query($query) or trigger_error(mysql_error());


echo '<script>
              function manifesto_SubmitCtrl($scope,GetResponse, $location, UserData){
                UserData.request(); 
                GetResponse.request({ location: \'/user\', cache: false, method: \'POST\' });
				  }
          </script>
          <div ng-controller = \'manifesto_SubmitCtrl\'><br><br> <br><center><h2>Uploading Manifesto</h2> </center>  </div>';
