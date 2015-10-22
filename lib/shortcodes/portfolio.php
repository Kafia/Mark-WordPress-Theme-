<?php

function portfolio_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'view_all_text' => '',
		'layout' => '',
		'show_filters' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$output  = '';

	global $post;
	// get categories for portfolio item
	$cats = get_terms( 'portfolio-category' );
	
	// if it has categories
	if ( $cats && ! is_wp_error( $cats ) && $show_filters == 1 ) : 

		$cats_array = array();
		
		$output  .= '<ul id="galleryFilters" class="option-set clearfix list-unstyled list-inline">';
		$output  .= '<li><a href="#filter=*" class="btn btn-default btn-primary">'.$view_all_text.'</a></li>';
		
		// loop through and add each category id to an array
		foreach ( $cats as $cat ):
			$output  .= '<li><a href="#filter=.'.$cat->slug.'" class="btn btn-default">'.$cat->name.'</a></li>';
		endforeach;
		
		$output  .= '</ul>';
	
	endif;
	
	if($layout == 'cols'):
		$output  .= '<div id="galleryContainer" class="clearfix withSpaces col-3">';
	else:
		$output  .= '<div id="galleryContainer" class="clearfix col-4">';
	endif;
	
	// get latest 4 portfolio items that are in one of those categories, exclusing the id of the current one
	$args = array('post_type' => 'portfolio',
				 	'posts_per_page' => -1,
				 	'caller_get_posts' => 1);

	$portfolio_items = new wp_query($args); 
   
	// if other items in the cateogies exist
	if($portfolio_items->have_posts()):
	
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
			
			if($layout == 'cols'): // columns layout
			
			$output  .= '<div class="galleryItem '.$types.'">';
			$output  .= '<article class="portfolio-item">';
			if(has_post_thumbnail()):
				$output  .= '<div class="portfolio-thumbnail">';
				$output  .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'related').'</a>';
				$output  .= '<a href="'.get_permalink().'" class="overlay-img"><span class="overlay-ico"><i class="fa fa-plus"></i></span></a>';
				$output  .= '</div>';
			endif;
			if ($categories && ! is_wp_error($categories )):
				$output  .= '<div class="entry-meta">';
				$output  .= '<span class="cat-links">'.$types_comma.'</span>';
				$output  .= '</div>';
			endif;
			$output  .= '<h4 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
			$output  .= '</article>';
			$output  .= '</div>';
			
			else: // grid layout

			if(has_post_thumbnail()):		
				$output  .= '<div class="galleryItem '.$types.'">';
				$output  .= '<a href="'.get_permalink().'" class="area-hover imgpopup">';
				$output  .= '<div class="vertical-parent">';
				$output  .= '<div class="vertical-child">';
				$output  .= '<span class="cat-links">'.$types_comma.'</span>';
				$output  .= '<h4 class="entry-title">'.get_the_title().'</h4>';
				$output  .= '</div>';
				$output  .= '</div>';
				$output  .= '</a>';
				$output  .= '<a href="'.get_permalink().'" class="imgpopup">'.get_the_post_thumbnail(get_the_ID(), 'related').'</a>';
				$output  .= '</div>';
			endif;
			
			endif;
		
		endwhile;

	endif;
	
	wp_reset_query();
	
	$output  .= '</div>';
	
	return $output;

}
add_shortcode( 'portfolio', 'portfolio_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "portfolio",
		"name"		=> __("Portfolio", "frogsthemes"),
		"class"		=> "",
		"icon"      => "portfolio",
		"description" 	=> __("Portfolio display.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("View All Text", "frogsthemes"),
				"param_name" => "view_all_text",
				"value" => "View all",
				"description" => __("e.g. 'View all'", "frogsthemes")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Layout", "frogsthemes"),
				"param_name" => "layout",
				"value" => array("3 columns" => "cols", "Grid" => "grid"),
				"admin_label" => true,
				"description" => __("Display as 3 columns or a grid wiht 4 across and no gaps.", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Filters?", "frogsthemes"),
				"param_name" => "show_filters",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the filters.", "frogsthemes")
			)
		)
	));
endif;



?>