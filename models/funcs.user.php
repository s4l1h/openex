<?php	function isUserAdmin($user)	{		$sql94 = mysql_query("SELECT * FROM userCake_Users WHERE `User_ID`='$user'");		if (mysql_result($sql94, 0, "Group_ID") == 9) {			return true;		} else {			return false;		}	}
	
	function isUserMod($user)
	{
		$sql93 = mysql_query("SELECT * FROM userCake_Users WHERE `User_ID`='$user'");
		if (mysql_result($sql93, 0, "Group_ID") == 5) {
			return true;
		} else {
			return false;
		}
	}		function isUserNormal($user)	{		$sql92 = mysql_query("SELECT * FROM userCake_Users WHERE `User_ID`='$user'");		if (mysql_result($sql92, 0, "Group_ID") == 1) {			return true;		} else {			return false;		}	}
	
	function isUserCBanned($user)
	{
		$sql91 = mysql_query("SELECT * FROM userCake_Users WHERE `User_ID`='$user'");
		if (mysql_result($sql91, 0, "ChatBanned") == 1) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function usernameExists($username)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT Active
				FROM ".$db_table_prefix."Users
				WHERE
				Username_Clean = '".$db->sql_escape(sanitize($username))."'
				LIMIT 1";
	
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	function emailExists($email)
	{
		global $db,$db_table_prefix;
	
		$sql = "SELECT Active FROM ".$db_table_prefix."Users
				WHERE
				Email = '".$db->sql_escape(sanitize($email))."'
				LIMIT 1";
	
		if(returns_result($sql) > 0)
			return true;
		else
			return false;	
	}
	
	//Function lostpass var if set will check for an active account.
	function validateActivationToken($token,$lostpass=NULL)
	{
		global $db,$db_table_prefix;
		
		if($lostpass == NULL) 
		{	
			$sql = "SELECT ActivationToken
					FROM ".$db_table_prefix."Users
					WHERE Active = 0
					AND
					ActivationToken ='".$db->sql_escape(trim($token))."'
					LIMIT 1";
		}
		else 
		{
			 $sql = "SELECT ActivationToken
			 		FROM ".$db_table_prefix."Users
					WHERE Active = 1
					AND
					ActivationToken ='".$db->sql_escape(trim($token))."'
					AND
					LostPasswordRequest = 1 LIMIT 1";
		}
		
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	
	function setUserActive($token)
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."Users
		 		SET Active = 1
				WHERE
				ActivationToken ='".$db->sql_escape(trim($token))."'
				LIMIT 1";
		
		return ($db->sql_query($sql));
	}
	
	//You can use a activation token to also get user details here
	function fetchUserDetails($username=NULL,$token=NULL)
	{
		global $db,$db_table_prefix; 
		
		if($username!=NULL) 
		{  
			$sql = "SELECT * FROM ".$db_table_prefix."Users
					WHERE
					Username_Clean = '".$db->sql_escape(sanitize($username))."'
					LIMIT
					1";
		}
		else
		{
			$sql = "SELECT * FROM ".$db_table_prefix."Users
					WHERE 
					ActivationToken = '".$db->sql_escape(sanitize($token))."'
					LIMIT 1";
		}
		 
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row);
	}
	
	function flagLostPasswordRequest($username,$value)
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."Users
				SET LostPasswordRequest = '".$value."'
				WHERE
				Username_Clean ='".$db->sql_escape(sanitize($username))."'
				LIMIT 1
				";
		
		return ($db->sql_query($sql));
	}
	
	function updatePasswordFromToken($pass,$token)
	{
		global $db,$db_table_prefix;
		
		$new_activation_token = generateActivationToken();
		
		$sql = "UPDATE ".$db_table_prefix."Users
				SET Password = '".$db->sql_escape($pass)."',
				ActivationToken = '".$new_activation_token."'
				WHERE
				ActivationToken = '".$db->sql_escape(sanitize($token))."'";
		
		return ($db->sql_query($sql));
	}
	
	function emailUsernameLinked($email,$username)
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT Username,
				Email FROM ".$db_table_prefix."Users
				WHERE Username_Clean = '".$db->sql_escape(sanitize($username))."'
				AND
				Email = '".$db->sql_escape(sanitize($email))."'
				LIMIT 1
				";
		
		if(returns_result($sql) > 0)
			return true;
		else
			return false;
	}
	
	
	function isUserLoggedIn()
	{
		global $loggedInUser,$db,$db_table_prefix;
		
		$sql = "SELECT User_ID,
				Password
				FROM ".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($loggedInUser->user_id)."'
				AND 
				Password = '".$db->sql_escape($loggedInUser->hash_pw)."' 
				AND
				Active = 1
				LIMIT 1";
		
		if($loggedInUser == NULL)
		{
			return false;
		}
		else
		{
			//Query the database to ensure they haven't been removed or possibly banned?
			if(returns_result($sql) > 0)
			{
					return true;
			}
			else
			{
				//No result returned kill the user session, user banned or deleted
				$loggedInUser->userLogOut();
			
				return false;
			}
		}
	}
	
	//This function should be used like num_rows, since the PHPBB Dbal doesn't support num rows we create a workaround
	function returns_result($sql)
	{
		global $db;
		
		$count = 0;
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
		  $count++;
		}
		
		$db->sql_freeresult($result);
		
		return ($count);
	}
	
	//Generate an activation key 
	function generateActivationToken()
	{
		$gen;
	
		do
		{
			$gen = md5(uniqid(mt_rand(), false));
		}
		while(validateActivationToken($gen));
	
		return $gen;
	}
	
	function updateLastActivationRequest($new_activation_token,$username,$email)
	{
		global $db,$db_table_prefix; 
		
		$sql = "UPDATE ".$db_table_prefix."Users
		 		SET ActivationToken = '".$new_activation_token."',
				LastActivationRequest = '".time()."'
				WHERE Email = '".$db->sql_escape(sanitize($email))."'
				AND
				Username_Clean = '".$db->sql_escape(sanitize($username))."'";
		
		return ($db->sql_query($sql));
	}
?>