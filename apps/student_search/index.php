<script>
  function StudentSearchCtrl($scope){
    $scope.studentsearch="<?= $_GET['q']?>";
  }
</script>
<br><br>
<div ng-controller="StudentSearchCtrl">
<form ng-submit="app.reqLite('/student_search/?search='+studentsearch)">
 <div class="row">
    <div class="large-8 large-centered columns">
      <div class="row collapse">
        <div class="small-10 columns">
        <input type="text" ng-model="studentsearch"  placeholder="Search Students" >
        </div>
        <div class="small-2 columns">
          <input type="submit" value="Go" class="button postfix">
        </div>
      </div>
    </div>
  </div>
</form>
</div>



<?php

page_title('Student Search');

if( !$current_user->login() ) redirect_to('/user/login', true);

$data->search = isset($_GET['search']) ? $_GET['search'] : 'Avinash';
$limit_f = isset( $_GET['f']) ? $_GET['f'] : 0;


$query = "SELECT DISTINCT username,fullname,room,hostel,email,profile_picture FROM `stu_portal`.`users` where username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%' LIMIT ".$limit_f.", 10";
$result = mysql_query($query) or http_response_code(500);


$count = mysql_query("SELECT COUNT(id) FROM stu_portal.users where username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%'");
$count_result = mysql_fetch_array($count);

if( !mysql_num_rows($result) ) 
  echo "<br><br><i class='fa fa-search'></i> | No Results Found <i class='fa fa-frown-o'></i>";
else{
    $limit_t = ($count_result[0]-$limit_f > 9) ? $limit_f+10 : $count_result[0];
    $show_next = ($count_result[0]-$limit_t ) ? 1 : 0; 
    $new_limit_f = $limit_f - 10;
    echo "<br>
        <h4 class='text right'>
          <small> Showing ".$limit_f." - ".$limit_t." of ".$count_result[0];
    if( $limit_f > 0 ) 
        echo" <a href='#/student_search?search=".$_GET['search']."&f=$new_limit_f'> | Previous</a> ";
    else 
        echo" | Previous";
    if( $show_next ) 
        echo" <a href='#/student_search?search=".$_GET['search']."&f=$limit_t'> | Next</a> ";
    else 
      echo" | Next";
    //	Displaying the Next Page Tab ends;    
    echo " </small> 
        </h4><br>";
    while($row = mysql_fetch_object($result) ){
		$name_parts=explode(" ", $row->fullname);
			for($i=0;$i<sizeof($name_parts);$i++)
				$name_parts[$i]= ucfirst(strtolower($name_parts[$i]));
			$fullname = implode(" ", $name_parts);
		if(empty($row->profile_picture) or !file_exists(FILE_DIR_ROOT.'/'.$row->profile_picture)) $image_file= IMG_ROOT."/default/user-default-blue.png";
		else $image_file = FILE_ROOT.'/'.$row->profile_picture;
		
		echo " <div class='small-12 columns '>
					<div class='small-2 columns'>
						<a style='float:right' class='th'><img style='max-height:100px;' src='" . $image_file . "'></a>					
					</div>";    	
    	
       echo "<div class='small-10 columns'><blockquote>
            <h4>". strtoupper($row->username)."  |  $fullname</h4>
            <p><i class='fa fa-map-marker' style='margin-left:4px; margin-right:3px;'></i> | $row->room,  $row->hostel 
            <br><i class='fa fa-envelope'></i> | $row->email </p>
        </blockquote></div>";
        
      echo "</div>";
    }
	//	Displaying the Next Page Tab again at the end of results;	
	echo "
        <h4 class='text right'>
          <small> Showing ".$limit_f." - ".$limit_t." of ".$count_result[0];
    if( $limit_f > 0 ) 
        echo" <a href='#/student_search?search=".$_GET['search']."&f=$new_limit_f'> | Previous</a> ";
    else 
        echo" | Previous";
    if( $show_next ) 
        echo" <a href='#/student_search?search=".$_GET['search']."&f=$limit_t'> | Next</a> ";
    else 
      echo" | Next";
    
    echo " </small> 
        </h4>";
}

?>
