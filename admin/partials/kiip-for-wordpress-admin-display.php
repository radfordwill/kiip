<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Provide a admin area view for the plugin

 * Plugin URI: https://wordpress.org/plugins/kiip/
 * Version: 3.1.2
 * @author     Will Radford <radford.will@gmail.com>
 * @link       http://radford.online/
 * @since      1.0.0
 *
 * @package kiip
 */

/**
 * Provides an admin area view for the plugin (WP CSS)
 *
 *
 */

$plugin_data = new kiip_for_wordpress();
$plugin_name_version = $plugin_data->get_plugin_data()[ 'Name' ] . ' v' . $plugin_data->get_plugin_data()[ 'Version' ];
$kiip_plugin_url = $plugin_data->kiip_the_url();

?> <!-- This file  primarily consists of HTML with a little bit of PHP. -->
<div class="wrap body-kiip">
<div class="row">
<div class="col-lg-4">
<h1><!-- place holder for admin notice --></h1>
</div>
</div>
	<!-- Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<img class="img-thumbnail" alt="kiip-for-wp" src="<?php echo $kiip_plugin_url; ?>assets/images/kiip-for-wp.png" width="150" height="150" alt=""/>
				<p class="font-weight-bold small">Kiip is a marketing and monetization platform unique in style and user reward platforms.</p>
				<p class="font-weight-bold small">User retention is an important aspect for wordpress websites with subscribers, crm's and more.</p>
				<p class="font-weight-bold small">Reward your users and monetize your website today!</p>
				<p class="font-weight-bold small">Make ad revenue. Create rewards and user retention.</p>
			</div>
			<div class="col-lg-4">
				<table style="text-align:center">
					<?php /* Donation Form */ ?>
					<div id="submitdiv" class="form" style="padding: 6px; margin-top:20px; border-left: 5px solid   #FF0000;">
						<hr/>
						<h3 class="font-weight-bold">
							<?php echo 'Please consider making a donation so I can keep up support for this plugin. You can donate any amount.';?>
						</h3>
						<form name="_xclick" action="https://www.paypal.com/yt/cgi-bin/webscr" method="post">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="business" value="power.sell2002@gmail.com">
							<input type="hidden" name="item_name" value="Kiip For Wordpress - Donations">
							<input type="hidden" name="currency_code" value="USD">
							<tr class="bg-primary">
								<th scope="row">
									<label for="paypal_amount"><span class="glyphicon glyphicon-usd"></span></label>
								</th>
								<td class="input-group-sm">
									<input class="input-group-sm" type="text" name="amount" value="" required="required" placeholder="Enter amount" class="regular-text ltr">
								</td>
								<td>
									<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make Donations with Paypal">
								</td>
							</tr>
					</div>
				</table>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 ">

					<p>NEW!<br> A widget has been added in WP Widgets page to use the container(small) moment anywhere you can add your widgets in themes.</p>
					<p></p>
					<kbd>Shortcodes List</kbd><br>
					<div class="microlight"><?php print('<span class="odd">1. </span><p>&#91;kiip_ad_shortcode type="fullscreen"&#93;</p>'."".'

<span class="even">2. </span><p>&#91;kiip_ad_shortcode type="contained"&#93;</p>'.''."".'

<span class="odd">3. </span><p>&#91;kiip_ad_shortcode type="fullscreen-onscroll"&#93;</p>'.''."".'

<span class="even">4. </span><p>&#91;kiip_ad_shortcode type="fullscreen-onclick"&#93;</p>'.""

													   ) ?></div>

			</div>
			<div class="col-lg-4 align-baseline">
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<div class="alert">
					<p class="font-weight-bold">1. Fullscreen Moment- Opens a kiip moment immediately when the visitor opens the page. </p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">2. Container Moment- Loads a kiip moment in a smaller container. Ideal for html widgets in sidebars. Sidebar must be a minimum of 400p px in width.</p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">3. Onscroll Moment- Opens a moment immediately after the visitor get to the bottom of the page. </p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">4. Onclick Moment- Add a link or a button with the class you define in the admin and make anything a kiip poptart(popup) moment. Add a class to the link or button in the wordpress editor eg. <i>class = "kiip-moment"</i>
					</p>
					<p class="font-weight-bold">&nbsp;</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="lead">
	<a class="dashicons dashicons-admin-links text-nowrap" href="https://app.kiip.me/register/dev_verify" target="new">Sign up for the kiip.me developer key</a>
	</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="lead"><strong>Kiip for WP Settings</strong></p>
				<form method="post" action="options.php">
					<?php settings_fields( 'kiip-settings-group' ); ?>
					<?php do_settings_sections( 'kiip-settings-group' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><span class="small text-danger">*Required</span>
							</th>
							<td>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">Kiip Developer Public Key<span class="small text-danger">*</span>
							</th>
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
					</table>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<span class="text-muted">
				<p class="font-weight-bold L9">
					<?php echo( $plugin_name_version ); ?>
				</p>
				<p class="font-weight-bold small">*kiip logos and branding are reg. trademarks of <a class="footer-link dashicons dashicons-admin-links text-nowrap" href="http://kiip.me" title="Kiip Inc website" target="_blank">Kiip, Inc.</a>
				</p>
			</span>
			<?php if( isset($_GET['settings-updated']) ) { ?>
			<div class=”updated”>
				<div class="notice notice-success is-dismissible col-xs-4">
					<strong>
						<?php echo 'Settings Saved.'; ?>
					</strong>
				</div>
		<?php } ?>
		</div>
	</footer>
</div>
