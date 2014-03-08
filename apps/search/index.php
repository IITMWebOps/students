<?php

page_title('Search');

if( !$current_user->login() ) redirect_to('/user/login', true);

$data->search = $_GET['q'];
$limit_f = isset( $_GET['f']) ? $_GET['f'] : 0;

if($limit_f){
	$limit_f1=$limit_f;
	$limit_f2=$limit_f;
	$limit_f3=$limit_f;}
else{
	$limit_f1 = $limit_f;
	$limit_f2 = $limit_f - $count_pages_result[0];
	$limit_f3 = $limit_f - $count_pages_result[0] - $count_applications_result[0];
}

$limit1 = 10;

$query_pages = "SELECT DISTINCT name,link,content,trash 
		  FROM `stu_portal`.`pages` 
		  WHERE (name like '%$data->search%' or link like '%$data->search%') and (trash !=1)
		  LIMIT ".$limit_f1.", ".$limit1;
$result_pages = mysql_query($query_pages);
$count_pages = mysql_query("SELECT COUNT(id) 
					  FROM stu_portal.pages 
					  WHERE (name like '%$data->search%' or link like '%$data->search%') and (trash !=1)
					  ");
$count_pages_result = mysql_fetch_array($count_pages);
echo "<script>alert(".$count_pages_result[0].");</script>";

$limit2 = $limit1 - $count_pages_result[0];
$query_applications = "SELECT DISTINCT name,link 
		  FROM `stu_portal`.`applications` 
		  WHERE name like '%$data->search%'
		  LIMIT ".$limit_f2.", ". $limit2;
$result_applications = mysql_query($query_applications);
$count_applications = mysql_query("SELECT COUNT(id) 
					  FROM stu_portal.applications 
					  WHERE name like '%$data->search%'
					  ");
$count_applications_result = mysql_fetch_array($count_applications);


$limit3 = $limit1 - $count_pages_result[0] - $count_applications_result[0];
$query_students = "SELECT DISTINCT username,fullname,room,hostel,contact 
		  FROM `stu_portal`.`users` 
		  WHERE username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%'
		  LIMIT ".$limit_f3.", ".$limit3;
$result_students = mysql_query($query_students);
$count_students = mysql_query("SELECT COUNT(id) 
					  FROM stu_portal.users 
					  WHERE username like '%$data->search%' or fullname like '%$data->search%' or email like '%$data->search%' or contact like '%$data->search%' 
					  ");
$count_students_result = mysql_fetch_array($count_students);



$count_result = $count_students_result[0]+$count_applications_result[0]+$count_pages_result[0];
if( !mysql_num_rows($result_students) and !mysql_num_rows($result_applications) and !mysql_num_rows($result_pages)) 
  echo "<br><br>Search Results Not found";
else{
    $limit_t = ($count_result-$limit_f > 9) ? $limit_f+10 : $count_result;
    $show_next = ($count_result-$limit_t ) ? 1 : 0; 
    $new_limit_f = $limit_f - 10;
    echo "<br>
        <h4 class='text right'>
          <small> Showing ".$limit_f." - ".$limit_t." of ".$count_result;
    if( $limit_f > 0 ) 
        echo" <a href='#/search?q=".$_GET['q']."&f=$new_limit_f'> | Previous</a> ";
    else 
        echo" | Previous";
    if( $show_next ) 
        echo" <a href='#/search?q=".$_GET['q']."&f=$limit_t'> | Next</a> ";
    else 
      echo" | Next";
    //	Displaying the Next Page Tab ends;    
    echo " </small> 
        </h4><br>";
    while($row = mysql_fetch_object($result_pages) ){
       echo "<blockquote>
            <h4><a href='#/messages/$row->link'>". strtoupper($row->name)."</a></h4>
            <p># $row->link</p>
        </blockquote>";
    }
	while($row = mysql_fetch_object($result_applications) ){
       echo "<blockquote>
            <h4><a href='$row->link' target='_blank'>". strtoupper($row->name)."</a></h4>
            <p># $row->link</p>
        </blockquote>";
    }
	while($row = mysql_fetch_object($result_students) ){
       echo "<blockquote>
            <h4>". strtoupper($row->roll)."  |  $row->fullname</h4>
            <p># $row->room  $row->hostel | $row->contact</p>
        </blockquote>";
    }
	//	Displaying the Next Page Tab again at the end of results;	
	echo "
        <h4 class='text right'>
          <small> Showing ".$limit_f." - ".$limit_t." of ".$count_result[0];
    if( $limit_f > 0 ) 
        echo" <a href='#/search?q=".$_GET['q']."&f=$new_limit_f'> | Previous</a> ";
    else 
        echo" | Previous";
    if( $show_next ) 
        echo" <a href='#/search?q=".$_GET['q']."&f=$limit_t'> | Next</a> ";
    else 
      echo" | Next";
    
    echo " </small> 
        </h4>";
}

?>
