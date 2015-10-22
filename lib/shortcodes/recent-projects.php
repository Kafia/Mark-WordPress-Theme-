<?php

function recent_projects_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'number' => ''
	), $atts));

	$output  = '';
	
	global $post;
	
	// get recent posts
	$args = array('post_type' => 'portfolio',
				 	'posts_per_page' => $number,
				 	'caller_get_posts' => 1);

	$portfolio_items = new wp_query($args); 
   
	// if posts exist
	if($portfolio_items->have_posts()):
		
		$output  .= '<div id="galleryContainer" class="clearfix">';
		
		// loop through and display them
		while( $portfolio_items->have_posts() ):
			
			$portfolio_items->the_post();
			
			// find and display categories of portfolio items
			$categories = get_the_terms( get_the_ID(), 'portfolio-category' );
			if ($categories && ! is_wp_error($categories )):
				$cat_list = array();
				$cat_list_slug = array();
				foreach ( $categories as $category ):
					$cat_list[] = $category->name;
					$cat_list_slug[] = $category->slug;
				endforeach;
				$types = join( " ", $cat_list_slug );
				$types_comma = join( ", ", $cat_list );
			endif;
	
			if(has_post_thumbnail()):
				$output  .= '<div class="galleryItem '.$types.'">';
				$output  .= '<a href="'.get_the_permalink().'" class="area-hover">';
				$output  .= '<div class="vertical-parent">';
				$output  .= '<div class="vertical-child">';
				$output  .= '<span class="cat-links">'.$types_comma.'</span>';
				$output  .= '<h4 class="entry-title">'.get_the_title().'</h4>';
				$output  .= '</div>';
				$output  .= '</div>';
				$output  .= '</a>';
				$output  .= '<a href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'related').'</a>';
				$output  .= '</div>';
			endif;
		
		endwhile;
		
		$output  .= '</div>';

	endif;
	
	wp_reset_query();
	
	return $output;

}
add_shortcode( 'recent_projects', 'recent_projects_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "recent_projects",
		"name"		=> __("Recent Projects", "frogsthemes"),
		"class"		=> "",
		"icon"      => "recent_projects",
		"description" 	=> __("Gets recent projects and displays them in a full width grid.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Number of Projects to Show", "frogsthemes"),
				"param_name" => "number",
				"value" => "10"
			)
		)
	));
endif;



?>