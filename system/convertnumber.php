<?php
header("Content-type: text/plain");
$price = $_GET["P"];
echo sprintf("%2.8f", $price);
?>