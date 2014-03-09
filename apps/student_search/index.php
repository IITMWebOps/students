<script>
  function StudentSearchCtrl($scope){
    $scope.studentsearch="<?=$_GET['q']?>";
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

$data->search = $_GET['search'];
$limit_f = isset( $_GET['f']) ? $_GET['f'] : 0;


$query = "SELECT DISTINCT username,fullname,room,hostel FROM `stu_portal`.`users` where username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%' LIMIT ".$limit_f.", 10";
$result = mysql_query($query) or http_response_code(500);


$count = mysql_query("SELECT COUNT(id) FROM stu_portal.users where username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%'");
$count_result = mysql_fetch_array($count);

if( !mysql_num_rows($result) ) 
  echo "<br><br>Search Results Not found";
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
		
		echo " <div class='small-12 columns '>
					<div class='small-2 columns'>
						<a style='float:right' class='th'><img style='max-height:70px;' src='" . IMG_ROOT . "/default/user-default-blue.png'></a>					
					</div>";    	
    	
       echo "<div class='small-10 columns'><blockquote>
            <h4>". strtoupper($row->username)."  |  $row->fullname</h4>
            <p># $row->room  $row->hostel</p>
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
