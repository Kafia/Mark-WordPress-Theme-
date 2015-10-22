<?php

function icon_box_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$content = wpb_js_remove_wpautop($content, true);
	
	$output  = '';
	
	$output  .= '<div class="iconBox">';
	$output  .= '<div class="media">';
	$output  .= '<span class="pull-left">';
	$output  .= '<span class="circle">';
	$output  .= '<i class="fa fa-check"></i>';
	$output  .= '</span>';
	$output  .= '</span>';
	$output  .= '<div class="media-body">';
	$output  .= $content;
	$output  .= '</div>';
	$output  .= '</div>';
	$output  .= '</div>';
	
	return $output;

}
add_shortcode( 'icon_box', 'icon_box_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "icon_box",
		"name"		=> __("Icon Box", "frogsthemes"),
		"class"		=> "",
		"icon"      => "case-study",
		"description" 	=> __("Styled icon box", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textarea_html",
				"class" => "",
				"heading" => __("Content", "frogsthemes"),
				"param_name" => "content",
				"admin_label" => true,
				"holder" => "div",
				"description" => __("Enter the content for this icon box.", "frogsthemes")
			)
		)
	));
	endif;



?>