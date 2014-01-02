<?php
/*
	UserCake Version: 1.4
	http://usercake.com
	
	Developed by: Adam Davis
*/

class loggedInUser {

	public $email = NULL;
	public $hash_pw = NULL;
	public $user_id = NULL;
	public $clean_username = NULL;
	public $display_username = NULL;
	
	//Simple function to update the last sign in of a user
	public function updateLastSignIn()
	{
		global $db,$db_table_prefix;
		
		$sql = "UPDATE ".$db_table_prefix."Users
			    SET
				LastSignIn = '".time()."'
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		return ($db->sql_query($sql));
	}
	
	//Return the timestamp when the user registered
	public function signupTimeStamp()
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT
				SignUpDate
				FROM
				".$db_table_prefix."Users
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);
		
		return ($row['SignUpDate']);
	}
	
	//Update a users password
	public function updatePassword($pass)
	{
		global $db,$db_table_prefix;
		
		$secure_pass = generateHash($pass);
		
		$this->hash_pw = $secure_pass;
		
		$sql = "UPDATE ".$db_table_prefix."Users
		       SET
			   Password = '".$db->sql_escape($secure_pass)."' 
			   WHERE
			   User_ID = '".$db->sql_escape($this->user_id)."'";
	
		return ($db->sql_query($sql));
	}
	
	//Update a users email
	public function updateEmail($email)
	{
		global $db,$db_table_prefix;
		
		$this->email = $email;
		
		$sql = "UPDATE ".$db_table_prefix."Users
				SET Email = '".$email."'
				WHERE
				User_ID = '".$db->sql_escape($this->user_id)."'";
		
		return ($db->sql_query($sql));
	}
	
	//Fetch all user group information
	public function groupID()
	{
		global $db,$db_table_prefix;
		
		$sql = "SELECT ".$db_table_prefix."Users.Group_ID, 
			   ".$db_table_prefix."Groups.* 
			   FROM ".$db_table_prefix."Users
			   INNER JOIN ".$db_table_prefix."Groups ON ".$db_table_prefix."Users.Group_ID = ".$db_table_prefix."Groups.Group_ID 
			   WHERE
			   User_ID  = '".$db->sql_escape($this->user_id)."'";
		
		$result = $db->sql_query($sql);
		
		$row = $db->sql_fetchrow($result);

		return($row);
	}
	
	//Is a user member of a group
	public function isGroupMember($id)
	{
		global $db,$db_table_prefix;
	
		$sql = "SELECT ".$db_table_prefix."Users.Group_ID, 
				".$db_table_prefix."Groups.* FROM ".$db_table_prefix."Users 
				INNER JOIN ".$db_table_prefix."Groups ON ".$db_table_prefix."Users.Group_ID = ".$db_table_prefix."Groups.Group_ID
				WHERE User_ID  = '".$db->sql_escape($this->user_id)."'
				AND
				".$db_table_prefix."Users.Group_ID = '".$db->sql_escape($db->sql_escape($id))."'
				LIMIT 1
				";
		
		if(returns_result($sql))
			return true;
		else
			return false;
		
	}
	
	//Logout
	function userLogOut()
	{
		destorySession("userCakeUser");
	}

}
?>