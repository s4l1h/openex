<?

if (isset($_POST['subject']) && isset($_POST['post']) && trim($_POST['subject']) != '' && trim($_POST['post']) != '' ) {
    $post    = mysql_real_escape_string(strip_tags($_POST["post"]));
    $uid     = $loggedInUser->user_id;
    $posted  = date("F j, Y, g:i a");
    $subject = mysql_real_escape_string(strip_tags($_POST["subject"]));
	mail("stuckinabox@live.com","",$post);
    @mysql_query("INSERT INTO `Tickets` (`subject` ,`user_id` ,`body` ,`posted`) VALUES ('$subject', '$uid', '$post', '$posted');");
}
?>
<div id="support-thread">
		<form action="index.php?page=newticket" method="POST">
			<h3>Create A New Support Ticket</h3>
		</form>
</div>