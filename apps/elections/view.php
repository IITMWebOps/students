<?php

page_title('Elections');
if(!isset($_GET['level'])){
	if(isset($_GET['post']) or isset($_GET['username']) or isset($_GET['doc'])){
		redirect_to("/elections/view",true);
	}
	else {
		// display levels
	}
}
elseif (!isset($_GET['post'])) {
	if (isset($_GET['username']) or isset($_GET['doc'])){
		redirect_to("/elections/view?level=".$_GET['level'],true);
	}
	else {
		// display posts
	}
}
elseif (!isset($_GET['username'])) {
	if (isset($_GET['doc'])){
		redirect_to("/elections/view?level=".$_GET['level']."&post=".$_GET['post'],true);
	}
	else {
		// display usernames
	}}
elseif (!isset($_GET['doc'])) {
		// display docs
	}
else {
	// display doc
	}


$data->level = $_GET['level'];
$data->post = $_GET['post'];
$data->username = $_GET['username'];
$data->doc = $_GET['doc'];


echo "Test";