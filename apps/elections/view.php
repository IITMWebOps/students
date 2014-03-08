<script>
    function hostel_SubmitCtrl($scope) {
        $scope.eview = {'hostel': '<?= $current_user->hostel ?>'};


<?php
$all_hostels = '[';
$h_res = mysql_query("SELECT DISTINCT `users`.`hostel` FROM `stu_portal`.`users` ORDER BY `users`.`hostel` ASC");
while ($row = mysql_fetch_object($h_res)) {
    $all_hostels.= "{ 'name' : '" . $row->hostel . "' },";
}
$all_hostels = substr($all_hostels, 0, -1) . ' ]';
?>

        $scope.AllHostels = <?= $all_hostels ?>;

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
        
    } elseif (!isset($_GET['post'])) {
        if (isset($_GET['username'])) {
            redirect_to("/elections/view?category=" . $_GET['category'], true);
        } else {

            echo "<div><ul class='breadcrumbs'>";
            echo "<li><a href='#/elections'>Elections 2014</a></li>";
            echo "<li class='current'><a href='#'>" . $elec_body[$_GET['category']] . "</a></li>";
            echo "</ul></div>";
            if ($_GET['category'] == 'HBE') {
                echo "<select class='' ng-model='eview.hostel' ng-options = 'h.name as h.name for h in AllHostels'></select>";
            }
            $query = "SELECT post_id FROM `stu_portal`.`post_instances` WHERE open=1";
            $result = mysql_query($query) or trigger_error(mysql_error());

            while ($row = mysql_fetch_object($result)) {
                if ($_GET['category'] == 'GBE') {
                    $query2 = "SELECT post_name,top_level_post_name FROM `stu_portal`.`posts` WHERE (id='" . $row->post_id . "') and (top_level_post_name='Secretary' or top_level_post_name='Councillor' or top_level_post_name='Branch Councillor')";
                    $result2 = mysql_query($query2) or trigger_error(mysql_error());
                    $row2 = mysql_fetch_object($result2);
                    if ($row2) {
                        $post = str_replace(" ", "_", $row2->post_name . "_" . $row2->top_level_post_name);
                        echo "<a href='#/elections/view?category=" . $_GET['category'] . "&post=" . $post . "'>" . $row2->post_name . " " . $row2->top_level_post_name . "</a></br>";
                    }
                } elseif ($_GET['category'] == 'HBE') {
                    $query2 = "SELECT post_name,top_level_post_name FROM `stu_portal`.`posts` WHERE (id='" . $row->post_id . "') and (top_level_post_name='Hostel Secretary')";
                    $result2 = mysql_query($query2) or trigger_error(mysql_error());
                    $row2 = mysql_fetch_object($result2);
                    if ($row2) {
                        $post = str_replace(" ", "_", $row2->post_name . "_" . str_replace('Hostel ', '', $row2->top_level_post_name));
                        echo "<a href='#/elections/view?category=" . $_GET['category'] . "&post={{ eview.hostel | lowercase}}_" . $post . "'>" . $row2->post_name . " " . str_replace('Hostel ', '', $row2->top_level_post_name) . "</a></br>";
                    }
                }
            }
        }
    } elseif (!isset($_GET['username'])) {
        echo "<div><ul class='breadcrumbs'>";
        echo "<li><a href='#/elections'>Elections 2014</a></li>";
        echo "<li><a href='#/elections/view?category=" . $_GET['category'] . "'>" . $elec_body[$_GET['category']] . "</a></li>";
        echo "<li class='current'><a href='#'>" . str_replace("_", " ", $_GET['post']) . "</a></li>";
        echo "</ul></div>";
        echo "<a href='#/elections/view?category=" . $_GET['category'] . "&post=" . $_GET['post'] . "&username=ae11b000'>ae11b000</a>";
    } else {
        echo "<div><ul class='breadcrumbs'>";
        echo "<li><a href='#/elections'>Elections 2014</a></li>";
        echo "<li><a href='#/elections/view?category=" . $_GET['category'] . "'>" . $elec_body[$_GET['category']] . "</a></li>";
        echo "<li><a href='#/elections/view?category=" . $_GET['category'] . "&post=" . $_GET['post'] . "'>" . str_replace("_", " ", $_GET['post']) . "</a></li>";
        echo "<li class='current'><a href='#'>" . $_GET['username'] . "</a></li>";
        echo "</ul></div>";
        foreach ($docs as $value) {
            echo "<a data-reveal-id='myModal' data-reveal>" . $value . "</a>";
            ?>

            <div id="myModal" class="reveal-modal" data-reveal>
                <object data="<?= IMG_ROOT ?>/social/WC.pdf" type="application/pdf" class="pdf-object">	<!-- Just change the path in data=" " and a href=" " for different Candidates -->
                    alt : <a href="<?= IMG_ROOT ?>/social/WC.pdf">test.pdf</a>
                </object>
            </div>	
            <!-- @Prasanth, The modal is not working unless i invoke the foundation script again -->
            <script>
                    $(document).foundation();
            </script>

        <?php
    }
}
?>
</div>