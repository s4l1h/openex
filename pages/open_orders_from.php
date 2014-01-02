<?php
include("../models/config.php");
$id     = mysql_real_escape_string($_GET["market"]);
$result = mysql_query("SELECT * FROM Wallets WHERE `Id`=$id");
$name   = mysql_real_escape_string(mysql_result($result, 0, "Acronymn"));
$type = $name;
?>
<div class="top">
<center>Sell Orders</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
    <th style="width: 33%;">Price</th>
    <th style="width: 33%;">Quantity</th>
	<th style="width: 33%;">Total</th>
</tr>
<?php
$sql = mysql_query("SELECT * FROM trades WHERE `Type`='$type' ORDER BY `Value` ASC");
while ($row = mysql_fetch_assoc($sql)) {
if($row["To"] == "BTC") { 
?>
<tr>
	<td style="width: 33%;"><?php echo sprintf('%.9f',$row["Value"]);?></td>
    <td style="width: 33%;"><?php echo $row["Amount"];?></td>
	<td style="width: 33%;"><?php echo sprintf('%.9f',$row["Amount"] * $row["Value"]);?></td>
</tr>
<?php
}
}
?>
</thead>
</table>
</div>
