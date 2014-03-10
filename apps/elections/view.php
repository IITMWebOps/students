<script>
    function hostel_SubmitCtrl($scope) {
        $scope.eview = {'hostel': '<?= ucfirst(strtolower($current_user->hostel)) ?>'};


<?php
if (!$current_user->login()) redirect_to('/user/login',true);
$all_hostels = '[';
$uc_all_hostels = '[';
$h_res = mysql_query("SELECT DISTINCT `users`.`hostel` FROM `stu_portal`.`users` ORDER BY `users`.`hostel` ASC");
while ($row = mysql_fetch_object($h_res)) {
    $all_hostels.= "{ 'name' : '" . $row->hostel . "' },";
    $uc_all_hostels.= "{ 'name' : '" . ucfirst(strtolower($row->hostel)) . "' },";
}
$all_hostels = substr($all_hostels, 0, -1) . ' ]';
$uc_all_hostels = substr($uc_all_hostels, 0, -1) . ' ]';
?>

        $scope.AllHostels = <?= $all_hostels ?>;
        $scope.UCAllHostels = <?= $uc_all_hostels ?>;

    }
</script>
<div ng-controller = "hostel_SubmitCtrl">
    <?php
    page_title('Elections');


    $elec_body = array(
        "GBE" => "General Body Elections",
        "HBE" => "Hostel Body Elections"
    );
    $docs = array('manifesto', 'writeup');

    if (!isset($_GET['category'])) {redirect_to("/elections", true);
    }
	elseif (!isset($_GET['post'])) {
        if (isset($_GET['username'])) {
            redirect_to("/elections/view?category=" . $_GET['category'], true);
        } else {

            echo "<div><ul class='breadcrumbs'>";
            echo "<li><a href='#/elections'>Elections 2014</a></li>";
            echo "<li class='current'><a href='#'>" . $elec_body[$_GET['category']] . "</a></li>";
            echo "</ul></div>";
            if ($_GET['category'] == 'HBE') {
                echo "<select class='small-12 medium-8 large-6 medium-offset-2 large-offset-3 columns' ng-model='eview.hostel' ng-options = 'h.name as h.name for h in UCAllHostels'></select>";
            }
            $query = "SELECT post_id FROM `stu_portal`.`post_instances` WHERE open=1";
            $result = mysql_query($query) or trigger_error(mysql_error());

				echo "<table class='small-12 medium-8 large-6 medium-centered columns'><thead><tr><th>Candidate Posts</th></tr></thead><tbody>";
            while ($row = mysql_fetch_object($result)) {
                if ($_GET['category'] == 'GBE') {
                    $query2 = "SELECT post_name,top_level_post_name FROM `stu_portal`.`posts` WHERE (id='" . $row->post_id . "') and (top_level_post_name='Secretary' or top_level_post_name='Councillor' or top_level_post_name='Branch Councillor')";
                    $result2 = mysql_query($query2) or trigger_error(mysql_error());
                    $row2 = mysql_fetch_object($result2);
                    if ($row2) {
                        $post = str_replace(" ", "_", $row2->post_name . "_" . $row2->top_level_post_name);
                        
                        echo "<tr><td><a class='' href='#/elections/view?category=" . $_GET['category'] . "&post=" . $post . "'>" . $row2->post_name . " " . $row2->top_level_post_name . "</a></td></tr>";
				        }
                } elseif ($_GET['category'] == 'HBE') {
                    $query2 = "SELECT post_name,top_level_post_name FROM `stu_portal`.`posts` WHERE (id='" . $row->post_id . "') and (top_level_post_name='Hostel Secretary')";
                    $result2 = mysql_query($query2) or trigger_error(mysql_error());
                    $row2 = mysql_fetch_object($result2);
                    if ($row2) {
                        $post = str_replace(" ", "_", $row2->post_name . "_" . str_replace('Hostel ', '', $row2->top_level_post_name));
                        echo "<tr><td><a  href='#/elections/view?category=" . $_GET['category'] . "&post={{ eview.hostel | capitalize}}_" . $post . "'>" . $row2->post_name . " " . str_replace('Hostel ', '', $row2->top_level_post_name) . "</a></td></tr>";
                    }
                }
            }
        		echo "</body></table></div>";               
            
        }
    } else  {
        echo "<div><ul class='breadcrumbs'>";
        echo "<li><a href='#/elections'>Elections 2014</a></li>";
        echo "<li><a href='#/elections/view?category=" . $_GET['category'] . "'>" . $elec_body[$_GET['category']] . "</a></li>";
        echo "<li class='current'><a href='#'>" . str_replace("_", " ", $_GET['post']) . "</a></li>";
        echo "</ul></div>";
		
		
		

			$result = mysql_query("SELECT pi.id, pi.post_id, no.user_id,p.post_name, p.top_level_post_name, no.user_id,u.username,u.hostel,u.room,u.contact,u.email,u.fullname,no.image,no.manifesto,no.writeup
					FROM `stu_portal`.`nominations` AS no
					JOIN `stu_portal`.`users` AS u
					  ON (u.id = no.user_id )
					JOIN `stu_portal`.`post_instances` AS pi 
					  ON (no.post_instance_id = pi.id)
					JOIN `stu_portal`.`posts` AS p 
					  ON (p.id = pi.post_id) 
					WHERE (pi.open = 1)
					ORDER BY pi.id ASC ") or trigger_error(mysql_error() );

			while($row = mysql_fetch_object($result)){
				if ($row->top_level_post_name == 'Secretary' or $row->top_level_post_name == 'Councillor' or $row->top_level_post_name == 'Branch Councillor')
					$post = str_replace(' ','_',$row->post_name.'_'.$row->top_level_post_name);
				elseif ($row->top_level_post_name == 'Hostel Secretary') 
					$post = ucfirst(strtolower($row->hostel)).'_'.str_replace(' ','_',$row->post_name.'_'.str_replace('Hostel ','',$row->top_level_post_name));
				if ($post == $_GET['post']){
				
				$name_parts=explode(" ", $row->fullname);
			for($i=0;$i<sizeof($name_parts);$i++)
				$name_parts[$i]= ucfirst(strtolower($name_parts[$i]));
			$row->fullname = implode(" ", $name_parts);
						if(!$row->image or !file_exists(FILE_DIR_ROOT.'/'.$row->image)) $image_file= IMG_ROOT."/default/user-default-blue.png";
						else $image_file = FILE_ROOT.'/'.$row->image;
				
				echo "<div class='small-12 columns'>";
					echo "<div class='small-5 medium-5 large-2 columns'><a class='th '><img src='".$image_file."'></a></div>";        
					echo "<div class='small-7 medium-7 large-5 columns'><h4><a>$row->username</a></h4>
							<h4>$row->fullname</h4><h5>$row->room, $row->hostel</h5><h5>+91 $row->contact</h5><h5>$row->email</h5></div>";
					echo "";
					if (strtolower($row->username) == strtolower($current_user->username)){
					foreach ($docs as $value) {
						echo "<div class='small-12 medium-12 large-5 columns'><div class='row collapse'><div class='small-7 columns'><a class='button expand' data-reveal-id='myModal-$row->username$value' data-reveal>View " . $value. "</a></div>
						<div class='small-5 columns'><a class='button success expand' target='_blank' href='".FILE_ROOT."/".$row->{$value}."'>Download</a></div></div></div>";
						?>
						<div id="myModal-<?= $row->username.$value?>" class="reveal-modal" data-reveal>
							<object data="<?= FILE_ROOT ?>/<?= $row->{$value} ?>" type="application/pdf" class="pdf-object">	<!-- Just change the path in data=" " and a href=" " for different Candidates -->
								alt : <a href="<?= FILE_ROOT ?>/<?= $row->{$value} ?>">$value</a>
							</object>
						</div>	
						<!-- @Prasanth, The modal is not working unless i invoke the foundation script again -->
						<script>
								$(document).foundation();
						</script>
						
					<?php
				}}
				echo "<hr></div>";
				}
			
			
			}
       	
    } 

?>
</div>
