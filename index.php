<?php

require_once("models/config.php");


if(isIPbanned()) {
	die("ip address is banned.");
}

//start memcache
memcache_init();

//start load monitor
load_monit_init();

//check the browser, only let chrome safari or firefox through.

if(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE) {
	//ignore
}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE) {
	//ignore
}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE) {
	//ignore
	}else{
		echo '<meta http-equiv="refresh" content="0; URL=browser_alert.php">';
	}

//when enabled, detects mobile browsers and redirects accordingly.
if($mobile_redirect === true) {
	mobile_listen();
}
//maintenance handler
if($maintenance === true) {
	if(!isUserAdmin($id))
	{
	echo '<meta http-equiv="refresh" content="0; URL='.$maint_url.'">';
	die();
	}else{
	//do nothing
	}
}
// global session config
$id = $loggedInUser->user_id;
$account = $loggedInUser->display_username;

?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title; ?></title>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
<link href="assets/css/base.css" rel="stylesheet" />
<link href="assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="assets/css/meny.css" />
<?php
if(isset($_SERVER['HTTP_USER_AGENT'])){
    $agent = $_SERVER['HTTP_USER_AGENT'];
}
if(strlen(strstr($agent,"Firefox")) > 0 ){ 

  echo '<link rel="stylesheet" type="text/css" href="assets/css/chatff.css" />';
  }
  else
  {
  echo '<link rel="stylesheet" type="text/css" href="assets/css/chat.css" />';
  }
?>
<link rel="stylesheet" type="text/css" href="assets/css/tiled.css" />
<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
		//trade funcs
	function per(num, percentage){
	  return num*percentage/100;
	}
	function calculateFees1(x)
	{
	var total = document.getElementById('Amount').value;
	var earn = document.getElementById('Amount').value * document.getElementById('price1').value;
	document.getElementById('earn1').value = earn;
	document.getElementById('fee1').value = 0;
		$.get("system/calculatefees.php?P=" + total,function(data,status){
		  document.getElementById('fee1').value = data;
		  
		});
		$.get("system/convertnumber.php?P=" + earn,function(data,status){
		  document.getElementById('earn1').value = data;
		  
		});

	}
	function calculateFees2()
	{
	var total = document.getElementById('Amount2').value;
	var earn = document.getElementById('Amount2').value * document.getElementById('price2').value;
		$.get("system/calculatefees.php?P=" + earn,function(data,status){
		  document.getElementById('fee2').value = data;
		});

	}

	//page transitions
    $(document).ready(function() {
			
        $("#contentloader").slideDown(500, function() {
            $('.spinner').fadeOut();
        });
			
        $("a").click(function(event){

            event.preventDefault();

            linkLocation = this.href;
            
            $("#contentloader").slideUp(500, function() {
                $('.spinner').fadeIn(300, redirectPage);
            });    
        });
         
        function redirectPage() {
            window.location = linkLocation;
        }
    });
	//chat funcs
	$(document).ready(function() {
		//load messages
		setTimeout(function(){ 
        $('#messages').load('ajaxLOAD.php', function() {
            $('#messages').scrollTop($("#messages")[0].scrollHeight);
        });
		}, 1000);
		$('#ajaxPOST').submit(function() {
			$.post('ajaxPOST.php', $('#ajaxPOST').serialize(), function(data){
                            //clear the message field
                            $('#message').val('');
                            //reload messages
                            $('#messages').load('ajaxLOAD.php', function() {
                                // standard scroll:
                                // $('#messages').scrollTop($("#messages")[0].scrollHeight);
                                // smooth scroll:
                                $('#messages').animate({
                                    scrollTop: $('#messages')[0].scrollHeight
                                  }, 1000);
                            }); //.delay(1000).scrollTop($("#messages")[0].scrollHeight);
			});
			return false; 
		});
    });
	//sanitize messages
	$('#message').keypress(function(event){
    var char = String.fromCharCode(event.which)
    var txt = $(this).val()

    if (! txt.match(/^[^A-Za-z0-9+#\-\.]+$/)){
        $(this).val(txt.replace(char, ''));
    }
	});

</script>
</head>
<body>
<div class="meny">
	<div id="chat-wrapper">
	<div id="messages"></div>
	<?php
	if (isUserLoggedIn()){ 
	
	echo'
	<form id="ajaxPOST" history="off" autocomplete="off">
		<div class="fields">
			<input type="text" id="message" maxlength="255" name="message" />
		</div>
		<div class="actions">
			<input type="submit" id="chat-submit" value="Post Message" />
		</div>
	</form>';
	
	} else {
	
	echo'
	<div id="LoggedOut"></br><b><center>You must be logged in to chat</center></b></div>';
	
	
	} 
	
	?>
	</div>
</div>
<div class="meny-arrow"></div>

<div class="contents"
<div class="contents_outer">

	<div class="contents_inner">
	
		<div class="framecontentLeft color" id="resizeHeight">
			<div class="innertube">

			</div>
		</div>
		
		<div class="framecontentRight color" id="resizeHeight">
			<div class="innertube">
				<?php 
				
				if(isUserLoggedIn()) {
				$account = $loggedInUser->display_username;
				/*
				echo'<div class="user_area">';
				echo '<h6>Welcome'.$account.'!</h6>';	
				echo'</div>';
				*/
				}
				?>
				<div class="markets_right">
					<center><i class="fa fa-bar-chart-o fa-2x" style="color: #fff;">Markets</i></center>
					<ul id="markets" class="markets">
					<?php
						$sqlx = mysql_query("SELECT * FROM Wallets ORDER BY `Acronymn` ASC");

						while ($row = mysql_fetch_assoc($sqlx)) {
						if($row["Market_Id"] == 0)
						{
							
						}
						else
						{
							$sqls_2 = mysql_query("SELECT * FROM Trade_History WHERE `Market_Id`='". $row["Id"] . "' ORDER BY Timestamp DESC");
							
							$last_trade = mysql_result($sqls_2,0,"Price");
							
						?>
						<li class='left' ><a href='index.php?page=trade&market=<?php echo $row["Id"]; ?>'><?php echo $row["Acronymn"];?> / BTC<?php echo "<font class='price'>".sprintf("%2.8f",$last_trade)."</font>"; ?></a></li>
						<?php
						
						}
						}
					?>
					</ul>
				</div>
			</div>
		</div>

		<div class="framecontentTop color">
		<div class="innertube">
			<div class="menu_top">
				<ul class="flatflipbuttons">
					<li class="logo"><a href="https://openex.pw"><span><img src="assets/img/OpenEx-header.png" /></span></a> <b>OpenEx</b></li>
					<li class="square"><a href="index.php?page=home"><span><i class="fa fa-home fa-2x"></i></span></a> <b>Home</b></li>
					<li class="square"><a href="index.php?page=about"><span><i class="fa fa-info fa-2x"></i></span></a> <b>About</b></li>
					<?php
					if(!isUserLoggedIn()){ 
					echo
					'
					<li class="square"><a href="index.php?page=login"><span><i class="fa fa-power-off fa-2x"></i></span></a> <b>Login</b></li>
					<li class="square"><a href="index.php?page=register"><span><i class="fa fa-edit fa-2x"></i></span></a> <b>Register</b></li>
					';
					}else{
					echo
					'
					<li class="square"><a href="index.php?page=logout"><span><i class="fa fa-power-off fa-2x"></i></span></a> <b>Logout</b></li>
					';
					}
					?>
					<li class="square"><a href="https://openex.mobi"><span><i class="fa fa-mobile fa-2x"></i></span></a> <b>Mobile</b></li>
					<li class="square"><a href="https://openex.info"><span><i class="fa fa-comments-o fa-2x"></i></span></a> <b>Forums</b></li>
					<li class="square"><a href="https://twitter.com/_OpenEx_"><span><i class="fa fa-twitter fa-2x"></i></span></a> <b>Twitter</b></li>
					<li class="square"><a href="https://github.com/r3wt/openex.git"><span><i class="fa fa-github fa-2x"></i></span></a> <b>Github</b></li>
				</ul>
			</div>
		</div>
		</div>

		<div class="framecontentBottom color">
		<div class="innertube">

			<center><pre></pre></center>

		</div>
		</div>


		<div class="maincontent color" id="resizeHeight">
		<div class="innertube">
			<div class="user_menu">
				<ul class="flatflipbuttons">
					<?php
					if(isUserLoggedIn()){ 
					echo 
					'
					<li class="square"><a href="index.php?page=account"><span><i class="fa fa-suitcase fa-2x"></i></span></a><b>Account</b></li>
					<li class="square"><a href="index.php?page=support"><span><i class="fa fa-warning fa-2x"></i></span></a> <b>Support</b></li>
					<li class="square"><a href="index.php?page=preferences"><span><i class="fa fa-cogs fa-2x"></i></span></a> <b>Settings</b></li>
					';
					} else {
					
					}

					if(isUserAdmin($id)){ 
					echo
					'
					<li class="square"><a href="index.php?page=admin"><span><i class="fa fa-terminal fa-2x"></i></span></a> <b>Admin</b></li>
					<li class="square"><a href="index.php?page=site_monitor"><span><i class="fa fa-tachometer fa-2x"></i></span></a> <b>Monitor</b></li>
					';
					} else {
					
					}

					if(isUserMod($id)){
					echo'
					<li class="square"><a href="index.php?page=moderate"><span><i class="fa fa-gavel fa-2x"></i></span></a> <b>Moderate</b></li>
					';
					} else {
					
					}
					?>
				</ul>
			</div>
			<div id="contentloader" class="color" >
			<center>
			<div id="contentchild">
				<div class="spinner"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
				<?php
					if($_GET["page"] == "")
					{
						if(isUserLoggedIn())
					{
						include("pages/account.php");
					}else{
						include("pages/home.php");
					}
					}else{
						include("pages/".$_GET["page"].".php");
					}
				?>
			</center>
			</div>
			</div>
		</div>
		</div>
	</div>
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
	width: 380,

	// [optional] Distance from mouse (in pixels) when menu should open
	threshold: 40,

	// [optional] Use mouse movement to automatically open/close
	mouse: true,

	// [optional] Use touch swipe events to open/close
	touch: true
});
</script>	
</body>
</html>

