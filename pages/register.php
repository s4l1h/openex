<?phprequire_once("models/config.php");if(isUserLoggedIn()) {	echo '<meta http-equiv="refresh" content="0; URL=index.php?page=account">';	die(); }if(isRegistrationDisabled()){    display_Reg_message();}else{	
if(!empty($_POST))
{
		$errors = array();
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
		$captcha = md5($_POST["captcha"]);					if ($captcha != $_SESSION['captcha'])		{			$errors[] = lang("CAPTCHA_FAIL");		}		
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidEmail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{										
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)					$errors[] = 'Successfully registered! Returning you to the login form!';
					if(!$user->userCakeAddUser())
					{
						
					}									}
		}
	}
?> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="en"><link rel="stylesheet" type="text/css" href="assets/css/register.css" /><h1>Register</h1><b>By signing up, you agree to the <a href="index.php?page=tos"><u>Terms Of Service</u></a></b><center><?phpif ($message != ""){echo $message;}if (isset($errors)){errorBlock($errors);} ?></center><script type="text/javascript" src="assets/js/register.js"></script>
<div id="login-holder">
	<div id="loginbox">
		<center>
		</center>
		<div id="login-inner"><form method="POST" action="">
<table border="0" cellpadding="0" cellspacing="0">		<tr>		<td>			<input type="text" name="email" placeholder="Email" class="field"/>		</td>	</tr>
	<tr>
		<td>
			<input name="username" type="text" class="field" placeholder="Desired Username"/>
		</td>
	</tr>
	<tr>
		<td>
			<input type="password" id="password1" name="password" class="field" placeholder="Password" onkeyup="passwordStrength(this.value)"/>
		</td>
	</tr>	</br>	</br>	<tr>		<td>						<p>				<div id="passwordDescription">Password strength: not entered</div>				<div id="strength">					<div id="passwordStrength" class="strength0"></div>				</div>			</p>					</td>	</tr>		<tr>		<td>			<input type="password" id="password2" name="passwordc" class="field" placeholder="Repeat Password"/>		</td>	</tr>	<tr>		<td>			<center><img src="pages/docs/captcha.php" class="captcha"></center>		</td>	</tr>	<tr>		<td>			<input name="captcha" type="text" placeholder="Enter Security Code" class="field">		</td>	</tr>
	<tr>
		<td>
			<input type="submit" class="blues"/>
		</td>
	</tr>
</table></form>
</div>
</div>
</div>
</body>
</html><?php}?>