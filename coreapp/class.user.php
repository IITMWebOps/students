<?php
  


class User{
 
  public function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
      $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
      $ret[$ii]=$array[$ii];
    }
    $array=$ret;
  }

  public function get_user($id = NULL){
    if ( $id !== NULL   ){
      
        $query = "SELECT u.id AS id,
                        u.username AS username, 
                        u.fullname AS fullname, 
                        u.room AS room, 
                        u.hostel AS hostel,
                        u.bgroup AS bgroup, 
                        u.contact AS contact, 
                        u.email AS email, 
                        u.nick AS nick, 
                        u.gender AS gender, 
                        u.updated_timestamp AS updated_timestamp, 
                        por.id AS por_id,
                        por.active AS por_active,
                        ai.year_from AS year_from, 
                        ai.year_to AS year_to, 
                        ai.active AS ai_active,
                        p.id  AS post_id,
                        p.post_name AS post_name,
                        p.top_level_post_name AS top_level_post_name,
                        p.lead_post_id AS lead_post_id
                FROM stu_portal.users AS u
                LEFT JOIN stu_portal.position_of_responsibilities AS por
                  ON u.id = por.user_id
                LEFT JOIN stu_portal.posts AS p
                  ON por.post_id = p.id
                LEFT JOIN stu_portal.application_instances AS ai
                  ON por.application_instance_id = ai.id
                  WHERE u.id = '$id' OR u.username = '$id'";
        $result = mysql_query($query) or error_log(mysql_error());
        if( mysql_num_rows($result) > 0 ){
          $rows = mysql_fetch_all ($result, MYSQLI_ASSOC);

          $userdata['username'] = $rows[0]['username'];
          $userdata['fullname'] = $rows[0]['fullname'];
          $userdata['room'] = $rows[0]['room'];
          $userdata['hostel'] = $rows[0]['hostel'];
          $userdata['bgroup'] = $rows[0]['bgroup'];
          $userdata['contact'] = $rows[0]['contact'];
          $userdata['email'] = $rows[0]['email'];
          $userdata['nick'] = $rows[0]['nick'];
          $userdata['gender'] = $rows[0]['gender'];
          $userdata['updated_timestamp'] = $rows[0]['updated_timestamp'];

          foreach($rows as $key => $value){
            if ( array_key_exists('top_level_post_name', $value) ) {
              $por_active = ($value['por_active'] == 2) ? $value['ai_active'] : $value['por_active'];
              $por = array( 'por_id' => $value['por_id'],
                          'post_id' => $value['post_id'],
                          'top_level_post_name' => $value['top_level_post_name'],
                          'post_name' => $value['post_name']." ".$value['top_level_post_name'],
                          'year_from' => $value['year_from'],
                          'year_to' => $value['year_to'],
                          'lead_post_id' => $value['lead_post_id'],
                          'active' => $por_active );
              $userdata['por'][] =  $por;
            }
          }

          User::aasort($userdata['por'],"active"); 
          return $userdata;
      
      } else {
        http_response_code(500);
      }

    } else {
      return;
    }

 
  }

}

?>
