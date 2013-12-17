<?php

include("../models/config.php");


$id     = mysql_real_escape_string($_GET["market"]);

$result = mysql_query("SELECT * FROM Wallets WHERE `Id`=$id");

$name   = mysql_real_escape_string(mysql_result($result, 0, "Acronymn"));

$type = $name;

?>
<div class="top">

<center>

<font color="000000">

Buy Orders

</font>

</center>

</div>

<div class="box">

<table id="page" class="data">

<thead>

<tr>

    <th>Price</th>

    <th>Quantity (<?php echo $name; ?>)</th>

	<th>Total</th>

</tr>



<?php





$sql = mysql_query("SELECT * FROM trades WHERE `Type`='$type' ORDER BY Value ASC");



while ($row = mysql_fetch_assoc($sql)) {

if($row["To"] == $name) { 
if($name == "ONC")
{
$divider = 1000;
}
?>



<tr>

	<td><?php if($divider != 0) {echo sprintf('%.9f',$row["Value"]/$divider);} else {echo sprintf('%.9f',$row["Value"]);}?></td>

    <td><?php echo $row["Amount"];?></td>

	<td><?php if($divider != 0) { echo sprintf('%.9f',$row["Amount"] * $row["Value"] / 1000); } else { echo sprintf('%.9f',$row["Amount"] * $row["Value"]); }?></td>

</tr>



<?php

}

}

?>
</thead>

</table>

</div>
