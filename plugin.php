<?php
/*
Plugin Name: TCBD WooCommerce reCAPTCHA
Plugin URI: http://tcoderbd.com
Description: This plugin will enable to add Google reCAPTCHA in your woocommerce single product page.
Author: Md Touhidul Sadeek
Version: 1.0
Author URI: http://tcoderbd.com
*/

/*  Copyright 2017 tCoderBD (email: hello@tcoderbd.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

function TCBD_WooCommerce_reCAPTCHA() {
	add_plugins_page( 'TCBD WooCommerce reCAPTCHA', 'TCBD WooCommerce reCAPTCHA', 'update_core', 'TCBD_WooCommerce_reCAPTCHA', 'tcbd_woo_re_settings_page');
}
add_action( 'admin_menu', 'TCBD_WooCommerce_reCAPTCHA' );

function tcbd_woo_re_register_settings() {
	register_setting( 'tcbd_woo_go_re_register_setting', 'tcbd_woo_site_key' );
	register_setting( 'tcbd_woo_go_re_register_setting', 'tcbd_woo_secret_key' );
	register_setting( 'tcbd_woo_go_re_register_setting', 'tcbd_woo_re' );
}
add_action( 'admin_init', 'tcbd_woo_re_register_settings' );
	
function tcbd_woo_re_settings_page(){ // settings page function

	if( get_option('tcbd_woo_site_key') ){
		$tcbd_woo_site_key = get_option('tcbd_woo_site_key');
	}
	
	if( get_option('tcbd_woo_secret_key') ){
		$tcbd_woo_secret_key = get_option('tcbd_woo_secret_key');
	}	
	
	?>
		<div class="wrap">
			<h2 style="margin-bottom: 30px;">TCBD WooCommerce reCAPTCHA</h2>
			
			<?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] ){ ?>
				<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
					<p><strong>Settings saved.</strong></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>
			<?php } ?>
		
			
			<form method="post" action="options.php">
				<?php settings_fields( 'tcbd_woo_go_re_register_setting' ); ?>
				
				<div class="updated settings-error notice is-dismissible">
					<h1>Important Notification</h1>
					<p></p>
					<p><strong>For the Google reCAPTCHA extension to work on your site you need to generate site and secret keys. If you already have the keys you can skip the next section. If you do not have your reCAPTCHA details already then click the “Generate your site and secret key” button where you will be taken to the official Google reCAPTCHA website.</strong> </p>
					<p>To generate your site and secret keys please visit the <a href="https://www.google.com/recaptcha/admin" target="_BLANK">Google reCAPTCHA</a> site and click the blue “Get reCAPTCHA” button to login to the website using your Google account.</p>
					<p>To create your site and secret key please do the following:</p>
					<ol>
						<li>
							Enter a label for your site e.g Ultimate Member.
						</li>
						<li>
							Enter your site’s domain name in the text area (do not include http:// or www and make sure you do not have a forward slash / at end of url).
						</li>
						<li>
							Click the register button
						</li>
						<li>
							Once you click register your site will be registered with Google reCAPTCHA and you will be redirected to the site overview page which contains the keys. The only two pieces of information you need from this page are the site key and secret key.
						</li>
						<li>
							Paste your site key and secret key and press 'Save Changes'.
						</li>
					</ol>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>
				
				<table class="form-table">
					<tbody>
					
						<tr>
							<th scope="row"><label for="tcbd_woo_site_key">Site key:</label></th>
							<td>
								<input class="regular-text" name="tcbd_woo_site_key" type="text" id="tcbd_woo_site_key" value="<?php echo esc_attr( $tcbd_woo_site_key ); ?>"required>
							</td>
						</tr>
					
						<tr>
							<th scope="row"><label for="tcbd_woo_secret_key">Secret key:</label></th>
							<td>
								<input class="regular-text" name="tcbd_woo_secret_key" type="text" id="tcbd_woo_secret_key" value="<?php echo esc_attr( $tcbd_woo_secret_key ); ?>" required>
							</td>
						</tr>
													
						<tr>
							<th scope="row"><label for="tcbd_woo_re">reCAPTCHA:</label></th>
							<td>
								<?php
									if( get_option( 'tcbd_woo_re' ) ){
										$tcbd_woo_on = get_option( 'tcbd_woo_re' );
									}
								?>
								<label for="tcbd_woo_re">
									<input type="checkbox" id="tcbd_woo_re" name="tcbd_woo_re" value="1" <?php checked( 1, $tcbd_woo_on ); ?>>
									On
								</label>
							</td>
						</tr>
						
					</tbody>
				</table>
				
				<p class="submit"><input id="submit" class="button button-primary" type="submit" name="submit" value="Save Changes"></p>
			</form>
			
		</div>
	<?php
} // settings page function


// Add settings page link in before activate/deactivate links.
function tcbd_woocommerce_recaptcha_plugin_action_links( $actions, $plugin_file ){
	
	static $plugin;

	if ( !isset($plugin) ){
		$plugin = plugin_basename(__FILE__);
	}
		
	if ($plugin == $plugin_file) {
		
		if ( is_ssl() ) {
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=TCBD_WooCommerce_reCAPTCHA', 'https' ).'">Settings</a>';
		}else{
			$settings_link = '<a href="'.admin_url( 'plugins.php?page=TCBD_WooCommerce_reCAPTCHA', 'http' ).'">Settings</a>';
		}
		
		$settings = array($settings_link);
		
		$actions = array_merge($settings, $actions);
			
	}
	
	return $actions;
	
}
add_filter( 'plugin_action_links', 'tcbd_woocommerce_recaptcha_plugin_action_links', 10, 5 );

if(get_option('tcbd_woo_re') == 1){
		
	function tcbd_google_re_add_recaptcha_head(){
		echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
	}
	add_action( 'wp_head', 'tcbd_google_re_add_recaptcha_head');

	function tcbd_add_content_after_addtocart_button_func() {
		
		$site_key = get_option('tcbd_woo_site_key');
		$secret = get_option('tcbd_woo_secret_key');
		
		if( $site_key and $secret = !null ){
			echo '<div style="margin: 15px 0;" class="g-recaptcha" data-sitekey="'.$site_key.'"></div>';
		} else {
			if( is_admin() ){
				wc_add_notice( __( 'Please add your Google reCAPTCHA <a href="'.home_url().'/wp-admin/plugins.php?page=TCBD_WooCommerce_reCAPTCHA">site key and secret key</a>!', 'woocommerce' ), 'error' );	
			}
		}
		
	}
	add_action( 'woocommerce_before_add_to_cart_button', 'tcbd_add_content_after_addtocart_button_func' );


	function tcbd_add_the_date_validation( $passed ) { 

		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
			

			$secret = get_option('tcbd_woo_secret_key');

			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
			$response = json_decode($verifyResponse);
			if(!isset($response->success)) {
				wc_add_notice( __( 'Invalid captcha!', 'woocommerce' ), 'error' );
			}
			
			return $passed;
		}
		else {
			wc_add_notice( __( 'Please click on the reCAPTCHA box!', 'woocommerce' ), 'error' );
		}
		
	}
	add_action( 'woocommerce_add_to_cart_validation', 'tcbd_add_the_date_validation', 10, 5 ); 
}