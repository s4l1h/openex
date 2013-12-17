<?php
if(!empty($_POST))
{
		$errors = array();
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		if($username == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
		}
		if($password == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		}
		
		if(count($errors) == 0)
		{

			if(!usernameExists($username))
			{
				$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
			}
			else
			{
				$userdetails = fetchUserDetails($username);
			
				if($userdetails["Banned"]==1)
				{
					$errors[] = "<p class='notify-red'>This account is banned!</p>";
				}
				else
				{
					$entered_pass = generateHash($password,$userdetails["Password"]);

					if($entered_pass != $userdetails["Password"])
					{
						$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
					}
					else
					{
						$loggedInUser = new loggedInUser();
						$loggedInUser->email = $userdetails["Email"];
						$loggedInUser->user_id = $userdetails["User_ID"];
						$loggedInUser->hash_pw = $userdetails["Password"];
						$loggedInUser->display_username = $userdetails["Username"];
						$loggedInUser->clean_username = $userdetails["Username_Clean"];		
						$loggedInUser->updateLastSignIn();
		
						$_SESSION["userCakeUser"] = $loggedInUser;
						
						echo '<meta http-equiv="refresh" content="0; URL=index.php?page=home">';
						die();
					}
				}
			}
		}
	}
        if(!empty($_POST))
        {
        if(count($errors) > 0)
			{
			errorBlock($errors); 
			} 
?> 
<html lang="en">
<div id="login-holder">
	<div id="logo-login">
	</div>

	<div class="clear"></div>
	
	<div id="loginbox">
	

	<div id="login-inner">
	<form method="POST" action="index.php?page=login" autocomplete="on">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td><input name="username" type="text"  class="field" placeholder="username" /></td>
		</tr>
		<tr>
			<td><input type="password" name="password" placeholder="password" class="field" /></td>
		</tr>
		<tr>
			<td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
		</tr>
		<tr>
			<td><input type="submit" id="loginbutton" class="blues"/></td>
		</tr>
		<tr>
			<th></th>
			
		</tr>
		</table>	</div>

	<div class="clear"></div>
 </div>

 

	<div id="forgotbox">
		<div id="forgotbox-text"><a href="index.php?page=reset">Help! I forgot my password</a></div>
		
	</div>
</div>