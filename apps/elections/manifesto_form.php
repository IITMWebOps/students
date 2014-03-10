<?php
if (!$current_user->login()) redirect_to('/user/login',true);
$query = "SELECT * FROM `stu_portal`.`nominations` WHERE user_id=$current_user->id";
$result = mysql_query($query) or trigger_error(mysql_error());
$num_rows = mysql_num_rows($result);
if ($num_rows)	redirect_to('/elections/manifesto_edit',true);?>

<script>
  function eapply_SubmitCtrl($scope, GetResponse){
    $scope.ecat = [ { 'category': 'gbe', 'name': 'General Body Elections'}, 
                    { 'category': 'hbe', 'name': 'Hostel Body Elections'}];
    $scope.apply = {'category': 'gbe'};

    $scope.makereq = function(){

    var imgEl = angular.element( document.querySelector( '#electionImgId') );
    var maniEl = angular.element( document.querySelector( '#electionManiId') );
    var writeEl = angular.element( document.querySelector( '#electionWriteId') );
    this.apply.image =  imgEl.val() ;
    this.apply.manifesto =  maniEl.val() ;
    this.apply.writeup =  writeEl.val() ;
          GetResponse.request({ location: '/elections/submit', cache: false, method: 'POST', object: this.apply });
    }
    <?php
    $result = mysql_query("SELECT pi.id, pi.post_id, p.post_name, p.top_level_post_name
      FROM `stu_portal`.`post_instances` AS pi LEFT JOIN `stu_portal`.`posts` AS p ON (pi.post_id = p.id)
      WHERE pi.open = 1") or trigger_error(mysql_error());
    $gbe_p = "";
    $hbe_p = "";
    while($row = mysql_fetch_object($result) ){
      if ($row->top_level_post_name == 'Secretary' or $row->top_level_post_name == 'Branch Councillor' or $row->top_level_post_name == 'Councillor' )
        $gbe_p.= "<option value='".$row->id."'>".$row->post_name." ".$row->top_level_post_name."</option>";
      else
        $hbe_p.="<option value='".$row->id."'>".$row->post_name." ".str_replace('Hostel ','',$row->top_level_post_name)."</option>";
    }
?>


  }
 </script>
<div ng-controller = "eapply_SubmitCtrl">
<form ">
<br><br> 
<div>
<? echo $current_user->id."dfdsf"; ?>
<div class="small-12 large-8 large-centered columns">
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Category</span>
    		</div>
   		<div class="small-9 large-10 columns">       
       		<select ng-model="apply.category" ng-options="a.category as a.name for a in ecat" >       
        		</select>
         </div>
  		</div>
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix">Post</span>
    		</div>
      <div class="small-9 large-10 columns " ng-switch on="apply.category">  
            <select ng-model="apply.post_instance_id"  ng-switch-when="gbe" ><?=$gbe_p?></select>
            <select ng-model="apply.post_instance_id"  ng-switch-when="hbe" ><?=$hbe_p?></select>
         </div>
  		</div>	
		 	
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix" style="height:3.2rem;">Image</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
            <?php upload_file(array('image/jpeg','image/jpg', 'image/png'), 5242880, 'electionImgId'); ?>
         </div>
  		</div>
  		<div class="row collapse">
    		<div class="small-3 large-2 columns">
          <span class="prefix" style="height:3.2rem;" >Manifesto</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
            <?php upload_file(array('application/pdf'), 5242880, 'electionManiId'); ?>
         </div>
  		</div>
		<div class="row collapse">
    		<div class="small-3 large-2 columns">
      		<span class="prefix"  style="height:3.2rem;"  >Write Up</span>
    		</div>
   		<div class="small-9 large-10 columns " >       
            <?php upload_file(array('application/pdf'), 5242880, 'electionWriteId'); ?>
         </div>
  		</div>	
</div>
<hr>
<div class="small-12 columns">
	<div class="small-6 medium-4 columns">
		<input type="submit" ng-click="makereq()"  class="button expand" value="Save Changes" >
	</div>
	<div class="small-6 medium-4 columns">
		<a href="#/elections/" class="button expand secondary">Cancel</a>
	</div>
</div>
</div>
</form>
</div>
