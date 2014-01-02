<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('api.config.php');

$query1 = $db2->query("SELECT * FROM Wallets ORDER BY `Acronymn` ASC");
	$data = $db2->GET($query1);
	foreach($data as $key => $value) {
		echo $value['Name']." | ".$value['Acronymn']" | ".$value['Last_Trade']."<br/>";
}
/*
if($_GET["api"] == "test") {
	
}
*/

?>