<?php

// Tell WordPress to run ft_setup() when the 'after_setup_theme' hook is run
add_action( 'after_setup_theme', 'ft_setup' );

if ( ! function_exists( 'ft_setup' ) ){
	function ft_setup() {
		
		// allow post thumbnails
		add_theme_support('post-thumbnails');
	
		// image sizes
		add_image_size('post-inner', 870, 9999);
		add_image_size('related', 270, 160, true);
		add_image_size('masonry', 370, 250, true);
		add_image_size('staff', 270, 280, true);
		
		// post formats
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'link', 'quote', 'audio' ) );
		
		// register nav menus
		register_nav_menus( array(
			'top-nav' => __('Top Navigation', 'frogsthemes')
		) );
	}
}


/**
 * Load scripts
 *
 * @since 1.0
 */
 
if ( ! function_exists( 'ft_loadscripts' ) ){
	function ft_loadscripts(){
			
		$template_dir = get_bloginfo('template_directory');
		
		wp_deregister_script( 'isotope' );
		wp_deregister_script( 'flexslider' );
		
		// all js files should be added in here where possible
		wp_enqueue_script('bootstrap', $template_dir . '/lib/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '3.0.3', true);
		wp_enqueue_script('detectmobilebrowser', $template_dir . '/lib/assets/js/detectmobilebrowser.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('gmap3', $template_dir . '/lib/assets/js/gmap3.min.js', array('jquery'), '5.1.1', true);
		wp_enqueue_script('appear', $template_dir . '/lib/assets/js/jquery.appear.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('isotope', $template_dir . '/lib/assets/js/jquery.isotope.min.js', array('jquery'), '1.5.25', true);
		wp_enqueue_script('ba-bbq', $template_dir . '/lib/assets/js/jquery.ba-bbq.min.js', array('jquery'), '1.3', true);
		wp_enqueue_script('countTo', $template_dir . '/lib/assets/js/jquery.countTo.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('jplayer', $template_dir . '/lib/assets/js/jquery.fitvids.js', array('jquery'), '1.0.3', true);
		wp_enqueue_script('fitvids', $template_dir . '/lib/assets/js/jquery.jplayer.min.js', array('jquery'), '2.0.0', true);
		wp_enqueue_script('flexslider', $template_dir . '/lib/assets/js/jquery.flexslider-min.js', array('jquery'), '2.2.2', true);
		wp_enqueue_script('magnific-popup', $template_dir . '/lib/assets/js/jquery.magnific-popup.min.js', array('jquery'), '0.9.9', true);
		wp_enqueue_script('YTPlayer', $template_dir . '/lib/assets/js/jquery.mb.YTPlayer.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('placeholder', $template_dir . '/lib/assets/js/jquery.placeholder.min.js', array('jquery'), '1.0.0', true);
		wp_enqueue_script('retina', $template_dir . '/lib/assets/js/retina-1.1.0.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('storyjs', $template_dir . '/lib/assets/js/timeline/js/storyjs-embed.js', array('jquery'), '2.29.0', true);
		wp_enqueue_script('main', $template_dir . '/lib/assets/js/main.js', array('jquery','bootstrap','detectmobilebrowser','gmap3','appear','isotope','ba-bbq','countTo','jplayer','fitvids','flexslider','magnific-popup','YTPlayer','placeholder','retina','storyjs'), '1.0.0', true);	
	
	}
}
add_action('wp_enqueue_scripts', 'ft_loadscripts');



/**
 * Admin scripts
 *
 * @since 1.0
 */
 
if ( ! function_exists( 'ft_admin_loadscripts' ) ){
	function ft_admin_loadscripts(){
    	wp_enqueue_script('admin', get_bloginfo('template_url').'/lib/admin/assets/js/admin.js', array('jquery'));
	}
}
add_action('admin_enqueue_scripts', 'ft_admin_loadscripts');


/**
 * goes into wp_footer();
 *
 * @since 1.0
 */
 
if ( ! function_exists( 'frogs_wp_footer' ) ):
	function frogs_wp_footer(){	
		if(of_get_option('ft_custom_js'))
		{
			echo "\n<script type=\"text/javascript\">\n" . of_get_option('ft_custom_js') . "</script>\n";
		}
	}
	add_action('wp_footer', 'frogs_wp_footer');
endif;

?>