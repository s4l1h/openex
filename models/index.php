<?php

$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
header('Location: mobile.php');
}
require_once("models/config.php");
$title="OpenEx";
//a simple alert system so we can easily display an alert when a section is down
$alert= "<strong>the CHATBOX is down for maintenance.</strong>";
//how to call the alert
/*  <?php  echo $alert; ?>   */
include("system/ratelimiter.php");

$rateLimiter = new RateLimiter(new Memcache(), $_SERVER["REMOTE_ADDR"]);
try {
    // allow a maximum of 15 requests per minute
    $rateLimiter->limitRequestsInMinutes(15, 1);
} catch (RateExceededException $e) {
    header("HTTP/1.0 529 Too Many Requests");
    exit;
}

?>
<html>
<head>
	<meta name="viewport" content="width=800, user-scalable=no">
	<link rel="icon" 
      type="image/png" 
      href="assets/img/favicon.png" />
	<link href="assets/css/base.css" type="text/css" rel="stylesheet" />
	<title><?php echo $title; ?></title>
</head>
<body>
<div class="meny">
	<?php
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
		echo '<iframe src="chatbox/chat.php" height="610" width="440" ></iframe>';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		echo '<embed type="text/x-php" src="chatbox/chat.php"/ height="610" width="470" scrolling="no" />';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		echo 'Opera Mini Is Not Supported';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		echo '<iframe src="chatbox/chat.php" height="610" width="440" ></iframe>';
		//hack for firefox 22
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox/25.0') == TRUE) 
		echo '<iframe src="chatbox/chat.php" frameBorder="0" scrolling="no" height="610" width="440" ></iframe>';

		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		echo '<embed type="text/x-php" src="chatbox/chat.php"/ height="610" width="440" >';
		else
		echo 'Unknown Browser/Not Supported. </br>This site is best viewed in Chrome, Chromium or Safari';
	?>
</div>
</div>

<div class="meny-arrow"></div>

<div class="contents">
<div class="container clearfix">
	<header class="website-header color">
		<div>
		<h1 class="Head_T"><a class="Head_A" href="http://openex.pw"><?php echo $title; ?></a></h1>
		<ul id="nav" class="Head_B">
			<li><a href='index.php?page=markets'>Market Overview</a></li>
			<?php $account = $loggedInUser->display_username; if(isUserLoggedIn()){ echo "<li><a href='index.php?page=account'>Account</a></li><li><a href='index.php?page=support'>Support</a></li><li><a href='index.php?page=logout'>Logout</a></li>"; } else { echo "<li><a href='index.php?page=login'>Login</a></li><li><a href='index.php?page=register'>Register</a></li>"; } $id = $loggedInUser->user_id; if(isUserAdmin($id) === true){echo "<li><a href='admin.php'>Admin</a></li>"; }else{ echo "";} ?>
			<li><a href='index.php?page=about'>About</a></li>
        </ul>
		</div>
	</header>
		<section class="content color">
																	<?php

												if($_GET["page"] == "")

												{

													if(isUserLoggedIn())

													{
                                                        echo "<a href='index.php?page=logout'>Click Here To Logout</a>";
														include("pages/account.php");

													}

													else

													{

														include("pages/markets.php");

													}

												}

												else

												{

													include("pages/".$_GET["page"].".php");

												}

											?>	
		</section>
		<aside class="sidebar color">
		<table>
      <tr>
        <td>
          <b id="Mrkt_H">BTC Markets</b><br />

          <ul id="market-list">
			<li><a href='index.php?page=trade&market=15'>ANC &rarr; BTC</a></li>
			
            <li><a href='index.php?page=trade&market=10'>CGB &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=6'>CPR &rarr; BTC</a></li>
			
			<li><a href='index.php?page=trade&market=7'>FRK &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=9'>GLD &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=2'>LTC &rarr; BTC</a></li>
			
			<li><a href='index.php?page=trade&market=8'>MEC &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=4'>NVC &rarr; BTC</a></li>
			
			<li><a href='index.php?page=trade&market=3'>OSC &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=5'>UNO &rarr; BTC</a></li>

            <li><a href='index.php?page=trade&market=11'>XPM &rarr; BTC</a></li>
          </ul>
          <b id="Mrkt_H">LTC Markets</b><br />

          <ul id="market-list">

            <li><a href='index.php?page=closed'>BUK &rarr; LTC</a></li>

            <li><a href='index.php?page=closed'>DBL &rarr; LTC</a></li>

            <li><a href='index.php?page=closed'>NET &rarr; LTC</a></li>
          </ul>
        </td>

      </tr>
    </table>
		</aside>
</div>
</div>
<script src="assets/js/meny.min.js"></script>
		<script>
			// Create an instance of Meny
			var meny = Meny.create({
				// The element that will be animated in from off screen
				menuElement: document.querySelector( '.meny' ),

				// The contents that gets pushed aside while Meny is active
				contentsElement: document.querySelector( '.contents' ),

				// [optional] The alignment of the menu (top/right/bottom/left)
				position: Meny.getQuery().p || 'left',

				// [optional] The height of the menu (when using top/bottom position)
				height: 200,

				// [optional] The width of the menu (when using left/right position)
				width: 500,

				// [optional] Distance from mouse (in pixels) when menu should open
				threshold: 40,

				// [optional] Use mouse movement to automatically open/close
				mouse: true,

				// [optional] Use touch swipe events to open/close
				touch: true
			});

			// API Methods:
			//meny.open();
			//meny.close();
			//meny.isOpen();

			// Events:
			//meny.addEventListener( 'open', function(){ console.log( 'open' ); } );
			//meny.addEventListener( 'close', function(){ console.log( 'close' ); } );

			// Embed an iframe if a URL is passed in
			if( Meny.getQuery().u && Meny.getQuery().u.match( /^http/gi ) ) {
				var contents = document.querySelector( '.contents' );
				contents.style.padding = '0px';
				contents.innerHTML = '<div class="cover"></div><iframe src="'+ Meny.getQuery().u +'" style="width: 100%; height: 100%; border: 0; position: absolute;"></iframe>';
			}
		</script>
</body>
</html>