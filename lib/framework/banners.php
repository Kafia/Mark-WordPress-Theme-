<?php

/*
*
* Author: FrogsThemes
*
*
*/

if ( ! function_exists( 'banner_post_type' ) ) {
	function banner_post_type() {
	 	
		// labels
		$labels = array(
			'name' 					=>  __('Home Banners', 'frogsthemes'),
			'singular_name' 		=>  __('Banner', 'frogsthemes'),
			'add_new' 				=>  __('Add Banner', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Banner', 'frogsthemes'),
			'edit_item' 			=>  __('Edit Banner', 'frogsthemes'),
			'new_item' 			=>  __('New Banner', 'frogsthemes'),
			'view_item' 			=>  __('View Banner', 'frogsthemes'),
			'search_items' 		=>  __('Search Banners', 'frogsthemes'),
			'not_found' 			=>  __('Nothing found', 'frogsthemes'),
			'not_found_in_trash' 	=>  __('Nothing found in Trash', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Banner:', 'frogsthemes'),
		);
	 	// options
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'publicly_queryable' 	=> false,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'banner'),
			'has_archive' 			=> false,
			'capability_type' 		=> 'post',
			'exclude_from_search' => true,
			'hierarchical' 		=> true,
			'menu_position' 		=> null,
			'menu_icon' 			=> get_bloginfo('template_directory').'/lib/assets/images/icons/home-banners.png',
			'supports' 			=> array('title')
		); 
		// register
		register_post_type('banner' , $args);
		//flush_rewrite_rules();
	}
}


// initialise post type
add_action('init', 'banner_post_type');

?>