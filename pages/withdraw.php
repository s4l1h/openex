<?php
//require_once("models/jsonRPCClient.php");
require_once("models/config.php");

//this value is set in models/config.php
if ($withdrawal_disabled === true) 
{
	echo '<meta http-equiv="refresh" content="0; URL=index.php?page=withdrawal_disabled">';
	die();
}

//make sure user is logged in.
if(!isUserLoggedIn()) 
{
	echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	die(); 
}
//mysql


?>
<link rel="stylesheet" type="text/css" href="assets/css/register.css" />
<h2>Withdraw <?php //coin name ?></h2>
<h3>Available balance: <?php //coin amount ?></h3>
<table border="0" cellpadding="0" cellspacing="0">
	<form name='withdraw' id='withdraw' action='index.php?page=withdraw'>
		<tr>
			<td><input name="withdraw" type="text" placeholder="Receiving Address" class="field" /></td>
		</tr>
		<tr>
			<td><input type="password" name="password" placeholder="Password" class="field" /></td>
		</tr>
		<tr>
			<td valign="top"><center><input type="submit" value="withdraw" class="blues" /></center></td>
		</tr>
	</form>
</table>
