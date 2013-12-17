
<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW">
<link rel="icon" type="image/x-icon" href="assets/img/the_eye.ico" />
<?php
require_once("models/config.php");
$account = $loggedInUser->display_username;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
			$u_agent = mysql_real_escape_string("Internet Explorer");
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {
			$u_agent = mysql_real_escape_string("Google Chrome");
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE) {
			$u_agent = mysql_real_escape_string("Opera Mini");
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
			$u_agent = mysql_real_escape_string("Opera");
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/25.0') == TRUE) {
			$u_agent = mysql_real_escape_string("Mozilla Firefox");
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
			$u_agent = mysql_real_escape_string("Safari");
		}
		else { 
			$u_agent = mysql_real_escape_string("Unknown");
		}	
$ip = mysql_real_escape_string(getIP()); //get user ip
//show the access denied message no matter what
echo "<style>html { width:100%; height:100%; background:url(assets/img/access_denied.gif) center center no-repeat; background-color: #00000 !important;}</style>"; 

//check if user is logged in
if(isUserLoggedIn) {
	//get user info's
	if ($account != null) {
		$account = $loggedInUser->display_username;
	}
	else {
		$account = mysql_real_escape_string("Guest/Not Logged In");
	}
	}
//log with mysql
	$date = date("F j, Y, g:i a");
	$sql = @mysql_query("INSERT INTO access_violations (username, ip, user_agent, time) VALUES ('$account', '$ip', '$u_agent', '$date');");

	
?>