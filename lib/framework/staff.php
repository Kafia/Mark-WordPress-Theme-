<?php

/*
*
* Author: FrogsThemes
*
*
*/

if ( ! function_exists( 'staff_post_type' ) ) {
	function staff_post_type() {
	 	
		// labels
		$labels = array(
			'name' 					=>  __('Staff', 'frogsthemes'),
			'singular_name' 		=>  __('Staff', 'frogsthemes'),
			'add_new' 				=>  __('Add Staff', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Staff', 'frogsthemes'),
			'edit_item' 			=>  __('Edit Staff', 'frogsthemes'),
			'new_item' 			=>  __('New Staff', 'frogsthemes'),
			'view_item' 			=>  __('View Staff', 'frogsthemes'),
			'search_items' 		=>  __('Search Staff', 'frogsthemes'),
			'not_found' 			=>  __('Nothing found', 'frogsthemes'),
			'not_found_in_trash' 	=>  __('Nothing found in Trash', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Staff:', 'frogsthemes'),
		);
	 	// options
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false,
			'publicly_queryable' 	=> false,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'staff'),
			'has_archive' 			=> false,
			'capability_type' 		=> 'post',
			'exclude_from_search' => true,
			'hierarchical' 		=> true,
			'menu_position' 		=> null,
			'menu_icon' 			=> get_bloginfo('template_directory').'/lib/assets/images/icons/staff.png',
			'supports' 			=> array('title')
		); 
		// register
		register_post_type('staff' , $args);
		//flush_rewrite_rules();
	}
}


// initialise taxonomies and post type
add_action('init', 'staff_post_type');

?>