<?php

if(!isUserLoggedIn()) 
{
	echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	die(); 
}
?>
<center>
<?
$id     = mysql_real_escape_string($_GET["market"]);
$result = mysql_query("SELECT * FROM Wallets WHERE `Id`=$id");
$name   = mysql_real_escape_string(mysql_result($result, 0, "Acronymn"));
$type = $name;
$user = $loggedInUser->user_id;
?>
<div class="top">
<center>Your Orders</center>
</div>
<div class="box">
<table id="page" class="data" style="width: 100%;">
<thead>
<tr>
    <th style="width: 25%;">Price (BTC)</th>	
	<th style="width: 25%;">Quantity(<?php echo $name;?>)</th>	
	<th style="width: 25%;">Total (BTC)</th>	
	<th style="width: 25%;">Options</th>
</tr>
<?php
$sql = mysql_query("SELECT * FROM trades WHERE `Type`='$type' AND `User_ID`='$user' ORDER BY `Value` ASC");
while ($row = mysql_fetch_assoc($sql)) {
	$marketid = $_GET["market"];
	$ids = $row["Id"];
?>
<tr>
	<td style="width: 25%;"><?php echo sprintf('%.9f',$row["Value"]);?></td>
    <td style="width: 25%;"><?php echo $row["Amount"];?></td>
	<td style="width: 25%;"><?php echo sprintf('%.9f',$row["Amount"] * $row["Value"]);?></td>
	<td style="width: 25%;"><a href="index.php?page=trade&market=<?php echo $marketid; ?>&cancel=<?php echo $ids; ?>">Cancel</a></td>
</tr>
<?php
}
?>
</thead>
</table>
</div>
</center>