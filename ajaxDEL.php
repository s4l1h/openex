<?php
include 'models/chat.config.php';

$idz = $db->real_escape_string($_POST['id']);
$query = $db->Query("UPDATE messages SET `hidden`='1' WHERE `id`='$idz'");
$result = $db->GET($query);
print($result);
?>