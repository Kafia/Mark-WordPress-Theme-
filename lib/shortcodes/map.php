<?php

function map_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'map_code' => '',
		'map_height' => '',
		'map_zoom' => '',
		'show_details' => '',
		'show_address' => '',
		'show_phone' => '',
		'show_email' => '',
		'address1' => '',
		'address2' => '',
		'address3' => '',
		'phone_text' => '',
		'phone' => '',
		'email_text' => '',
		'email' => ''
	), $atts));

	$output  = '';

	$output  .= '<section class="content-area bg1" data-topspace="0" data-btmspace="0">';
	$output  .= '<div class="mapOuter">';
	$output  .= '<div class="googleMap" data-location="'.$map_code.'" data-height="'.$map_height.'" data-offset="0" data-zoom="'.$map_zoom.'"></div>';
	
	if($show_details == 1):
	
	$output  .= '<div class="addressBox text-center">';
	$output  .= '<dl>';
	if($show_address == 1):
	$output  .= '<dt>'.$address1.'</dt>';
	$output  .= '<dd>'.$address2.'<br>';
	$output  .= $address3;
	$output  .= '</dd>';
	endif;
	if($show_phone == 1):
	$output  .= '<dt>'.$phone_text.'</dt>';
	$output  .= '<dd>'.$phone.'</dd>';
	endif;
	if($show_email == 1):
	$output  .= '<dt>'.$email_text.'</dt>';
	$output  .= '<dd><a href="mailto:'.$email.'">'.$email.'</a></dd>';
	endif;
	$output  .= '</dl>';
	$output  .= '</div>';
	
	endif;
	
	$output  .= '</div>';
	$output  .= '</section>';
	
	return $output;

}
add_shortcode( 'map', 'map_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "map",
		"name"		=> __("FT Map", "frogsthemes"),
		"class"		=> "",
		"icon"      => "icon-wpb-map",
		"description" 	=> __("Add a custom Google map with a details box.", "frogsthemes"),
		"params"	=> array(
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
				"value" => "450",
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
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Details Box?", "frogsthemes"),
				"param_name" => "show_details",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the details box.", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Address?", "frogsthemes"),
				"param_name" => "show_address",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the address.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Address Title", "frogsthemes"),
				"param_name" => "address1",
				"value" => __("Address", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Address Line 2", "frogsthemes"),
				"param_name" => "address2"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Address Line 3", "frogsthemes"),
				"param_name" => "address3"
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Phone Number?", "frogsthemes"),
				"param_name" => "show_phone",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the phone number.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Phone Title", "frogsthemes"),
				"param_name" => "phone_text",
				"value" => __("Phone Number", "frogsthemes"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Phone Number", "frogsthemes"),
				"param_name" => "phone"
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Email Address?", "frogsthemes"),
				"param_name" => "show_email",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the email address.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Email Title", "frogsthemes"),
				"param_name" => "email_text",
				"value" => __("Email Address", "frogsthemes"),
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Email Address", "frogsthemes"),
				"param_name" => "email"
			),
		)
	));
	endif;



?>