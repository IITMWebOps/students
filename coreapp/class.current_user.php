<?php

/**
 * $current_user->login() // return true if login
 * $current_user->username  // --- users table --- Roll number
 * $current_user->fullname  // --- users table --- full name
 * $current_user->room  // --- users table --- room
 * $current_user->hostel  // --- users table --- hostel
 * $current_user->bgroup  // --- users table --- bgroup
 * $current_user->contact  // --- users table --- contact
 * $current_user->email  // --- users table --- email
 * $current_user->nick  // --- users table --- nick
 * $current_user->gender  // --- users table --- gender
 * $current_user->updated_timestamp  // --- users table --- updated_timestamp
 * $current_user->por => array(2) { 
 *    [0] 
 *       por_id // --- postiton_of_responsibility table --- id
 *       post_id // --- posotion_of_responsibility table --- post_id || --- posts table --- id
 *       top_level_post_name // --- posts table  --- top_level_post_name eg: core
 *       post_name // --- posts table --- post_name eg: Institute webops core
 *       year_from 
 *       year_to   
 *       lead_post_id // --- posts table --- lead_pst_id eg: "|2|3|"
 *       active
 *    [1]
 *        .
 *        .
 *        .
 *        .
 *        .
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
      trigger_error(__FUNCTION__ . "(): Tried to access invalid member $name");
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

    if( $this->_userdata['id'] ){
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

  public function has_active_post($top_level_post_name){
    foreach ( $this->_userdata['por'] as $key => $value ){
      if ( isset($value['top_level_post_name']) )
        if( $value['top_level_post_name'] == $top_level_post_name and $value['active'] == 1 )
          return $value['post_id'];
    }
    return false;
  }

  public function has_active_por($post_name){
    foreach ( $this->_userdata['por'] as $key => $value ){
      if ( isset($value['post_name']) )
        if( $value['post_name'] == $post_name and $value['active'] == 1 )
          return $value['por_id'];
    }
    return false;
  }

  public function logout(){
    $this->_userdata['id'] = 0;
  }

  protected function SetSessionFromCookie($uid) {
    return true;
  }

  protected function define($id ) {
    if ( !$this->_userdata['username']  ){
      $this->_userdata = User::get_user($id);      

    }
  }

}
?>
