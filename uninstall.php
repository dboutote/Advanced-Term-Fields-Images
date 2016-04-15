<?php
/**
 * Advanced Term Images Uninstall actions
 *
 * Removes all options set by the plugin.
 * Note: Does NOT remove term meta.
 * 
 * @since 1.0
 */
 

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// remove our options
delete_option( 'atf__thumbnail_id_version' );
delete_options( '_thumbnail_id_key_updated' );
