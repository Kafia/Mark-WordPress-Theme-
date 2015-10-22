<?php

function home_banners_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'section_height' => '',
		'loop' => '',
		'slideshow' => '',
		'time' => '',
		'transition_time' => ''
	), $atts));

	$output  = '';
	
	global $post;
	
	// get recent posts
	$args = array('post_type' => 'banner',
				 	'posts_per_page' => -1,
					'orderby' => 'menu_order',
					'order' => 'ASC',
				 	'caller_get_posts' => 1);

	$posts = new wp_query($args); 
   
	// if posts exist
	if($posts->have_posts()):
		
		$output  .= '<section class="flexslider std-slider" data-height="'.$section_height.'" data-loop="'.$loop.'" data-smooth="false" data-slideshow="'.$slideshow.'" data-speed="'.$time.'" data-animspeed="'.$transition_time.'" data-controls="true" data-dircontrols="true">';
		$output  .= '<ul class="slides">';
		// loop through and display them
		while( $posts->have_posts() ):
			$posts->the_post();
			if(rwmb_meta('_wp_banner_image', $post->ID)):
				$images = rwmb_meta( '_wp_banner_image', 'type=plupload_image', $post->ID ); 
				if(count($images) > 0):
					foreach ( $images as $image ):
						$image_url = wp_get_attachment_image_src( $image['ID'], 'full');
						$output  .= '<li data-bg="'.$image_url[0].'">';
					endforeach;
				endif;
			endif;
			$output  .= '<div class="container">';
			$output  .= '<div class="inner">';
			$output  .= '<div class="row">';
			$output  .= '<div class="text-center animated" data-fx="fadeIn">';
			if(rwmb_meta('_wp_title', get_the_ID())): $output  .= '<h2>'.rwmb_meta('_wp_title', get_the_ID()).'</h2>'; endif;
			if(rwmb_meta('_wp_sub_title', get_the_ID())): $output  .= '<p>'.rwmb_meta('_wp_sub_title', get_the_ID()).'</p>'; endif;
			if(rwmb_meta('_wp_show_button_1', get_the_ID()) == 1): $output  .= '<a href="'.rwmb_meta('_wp_button_1_url', get_the_ID()).'" class="btn btn-primary btn-lg local">'.rwmb_meta('_wp_button_1_text', get_the_ID()).'</a>'; endif;
			if(rwmb_meta('_wp_show_button_2', get_the_ID()) == 1): $output  .= '<a href="'.rwmb_meta('_wp_button_2_url', get_the_ID()).'" class="btn btn-default btn-lg">'.rwmb_meta('_wp_button_2_text', get_the_ID()).'</a>'; endif;
			$output  .= '</div>';
			$output  .= '<div class="col-md-6"></div>';
			$output  .= '</div>';
			$output  .= '</div>';
			$output  .= '</div>';
			$output  .= '</li>';
		endwhile;
		$output  .= '</ul>';
		$output  .= '</section>';

	endif;
	
	wp_reset_query();
	
	return $output;

}
add_shortcode( 'home_banners', 'home_banners_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "home_banners",
		"name"		=> __("Home Banners", "frogsthemes"),
		"class"		=> "",
		"icon"      => "home_banners",
		"description" 	=> __("Pulls out the home banners.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Height", "frogsthemes"),
				"param_name" => "section_height",
				"description" => __("The height in pixels you would like the banners section to be (e.g. 560).", "frogsthemes"),
				"value" => "560"
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Loop", "frogsthemes"),
				"param_name" => "loop",
				"value" => array("Yes" => "true", "No" => "false"),
				"description" => __("Should the banners loop?", "frogsthemes")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Slideshow", "frogsthemes"),
				"param_name" => "slideshow",
				"value" => array("Yes" => "true", "No" => "false"),
				"description" => __("Should the banners rotate automatically on load?", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Time Between Banners", "frogsthemes"),
				"param_name" => "time",
				"description" => __("The time in milliseconds between slides if slideshow is set to true (1000 = 1 second).", "frogsthemes"),
				"value" => "8000"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Transition Time", "frogsthemes"),
				"param_name" => "transition_time",
				"description" => __("The transition time in milliseconds between slides (1000 = 1 second).", "frogsthemes"),
				"value" => "600"
			)
		)
	));
endif;



?>