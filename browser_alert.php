<html>
<head>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
<title>Browser Not Supported</title>
<style>
@font-face{
    font-family: 'ws-ui';
    font-style: normal;
    font-weight: normal;
    src: url('assets/font/weblysleekuil.ttf') format('truetype');
}
@font-face{
    font-family: 'Comfortaa-Regular';
    font-style: normal;
    font-weight: normal;
    src: url('assets/font/Comfortaa-Regular.ttf') format('truetype');
}
body{
	background: #B6B6B4;
	color: #fff;
    font-family: 'ws-ui', sans-serif;
	margin:0;
	padding:0;
	line-height: 1.5em;
}
h1,h2,h3,h4,h5,h6 {
	font-family: 'Comfortaa-Regular', sans-serif;
}
</style>
</head>
<body>
<center>
<?php

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
			$u_agent = "Internet Explorer";
			$message = "this site is best viewed in Google Chrome.";
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE) {
			$u_agent = "Opera";
			$message = "this site is best viewed in Google Chrome.";
		}
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/25.0') == TRUE) {
			$u_agent = "Mozilla Firefox";
			$message = "this site is best viewed in Google Chrome.";
			}
		else { 
			$u_agent = "Unknown";
			$message = "this site is best viewed in Google Chrome.";
		}
echo '<img src="assets/img/OpenEx-square.png" />';
echo '<h3>'.$message.'</h3>';
echo '<h4>Your Browser: '.$u_agent.'</h4>';
echo '<br/>';
echo 'Click Below to download Google Chrome.<br/>';
echo '<a href="https://www.google.com/intl/en/chrome/#cds"><img src="assets/img/Chrome Logo.png" style="width: 25%; border: 2px solid #000;"></a><br/>';
echo "if you are accessing from a mobile device, <a href='https://openex.mobi'>click here.</a>";

?>
</center>
</body>
</html>