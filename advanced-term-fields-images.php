<?php
/**
 * Advanced Term Images
 *
 * @package Advanced_Term_Images
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     1.0
 *
 * Plugin Name: Advanced Term Images
 * Plugin URI:  http://darrinb.com/plugins/advanced-term-fields-images
 * Description: Easily assign featured images for categories, tags, and custom taxonomy terms.
 * Version:     1.0
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
define( 'ATF_IMAGES_VERSION', '1.0' );


if ( ! defined( 'ATF_IMAGES_FILE' ) ) {
	define( 'ATF_IMAGES_FILE', __FILE__ );
}


/**
 * Loads Utilities
 *
 * @since 0.1.1
 */
include dirname( __FILE__ ) . '/inc/class-advanced-term-images-utils.php';


/**
 * Checks compatibility
 *
 * @since 0.1.0
 */
add_action( 'plugins_loaded', array( 'Advanced_Term_Images_Utils', 'compatibility_check' ), 99 );


/**
 * Instantiates main Advanced Term Images class
 *
 * @since 0.1.0
 */
function _atf_images_init() {

	if( ! defined( 'ATF_IMAGES_IS_COMPATIBLE' ) || ! ATF_IMAGES_IS_COMPATIBLE ) { return; }

	/**
	 * Load core framework
	 *
	 * Note: this replaces the Advanced Term Fields framework plugin
	 * @see https://make.wordpress.org/plugins/2016/03/01/please-do-not-submit-frameworks/
	 *
	 * @since 1.0
	 */
	include dirname( __FILE__ ) . '/lib/adv-term-fields/class-advanced-term-fields.php';

	include dirname( __FILE__ ) . '/inc/class-advanced-term-images.php';

	$Advanced_Term_Images = new Advanced_Term_Images( __FILE__ );
	$Advanced_Term_Images->init();

}
add_action( 'init', '_atf_images_init', 99 );


/**
 * Runs actions on plugin upgrade
 *
 * @since 0.1.1
 */
add_action( "atf__thumbnail_id_version_upgraded", array( 'Advanced_Term_Images_Utils', 'version_upgraded_notice' ), 10, 5 );
add_action( "atf__thumbnail_id_version_upgraded", array( 'Advanced_Term_Images_Utils', 'maybe_update_meta_key' ), 10, 5 );