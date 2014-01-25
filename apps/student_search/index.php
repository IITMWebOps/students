<?php

page_title('Student Search');

if( !$current_user->login() ) redirect_to('/user/login', true);

$data = json_decode(file_get_contents("php://input"));

echo "<br><br>";

$query = "SELECT DISTINCT username,fullname,room,hostel FROM `stu_portal`.`users` where username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%' LIMIT 10";
$result = mysql_query($query) or http_response_code(500);

if( !mysql_num_rows($result) ) echo "Search Results Not found";
else{
  while($row = mysql_fetch_object($result) ){
    echo "<blockquote>
            <h4>". strtoupper($row->username)."  |  $row->fullname</h4>
            <p># $row->room  $row->hostel</p>
        </blockquote>";
  }
}

?>
