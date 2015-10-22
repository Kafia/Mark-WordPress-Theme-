<?php

/*
*
* Author: FrogsThemes
*
*
*/

if ( ! function_exists( 'portfolio_taxonomies' ) ) {
	function portfolio_taxonomies() 
	{
		// taxonomy labels
		$labels = array(
			'name' 					=>  __('Categories', 'frogsthemes'),
			'singular_name' 		=>  __('Category', 'frogsthemes'),
			'search_items' 		=>  __('Search Categories', 'frogsthemes'),
			'all_items' 			=>  __('All Categories', 'frogsthemes'),
			'parent_item' 			=>  __('Parent Category', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Category:', 'frogsthemes'),
			'edit_item'	 		=>  __('Edit Category', 'frogsthemes'), 
			'update_item' 			=>  __('Update Category', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Category', 'frogsthemes'),
			'new_item_name' 		=>  __('New Category', 'frogsthemes'),
			'menu_name' 			=>  __('Categories', 'frogsthemes'),
		);
		// register taxonomy
		register_taxonomy('portfolio-category',array('portfolio'), array(
			'hierarchical' 		=> true,
			'labels' 				=> $labels,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'portfolio-category'),
		));
	}
}

if ( ! function_exists( 'portfolio_post_type' ) ) {
	function portfolio_post_type() {
	 	
		// labels
		$labels = array(
			'name' 					=>  __('Portfolio', 'frogsthemes'),
			'singular_name' 		=>  __('Portfolio Item', 'frogsthemes'),
			'add_new' 				=>  __('Add Portfolio Item', 'frogsthemes'),
			'add_new_item' 		=>  __('Add New Portfolio Item', 'frogsthemes'),
			'edit_item' 			=>  __('Edit Portfolio Item', 'frogsthemes'),
			'new_item' 			=>  __('New Portfolio Item', 'frogsthemes'),
			'view_item' 			=>  __('View Portfolio Items', 'frogsthemes'),
			'search_items' 		=>  __('Search Portfolio Items', 'frogsthemes'),
			'not_found' 			=>  __('Nothing found', 'frogsthemes'),
			'not_found_in_trash' 	=>  __('Nothing found in Trash', 'frogsthemes'),
			'parent_item_colon' 	=>  __('Parent Portfolio Item:', 'frogsthemes'),
		);
	 	// options
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> true,
			'publicly_queryable' 	=> true,
			'show_ui' 				=> true,
			'query_var' 			=> true,
			'rewrite' 				=> array('with_front' => true, 'slug' => 'portfolio'),
			'has_archive' 			=> false,
			'capability_type' 		=> 'post',
			'exclude_from_search'	=> true,
			'hierarchical' 		=> true,
			'menu_position' 		=> null,
			'menu_icon' 			=> get_bloginfo('template_directory').'/lib/assets/images/icons/portfolio.png',
			'supports' 			=> array('title','editor','thumbnail')
		); 
		// register
		register_post_type('portfolio' , $args);
		//flush_rewrite_rules();
	}
}

// initialise taxonomies and post type
add_action('init', 'portfolio_taxonomies');
add_action('init', 'portfolio_post_type');

?>