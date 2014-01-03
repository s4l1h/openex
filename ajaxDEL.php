<?php
require_once('models/config.php');
require_once('models/chat.config.php');

$user_id = $loggedInUser->user_id;
if(isUserAdmin($id)===FALSE && isUserMod($id)===FALSE){
    exit(':)');
}



$idz = $db->real_escape_string($_POST['id']);
$query = $db->Query("UPDATE messages SET `hidden`='1' WHERE `id`='$idz'");
$result = $db->GET($query);
print($result);
?>
