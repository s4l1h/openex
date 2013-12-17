
<div class="container">
	<div class="innertube">
		<div class="tiles first">
			<div class="innertube">
			<?php 
			$account = $loggedInUser->display_username;

			if(isUserLoggedIn()) {
			echo '<h4>Welcome back '.$account.'!</h4>';
			echo '';
			echo '';
			} else {
			echo '<h4>Welcome to OpenEx!</h4>';
			}
			?>
			</div>
		</div>
		<div class="tiles third">
			<div class="innertube">
			</div>
		</div>
		<div class="tiles second">
		second div
		</div>
		<div class="tiles fourth">
		fourth div
		</div>
		<div class="tiles last">
		last div
		</div>
	</div>
</div>