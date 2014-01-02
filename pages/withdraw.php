<?php
require_once("models/config.php");
if (isWithdrawalDisabled()) {
	echo 'Withdrawals are currently disabled.';
}else{
	if(!isUserLoggedIn()) {
		echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
		die(); 
	}
	
	
	/*Check to make sure the user has the balance available before adding the request to queue.
	Be sure to look at the Withdraw_Request table. Everything essentially lines up with the input fields.*/
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
<?php
}
?>
