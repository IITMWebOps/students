<?php

page_title('Elections');
if(!isset($_GET['level')){
	if(isset($_GET['post'] or isset($_GET['username'] or $_GET['doc']){
		redirect_to("/elections/view");
	}
	else {
		// display levels
	}
else if (!isset($_GET['post'])) {
	if (isset($_GET['username'] or $_GET['doc']){
		redirect_to("/elections/view?level=".$_GET['level']);
	}
	else {
		// display posts
	}
else if (!isset($_GET['username'])) {
	if (isset($_GET['doc']){
		redirect_to("/elections/view?level=".$_GET['level']."&post=".$_GET['post']);
	}
	else {
		// display usernames
	}
else if (!isset($_GET['doc'])) {
		// display docs
	}
else {
	// display doc
	}
}

$data->level = $_GET['level'];
$data->post = $_GET['post'];
$data->username = $_GET['username'];
$data->doc = $_GET['doc'];


echo "Test";