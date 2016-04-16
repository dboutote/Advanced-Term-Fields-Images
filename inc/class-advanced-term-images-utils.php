<?php

/**
 * Advanced Term Images Utilities Class
 *
 * All methods are static, this is basically a namespacing class wrapper.
 *
 * @package Advanced_Term_Images
 * @subpackage Advanced_Term_Images_Utils
 *
 * @since 0.1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Advanced_Term_Images_Utils Class
 *
 * Group of utility methods for use by Advanced_Term_Images
 *
 * @version 0.1.1 Added check for update.
 * @version 0.1.0
 *
 * @since 0.1.0
 */
class Advanced_Term_Images_Utils
{

	/**
	 * Name of plugin
	 *
	 * @since 0.1.1
	 *
	 * @var string
	 */
	public static $plugin_version = ATF_IMAGES_VERSION;


	/**
	 * Name of plugin
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public static $plugin_name = 'Advanced Term Images';


	/**
	 * Minimum WP version required for this plugin
	 *
	 * @since 0.1.0
	 *
	 * @var string
	 */
	public static $required_wp_version = '4.4';


	/**
	 * Minimum PHP version required for this plugin
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public static $required_php_version = '5.3';


	/**
	 * Loads compatibility check
	 *
	 * @uses Advanced_Term_Images_Utils::compatible_version()
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function compatibility_check()
	{
		if ( ! self::compatible_version() ) {
			add_action( 'admin_init', array( __CLASS__, 'plugin_deactivate') );
			add_action( 'admin_notices', array( __CLASS__, 'plugin_compatibility_notice') );
			return;
		}

		define( 'ATF_IMAGES_IS_COMPATIBLE', true );
	}



	/**
	 * Deactivates plugin
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function plugin_deactivate()
	{
		deactivate_plugins( plugin_basename( ATF_IMAGES_FILE ) );
	}


	/**
	 * Displays deactivation notice
	 *
	 * @uses Advanced_Term_Images_Utils::$plugin_name
	 * @uses Advanced_Term_Images_Utils::$required_wp_version
	 *
	 * @since 0.1.0
	 *
	 * @return void
	 */
	public static function plugin_compatibility_notice()
	{
		printf( '<div class="error"><p>%1$s</p></div>',
			sprintf( __( '%1$s requires WordPress %2$s and PHP %3$s to function correctly. We detected WordPress %4$s and PHP %5$s. Unable to activate at this time.', 'atf-images' ),
				'<strong>' . esc_html( self::$plugin_name ) . '</strong>',
				'<strong>' . esc_html( self::$required_wp_version ) . '</strong>',
				'<strong>' . esc_html( self::$required_php_version ) . '</strong>',
				'<strong>' . esc_html( $GLOBALS['wp_version'] ) . '</strong>',
				'<strong>' . esc_html( PHP_VERSION ) . '</strong>'
			)
		);

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}


	/**
	 * Checks for compatibility with current version of WordPress
	 *
	 * @see Advanced_Term_Images_Utils::$required_wp_version
	 * @see Advanced_Term_Images_Utils::$required_php_version
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if current version of WP is greater than or equal to required version,
	 *              false if not.
	 */
	private static function compatible_version()
	{
		if ( version_compare( $GLOBALS['wp_version'], self::$required_wp_version, '>=' ) &&
			version_compare( PHP_VERSION, self::$required_php_version, '>=' )
		) {
			return true;
		}

		return false;
	}


	/**
	 * Updates meta key to protected on upgrade
	 *
	 * Prior to v0.1.1 meta keys were stored non-protected, i.e. "thumbnail_id".  As of v0.1.1 meta keys
	 * were stored as protected, i.e. "_thumbnail_id" with a prefixed underscore "_".  This function
	 * updates all old versions of the stored meta key. It will only be run once, on upgrade to any
	 * version higher than 0.1.0.
	 *
	 * @since 1.0 namespaced option key to "atf_{$meta_key}_key_updated"
	 *
	 * @since 0.1.1
	 *
	 * @return mixed bool|integer False on failure, number of rows affected on success.
	 */
	public static function maybe_update_meta_key( $updated, $db_version_key, $plugin_version, $db_version, $meta_key )
	{
		$old_key = 'thumbnail_id';

		if ( ! $updated ) {
			return;
		}

		/**
		 * If the new key is set, return
		 * @since 1.0
		 */
		if( get_option( "atf_{$meta_key}_key_updated" ) ) {
			return;
		}

		if( get_option( "{$meta_key}_key_updated" ) ){
			update_option( "atf_{$meta_key}_key_updated", get_option( "{$meta_key}_key_updated" ) );
			delete_option( "{$meta_key}_key_updated" );
			return;
		}

		global $wpdb;

		$updated_keys = $wpdb->update(
			$wpdb->termmeta,
			array( 'meta_key' => $meta_key ),
			array( 'meta_key' => $old_key ),
			array( '%s' ),
			array( '%s' )
		);

		if ( false !== $updated_keys ) {
			$now = time();
			update_option( "atf_{$meta_key}_key_updated", $updated_keys . ':' . $now );
		}

		return $updated_keys;
	}


	/**
	 * Displays upgrade notice
	 *
	 * @since 0.1.1
	 *
	 * @param bool   $updated        True|False flag for option being updated.
	 * @param string $db_version_key The database key for the plugin version.
	 * @param string $plugin_version The most recent plugin version.
	 * @param string $db_version     The plugin version stored in the database pre upgrade.
	 * @param string $meta_key       The meta field key.
	 *
	 * @return void
	 */
	public static function version_upgraded_notice( $updated, $db_version_key, $plugin_version, $db_version, $meta_key )
	{
		if ( $updated ) {

			$display_msg = sprintf(
				'<div class="updated notice is-dismissible"><p><b>%1$s</b> has been upgraded to version <b>%2$s</b></p></div>',
				__( 'Advanced Term Images', 'atf-images' ),
				$plugin_version
			);

			add_action('admin_notices', function() use ( $display_msg ) {
				echo $display_msg;
			});

		}
	}

}