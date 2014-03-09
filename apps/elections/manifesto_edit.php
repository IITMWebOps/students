<?php
if (!$current_user->login()) redirect_to('/user/login',true);
$query = "SELECT * FROM `stu_portal`.`nominations` WHERE user_id=$current_user->id";
$result = mysql_query($query) or trigger_error(mysql_error());
$num_rows = mysql_num_rows($result);
//if (!$num_rows)	redirect_to('/elections/manifesto_form',true);

$result = mysql_query("SELECT pi.id, pi.post_id, p.post_name, p.top_level_post_name, no.user_id,u.username,u.hostel
        FROM `stu_portal`.`nominations` AS no
        JOIN `stu_portal`.`users` AS u
          ON (u.id = no.user_id )
        JOIN `stu_portal`.`post_instances` AS pi 
          ON (no.post_instance_id = pi.id)
        JOIN `stu_portal`.`posts` AS p 
          ON (p.id = pi.post_id) 
        WHERE pi.open = 1 and no.user_id = $current_user->id
        ORDER BY pi.id ASC ") or trigger_error(mysql_error() );

$row = mysql_fetch_object($result);


if ($row->top_level_post_name == 'Secretary' or $row->top_level_post_name == 'Councillor' or $row->top_level_post_name == 'Branch Councillor')
	$row->category = 'General Body Elections';
elseif ($row->top_level_post_name == 'Hostel Secretary') $row->category = 'Hostel Body Elections';

print_r($row);
		
?>




