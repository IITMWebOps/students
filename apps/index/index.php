<!DOCTYPE html>
<!--[if IE 9]><html ng-app="spApp" ng-controller = "AppCtrl as app" class="lt-ie10" lang="en" > <![endif]-->

<html id='students_portal_app' ng-app="spApp" ng-controller = "AppCtrl as app"  class="no-js" lang="en" >
<?php
	require_once"header.php";
?>

<!-- ### Main Body Div - Begin -->
<div class="row">
    
<!-- ### Left Column Div - Begin -->

	<?php require_once"left-sidebar.php"; ?>

<!-- ### Left Column Div - End -->
        
<!-- ### Right Column Div - Begin -->

	<div class="large-9 medium-8 small-12 columns" style="">
<br><br>
<div class="row">
  <div class="small-7 columns">
     <h2> {{app.title() | capitalize}}</h2>
  </div>
  <div class="small-5 columns">
    <alert-status></alert-status>
  </div>
</div>
<progressbar> 
<hr>
</progressbar>
  <div id='view' compile = "app.data" >

	</div>   
    	
	</div>

<!-- ### Right Column Div - End -->

</div>
<!-- ### Main Body Div - End -->
<!-- ### Left Column Div - Begin -->

	<?php require_once"footer.php"; ?>

<!-- ### Left Column Div - End -->



<!--
<ng-progress> </ng-progress>
-->
<script src="<?=JS_ROOT?>/vendor/jquery.js"></script>
<script src="<?=JS_ROOT?>/foundation.min.js"></script>
<script src="<?=JS_ROOT?>/angular.min.js"></script>
<script src="<?=APPJS_ROOT?>/config.application.js"></script>
<script src="<?=APPJS_ROOT?>/application.js"></script>
<script src="<?=APPJS_ROOT?>/ngProgress.js"></script>
<script>
	$(document).foundation();
</script>

</html>
