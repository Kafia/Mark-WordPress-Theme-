<?php

function form_map_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'map_code' => '',
		'map_height' => '',
		'map_zoom' => '',
		'title' => '',
		'sub_title' => '',
		'show_map_text' => '',
		'show_form_text' => '',
		'form_id' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$content = wpb_js_remove_wpautop($content, true);
	$image_attributes = wp_get_attachment_image_src($author_image, 'full'); // returns an array
	
	$output  = '';

	$output  .= '<section class="content-layer brightText removemargin">';
	$output  .= '<div class="mapOuter">';
	$output  .= '<div class="googleMap" data-location="'.$map_code.'" data-height="'.$map_height.'" data-offset="0" data-zoom="'.$map_zoom.'"></div>';
	$output  .= '</div>';
	$output  .= '<a href="#" class="showMap btn btn-primary" data-text="'.$show_form_text.'">'.$show_map_text.'</a>';
	$output  .= '<div class="bg-layer"></div>';
	$output  .= '<div class="placeOver">';
	$output  .= '<div class="container">';
	$output  .= '<header class="page-header text-center">';
	if($title): $output  .= '<h2>'.$title.'</h2>'; endif;
	if($sub_title): $output  .= '<p>'.$sub_title.'</p>'; endif;
	$output  .= '</header>';
	if($form_id): $output  .= do_shortcode( '[contact-form-7 id="'.$form_id.'"]' ); endif;
	$output  .= '</div>';
	$output  .= '</div>';
	$output  .= '</section>';
	
	return $output;

}
add_shortcode( 'form_map', 'form_map_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "form_map",
		"name"		=> __("Form & Map", "frogsthemes"),
		"class"		=> "",
		"icon"      => "form_map",
		"description" 	=> __("A Google map with contact form overlaying it.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Contact Form ID", "frogsthemes"),
				"param_name" => "form_id",
				"description" => __("Enter the ID of the contact form 7 form.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Google Map Location", "frogsthemes"),
				"param_name" => "map_code",
				"value" => "York, YO1",
				"description" => __("Location of the marker (e.g. York, YO1)", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Map Height", "frogsthemes"),
				"param_name" => "map_height",
				"value" => "695",
				"description" => __("The height in pixels you would like the map to be (it will be 100% width).", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Map Zoom", "frogsthemes"),
				"param_name" => "map_zoom",
				"value" => "18",
				"description" => __("Zoom level of the map (1-23).", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Title", "frogsthemes"),
				"param_name" => "title",
				"value" => __("Request a Quote", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Sub Title", "frogsthemes"),
				"param_name" => "sub_title",
				"value" => __("Contact us to request a quote or make a general enquiry.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Show Map Text", "frogsthemes"),
				"param_name" => "show_map_text",
				"value" => __("Show Map", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Show Form Text", "frogsthemes"),
				"param_name" => "show_form_text",
				"value" => __("Show Contact Form", "frogsthemes")
			)
		)
	));
endif;
?>