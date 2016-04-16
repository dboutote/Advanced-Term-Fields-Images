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

$meta_key = '_thumbnail_id';

// remove our options
delete_option( "atf_{$meta_key}_version" );
delete_option( "atf_{$meta_key}_key_updated" );