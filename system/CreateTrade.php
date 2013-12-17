<?php
require_once("../models/config.php");
if(isset($_GET["price2"]))
{
	if ($_GET["price2"] > 0 && $_GET["Amount2"] > 0) 
	{
		$PricePer = mysql_real_escape_string($_GET["price2"]);
		$Amount = mysql_real_escape_string($_GET["Amount2"]);
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
if(isset($_GET["Amount"]))
{
	if ($_GET["price1"] > 0 && $_GET["Amount"] > 0) 
	{
		$PricePer = mysql_real_escape_string($_GET["price1"]);
		$Amount = mysql_real_escape_string($_GET["Amount"]);
		$Fees = file_get_contents("http://openex.pw/system/calculatefees2.php?P=" . $Amount);
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