<?php
class Wallet
{
	public $ip;
	public $port;
	public $username;
	public $password;
	public $Client;
	public $Wallet_Id;
	function Wallet($Wallet_Id)
	{
		$wallet_sql = mysql_query("SELECT * FROM Wallets WHERE `Id`='$Wallet_Id'");
		$this->ip = mysql_result($wallet_sql,0,"Wallet_Ip");
		$this->username = mysql_result($wallet_sql,0,"Wallet_Username");
		$this->password = mysql_result($wallet_sql,0,"Wallet_Password");
		$this->Wallet_Id = $Wallet_Id;
		$this->port = mysql_result($wallet_sql,0,"Wallet_Port");
		$this->Client = new jsonRPCClient('http://' . $this->username . ':' .$this->password . '@' . $this->ip . ':' . $this->port);
	}
	public function GetDepositAddress()
	{
		return $this->Client->getaccountaddress($loggedInUser->display_username);
	}
	public function Withdraw($address,$total,$user)
	{
		$address = mysql_real_escape_string($address);
		$total = mysql_real_escape_string($total);
		$user = mysql_real_escape_string($user);
		$time = time();
		mysql_query("INSERT INTO Withdraw_History(`Timestamp`,`User`,`Amount`,`Address`) values('$time','$user','$total','$address')");
		$this->Client->sendtoaddress($address,$total);
	}
	public function GetTransactions()
	{
		return $this->Client->listtransactions();
	}
}



?>