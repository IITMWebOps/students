<script>
  function PageSearchCtrl($scope){
    $scope.pagesearch="<?=$_GET['q']?>";
  }
</script>
<br><br>
<div ng-controller="PageSearchCtrl">
<form ng-submit="app.reqLite('/messages/?q='+pagesearch)">
 <div class="row">
    <div class="large-8 large-centered columns">
      <div class="row collapse">
        <div class="small-10 columns">
        <input type="text" ng-model="pagesearch"  placeholder="Search Messages" >
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

  function GetPostName($id){
    $result = mysql_query("SELECT * FROM `stu_portal`.`posts` WHERE `id` = '$id'") or trigger_error(mysql_error() );
    $row = mysql_fetch_object($result);
    return $row->post_name." ".$row->top_level_post_name;
  }


$range = 10;
$limit_f = isset($_GET['f']) ? $_GET['f'] : '0';

$limit_query = "LIMIT ".$limit_f." , ".$range;
$search = isset($_GET['q']) ? "AND (`link` LIKE '%".$_GET['q']."%' OR `name` LIKE '%".$_GET['q']."%')" : "";

$query="SELECT * FROM `stu_portal`.`pages` WHERE `trash` = '0' ".$search."  ORDER BY `updated_at` DESC ".$limit_query;
$result = mysql_query($query) or trigger_error(mysql_error() );


$count = mysql_query("SELECT COUNT(link) FROM stu_portal.pages where `trash`='0' ".$search." ORDER BY `updated_at` ");
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
        echo" <a href='#/messages/?q=".$_GET['q']."&f=$new_limit_f'> | Previous</a> ";
    else 
        echo" | Previous";
    if( $show_next ) 
        echo" <a href='#/messages/?q=".$_GET['q']."&f=$limit_t'> | Next</a> ";
    else 
      echo" | Next";
    
    echo " </small> 
        </h4><br>";

    while($row = mysql_fetch_object($result) ){
        echo "<blockquote>
         <h4><a href='#/messages/".$row->link."'>". $row->name."</a>  </h4>";
        if( $current_user->login() )
          if( $current_user->has_active_post('Secretary') == $row->post_id or $current_user->por[0]['post_id'] == $row->post_id )
            echo"<a href='#/messages/edit?q=".$row->id."' class='button tiny right'> Edit</a>
                 <a ng-click=\"app.reqLite('/messages/trash?q=".$row->id."')\" class='button tiny right'> Trash it </a>";

            echo "<i class='fa fa-user'></i> | ".GetPostName($row->post_id)."<p class='text right'><i class='fa fa-clock-o'></i> | $row->updated_at </p>
        </blockquote>";
    }
}

?>
