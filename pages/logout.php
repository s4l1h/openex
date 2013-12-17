<?php
if(isUserLoggedIn){
$loggedInUser->userLogOut();
?>

<meta http-equiv="refresh" content="0; URL=index.php?page=loggedout">

<?php }else{ ?>

<meta http-equiv="refresh" content="0; URL=index.php?page=home">

<?php } ?>