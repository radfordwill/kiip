<?php

// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}

/**
 * Provide a admin area view for the plugin
 *
 * @link       http://radford.online/
 * @since      1.0.2
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/public
 */

/**
 * Provide a admin area view for the plugin
 *
 *
 * @package    Kiip_For_Wordpress
 * @subpackage Kiip_For_Wordpress/public
 * @author     Will Radford <radford.will@gmail.com>
 */

$plugin_data = new kiip_for_wordpress();
$plugin_name_version = $plugin_data->get_plugin_data()[ 'Name' ] . ' v' . $plugin_data->get_plugin_data()[ 'Version' ];
?> <!-- This file should primarily consist of HTML with a little bit of PHP. -->
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
                <img class="img-thumbnail" alt="kiip-for-wp" src="<?php echo plugins_url( 'kiip_for_wordpress' ); ?>/assets/images/kiip-for-wp.png" width="150" height="150" alt=""/>
            </div>
            <div class="col-lg-4">
                <table style="text-align:center">

                    <?php /* Donation Form */ ?>
                    <div id="submitdiv" class="form" style="padding: 6px; margin-top:20px; border-left: 5px solid   #FF0000;">
                        <hr/>
                        <h3><strong style="color:#000000"><?php _e('Please consider making a donation so I can keep up support for this plugin. You can donate any amount.', 'ffm')?></strong></h3>

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
                                    <input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make Donations with Paypal">
                                </td>
                            </tr>
                    </div>
                </table>
                </form>
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
                            <th scope="row">Load Reward On Pages</th>
                            <td><input type="checkbox" name="test_mode_all_pages" "<?php 
				echo (get_option('test_mode_all_pages')); 
								if (get_option('test_mode_all_pages') == '' || get_option('test_mode_all_pages') == 'off'){} 
								else echo " checked "; ?> /">
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Load Popup Ads</th>
                            <td><input type="checkbox" name="test_mode_popups" "<?php 
			if (get_option('test_mode_popups') == '' || get_option('test_mode_popups') == 'off')
           {
	        echo "value='off' ";
           }
			else echo "value='on' checked " ?> /">
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Load Reward On Posts</th>
                            <td><input type="checkbox" name="test_mode_all_posts" "<?php 
			if (get_option('test_mode_all_posts') == '' || get_option('test_mode_all_posts') == 'off')
           {
	        echo "value='off' ";
           }
			else echo "value='on' checked " ?> /">
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
    <footer class="footer">
        <div class="container">
            <span class="text-muted">
                <?php echo( $plugin_name_version ); ?>
            </span>
        </div>
    </footer>
</div>
<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>