<?php 
error_reporting(E_ALL);

include("models/class.trade.php");
$id = mysql_real_escape_string($_GET["market"]);

//this code is buggy and need fixed
//error message:
//Notice: Undefined variable: Trade_Data_C in /home/wwwroot/dev3.openex.pw/pages/trade.php on line 31

$time = time() - 86400;
$trade_sql = mysql_query("SELECT * FROM Trade_History WHERE `Market_Id`='$id' AND Timestamp > $time ORDER BY `Timestamp` ASC LIMIT 100");
$Last_Timestamp = "";
$Last_Price = "";
$Trades_Hour = "";
$Trade_Data = "";
while ($row = mysql_fetch_assoc($trade_sql)) {
	$Timestamp = $row["Timestamp"];
	$T3 = date("a",$Timestamp);
	$T2 = date("h",$Timestamp);
	if($T2 != $Last_Timestamp)
	{
		$Trade_Data=$Trade_Data_C;
		$Trades_Hour .= "$T2,";
		$Last_Price = $row["Price"];
		$Trade_Data_C .= $row["Price"] . ",";
	}
	else
	{
		$Last_Price = ($Last_Price + $row["Price"])/2;
		$Trade_Data_C = $Trade_Data . $Last_Price . ",";
	}
	$Last_Timestamp = $T2;
}
$Trade_Data=$Trade_Data_C;
$labels = $Trades_Hour;
$trade_data = $Trade_Data;




if (isUserLoggedIn()) 
{ 
//get balances
}

$result = mysql_query("SELECT * FROM Wallets WHERE `Id`='$id'");
$name = mysql_real_escape_string(mysql_result($result, 0, "Acronymn"));
$fullname = mysql_real_escape_string(mysql_result($result, 0, "Name"));
if($id == 1) {
?>
<meta http-equiv="refresh" content="0; URL=index.php?page=account">
<?php
	die();
	
}
if($name == NULL) {
?>
<meta http-equiv="refresh" content="0; URL=index.php?page=invalid_market">
<?php
	die();
}
$market_id = mysql_result($result, 0, "Market_Id");
$SQL2 = mysql_query("SELECT * FROM Wallets WHERE `Id`='$market_id'");
$Currency_1a = mysql_result($SQL2, 0, "Acronymn");
$Currency_1 = mysql_result($SQL2, 0, "Id");
if(isset($_POST["price2"]))
{
	if ($_POST["price2"] > 0 && $_POST["Amount2"] > 0) 
	{
		$PricePer = mysql_real_escape_string($_POST["price2"]);
		$Amount = mysql_real_escape_string($_POST["Amount2"]);
		$X = $PricePer * $Amount;
		$Total = file_get_contents("http://dev3.openex.pw/system/calculatefees.php?P=" . $X);
		$Fees = file_get_contents("http://dev3.openex.pw/system/calculatefees2.php?P=" . $X);
		$user_id = $loggedInUser->user_id; 
		
		if(TakeMoney($Total,$user_id,$Currency_1) == true)
		{
			AddMoney($Fees,-1,$Currency_1);
			$New_Trade = new Trade();
			$New_Trade->trade_to = $name;
			$New_Trade->trade_from = $Currency_1a;
			$New_Trade->trade_amount = $Amount;
			$New_Trade->trade_value = $PricePer;
			$New_Trade->trade_owner = $user_id;
			$New_Trade->trade_type = $name;
			$New_Trade->trade_fees = $Fees;
			$New_Trade->trade_total = $Total;
			$New_Trade->trade_type = $name;
			$New_Trade->standard = $Amount;
			$New_Trade->GetEquivalentTrade();
			$New_Trade->ExecuteTrade();
			//mysql_query("INSERT INTO trades (`To`,`From`,`Amount`,`Value`,`User_ID`,`Type`,`Fee`,`Total`)VALUES ('$name','$Currency_1a','$Amount','$PricePer','$user_id','$name','$Fees','$Total');");
		}
		else
		{
			echo "<p class='notify-red' id='notify'>You cannot afford that!</p>";
		}
	}
	else
	{
		echo "<p class='notify-red' id='notify'>Please fill in all the forms!!</p>";
	}
}
if (isset($_GET["cancel"])) {

    $ids      = mysql_real_escape_string($_GET["cancel"]);
    $tradesql = @mysql_query("SELECT * FROM trades WHERE `Id`='$ids'");
    $from     = @mysql_result($tradesql, 0, "From");
    $owner    = @mysql_result($tradesql, 0, "User_ID");
	$type     = @mysql_result($tradesql, 0, "Type");
	$Fee = @mysql_result($tradesql,0,"Fee");
	$Amount = @mysql_result($tradesql, 0, "Amount");
	$Price = @mysql_result($tradesql, 0, "Value");
	$sql = @mysql_query("SELECT * FROM Wallets WHERE `Acronymn`='$from'");
	$from_id = @mysql_result($sql,0,"Id");
	if($from != $type)
	{
		$Total = sprintf("%2.8f",$Amount * $Price);
		echo $Total;
		$Totals = file_get_contents("http://dev3.openex.pw/system/calculatefees.php?P=" . $Total);
		$Fees = file_get_contents("http://dev3.openex.pw/system/calculatefees2.php?P=" . $Total);
		TakeMoney($Fees,-1,$from_id,true);
		AddMoney($Totals,$owner,$from_id);
	}
	else
	{
		$Fees = file_get_contents("http://dev3.openex.pw/system/calculatefees2.php?P=" . $Amount);
		TakeMoney($Fees,-1,$from_id,true);
		AddMoney($Amount + $Fees,$owner,$from_id);
	}
	mysql_query("DELETE FROM trades WHERE `Id`='$ids'");
    
}
//--------------------------------------
if(isset($_POST["Amount"]))
{
	if ($_POST["price1"] > 0 && $_POST["Amount"] > 0) 
	{
		$PricePer = mysql_real_escape_string($_POST["price1"]);
		$Amount = mysql_real_escape_string($_POST["Amount"]);
		$Fees = file_get_contents("http://dev3.openex.pw/system/calculatefees2.php?P=" . $Amount);
		$Total = $Fees + $Amount;
		echo $Total;
		$user_id = $loggedInUser->user_id; 
		if(TakeMoney($Total,$user_id,$id) == true)
		{
			AddMoney($Fees,-1,$id);
			
			$New_Trade = new Trade();
			$New_Trade->trade_to = $Currency_1a;
			$New_Trade->trade_from = $name;
			$New_Trade->trade_amount = $Amount;
			$New_Trade->trade_value = $PricePer;
			$New_Trade->trade_owner = $user_id;
			$New_Trade->trade_type = $name;
			$New_Trade->trade_fees = $Fees;
			$New_Trade->trade_total = $Total;
			$New_Trade->trade_type = $name;
			$New_Trade->standard = $Amount;
			$New_Trade->GetEquivalentTrade();
			$New_Trade->ExecuteTrade();
			//mysql_query("INSERT INTO trades (`To`,`From`,`Amount`,`Value`,`User_ID`,`Type`,`Fee`,`Total`)VALUES ('$Currency_1a','$name','$Amount','$PricePer','$user_id','$name','$Fees','$Total');");
		}
		else
		{
			echo "<p class='notify-red' id='notify'>You cannot afford that!</p>";
		}
	}
	else
	{
		echo "<p class='notify-red' id='notify'>Please fill in all the forms!!</p>";
	}
}

?>
<link rel="stylesheet" type="text/css" href="../assets/css/trade.css" />
<link href="assets/css/tables.css" type="text/css" rel="stylesheet" />
<center><h3>Trade <?php echo $fullname; ?></h3></center>
	</body>
</div>
<div id="boxB">
	<div id="boxA">
		<div id="col1">
			<!-- Sell Form-->
			<?php if (isUserLoggedIn()) { ?>
			<div id="sellform" >
				<center><h4>Sell <?php echo $name; ?></h4></center>
				<form action="index.php?page=trade&market=<?php echo $id; ?>" method="POST" autocomplete="off" history="off"> 
					<input class="fieldsmall" type="text" style="width:150px;" name="Amount" onKeyUp="calculateFees1(this)" id="Amount" placeholder="Amount(<?php echo $name; ?>)"/><br/>
					<input class="fieldsmall" type="text" style="width:150px;" name="price1" onKeyUp="calculateFees1(this)" id="price1" placeholder="Price(BTC)"/><br/>
					<input class="fieldsmall" type="text" style="width:150px;" id="earn1"placeholder="Total(BTC)"/></br>
					<input class="fieldsmall" type="text" style="width:150px;" id="fee1"placeholder="Total(<?php echo $name; ?>)"/><br/>
					<input class="miniblues" style="width:150px; height: 25px;" type="submit" name="Sell" value="Sell" />
				</form>
			</div>
			<?php } ?>
			<!--Sell Order Book-->
			<div id="sellorders">
			<?php
				include("open_orders_from.php");
			?>
			</div>
		</div>
		<div id="col2">
			<!--Buy Form-->
			<?php if (isUserLoggedIn()) { ?>
			<div id="buyform">
				<center><h4>Buy <?php echo $name; ?></h4></center>
				<form action="index.php?page=trade&market=<?php echo $id; ?>" method="POST" autocomplete="off" history="off">
					<input class="fieldsmall" type="text" style="width:150px;" onKeyUp="calculateFees2()" name="Amount2" id="Amount2" placeholder="Amount(<?php echo $name; ?>)"/><br/>
					<input class="fieldsmall" type="text" style="width:150px;" id="price2" onKeyUp="calculateFees2()" onKeyUp="calculateFees2()" name="price2" placeholder="Price(BTC)"/><br/>
					<input class="fieldsmall" type="text" style="width:150px;" id="fee2" placeholder="Total(BTC)"/><br/>
					<input class="miniblues" style="width:150px; height: 25px;" type="submit" name="Buy" id="Buy" value="Buy"/>
				</form>
			</div>
			<?php  } ?>
			<!--Buy Order Book-->
			<div id="buyorders">
			<?php
				include("open_orders_to.php");
			?>
		</div>
		</div>
	</div>
</div>
<?php if (isUserLoggedIn()) { ?>
<div id="user-orders">
<?php include("open_orders.php"); ?>
</div>
<?php }  ?>



