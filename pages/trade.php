<?php 
error_reporting(e_all);


$id = mysql_real_escape_string($_GET["market"]);
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

function GetMoney($user, $currency)
{
    $user2 = $user;
    $sql   = @mysql_query("SELECT * FROM balances WHERE `User_ID`='$user2' AND `Coin`='$currency'");
    $id    = @mysql_result($sql, 0, "id");
    if ($id < 1) {
        $old = mysql_result($sql, 0, "Amount");
        return $old;
    } else {
        $old = mysql_result($sql, 0, "Amount");
        return $old;
    }
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
		$Total = file_get_contents("http://openex.pw/system/calculatefees.php?P=" . $X);
		$Fees = file_get_contents("http://openex.pw/system/calculatefees2.php?P=" . $X);
		$user_id = $loggedInUser->user_id; 
		if(TakeMoney($Total,$user_id,$Currency_1) == true)
		{
			AddMoney($Fees,101,$Currency_1);
			mysql_query("INSERT INTO trades (`To`,`From`,`Amount`,`Value`,`User_ID`,`Type`,`Fee`,`Total`)VALUES ('$name','$Currency_1a','$Amount','$PricePer','$user_id','$name','$Fees','$Total');");
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
	$Price = @mysql_result($tradesql, 0, "Price");
	$Total = @mysql_result($tradesql,0,"Total");
	$sql = mysql_query("SELECT * FROM Wallets WHERE `Acronymn`='$from'");
	$from_id = mysql_result($sql,0,"Id");
	if($from != $type)
	{
		$Total_New = ($Total - $Fee);
		$subtract = ($Amount * $Price);
		$Total = $Total_New - $subtract;
		$Totals = file_get_contents("http://openex.pw/system/calculatefees.php?P=" . $Total);
		$Fees = file_get_contents("http://openex.pw/system/calculatefees2.php?P=" . $Total);
	/*	echo $Totals;
		echo "<br/>";
		echo $Fees;*/
	}
	
	if(TakeMoney($Fee,101,$from_id,true) == true)
	{
		
		AddMoney($Total,$owner,$from_id);
	}
	else
	{
		echo "<p class='notify-red' id='notify'>You cannot afford that!</p>";
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
		$Fees = file_get_contents("https://openex.pw/system/calculatefees2.php?P=" . $Amount);
		$Total = $Fees + $Amount;
		echo $Total;
		$user_id = $loggedInUser->user_id; 
		if(TakeMoney($Total,$user_id,$id) == true)
		{
			AddMoney($Fees,101,$id);
			mysql_query("INSERT INTO trades (`To`,`From`,`Amount`,`Value`,`User_ID`,`Type`,`Fee`,`Total`)VALUES ('$Currency_1a','$name','$Amount','$PricePer','$user_id','$name','$Fees','$Total');");
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
<div id="chart">
<script src="../assets/charts/effects.js"></script>
<script src="../assets/charts/Chart.js"></script>
<script src="../assets/charts/excanvas.js"></script>

<meta name = "viewport" content = "initial-scale = 1, user-scalable = no">

			

		<canvas id="canvas" height="300" width="500" style="margin: 0 auto;"></canvas>
	<script>

		var lineChartData = {
			labels : [<?php echo $labels;?>],
			datasets : [
				{
				    //Coin A
					strokeColor : "#fff",
					pointColor : "#000",
					pointStrokeColor : "#fff",
					data : [<?php echo $trade_data; ?>]
				}
			]
			
		}

	var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData);
	</script>
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



