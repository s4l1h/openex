<?php

require_once("models/config.php");
//browsercheck_index();
//forceSSL();
$account = $loggedInUser->display_username;
$id = $loggedInUser->user_id;
if(isTORnode()){
	die("Due to legal restrictions users using TOR Browser are not allowed to access this website.");
}
if(isIPbanned()) {
	die("ip address is banned.");
}
if(isMobile_RedirectDisabled()) {
}else{
	mobile_listen();
}
if(isMaintenanceDisabled()) {
}else{
	if(!isUserAdmin($id)) {
	echo '<meta http-equiv="refresh" content="0; URL='.$maint_url.'">';
	die();
	}
}

//basic bot detection
echo '<input type="hidden" value="" name="fullname">';
$is_bot = mysql_real_escape_string($_POST["fullname"]);
if(isset($_POST["fullname"])) {
	if($is_bot != "") {
		echo '<meta http-equiv="refresh" content="0; URL=access_denied.php">';
	}else{
	
	}
}
?>
<html>
<head>
	<title><?php echo $title ?></title>
	<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/trade.css">
	<link rel="stylesheet" type="text/css" href="assets/css/tables.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css" />
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	$('document').ready(function() {
		$('#chat_toggle').click(function() {
			$('#chatbox').slideToggle();
		});
	});
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
	$(document).ready(function() {

		var refreshChat = function() 
		{ 
		 setTimeout( 
		  function() 
		  {
		   $('#messages').load('ajaxLOAD.php', 
			function() 
			{
			 $('#messages').animate({scrollTop: $('#messages')[0].scrollHeight}, 1000);
			}
		   );
		   refreshChat();
		  }, 
		  2000);
		};
		refreshChat();

		<?php 

			// Start Matt Smiths Code
			if(isset($_GET['page'])) {
				if($_GET['page'] == 'trade') {
					?>

					var MarketId = <?php echo($_GET['market']); ?>;
					var refreshOrderbooks = function() {
						setTimeout(function() {
							$("#sellorders").load('./pages/open_orders_from.php?market=' + MarketId,
								function() 
								{
									// Add animation here if you'd like
								});

							$("#buyorders").load('./pages/open_orders_to.php?market=' + MarketId,
								function() 
								{
									// Add animation here if you'd like
								});

							refreshOrderbooks();
						}, 
						10000);
					}
					refreshOrderbooks();

					<?php
				}
			}

			// End Matt Smiths Code
		?>
		$('#ajaxPOST').submit(function() {
			$.post('ajaxPOST.php', $('#ajaxPOST').serialize(), function(data){
                            $('#message').val('');
                            $('#messages').load('ajaxLOAD.php', function() {
                                $('#messages').animate({
                                    scrollTop: $('#messages')[0].scrollHeight
                                  }, 1000);
                            }); 
			});
			return false; 
		});

    });
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
	<div id="header" class="semi-translucent color">
		<div id="logo">
		<img src="assets/img/OpenEx.png" height="30" alt="OpenEx.pw"/>
		</div>
		<div id="menu_nest" class="menu_nest">
			<ul class="nobullets mainmenu">
				<li><a href="index.php?page=home" title="home"><i class="fa fa-home"></i></a></li>
				<li><a href="index.php?page=about" title="about"><i class="fa fa-info"></i></a></li>
				<?php
				if(!isUserLoggedIn()){ 
				echo
				'
				<li><a href="index.php?page=login" title="login"><i class="fa fa-power-off"></i></a></li>
				<li><a href="index.php?page=register" title="register"><i class="fa fa-edit"></i></a></li>
				';
				}else{
				echo
				'
				<li><a href="index.php?page=logout" title="logout"><i class="fa fa-power-off"></i></a></li>
				';
				}
				?>
				<!--<li><a href="https://openex.mobi" title="mobile sit"><i class="fa fa-mobile"></i></a></li>
				<li><a href="https://openex.info" target="_blank" title="forums"><i class="fa fa-comments-o"></i></a></li>-->
				<li><a class="blank" href="https://twitter.com/_OpenEx_" target="_blank" title="Follow us on Twitter"><i class="fa fa-twitter"></i></a></li>
				<li><a class="blank" href="https://github.com/r3wt/openex.git" target="_blank" title="View source on Github"><i class="fa fa-github"></i></a></li>
				<?php
				if(isUserLoggedIn()){ 
				echo 
				'
				<li><a href="index.php?page=account" title="account balances"><i class="fa fa-suitcase"></i></a></li>
				<li><a href="index.php?page=support" title="support system"><i class="fa fa-warning"></i></a></li>
				<li><a href="index.php?page=preferences" title="account preferences"><i class="fa fa-cogs"></i></a></li>
				';
				} else {
				
				}

				if(isUserAdmin($id)){ 
				echo
				'
				<li><a href="index.php?page=admin" title="admin area"><i class="fa fa-terminal"></i></a></li>
				<li><a href="index.php?page=site_monitor" title="site monitor"><i class="fa fa-tachometer"></i></a></li>
				<li><a href="index.php?page=moderate" title="moderator area"><i class="fa fa-gavel"></i></a></li>
				';
				} else {
				
				}

				if(isUserMod($id)){
				echo'
				<li><a href="index.php?page=moderate" title="moderator area"><i class="fa fa-gavel"></i></a></li>
				';
				} else {
				
				}
				?>
			</ul>
		</div>
	</div>
	
	<div id="markets" class="semi-translucent color2">
		<center><i class="fa fa-bar-chart-o fa-2x" style="color: #fff;">Markets</i></center>
		<ul class="nobullets">
		<?php
			$sqlx = mysql_query("SELECT * FROM Wallets ORDER BY `Acronymn` ASC");

			while ($row = @mysql_fetch_assoc($sqlx)) {
			if($row["Market_Id"] == 0)
			{
				
			}
			else
			{
				$sqls_2 = @mysql_query("SELECT * FROM Trade_History WHERE `Market_Id`='". $row["Id"] . "' ORDER BY Timestamp DESC");
				
				$last_trade = @mysql_result($sqls_2,0,"Price");
				
			?>
			<li class='left' ><p title="Trade <?php echo $row["Name"] ?>" onclick="window.location = 'index.php?page=trade&market=<?php echo $row["Id"]; ?>';"><?php echo $row["Acronymn"];?> / BTC<?php echo "<font class='price'>".sprintf("%2.8f",$last_trade)."</font>"; ?></p></li>
			<?php
			
			}
			}
		?>
		</ul>
	</div>
	
	<div id="main_content">
		<div id="contentloader">
			<center>
			<div id="contentchild">
				<div class="spinner"><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i><i></i></div>
				<?php
					if($_GET["page"] == "")
					{
						if(isUserLoggedIn())
						{
							include("pages/account.php");
						} 
						else 
						{
							include("pages/home.php");
						}
					} 
					else
					{
						include("pages/".$_GET["page"].".php");
					}
				?>
			</center>
			</div>
		</div>
	</div>
	
	<div id="bar" class="semi-translucent color">
		<button id="chat_toggle" class="semi-translucent color toggle"><img src="assets/img/chat_icon.png" height="24" alt="Chat"></button>
	</div>
	
	<div id="chatbox" class="color3 border-no-bottom glow">
			<hr class="five" />
			<div id="messages"></div>
			<?php
			if (isUserLoggedIn()){ 
			
				echo'
				<hr class="five" />
				<div id="message-wrap">
				<form id="ajaxPOST" history="off" autocomplete="off">
					<div class="fields">
						<input type="text" id="message" maxlength="255" name="message" />
					</div>
					<div class="actions">
						<input type="submit" id="chat-submit" value="Post Message" />
					</div>
				</form>
				</div>
				';
			
			} else {
			
				echo'
				<hr class="five" />
				<div id="LoggedOut"><b><center>You must be logged in to chat</center></b></div>
				';
			
			} 
			
			?>
		</div>
</body>

</html>