<?php


/* 
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 */

if ( !function_exists( 'of_get_option' ) ) {
	function of_get_option($name, $default = false) {
		
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
		
		if ( get_option($option_name) ) {
			$options = get_option($option_name);
		}
			
		if ( isset($options[$name]) ) {
			return $options[$name];
		} else {
			return $default;
		}
	}
}


/* 
 * This is an example of how to override the default location and name of options.php
 * In this example it has been renamed options-renamed.php and moved into the folder extensions
 */

add_filter('options_framework_location','options_framework_location_override');

if ( !function_exists( 'options_framework_location_override' ) ) {
	function options_framework_location_override() {
		return array('/lib/admin/options-framework-init.php');
	}
}

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 *
 */

if ( !function_exists( 'optionsframework_option_name' ) ) {
	function optionsframework_option_name() {
	
		// This gets the theme name from the stylesheet (lowercase and without spaces)
		$themename = get_option( 'stylesheet' );
		$themename = preg_replace("/\W/", "_", strtolower($themename) );
	
		$optionsframework_settings = get_option('optionsframework');
		$optionsframework_settings['id'] = $themename;
		update_option('optionsframework', $optionsframework_settings);
	}
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

if ( !function_exists( 'optionsframework_options' ) ) {
	function optionsframework_options() {
		
		// Pull all the pages into an array
		$options_pages = array();  
		$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
		$options_pages[''] = 'Select a page:';
		foreach ($options_pages_obj as $page):
			$options_pages[$page->ID] = $page->post_title;
		endforeach;
	
		// If using image radio buttons, define a directory path
		$imagepath =  get_template_directory_uri() . '/lib/assets/images/icons/';
	
		$options = array();
		
		$options[] = array(
			'name' 		=> __('General Settings', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array(
			'name' 		=> __('Favicon', 'frogsthemes'),
			'desc' 		=> __('To upload your favicon to the site, simply add the URL to it or upload and select it using the Upload button here.', 'frogsthemes'),
			'id' 		=> 'ft_custom_favicon',
			'type' 		=> 'upload');
			
		$options[] = array(
			'name' 		=> __('RSS Link', 'frogsthemes'),
			'desc' 		=> __('Add in the URL of your RSS feed here to overwrite the defaut WordPress ones.', 'frogsthemes'),
			'id' 		=> 'ft_rss',
			'type' 		=> 'text');
			
		$options[] = array(
			'name' 		=> __('Custom CSS', 'frogsthemes'),
			'desc' 		=> __('Not 100% happy with our lovely styles? Here you can add some custom CSS if you require minor changes to the ones we\'ve created. We won\'t be offended, honest :)', 'frogsthemes'),
			'id' 		=> 'ft_custom_css',
			'type' 		=> 'textarea');	
			
		$options[] = array(
			'name' 		=> __('Google Analytics (or custom Javascript)', 'frogsthemes'),
			'desc' 		=> __('If you\'re hooked up with Google Analytics you can paste the Javascript includes for it here (without the script tags). Or alternatively if you just want some custom Javascript added on top of ours, add that here too.', 'frogsthemes'),
			'id' 		=> 'ft_custom_js',
			'type' 		=> 'textarea');
			
		$options[] = array( 
			'name' 		=> __( 'Show Breadcrumb Trail?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will show the breadcrumb trail on all pages in the header.', 'frogsthemes'),
			'id' 		=> 'ft_show_breadcrumbs',
			'std' 		=> '1',
			'type' 		=> 'checkbox');
		
		$options[] = array(
			'name' 		=> __( 'Application Form ID', 'frogsthemes'),
			'id' 		=> 'ft_application_form_id',
			'desc'		=> 'If you have added an applcation form for the jobs section of your site using the Contact Form & plugin, you can add the ID of the form here for it to be pulled out automatically.',
			'std' 		=> '',
			'type' 		=> 'text');	
		
		$options[] = array(
			'name' 		=> __('Header', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array(
			'name' 		=> __('Custom Logo', 'frogsthemes'),
			'desc' 		=> __('To upload a custom logo, simply add the URL to it or upload and select it using the Upload button here.', 'frogsthemes'),
			'id' 		=> 'ft_custom_logo',
			'type' 		=> 'upload');
		
		$options[] = array(
			'name' 		=> __( 'Header Text', 'frogsthemes'),
			'id' 		=> 'ft_header_text',
			'des'		=> 'You can add some text to the header if you like. Keep it short and sweet mind; nobody likes a waffler :)',
			'std' 		=> '',
			'type' 		=> 'text');	
			
		$options[] = array( 
			'name' 		=> __( 'Contact Telephone', 'frogsthemes'),
			'desc' 		=> __('Enter your contact telephone number here to go in the header.', 'frogsthemes'),
			'id' 		=> 'ft_header_phone',
			'type' 		=> 'text');
		
		$options[] = array(
			'name' 		=> __('Footer', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array( 
			'name' 		=> __('Copyright Text', 'frogsthemes'),
			'desc' 		=> __('Enter the text for your copyright here.', 'frogsthemes'),
			'id' 		=> 'ft_footer_copyright',
			'type' 		=> 'text');
							
		$options[] = array( 
			'name' 		=> __( 'Hide FrogsThemes Link?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will hide our link :\'( <--sad face', 'frogsthemes'),
			'id' 		=> 'ft_hide_ft_link',
			'std' 		=> '0',
			'type' 		=> 'checkbox');
		
		$options[] = array( 
			'name' 		=> __( 'Blog', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array( 
			'name' 		=> __( 'Style', 'frogsthemes'),
			'desc' 		=> __('Select if you prefer the blog to be as a list or in masonry.', 'frogsthemes'),
			'id' 		=> 'ft_blog_style',
			'options' 	=> array('list' => __('List', 'frogsthemes'), 'masonry' => __('Masonry', 'frogsthemes')),
			'std'		=> 'list',
			'type' 		=> 'select');
		
		$options[] = array( 
			'name' 		=> __( 'Show Share Links?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will show the share links on all posts.', 'frogsthemes'),
			'id' 		=> 'ft_show_share_links',
			'std' 		=> '1',
			'type' 		=> 'checkbox');
		
		$options[] = array( 
			'name' 		=> __( 'Show Author Box?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will show the author box on all posts.', 'frogsthemes'),
			'id' 		=> 'ft_show_author',
			'std' 		=> '1',
			'type' 		=> 'checkbox');
			
		$options[] = array( 
			'name' 		=> __( 'Show Next/Previous Links?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will show the next/previous post links on all posts.', 'frogsthemes'),
			'id' 		=> 'ft_show_next_prev',
			'std' 		=> '1',
			'type' 		=> 'checkbox');
			
		$options[] = array( 
			'name' 		=> __( 'Show Related Posts?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will show the related posts section. These are related by tag.', 'frogsthemes'),
			'id' 		=> 'ft_show_related_posts',
			'std' 		=> '1',
			'type' 		=> 'checkbox');
		
		$options[] = array( 
			'name' 		=> __( 'Slider', 'frogsthemes'),
			'type' 		=> 'heading');
			
		$options[] = array( 
			'name' 		=> __( 'Speed of Transition', 'frogsthemes'),
			'desc' 		=> __('Enter the speed you would like the transition to be in milliseconds (1000 = 1 second).', 'frogsthemes'),
			'id' 		=> 'ft_slider_speed',
			'std'		=> '600',
			'type' 		=> 'text');
		
		$options[] = array( 
			'name' 		=> __( 'Pause Time', 'frogsthemes'),
			'desc' 		=> __('Enter the time you would like the gallery to pause between transitions in milliseconds (1000 = 1 second).', 'frogsthemes'),
			'id' 		=> 'ft_slider_pause',
			'std'		=> '7000',
			'type' 		=> 'text');
		
		$options[] = array( 
			'name' 		=> __( 'Auto Start?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will automatically start the gallery.', 'frogsthemes'),
			'id' 		=> 'ft_slider_auto_start',
			'std' 		=> '0',
			'type' 		=> 'checkbox');
		
		$options[] = array( 
			'name' 		=> __( 'Auto Loop?', 'frogsthemes'),
			'desc' 		=> __('If checked, this will automatically loop through the gallery.', 'frogsthemes'),
			'id' 		=> 'ft_slider_loop',
			'std' 		=> '0',
			'type' 		=> 'checkbox');
		/*	
		$options[] = array( 
			'name' 		=> __( 'Animation Type', 'frogsthemes'),
			'desc' 		=> __('Select which effect you would like to use when going between slides.', 'frogsthemes'),
			'id' 		=> 'ft_slider_transition',
			'options' 	=> array('fade' => __('Fade', 'frogsthemes'), 'slide' => __('Slide', 'frogsthemes')),
			'std'		=> 'fade',
			'type' 		=> 'select');
		*/
		$options[] = array( 
			'name' 		=> __( 'Connections', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array( 
			'name' 		=> __( 'Facebook URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full Facebook URL here.', 'frogsthemes'),
			'id' 		=> 'ft_facebook',
			'type' 		=> 'text');
		
		$options[] = array( 
			'name' 		=> __( 'Twitter URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full Twitter URL here.', 'frogsthemes'),
			'id' 		=> 'ft_twitter',
			'type' 		=> 'text');
							
		$options[] = array( 
			'name' 		=> __( 'Google+ URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full Google+ URL here.', 'frogsthemes'),
			'id' 		=> 'ft_google_plus',
			'type' 		=> 'text');
							
		$options[] = array( 
			'name' 		=> __( 'LinkedIn URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full LinkedIn URL here.', 'frogsthemes'),
			'id' 		=> 'ft_linkedin',
			'type' 		=> 'text');
			
		$options[] = array( 
			'name' 		=> __( 'Pinterest URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full Pinterest URL here.', 'frogsthemes'),
			'id' 		=> 'ft_pinterest',
			'type' 		=> 'text');
		
		$options[] = array( 
			'name' 		=> __( 'YouTube URL', 'frogsthemes'),
			'desc' 		=> __('Enter your full YouTube URL here.', 'frogsthemes'),
			'id' 		=> 'ft_youtube',
			'type' 		=> 'text');
							
		$options[] = array(
			'name' 		=> __( 'Twitter API Options', 'frogsthemes'),
			'type' 		=> 'heading');
		
		$options[] = array(
			'name' 		=> __( 'Twitter API', 'frogsthemes'),
			'desc' 		=> __('To use the Twitter API, you need to sign up for an <a href="https://dev.twitter.com/apps" target="_blank">app with Twitter</a>.', 'frogsthemes'),
			'type' 		=> 'info');
		
		$options[] = array(
			'name' 		=> __( 'Consumer Key', 'frogsthemes'),
			'id' 		=> 'consumer_key',
			'type' 		=> 'text');
							
		$options[] = array(
			'name' 		=> __( 'Consumer Secret', 'frogsthemes'),
			'id' 		=> 'consumer_secret',
			'type' 		=> 'text');
							
		$options[] = array(
			'name' 		=> __( 'Access Token', 'frogsthemes'),
			'id' 		=> 'access_token',
			'type' 		=> 'text');
							
		$options[] = array(
			'name' 		=> __( 'Access Token Secret', 'frogsthemes'),
			'id' 		=> 'access_token_secret',
			'type' 		=> 'text');
	
		return apply_filters('optionsframework_options', $options);
	}
}