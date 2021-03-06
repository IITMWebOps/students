<?php
page_title('Elections 2014');
$data->search = $_GET['q'];

$result = mysql_query("SELECT pi.id, pi.post_id, no.user_id,p.post_name, p.top_level_post_name, no.user_id,u.username,u.hostel,u.room,u.contact,u.email,u.fullname,no.image,no.manifesto,no.writeup
					FROM `stu_portal`.`nominations` AS no
					JOIN `stu_portal`.`users` AS u
					  ON (u.id = no.user_id )
					JOIN `stu_portal`.`post_instances` AS pi 
					  ON (no.post_instance_id = pi.id)
					JOIN `stu_portal`.`posts` AS p 
					  ON (p.id = pi.post_id) 
					WHERE (pi.open = 1) and (u.fullname like '%$data->search%'  or u.username like '%$data->search%' or u.hostel like '%$data->search%' or p.post_name like '%$data->search%' or p.top_level_post_name like '%$data->search%')
					ORDER BY pi.id ASC") or trigger_error(mysql_error());
?>

<br><br>
<div>
    <form ng-submit="app.reqLite('/elections/?q=' + postsearch)">
        <div class="row">
            <div class="large-8 large-centered columns">
                <div class="row collapse">
                    <div class="small-10 columns">
                        <input type="text" ng-model="postsearch"  placeholder="Search Posts" >
                    </div>
                    <div class="small-2 columns">
                        <input type="submit" value="Search" class="button postfix">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<br><br><br>
<?php
if (isset($_GET['q'])) {
    $elec_body = array(
        "GBE" => "General Body Elections",
        "HBE" => "Hostel Body Elections"
    );
    $docs = array('manifesto', 'writeup');
    if (!mysql_num_rows($result))
        echo "<br><i class='fa fa-search'></i> | No Results Found <i class='fa fa-frown-o'></i>";
    else {
        while ($row = mysql_fetch_object($result)) {

            if ($row->top_level_post_name == 'Secretary' or $row->top_level_post_name == 'Councillor' or $row->top_level_post_name == 'Branch Councillor') {
                $post = str_replace(' ', '_', $row->post_name . '_' . $row->top_level_post_name);
                $category = "GBE";
            } elseif ($row->top_level_post_name == 'Hostel Secretary') {
                $post = ucfirst(strtolower($row->hostel)) . '_' . str_replace(' ', '_', $row->post_name . '_' . str_replace('Hostel ', '', $row->top_level_post_name));
                $category = "HBE";
            }

			$name_parts=explode(" ", $row->fullname);
			for($i=0;$i<sizeof($name_parts);$i++)
				$name_parts[$i]= ucfirst(strtolower($name_parts[$i]));
			$fullname = implode(" ", $name_parts);
			$username = strtoupper($row->username);
			$post_f =str_replace('_',' ', $post);
			
			
            echo "<div class='row'> ";
            echo "<div class='small-12 medium-3 columns'><a class='button expand' href='#/elections/view?category=" . $category . "&post=" . $post . "'><i class='fa fa-folder-open'></i> | " . $username . "</a></div>";
            echo "<div class='small-12 medium-9 columns'><h4>" . $fullname . " | " . $post_f . "</h4>";
				
            echo "";
            echo "</div><hr></div>";
        }
    }
}
?>
<br><br>
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
        <a class="button expand large" href="<?= APP_URL ?>/#/elections/manifesto_form">Click here to Upload Manifesto</a>
        
    </div>
</div>

