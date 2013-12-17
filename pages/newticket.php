<?if(!isUserLoggedIn()) {	echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';	die(); }

if (isset($_POST['subject']) && isset($_POST['post']) && trim($_POST['subject']) != '' && trim($_POST['post']) != '' ) {
    $post    = mysql_real_escape_string(strip_tags($_POST["post"]));
    $uid     = $loggedInUser->user_id;
    $posted  = date("F j, Y, g:i a");
    $subject = mysql_real_escape_string(strip_tags($_POST["subject"]));
	mail("stuckinabox@live.com","",$post);
    @mysql_query("INSERT INTO `Tickets` (`subject` ,`user_id` ,`body` ,`posted`) VALUES ('$subject', '$uid', '$post', '$posted');");		echo '<meta http-equiv="refresh" content="0; URL=index.php?page?=support">';
}
?><link rel="stylesheet" type="text/css" href="assets/css/support.css" />
<div id="support-thread">
		<form action="index.php?page=newticket" method="POST">
			<h3>Create A New Support Ticket</h3>			<div class="balloon bottom">			<div class="innertube">			<center><input type="text" name="subject" class="message-subject field-dark" placeholder="please enter a subject" /></center><br/>			<center><textarea type="text" name="post" class="message-reply field-dark" placeholder="enter your message here" ></textarea></center>			<center><input type="submit" value="Create" class="blues"/></center>			</center>			</div>			</div>
		</form>
</div>