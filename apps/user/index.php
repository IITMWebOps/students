<?php
  if( !$current_user->login() ) redirect_to('/user/login',true);
  page_title($current_user->nick);
?>

<div class="rows">
<br>
	<div class="small-6 columns">
		<br>
    <h5><a href="<?= APP_HOST ?>/<?= strtoupper($current_user->username) ?>"><?= $current_user->fullname ?> | <?= $current_user->username?></h5>
    <h5>#<?= $current_user->room ?>, <?= $current_user->hostel ?> </h5>
    <h5>Blood Group : <?= $current_user->bgroup ?> </h5>
    <h5>Ph : +91 <?= $current_user->contact ?></h5>
    <h5>EMail ID : <?= $current_user->email ?></h5>				
	</div>
	<div class="small-6 columns">
			<a class="th radius" >
  					<img id="profile-pic" src="<?=IMG_ROOT?>/alert_images/yash.jpg">
			</a>
	</div>
</div>
