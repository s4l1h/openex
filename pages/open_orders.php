<?php

include("../models/config.php");

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

<center>

<font color="000000">

Your Orders

</font>

</center>

</div>

<div class="box">

<table id="page" class="data">

<thead>

<tr>

    <th>Price (BTC)</th>
	
	<th>Quantity(<?php echo $name;?>)</th>
	
	<th>Total (BTC)</th>
	
	<th>Cancel</th>
</tr>



<?php





$sql = mysql_query("SELECT * FROM trades WHERE `Type`='$type' AND `User_ID`='$user' ORDER BY `Value` ASC");



while ($row = mysql_fetch_assoc($sql)) {



?>



<tr>

	<td><?php echo sprintf('%.9f',$row["Value"]);?></td>

    <td><?php echo $row["Amount"];?></td>
<?php 
$marketid = $_GET["market"];
$ids = $row["Id"];
?>
	<td><?php echo sprintf('%.9f',$row["Amount"] * $row["Value"]);?></td>
	<td><a href="index.php?page=trade&market=<?php echo $marketid; ?>&cancel=<?php echo $ids; ?>">Cancel</a></td>


</tr>



<?php


}

?>





</thead>

</table>

</div>

</center>