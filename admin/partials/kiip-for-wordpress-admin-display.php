<?php
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
	die;
}

/**
 * Provides a admin area view for the plugin
 * Plugin URI: https://wordpress.org/plugins/kiip/
 * Version: 3.1.6
 * @author     Will Radford <radford.will@gmail.com>
 * @link       https://github.com/radfordwill/
 * @since      1.0.0
 *
 * @package kiip
 */

/**
 * Provides an admin area view for the plugi. Mobile views and wide screen views are supported
 * (Bootstrap 3 css\js and Wordpress css)
 *
 *
 */

$plugin_data = kiip_for_wordpress::init();
$plugin_name_version = $plugin_data->get_plugin_data()[ 'Name' ] . ' v' . $plugin_data->get_plugin_data()[ 'Version' ];
$kiip_plugin_url = $plugin_data->kiip_the_url();
$kiip_plugin_lang = kiip_for_wordpress::TEXTDOMAIN;
$kiip_plugin_textarea = $plugin_data->kiip_admin_page_textarea();


?> <!-- This file  primarily consists of HTML with a little bit of PHP. -->
<div class="wrap body-kiip">
	<div class="row">
		<div class="col-lg-4">
			<h1>
				<!-- place holder for admin notice -->
			</h1>
		</div>
	</div>
	<!-- Content -->
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<img class="img-thumbnail" alt="<?php _e('Kiip for Wordpress', $kiip_plugin_lang)?>" src="<?php echo $kiip_plugin_url; ?>assets/images/banner-772x250.png" width="375" height="145" alt=""/>
				<p class="font-weight-bold small">
					<?php _e('Kiip is a marketing and monetization platform unique in style and user reward platforms.', $kiip_plugin_lang)?>
				</p>
				<p class="font-weight-bold small">
					<?php _e('User retention is an important aspect for wordpress websites with subscribers, crm\'s and more.', $kiip_plugin_lang)?>
				</p>
				<p class="font-weight-bold small">
					<?php _e('Reward your users and monetize your website today!', $kiip_plugin_lang)?>
				</p>
				<p class="font-weight-bold small">
					<?php _e('Make ad revenue. Create rewards and user retention.', $kiip_plugin_lang)?>
				</p>
			</div>
			<div class="col-lg-4">
				<table style="text-align:center">
					<?php /* Donation Form */ ?>
					<div id="submitdiv" class="form" style="padding: 6px; margin-top:20px; border-left: 5px solid   #FF0000;">
						<hr/>
						<h3 class="font-weight-bold">
							<?php _e('Please consider making a donation so I can keep up support for this plugin. You can donate any amount.', $kiip_plugin_lang)?>
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
									<input class="input-group-sm" type="text" name="amount" value="" required="required" placeholder="<?php _e('Enter amount', $kiip_plugin_lang)?>" class="regular-text ltr">
								</td>
								<td>
									<input type="image" src="<?php echo $kiip_plugin_url; ?>assets/images/x-click-butcc-donate.gif" border="0" name="submit" alt="Make Donations with Paypal">
								</td>
							</tr>
					</div>
				</table>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 ">
				<p>
					<?php _e('Editor Buttons', $kiip_plugin_lang)?> <br><img class="rounded float-left img-thumbnail" src="<?php echo $kiip_plugin_url; ?>assets/images/mce-shortcode-scr-shot.png" alt="shortcodes screenshot"/><br>
					<span class="float-right">
						<?php _e('Shortcode buttons in the post and page editors.  Easily add Kiip Moments with buttons, links and automatic pop ups.  Add the type of ad moment you want with just a few clicks!', $kiip_plugin_lang)?>
					</span>
				</p>
				<p>
					<?php _e('Widgets', $kiip_plugin_lang)?><br>
					<?php _e('A widget has been added in WP Widgets page to use the container(small) moment anywhere you can add your widgets in themes.', $kiip_plugin_lang)?>
				</p>
				<p></p>
				<kbd>Shortcodes List</kbd><br>
				<?php /* @TODO: define min lines for textarea?*/?>
				<?php echo $kiip_plugin_textarea; ?>
			</div>
			<div class="col-lg-4 align-baseline">
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<div class="alert">
					<?php // @TODO: add to a separate row\column ?>
					<p class="font-weight-bold" style="min-height: 300px;">&nbsp;</p>
					<p class="font-weight-bold">
						<?php _e('1. Fullscreen Moment- Opens a kiip moment immediately when the visitor opens the page.', $kiip_plugin_lang)?>
					</p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">
						<?php _e('2. Container Moment- Loads a kiip moment in a smaller container. Ideal for html widgets in sidebars. Sidebar must be 350px to 400px in width.', $kiip_plugin_lang)?>
					</p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">
						<?php _e('3. Onscroll Moment- Opens a moment immediately after the visitor get to the bottom of the page.', $kiip_plugin_lang)?>
					</p>
					<p class="font-weight-bold">&nbsp;</p>
					<p class="font-weight-bold">
						<?php _e('4. Onclick Moment- Add a link or a button in the wordpress editor.', $kiip_plugin_lang)?>
					</p>
					<p class="font-weight-bold">&nbsp;</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="lead">
					<a class="dashicons dashicons-admin-links text-nowrap" href="https://app.kiip.me/register/dev_verify" target="new">
						<?php _e('Sign up for the kiip.me developer key', $kiip_plugin_lang)?>
					</a>
				</p>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="lead">
					<strong>
						<?php _e('Kiip for WP Settings', $kiip_plugin_lang)?>
					</strong>
				</p>
				<form method="post" action="options.php">
					<?php settings_fields( 'kiip-settings-group' ); ?>
					<?php do_settings_sections( 'kiip-settings-group' ); ?>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><span class="small text-danger">*<?php _e('Required', $kiip_plugin_lang)?></span>
							</th>
							<td>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Kiip Developer Public Key', $kiip_plugin_lang)?><span class="small text-danger">*</span>
							</th>
							<td><input required type="text" name="public_key" value="<?php echo esc_attr( get_option('public_key') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Moment Name', $kiip_plugin_lang)?>
							</th>
							<td><input type="text" name="test_mode_post_moment" value="<?php echo esc_attr( get_option('test_mode_post_moment') ); ?> "/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Test Mode', $kiip_plugin_lang)?>
							</th>
							<td><input type="checkbox" name="is_test_mode" "<?php
			if (!get_option('is_test_mode') || get_option('is_test_mode') == 'off')
           {
	        echo "value='off' ";
           }
			else echo "value='on' ". " checked " ?> /">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Test Mode Email', $kiip_plugin_lang)?>
							</th>
							<td><input type="text" name="test_mode_email" value="<?php echo esc_attr( get_option('test_mode_email') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Test Mode User ID', $kiip_plugin_lang)?>
							</th>
							<td><input type="text" name="test_mode_userid" value="<?php echo esc_attr( get_option('test_mode_userid') ); ?>"/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row">
								<?php _e('Clicklable Element Class', $kiip_plugin_lang)?>
							</th>
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

			<div class="col-lg-4 align-baseline footer-span">

				<span class="text-white small">
					<p class="font-weight-bold">
						<?php _e($plugin_name_version, $kiip_plugin_lang)?>
					</p>
					<p class="font-weight-bold small footer-span">*
						<?php _e('kiip logos and branding are reg. trademarks of', $kiip_plugin_lang)?>
						<a class="footer-link dashicons dashicons-admin-links text-nowrap" href="http://kiip.me" title="Kiip Inc website" target="_blank">
							<?php _e('Kiip, Inc.', $kiip_plugin_lang)?>&trade;</a>
					</p>
				</span>

			</div>

			<?php if( isset($_GET['settings-updated']) ) { ?>
			<div class=”updated”>
				<div class="notice notice-success is-dismissible col-xs-4">
					<strong>
						<?php _e('Settings Saved.', $kiip_plugin_lang)?>
					</strong>
				</div>
				<?php } ?>
			</div>
	</footer>
	</div>
