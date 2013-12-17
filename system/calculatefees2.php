<?php
header("Content-type: text/plain");
$price = $_GET["P"];
$price2 = ($price*0.005);
echo sprintf("%2.8f", $price2);
?>