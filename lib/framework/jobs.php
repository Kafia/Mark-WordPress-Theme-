<?php

/*
*
* Author: FrogsThemes
*
*
*/

if ( ! function_exists( 'job_taxonomies' ) ) {
	function job_taxonomies() 
	{
		// taxonomy labels
		$labels = array(
			'name' 					=>  __('Departments', 'frogsthemes'),
			'singular_name' 		=>  __('Department', 'frogsthemes'),
			'search_items' 		=>  __('Search Departments', 'frogsthemes'),
			'all_items' 			=>  __('All Departments', 'frogsthemes'),
			'parent_item' 			=>  __('Parent Department', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Department:', 'frogsthemes'),
			'edit_item'	 		=>  __('Edit Department', 'frogsthemes'), 
			'update_item' 			=>  __('Update Department', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Department', 'frogsthemes'),
			'new_item_name' 		=>  __('New Department', 'frogsthemes'),
			'menu_name' 			=>  __('Departments', 'frogsthemes'),
		);
		// register taxonomy
		register_taxonomy('department',array('job'), array(
			'hierarchical' 		=> true,
			'labels' 				=> $labels,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'department'),
		));
	}
}

if ( ! function_exists( 'job_post_type' ) ) {
	function job_post_type() {
	 	
		// labels
		$labels = array(
			'name' 					=>  __('Jobs', 'frogsthemes'),
			'singular_name' 		=>  __('Job', 'frogsthemes'),
			'add_new' 				=>  __('Add Job', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Job', 'frogsthemes'),
			'edit_item' 			=>  __('Edit Job', 'frogsthemes'),
			'new_item' 			=>  __('New Job', 'frogsthemes'),
			'view_item' 			=>  __('View Jobs', 'frogsthemes'),
			'search_items' 		=>  __('Search Jobs', 'frogsthemes'),
			'not_found' 			=>  __('Nothing found', 'frogsthemes'),
			'not_found_in_trash' 	=>  __('Nothing found in Trash', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Job:', 'frogsthemes'),
		);
	 	// options
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'job'),
			'has_archive' 			=> false,
			'capability_type' 		=> 'post',
			'exclude_from_search'	=> true,
			'hierarchical' 		=> true,
			'menu_position' 		=> null,
			'menu_icon' 			=> get_bloginfo('template_directory').'/lib/assets/images/icons/jobs.png',
			'supports' 			=> array('title','editor')
		); 
		// register
		register_post_type('job' , $args);
		//flush_rewrite_rules();
	}
}

// initialise taxonomies and post type
add_action('init', 'job_taxonomies');
add_action('init', 'job_post_type');

?>