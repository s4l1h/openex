<?php

$id = $loggedInUser->user_id;
$account = $loggedInUser->display_username;
if(!isUserLoggedIn()){
echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
}
if(isUserAdmin($id) === true)
{
echo "<h2>Welcome Admin</h2>";
$sql = mysql_query("SELECT * FROM Tickets");
}
if(isUserMod($id) === true)
{
echo "<h2>Welcome Moderator</h2>";
$sql = mysql_query("SELECT * FROM Tickets");
}
if(isUserNormal($id)){
echo "<h2>How may I help you today, <b>".$account."</b> ?</h2>";
echo "
<ul class='flatflipbuttons'>
	<li style='width: 200px !important;' class='square'><a href='index.php?page=newticket'><span>Get Support</span></a></li>
</ul>
</br>";
$sql = mysql_query("SELECT * FROM Tickets WHERE `user_id`='$id'");
}

$num = mysql_num_rows($sql);
?>

			<div id="page">
				<form action="">
				<table id="page">
				<tr>
					<th><a id="toggle-all" ></a> </th>
					<th><a href="">Ticket Subject</a>	</th>
					<th><a href="">Posted</a></th>			
					<th><a href="">Answers</a></th>
					<th><a href="">Status</a>
				</tr>
<?php
for($i = 0;$i<$num;$i++)
{
$subject = mysql_result($sql,$i,"subject");
$posted = mysql_result($sql,$i,"posted");
$id = mysql_result($sql,$i,"id");
$answers = GetPosts($id);
$opened = mysql_result($sql,$i,"opened");
if($opened == 1)
{
$open = "<b>Open</b>";
}
else
{
$open = "<b>Closed</b>";
}
?>
				<tr>
					<td><input  type="checkbox"/></td>
					<td><a href="index.php?page=viewticket&id=<?echo $id; ?>"><? echo $subject;?></a></td>
					<td><? echo $posted;?></td>
<td><? echo $answers;?></td>
<td><? echo $open; ?></td>
				</tr>
<?
}
?>

				</table>
				</form>
			</div>