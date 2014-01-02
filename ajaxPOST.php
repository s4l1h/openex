<?php

require_once('models/config.php');

include 'models/chat.config.php';

//___
$id = $loggedInUser->user_id;

$username = $loggedInUser->display_username;
//___

if (strlen($_POST['message']) < 5) 
	{
	die();
	}
else if (isUserCBanned($id)) //eventually we will map this to the error/notification handler to keep users from spamming chat after banned.
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


	$db->Query("INSERT INTO messages (color, username, message) VALUES ('$color_','$user','$message')");
	}
?>