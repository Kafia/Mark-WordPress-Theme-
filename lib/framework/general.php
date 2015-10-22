<?php

/*
*
* Author: FrogsThemes
* File: General framework functions
*
*
*/


/**
 * Gets ID for the current logged in user
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_user_ID' ) ) {
	function ft_user_ID() {
		
		$current_user = wp_get_current_user();
		return $current_user->ID;

	}
}


/**
 * Gets username for the current logged in user
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_user_name' ) ) {
	function ft_user_name() {
		
		$current_user = wp_get_current_user();
		return $current_user->user_firstname.' '.$current_user->user_lastname;

	}
}


/**
 * current_url function.
 *
 * @access public
 * @param string $url (default: '')
 * @return void
 */
function ft_current_url( $url = '' ) {
	$pageURL  = force_ssl_admin() ? 'https://' : 'http://';
	$pageURL .= esc_attr( $_SERVER['HTTP_HOST'] );
	$pageURL .= esc_attr( $_SERVER['REQUEST_URI'] );

	if ( $url != "nologout" ) {
		if ( ! strpos( $pageURL, '_login=' ) ) {
			$rand_string = md5( uniqid( rand(), true ) );
			$rand_string = substr( $rand_string, 0, 10 );
			$pageURL = add_query_arg( '_login', $rand_string, $pageURL );
		}
	}

	return esc_url_raw( $pageURL );
}


/**
 * Get the URL of the favourites page set in the theme options
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_get_page_url' ) ) {
	function ft_get_page_url($page_to_get) {
		
		$page = '';
		
		if(of_get_option($page_to_get)):
		$page = get_page(of_get_option($page_to_get));
		$page_url = $page->post_name;
		endif;

		return $page_url;
	}
}


/**
 * Get the ID of the page
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_get_page_id' ) ) {
	function ft_get_page_id($page_to_get) {
		
		$page = '';
		
		if(of_get_option($page_to_get)):
		$page = get_page(of_get_option($page_to_get));
		$page_id = $page->ID;
		endif;

		return $page_id;
	}
}


/**
 * Get the title of the page
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_get_page_title' ) ) {
	function ft_get_page_title($page_to_get) {
		
		$title = '';
		
		if(of_get_option($page_to_get)):
		$page = get_page(of_get_option($page_to_get));
		$title = get_the_title($page->ID);
		endif;

		return $title;
	}
}


/**
 * Adds to wp_head in header.php
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_head' ) ) {
	function ft_head() {
		
		// custom favicon
		if(of_get_option('ft_custom_favicon') != ''):
			echo '<link rel="shortcut icon" href="'.  of_get_option('ft_custom_favicon')  .'"/>'."\n";
		endif;
		
		if(of_get_option('ft_custom_css')):
		
			echo "\n<style type=\"text/css\">";
			
			// custom css
			if(of_get_option('ft_custom_css')!=''):
				echo "\n" . of_get_option('ft_custom_css');
			endif;
			
			echo "</style>\n";
			
		endif;

	}
}
add_action( 'wp_head', 'ft_head' );


add_action( 'wpcf7_init', 'wpcf7_add_shortcode_getparam' );

function wpcf7_add_shortcode_getparam() {
    if ( function_exists( 'wpcf7_add_shortcode' ) ) {
        wpcf7_add_shortcode( 'getparam', 'wpcf7_getparam_shortcode_handler', true );
        wpcf7_add_shortcode( 'showparam', 'wpcf7_showparam_shortcode_handler', true );
    }
}

function wpcf7_getparam_shortcode_handler($tag) {
    if (!is_array($tag)) return '';

    $name = $tag['name'];
    if (empty($name)) return '';

    $html = '<input type="hidden" name="' . $name . '" value="'. get_the_title($_GET[$name]) . '" />';
    return $html;
}

function wpcf7_showparam_shortcode_handler($tag) {
    if (!is_array($tag)) return '';

    $name = $tag['name'];
    if (empty($name)) return '';

    $html = $_GET[$name];
    return $html;
}


?>