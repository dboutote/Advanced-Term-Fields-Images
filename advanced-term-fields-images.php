<?php
/**
 * Advanced Term Fields: Featured Images
 *
 * @package Advanced_Term_Fields_Images
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     0.1.0
 *
 * Plugin Name: Advanced Term Fields: Featured Images
 * Plugin URI:  http://darrinb.com/plugins/advanced-term-fields-images
 * Description: Easily assign featured images for categories, tags, and custom taxonomy terms.
 * Version:     0.1.0
 * Author:      Darrin Boutote
 * Author URI:  http://darrinb.com
 * Text Domain: adv-term-fields-images
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Checks compatibility
 *
 * @uses _atf_images_plugin_deactivate()
 * @uses _atf_images_plugin_admin_notice()
 *
 * @since 0.1.0
 *
 * @return void
 */
function _atf_images_compatibility_check(){
	if ( ! class_exists( 'Advanced_Term_Fields' ) ) :
		add_action( 'admin_init', '_atf_images_plugin_deactivate');
		add_action( 'admin_notices', '_atf_images_plugin_admin_notice');
		return;
	endif;

	define( 'ATF_IMAGES_COMPAT', true );
}
add_action( 'plugins_loaded', '_atf_images_compatibility_check', 99 );


/**
 * Deactivates plugin
 *
 * @since 0.1.0
 *
 * @return void
 */
function _atf_images_plugin_deactivate() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}


/**
 * Displays deactivation notice
 *
 * @since 0.1.0
 *
 * @return void
 */
function _atf_images_plugin_admin_notice() {
	echo '<div class="error"><p>'
		. sprintf(
			__( '%1$s requires the %2$s plugin to function correctly. Unable to activate at this time.', 'wptt' ),
			'<strong>' . esc_html( 'Advanced Term Fields: Featured Images' ) . '</strong>',
			'<strong>' . esc_html( 'Advanced Term Fields' ) . '</strong>'
			)
		. '</p></div>';

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}


/**
 * Instantiates main Advanced Term Fields: Featured Images class
 *
 * @since 0.1.0
 */
function _atf_images_init() {

	if( ! defined( 'ATF_IMAGES_COMPAT' ) ){ return; }

	include dirname( __FILE__ ) . '/inc/class-adv-term-fields-images.php';

	$Adv_Term_Fields_Images = new Adv_Term_Fields_Images( __FILE__ );
	$Adv_Term_Fields_Images->init();

}
add_action( 'init', '_atf_images_init', 99 );
