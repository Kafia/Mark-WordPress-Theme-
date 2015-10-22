<?php

function banner_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'caption' => '',
		'show_button' => '',
		'button_url' => '',
		'button_text' => '',
		'testimonial_count' => '',
		'content_type' => '',
		'ft_slider_loop' => '',
		'ft_slider_speed' => '',
		'ft_slider_pause' => '',
		'ft_slider_auto_start' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$output  = '';
	
	$output  .= '<section class="content-area brightText removemargin">';
	$output  .= '<div class="flexslider std-slider center-controls" data-smooth="false" data-animation="fade" data-loop="';
	if($ft_slider_loop == '1'): $output  .= 'true'; else: $output  .= 'false'; endif;
	$output  .= '" data-animspeed="';
	if($ft_slider_speed): $output  .= $ft_slider_speed; else: $output  .= '600'; endif;
	$output  .= '" data-speed="';
	if($ft_slider_pause): $output  .= $ft_slider_pause; else: $output  .= '7000'; endif;
	$output  .= '" data-dircontrols="true" data-controls="true" data-slideshow="';
	if($ft_slider_auto_start == '1'): $output  .= 'true'; else: $output  .= 'false'; endif;
	$output  .= '">';
	
	if($content_type =='testimonials'): 
	
	global $post;
	
	if(!$testimonial_count): $testimonial_count = 3; endif;

	$testimonials = get_posts(array('post_type' => 'testimonial', 
								 'order' => 'ASC',
								 'orderby' => 'menu_order', 
								 'numberposts' => $testimonial_count
							  )
						  );
						  
	if(count($testimonials) > 0):
	
	$output  .= '<ul class="slides">';
	
	foreach( $testimonials as $post ) : setup_postdata($post);
	
	$output  .= '<li>';
	$output  .= '<blockquote class="huge text-center">';
	$output  .= '<p>'.get_the_title().'</p>';
	if(get_post_meta( $post->ID, '_wp_testimonial_by', true)): $output  .= '<span class="author">'.get_post_meta( $post->ID, '_wp_testimonial_by', true).'</span>'; endif;
	$output  .= '</blockquote>';
	$output  .= '</li>';
	
	endforeach;
	
	wp_reset_query();
	
	$output  .= '</ul>';
	
	endif;
	
	elseif($content_type =='quote' && $caption): 
	
	$output  .= '<ul class="slides">';
	$output  .= '<li>';
	$output  .= '<blockquote class="huge text-center">';
	$output  .= '<h1>'.$caption.'</h1>';
	if($show_button == 1): $output  .= '<p><a href="'.$button_url.'" class="btn btn-primary btn-lg local">'.$button_text.'</a></p>'; endif;
	$output  .= '</blockquote>';
	$output  .= '</li>';
	$output  .= '</ul>';
	
	endif;
	
	$output  .= '</div>';
	$output  .= '</section>';
	
	return $output;

}
add_shortcode( 'banner', 'banner_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "banner",
		"name"		=> __("Banner", "frogsthemes"),
		"class"		=> "",
		"icon"      => "banner",
		"description" 	=> __("Display a quote or testimonials", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Content Type", "frogsthemes"),
				"param_name" => "content_type",
				"value" => array("Custom Quote" => "quote", "Testimonials" => "testimonials"),
				"description" => __("You can choose to display a quote and add the quote below or display testimonials.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Caption", "frogsthemes"),
				"param_name" => "caption",
				"description" => __("Add a caption to this banner if you like.", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Button?", "frogsthemes"),
				"param_name" => "show_button",
				"value" => array("" => "1"),
				"description" => __("You can add a button to your banner should you wish. Simply turn it on/off with this checkbox and then add the URL and text below.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button URL", "frogsthemes"),
				"param_name" => "button_url",
				"description" => __("The button URL.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button Text", "frogsthemes"),
				"param_name" => "button_text",
				"description" => __("The text to display on the button.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Testimonial Count", "frogsthemes"),
				"param_name" => "testimonial_count",
				"value" => "3",
				"description" => __("Number of testimonials to show.", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Loop Testimonials", "frogsthemes"),
				"param_name" => "ft_slider_loop",
				"value" => array("" => "1"),
				"description" => __("Check if you would like the testimonial slider on a loop.", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Auto Start Testimonial Slider", "frogsthemes"),
				"param_name" => "ft_slider_auto_start",
				"value" => array("" => "1"),
				"description" => __("Check if you would like the testimonial slider to animate automatically.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Testimonial Slider Speed", "frogsthemes"),
				"param_name" => "ft_slider_speed",
				"value" => "600",
				"description" => __("Speed in milliseconds of slider transition (1000 = 1 second).", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Testimonial Slider Pause", "frogsthemes"),
				"param_name" => "ft_slider_pause",
				"value" => "7000",
				"description" => __("Speed in milliseconds of wait between slider transitions (1000 = 1 second).", "frogsthemes")
			),
		)
	));
	endif;



?>