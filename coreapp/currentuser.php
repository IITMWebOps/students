<?php

/**
 * 
 **/
class CurrentUser{

  private $_userdata = array(
    'id' => '0',
    'username' => '0'
  );

  public function __construct(){
    if ( $this->login() ) 
      $this->define($this->_userdata['id']);
    return true;
  }

  public function __get($name) {
    if (isset($this->_userdata[$name])) {
      return $this->_userdata[$name];
    } else {
      error_log("Tried to access invalid member $name");
    }
  }

  public function __set($name, $value) {
    if ($name === 'id') {
      throw new Exception("not allowed to change : $name");
    } else {
      $this->_userdata[$name] = $value;
    }
  }

  public function login(){

    if ($this->_userdata['id']){
       return true;
    } else {
      
        if( isset($_SESSION['id']) || isset($_COOKIE['uid'] ) ){

            if(!isset($_SESSION['id']) and isset($_COOKIE['uid']) ){

                if( $this->SetSessionFromCookie($_COOKIE['uid']) ){
                    $this->_userdata['id'] = $_SESSION['id'];
                    return true;
                }

            } else {
                $this->_userdata['id'] = $_SESSION['id'];
                return true;
            }
        } else
          return false;
  
    }
  }

public function logout(){
  $this->_userdata['id'] = 0;
}

  protected function SetSessionFromCookie($uid) {
    return true;
  }

  protected function define($id ) {
    if ( !$this->_userdata['username']  ){
      
      $query = "SELECT u.username AS username, u.fullname AS fullname, u.room AS room, u.hostel AS hostel,u.bgroup AS bgroup, u.contact AS contact, u.email AS email, u.nick AS nick, u.gender AS gender, u.updated_timestamp AS updated_timestamp FROM stu_portal.users AS u WHERE u.id = '$id'";
      $result = mysql_query($query) or error_log(mysql_error());
      if( mysql_num_rows($result) == 1 ){
        $row = mysql_fetch_array($result);
        foreach($row as $key => $value){
          $this->_userdata[$key] = $value;
        }
      } else {
        http_response_code(500);
      }

    }
  }

}
?>
