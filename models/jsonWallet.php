<?php

	require_once("jsonRPCClient.php");
	include("settings.php");
	function establishRPCConnection($ip,$port)

	{

		$bitcoin = new jsonRPCClient('http://$db_wallet_user:$db_wallet_password@' . $ip . ':' . $port );

		return $bitcoin;

	}

?>