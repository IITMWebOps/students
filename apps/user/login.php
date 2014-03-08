<?php

page_title('Login');


if ( $current_user->login() ){
  echo "<center><br><br><br> 
          Logged in as $current_user->fullname ( $current_user->username ) <br><br><br><br>
          <a href='#/user/logout' class='button'>Sign Out</a>
          </center>";
} else{
  echo '<br><br> 
    <form ng-submit = "app.request({
                          location: \'/user/submit\',
                          method: \'POST\', 
                          object: login,
                          title: \'login\',
                          alert: true,
                          alertAdv: { 0: {code: \'403\',text: \'Invalid Username or Password<br><p>Please use your LDAP Login credentials to login with students portal</p>\', cls: \'warning \'},
                                      1: {code: \'200\',text: \'Successfully Logged In\', cls:\'success\'}} })">
          <div class="row">
            <div class="small-8">
              <div class="row">
                <div class="small-6 columns">
                  <label for="right-label" class="right inline">Roll Number : </label>
                </div>
                <div class="small-6 columns">
                  <input type="text" ng-model = "login.username" id="right-label" placeholder="Inline Text Input">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="small-8">
              <div class="row">
                <div class="small-6 columns">
                  <label for="right-label" class="right inline">Password : </label>
                </div>
                <div class="small-6 columns">
                  <input type="password" ng-model="login.password" id="right-label" placeholder="Inline Text Input">
                </div>
              </div>
            </div>
          </div>
          <div class= ""> 
              <input type="submit"  class="button " value="Sign In" >
          </div>
       </form >
        ';
}
//redirect_to('messages');

?>
