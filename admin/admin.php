<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}
?>
<!-- Bootstrap core CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this page -->
<style>
	.body-kiip {
		padding-top: 54px;
	}
</style>
<div class="wrap body-kiip">
	<!-- Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<img class="img-thumbnail" alt="kiip-for-wp" src="<?php echo plugins_url( 'kiip-for-wp' ); ?>/assets/images/kiip-for-wp.png" width="150" height="150" alt=""/>
			</div>
			<div class="col-lg-4">
			<table style="text-align:center">
			
			<?php /* Donation Form */ ?>
<div id="submitdiv" class="form" style="padding: 6px; margin-top:20px; border-left: 5px solid   #FF0000;">
<hr />
    <h3><strong style="color:#000000"><?php _e('Please make a donation so I can buy stuff. You can donate any amount.', 'ffm')?></strong></h3>
    
    <form name="_xclick" action="https://www.paypal.com/yt/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="power.sell2002@gmail.com">
    <input type="hidden" name="item_name" value="Kiip For Wordpress - Donation">
    <input type="hidden" name="currency_code" value="USD">
<tr class="bg-primary">
<th scope="row" >
<label  for="paypal_amount"><span class="glyphicon glyphicon-usd"></span></label>
</th>
<td>
 <input type="text" name="amount" value="" required="required" placeholder="Enter amount" class="regular-text ltr">
</td>
<td>
 <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make Donations with Paypal">
</td>
</tr>
		</div>
	
	</table></form>
			</div>
			
		</div>
		
		
		<div class="row">
			<div class="col-lg-12">
				<h3 class="lead">
	<a href="https://app.kiip.me/register/dev_verify" target="new">Sign up for the kiip.me developer key</a>
	</h3>
			
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="mt-5">Kiip for WP Settings</h1>
				<p class="small text-danger">*Required</p>
				<form method="post" action="options.php">
					<?php settings_fields( 'kiip-settings-group' ); ?>
					<?php do_settings_sections( 'kiip-settings-group' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row">Kiip Developer Public Key<span class="small text-danger">*</span></th>
							<td><input required type="text" name="public_key" value="<?php echo esc_attr( get_option('public_key') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Moment Name</th>
							<td><input type="text" name="test_mode_post_moment" value="<?php echo esc_attr( get_option('test_mode_post_moment') ); ?> "/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Test Mode</th>
							<td><input type="checkbox" name="is_test_mode" "<?php 
			if (!get_option('is_test_mode') || get_option('is_test_mode') == 'off')
           {
	        echo "value='off' ";
           }
			else echo "value='on' ". " checked " ?> /">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Load Reward On Scrolling To The Bottom Of The Page</th>
							<td><input type="checkbox" name="test_mode_onscroll" "<?php 
			if (get_option('test_mode_onscroll') == '' || get_option('test_mode_onscroll') == 'off')
           {
	        echo "value='off' ";
           }
			else echo "value='on' ". " checked " ?> /">

							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Test Mode Email</th>
							<td><input type="text" name="test_mode_email" value="<?php echo esc_attr( get_option('test_mode_email') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Test Mode User ID</th>
							<td><input type="text" name="test_mode_userid" value="<?php echo esc_attr( get_option('test_mode_userid') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Clicklable Element Class</th>
							<td><input type="text" name="test_mode_set_click" value="<?php echo esc_attr( get_option('test_mode_set_click') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Element Class Ad Container</th>
							<td><input type="text" name="test_mode_set_container" value="<?php echo esc_attr( get_option('test_mode_set_container') ); ?>"/>
							</td>
						</tr>
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>