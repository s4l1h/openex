<?php



if(!isUserLoggedIn()) 
{
	echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	die(); 
}


?>
<center>
<?
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

<table id="page" class="fullversion"> 

<thead>
<tr>
	<th>Coin Name</th>
	
    <th>Amount</th>

    <th>Price</th>

	<th>Total</th>
	
	<th>Cancel</th>
</tr>

<?php





$sql = mysql_query("SELECT * FROM trades WHERE `User_ID`='$user' ORDER BY `Value` ASC");



while ($row = mysql_fetch_assoc($sql)) {
$type = $row["Type"];
?>



<tr>
	<td><?php echo $type; ?></td>
	<td><?php echo sprintf('%.9f',$row["Value"]);?></td>

    <td><?php echo $row["Amount"];?></td>
<?php 
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