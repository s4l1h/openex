<?php
if (isDepositDisabled()) {
	echo 'Deposits are currently disabled.';
}else{
	if(!isUserLoggedIn()) { 
		echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	}else{
	$account = $loggedInUser->display_username;
	$id = mysql_real_escape_string($_GET["id"]);
	$wallet = new Wallet($id);
	echo "<h3>Your deposit address is: </h3>";
	$address=$wallet->GetDepositAddress($account);
	echo $address;
	}
}
?>
