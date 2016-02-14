<?php
/**
 * Advanced Term Fields: Featured Images
 *
 * @package Advanced_Term_Fields_Images
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     0.1.1
 *
 * Plugin Name: Advanced Term Fields: Featured Images
 * Plugin URI:  http://darrinb.com/plugins/advanced-term-fields-images
 * Description: Easily assign featured images for categories, tags, and custom taxonomy terms.
 * Version:     0.1.1
 * Author:      Darrin Boutote
 * Author URI:  http://darrinb.com
 * Text Domain: atf-images
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
 * @internal Nobody should be able to overrule the real version number
 * as this can cause serious issues, so no if ( ! defined() )
 *
 * @since 0.1.1
 */
define( 'ATF_IMAGES_VERSION', '0.1.1' );


if ( ! defined( 'ATF_IMAGES_FILE' ) ) {
	define( 'ATF_IMAGES_FILE', __FILE__ );
}


/**
 * Load Utilities
 *
 * @since 0.1.1
 */
include dirname( __FILE__ ) . '/inc/functions.php';


/**
 * Checks compatibility
 *
 * @since 0.1.0
 */
add_action( 'plugins_loaded', '_atf_images_compatibility_check', 99 );


/**
 * Instantiates main Advanced Term Fields: Featured Images class
 *
 * @since 0.1.0
 */
function _atf_images_init() {

	if ( ! _atf_images_compatibility_check() ){ return; }

	include dirname( __FILE__ ) . '/inc/class-adv-term-fields-images.php';

	$Adv_Term_Fields_Images = new Adv_Term_Fields_Images( __FILE__ );
	$Adv_Term_Fields_Images->init();

}
add_action( 'init', '_atf_images_init', 99 );


/**
 * Run actions on plugin upgrade
 *
 * @since 0.1.1
 */
add_action( "atf__thumbnail_id_version_upgraded", '_atf_images_version_upgraded_notice', 10, 5 );
add_action( "atf__thumbnail_id_version_upgraded", '_atf_images_maybe_update_meta_key', 10, 5 );