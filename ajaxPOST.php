<?php

require_once('models/config.php');

include 'models/chat.config.php';

//___
$id = $loggedInUser->user_id;

$username = $loggedInUser->display_username;
//___


if (isUserCBanned($id))
	{
	die();
	}
else
	{
	if(isUserAdmin($id)) 
	{
		$color = "#0404B4";
	}
	else if (isUserMod($id))
	{
		$color = "#B43104";
	} 
	else 
	{
		$color = "#000000";
	}
	$color_ = $db->real_escape_string(htmlentities(($color)));
	$user = $db->real_escape_string(htmlentities(($username))); 
	$message = $db->real_escape_string(strip_tags(($_POST['message']), '<a>'));

	$timestamp = $db->real_escape_string(gettime());
	$db->Query("INSERT INTO messages (color, username, message, timestamp) VALUES ('$color_','$user','$message','$timestamp')");
	}
?>