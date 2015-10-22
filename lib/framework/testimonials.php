<?php

/*
*
* Author: FrogsThemes
*
*
*/

if ( ! function_exists( 'testimonial_post_type' ) ) {
	function testimonial_post_type() {
	 	
		// labels
		$labels = array(
			'name' 					=>  __('Testimonials', 'frogsthemes'),
			'singular_name' 		=>  __('Testimonial', 'frogsthemes'),
			'add_new' 				=>  __('Add Testimonial', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Testimonial', 'frogsthemes'),
			'edit_item' 			=>  __('Edit Testimonial', 'frogsthemes'),
			'new_item' 			=>  __('New Testimonial', 'frogsthemes'),
			'view_item' 			=>  __('View Testimonial', 'frogsthemes'),
			'search_items' 		=>  __('Search Testimonials', 'frogsthemes'),
			'not_found' 			=>  __('Nothing found', 'frogsthemes'),
			'not_found_in_trash' 	=>  __('Nothing found in Trash', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Testimonial:', 'frogsthemes'),
		);
	 	// options
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'publicly_queryable' 	=> false,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'testimonial'),
			'has_archive' 			=> false,
			'capability_type' 		=> 'post',
			'exclude_from_search' => true,
			'hierarchical' 		=> true,
			'menu_position' 		=> null,
			'menu_icon' 			=> get_bloginfo('template_directory').'/lib/assets/images/icons/testimonials.png',
			'supports' 			=> array('title')
		); 
		// register
		register_post_type('testimonial' , $args);
		//flush_rewrite_rules();
	}
}


// initialise post type
add_action('init', 'testimonial_post_type');

?>