<?php
/**Include with preferences menu**/
if(!isUserLoggedIn()){
echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
die();
}
if(!empty($_POST))
{
		$errors = array();
		$password = $_POST["password"];
		$password_new = $_POST["passwordc"];
		$password_confirm = $_POST["passwordcheck"];
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($password) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		}
		else if(trim($password_new) == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		}
		else if(minMaxRange(8,50,$password_new))
		{	
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
		}
		else if($password_new != $password_confirm)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//Confirm the hash's match before updating a users password
			$entered_pass = generateHash($password,$loggedInUser->hash_pw);
			
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
		
			if($entered_pass != $loggedInUser->hash_pw)
			{
				//No match
				$errors[] = lang("ACCOUNT_PASSWORD_INVALID");
			}
			else if($entered_pass_new == $loggedInUser->hash_pw)
			{
				//Don't update, this fool is trying to update with the same password ¬¬
				$errors[] = lang("NOTHING_TO_UPDATE");
			}
			else
			{
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
			}
		}
	}
            if(!empty($_POST))
            {
				if(count($errors) > 0)
				{
            errorBlock($errors); 
            } else { 
			echo lang("ACCOUNT_DETAILS_UPDATED"); ?>
        <?php } }?>

		<link rel="stylesheet" type="text/css" href="assets/css/register.css" />
            <form name="changePass" action="index.php?page=changepassword" method="post">
				<table>
					<tr>
						<td><center><h3>Change Password</h3></center></td>
					</tr>
					<tr>
						<td><input type="password" name="password" placeholder="Existing Password" class="field" /></td>
					</tr>
					
					<tr>
						<td><input type="password" name="passwordc" placeholder="New Password" class="field" /></td>
					</tr>
					
					<tr>
						<td><input type="password" name="passwordcheck" placeholder="NewPassword(Repeat)" class="field" /></td>
					</tr>
					
					<tr>
						<td><input type="submit" value="Update Password"  class="blues" /></td>
				   </tr>
				</table>       
            </form>



