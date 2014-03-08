<?php
  
if( !$current_user->login() ) redirect_to('/user/login', true);

$result = mysql_query( "SELECT * FROM stu_portal.pages_temp WHERE id = ".$_GET['q']." LIMIT 1" ) or trigger_error( mysql_error() );
if ( !$result )
  http_response_code(500);

$row = mysql_fetch_object($result);

if( $current_user->has_active_post('Secretary') != $row->post_id and $current_user->por[0]['post_id'] != $row->post_id ){
  render_alert("Permission Denied");
  include(PUBLIC_ROOT . DS . '403.html');
  exit();
}

page_title($row->name);

$script = "<script src='".JS_ROOT."/ckeditor/ckeditor.js'></script>
  <script>
      var data;
      var flag = 0;
      $('#".$row->id."canedit').bind('DOMSubtreeModified', function() {
        flag = 1;
        $('#".$row->id."savebutton').text('Save');
      });
      setInterval(function(){
        if (flag == 1){
            savepageData();
            flag = 0;
            $('#".$row->id."savebutton').text('Saved');
        }
      },10000);
      $('#".$row->id."savebutton').click( function(){
        savepageData();
        flag = 0;
        $('#".$row->id."savebutton').text('Saved');
      });
      function savepageData(){
        data = CKEDITOR.instances.editable".$row->id.".getData();
        $.post( '/".APP_SUBPATH."/messages/savepage', { htmldata: data, id: '".$row->id."' })
            .done(function() {
              return true;
        });
      } 
  </script>
  ";

echo $script."<br><br>
  <div id = '".$row->id."canedit'>
    <div id='editable".$row->id."' contenteditable='true'>
      $row->content
    </div>
  </div>
  <a id = '".$row->id."savebutton' class='button small'>Save</a>
  <a id = 'publish".$row->id."' ng-click=\"app.request({ location: '/messages/publish?q=".$row->id."'})\" class='button small'>Publish and Exit</a>
  <a href='#/messages/new' class='button small right'>Create Page</a>&nbsp;
  <a href='#/messages/mypages' class='button small right'>My Pages</a>";
?>
