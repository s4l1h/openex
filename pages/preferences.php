<?php

$id = $loggedInUser->user_id;
$account = $loggedInUser->display_username;

if(!isUserLoggedIn()){
echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
}
?>
<h1>Account Settings</h1>
<table id="page">
<tr>
	<th>Username</th>
	<th>Email</th>
</tr>
<tr>
	<td><?php echo $account; ?></td>
	<td>hidden for your protection</td>
</tr>
</table>
<hr><br/>
<h2>Options</h2><br/>
<div>
<?php

include('changepassword.php');

?>
</div><br/>
<hr><br/>
<h3> Enable/Disable Two Factor Auth </h3>

<p><i> unavailable at this time</i></p>