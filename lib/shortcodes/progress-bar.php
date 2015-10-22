<?php

function progress_bar_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'title' => '',
		'sub_title' => '',
		'percentage' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$output  = '';

	$output  .= '<div class="progress">';
	if($title): $output  .= '<span class="pro-skill pull-left">'.$title.'</span>'; endif;
	if($sub_title): $output  .= '<span class="pro-level pull-right">'.$sub_title.'</span>'; endif;
	$output  .= '<div class="progress-bar" role="progressbar" aria-valuenow="'.$percentage.'" data-percentage="'.$percentage.'" aria-valuemin="0" aria-valuemax="100">';
	$output  .= '</div>';
	$output  .= '</div>';
	
	return $output;

}
add_shortcode( 'progress_bar', 'progress_bar_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "progress_bar",
		"name"		=> __("FT Progress Bar", "frogsthemes"),
		"class"		=> "",
		"icon"     => "icon-wpb-graph",
		"description" 	=> __("Custom progress bar", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Title", "frogsthemes"),
				"param_name" => "title",
				"admin_label" => true,
				"description" => __("Enter a title.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Sub Title", "frogsthemes"),
				"param_name" => "sub_title",
				"admin_label" => true,
				"description" => __("Enter a sub title (if you like).", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Percentage", "frogsthemes"),
				"param_name" => "percentage",
				"admin_label" => true,
				"description" => __("Enter the percentage the progress bar should fill (0-100).", "frogsthemes")
			)
		)
	));
	endif;



?>