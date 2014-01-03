<center><h3><? $account = $loggedInUser->display_username; echo "Welcome to your account page <b>".$account.""; ?></h3><div id="page">
<table id="page">
<tr>
	<th>Currency</th><th>Available</th><th>Pending</th><th>Deposit</th><th>Withdraw</th>
</tr>
<?php
if(!isUserLoggedIn()){ header("LOCATION:index.php?page=login"); die(); }
$user_id =  $loggedInUser->user_id;
$sql = mysql_query("SELECT * FROM Wallets ORDER BY `Name` ASC");
while ($row = mysql_fetch_assoc($sql)) {
$coin = $row["Id"];
$result = @mysql_query("SELECT * FROM balances WHERE User_ID='$user_id' AND `Wallet_ID` = '$coin'");
if($result == NULL)
{
$amount = 0;
$pending = 0;
}
else
{
$amount = @mysql_result($result,0,"Amount");$account = $loggedInUser->display_username;
}
$account = $loggedInUser->display_username;$acronymn = $row["Acronymn"];$sql_pending = mysql_query("SELECT * FROM deposits WHERE `Paid`='0' AND `Account`='$account' AND `Coin`='$acronymn'");$nums = mysql_num_rows($sql_pending);$pending = 0;$market_id = $row["Id"];for($iz = 0;$iz<$nums; $iz++){$pending = $pending + @mysql_result($sql_pending,$iz,"Amount");}
?>
<tr>
	<td><a href="index.php?page=trade&market=<?php echo $market_id; ?>"><?php echo $row["Name"];?></a></td><td class="b1"><?php echo $amount ?></td><td class="b1"><?php echo $pending; ?></td><td><a href="index.php?page=deposit&id=<?php echo $row["Id"]; ?>">Deposit</a></td><td><a href="index.php?page=withdraw&id=<?php echo $row["Id"]; ?>">Withdraw</a></td>
</tr>
<?php
}
?>
</table></div>
</center>

