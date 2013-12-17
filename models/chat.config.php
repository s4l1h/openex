<?php

include 'mysqli.class.php';

$config = array();
$config['host'] = 'localhost';
$config['user'] = 'userchat';
$config['pass'] = 'password';
$config['table'] = 'databasename';

$db = new DB($config);

?>