<?php
/*
Plugin Name: Meta Box
Plugin URI: http://www.deluxeblogtips.com/meta-box
Description: Create meta box for editing pages in WordPress. Compatible with custom post types since WP 3.0
Version: 4.2.4
Author: Rilwis
Author URI: http://www.deluxeblogtips.com
License: GPL2+
*/

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Script version, used to add version for scripts and styles
define( 'RWMB_VER', '4.3.3' );

define( 'RWMB_JS_URL', trailingslashit( FT_METABOX_URL ) . 'js/' );
define( 'RWMB_CSS_URL', trailingslashit( FT_METABOX_URL ) . 'css/' );

define( 'RWMB_INC_DIR', trailingslashit( FT_METABOX_DIR ) . 'inc/' );
define( 'RWMB_FIELDS_DIR', trailingslashit( RWMB_INC_DIR ) . 'fields/' );
define( 'RWMB_CLASSES_DIR', trailingslashit( RWMB_INC_DIR ) . 'classes/' );

// Optimize code for loading plugin files ONLY on admin side
// @see http://www.deluxeblogtips.com/?p=345

// Helper function to retrieve meta value
require_once trailingslashit( RWMB_INC_DIR ) . 'helpers.php';

if ( is_admin() )
{
	require_once trailingslashit( RWMB_INC_DIR ) . 'common.php';

	// Field classes
	foreach ( glob( RWMB_FIELDS_DIR . '*.php' ) as $file )
	{
		require_once $file;
	}

	// Main file
	require_once trailingslashit( RWMB_CLASSES_DIR ) . 'meta-box.php';
}