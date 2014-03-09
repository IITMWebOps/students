<?php
  page_title('Elections 2014');

  $result = mysql_query("SELECT pi.id, pi.post_id, p.post_name, p.top_level_post_name, no.user_id,u.username,u.hostel,u.fullname
        FROM `stu_portal`.`nominations` AS no
        JOIN `stu_portal`.`users` AS u
          ON (u.id = no.user_id )
        JOIN `stu_portal`.`post_instances` AS pi 
          ON (no.post_instance_id = pi.id)
        JOIN `stu_portal`.`posts` AS p 
          ON (p.id = pi.post_id) 
        WHERE pi.open = 1 
        ORDER BY pi.id ASC ");

  $result2 = mysql_query("SELECT pi.id, pi.post_id, p.post_name, p.top_level_post_name 
        FROM `stu_portal`.`post_instances` AS pi 
        JOIN `stu_portal`.`posts` AS p 
          ON (p.id = pi.post_id) 
        WHERE pi.open = 1 
        ORDER BY pi.id ASC ");

  while($row = mysql_fetch_object($result)){
//    echo $row->id.$row->post_id.$row->post_name.$row->top_level_post_name.$row->user_id.$row->username.$row->hostel."<br>";
    if ($row->top_level_post_name == 'Secretary' or $row->top_level_post_name == 'Branch Councillor' or $row->top_level_post_name == 'Councillor' ){
      $catg = 'GBE';
      $pos = str_replace(" ", "_", $row->post_name." ".$row->top_level_post_name);
    }
    else{
      $catg = 'HBE';
      $pos = str_replace(" ", "_",strtolower($row->hostel)."_".$row->post_name.str_replace('Hostel','',$row->top_level_post_name));    
    }
    $roll_res .=  "{ 'link' : '#/elections/view?category=".$catg."&post=$pos&username=".strtolower($row->username)."' , 'name' : '".$row->username."','fullname':'".$row->fullname."', 'post': '".$row->post_name."', 'top_level':'".$row->top_level_post_name."' },";
   echo $roll_res."<br>"; 
  }


?>


<br><br>
<div ng-controller="PageSearchCtrl">
<form ng-submit="app.reqLite('/messages/?q='+pagesearch)">
 <div class="row">
    <div class="large-8 large-centered columns">
      <div class="row collapse">
        <div class="small-10 columns">
        <input type="text" ng-model="pagesearch"  placeholder="Search Posts" >
        </div>
        <div class="small-2 columns">
          <input type="submit" value="Go" class="button postfix">
        </div>
      </div>
    </div>
  </div>
</form>
</div>
<br><br><br>
<div class="rows">
	<div class="small-6 columns">
		<a href="#/elections/view?category=GBE" class="button expand large secondary">General Body Manifestos</a>
	</div>
	<div class="small-6 columns">
		<a href="#/elections/view?category=HBE" class="button expand large  secondary">Hostel Body Manifestos</a>
	</div>
</div>

<div class="small-12 columns">
<br><br>
	<div class="small-12 medium-8 medium-centered columns">
		<a class="button expand large" href="<?=APP_URL?>/#/elections/manifesto_form">Click here to Upload Manifesto</a>
	</div>
</div>
