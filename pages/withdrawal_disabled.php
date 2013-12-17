<?php
if(!isUserLoggedIn()) 
{
	echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	die(); 
}else{
	echo "withdrawals are disabled while we work out some bugs.";
}
?>