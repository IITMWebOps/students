<?php
  
if( !$current_user->login() ) redirect_to('/user/login', true);

if( !$current_user->has_active_post('Secretary') and !$current_user->has_active_por('Institute WebOps Core') ){
  render_alert("Permission Denied");
  include(PUBLIC_ROOT . DS . '403.html');
  exit();
}

$data = json_decode(file_get_contents("php://input"));


if( empty($data->link) ){
  page_title("New Page");
?>
  <br><br><br>
  <form ng-submit="app.request({ location: '/messages/new', object: pages})">
          <div class="row">
            <div class="small-8">
              <div class="row">
                <div class="small-6 columns">
                  <label for="right-label" class="right inline">Message Link : </label>
                </div>
                <div class="small-6 columns">
                  <input type="text" ng-model = "pages.link" id="right-label" placeholder="Inline Text Input">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="small-8">
              <div class="row">
                <div class="small-6 columns">
                  <label for="right-label" class="right inline">Message Name : </label>
                </div>
                <div class="small-6 columns">
                  <input type="text" ng-model="pages.name" id="right-label" placeholder="Inline Text Input">
                </div>
              </div>
            </div>
          </div>
          <div class= ""> 
              <input type="submit"  class="button " value="Create" >
          </div>
  </form>
<?php
}
else{
  if(empty($data->name )){
    render_alert("Name Cant be empty");
    exit();
  }
  $count = mysql_query("SELECT COUNT(link) FROM stu_portal.pages_temp WHERE link LIKE '".$data->link."'");
  $count_result = mysql_fetch_array($count);
  if ( $count_result[0]["COUNT(link)"] > 0 ){
    render_alert("Link already exists");
    exit();
  }

  $query = "INSERT INTO stu_portal.pages_temp ( link, name, content, post_id, created_position_of_responsibility_id, updated_position_of_responsibility_id,staged_changes, created_at ) VALUES ( '$data->link','$data->name','This is content of $data->name page','".$current_user->por[0]['post_id']."', '".$current_user->por[0]['por_id']."','".$current_user->por[0]['por_id']."','1','".date("Y-m-d H:i:s")."' )";
  $result = mysql_query($query) or trigger_error( mysql_error() );
  if($result)
    redirect_to('/messages/edit?q='.mysql_insert_id() , true ); 
  else
    http_response_code(500); 
}

?>
