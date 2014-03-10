<?php
  if ( !$current_user->login() ) redirect_to('/user/login',true);
  page_title('Edit Profile');
?>


<script>
  function Profile_SubmitCtrl($scope){
	  $scope.profile = { 'username' : '<?= $current_user->username?>',
                           'fullname' : '<?= $current_user->fullname?>',
                           'nick' : '<?= $current_user->nick?>',
                           'bgroup' : '<?= $current_user->bgroup?>',
                           'contact' : '<?= $current_user->contact?>',
                           'email' : '<?= $current_user->email?>',
                           'room' : '<?= $current_user->room?>',
                           'hostel' : '<?= $current_user->hostel?>' };
<?php
$all_hostels = '[';
$h_res = mysql_query("SELECT DISTINCT `users`.`hostel` FROM `stu_portal`.`users` ORDER BY `users`.`hostel` ASC");
while( $row = mysql_fetch_object($h_res) ){
    $all_hostels.= "{ 'name' : '".$row->hostel."' },";
}
$all_hostels = substr($all_hostels, 0, -1).' ]';

?>

  $scope.AllHostels = <?= $all_hostels ?>;

              }
          </script>
          <div ng-controller = "Profile_SubmitCtrl">


<form ng-submit = "app.request({
                          location: '/user/profile_submit',
                          method: 'POST', 
                          object: profile })"   >
<br><br>
<div class="small-12 columns">
	<div class="rows">
	<div class="small-12 medium-8 columns">
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Nickname</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" ng-model='profile.nick' >
    		</div>
  		</div>	
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Blood Group</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" ng-model='profile.bgroup'>
    		</div>
  		</div>	
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Phone No.</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input maxlength="10" type="text" class="" ng-model='profile.contact'>
    		</div>
  		</div>
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Email ID</span>
    		</div>
   		<div class="small-9 large-10 columns">
     			 <input type="text" class="" ng-model='profile.email' >
    		</div>
  		</div>	  		
  		<div class="rows">
  			<div class="small-6 columns">
  				<div class="row collapse">
    				<div class="small-3 columns">
      				<span class="prefix">Room</span>
    				</div>
   				<div class="small-9 columns">
     			 		<input maxlength="4" type="text" class="" ng-model='profile.room' >
    				</div>
  				</div>	
  			</div>
  			<div class="small-6 columns">
  				<div class="row collapse">
    				<div class="small-3 columns">
      				<span class="prefix">Hostel</span>
    				</div>
   				<div class="small-9 columns">
     			 		<select class="" ng-model='profile.hostel' ng-options = 'h.name as h.name for h in AllHostels'></select>
    				</div>
  				</div>	
  			</div>	
  		</div>	
	</div>
	<div class="small-12 medium-4 columns">
			<a class="th radius" >
  				<img id="profile-pic" src="<?=IMG_ROOT?>/default/user-default-blue.png">
			</a>
	</div>
	</div> 
</div>
<div>
	<hr>
	 <input type="submit"  class="button " value="Save Changes" >
</div>
</form>

</div>
