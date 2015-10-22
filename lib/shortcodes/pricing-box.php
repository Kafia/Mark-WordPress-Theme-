<?php

function pricing_box_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'title' => '',
		'currency_symbol' => '',
		'symbol_position' => '',
		'price' => '',
		'frequency' => '',
		'show_button' => '',
		'button_url' => '',
		'button_text' => '',
		'list' => '',
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$content = wpb_js_remove_wpautop($content, true);
	
	$output  = '';

	$output  .= '<div class="priceBox text-center">';
	$output  .= '<div class="inner">';
	if($title): $output  .= '<h3>'.$title.'</h3>'; endif;
	$output  .= '<div>';
	if($symbol_position == 'after'):
		$output  .= '<em>'.$price.'</em><sup>'.$currency_symbol.'</sup>';
	else:
		$output  .= '<sup>'.$currency_symbol.'</sup><em>'.$price.'</em>';
	endif;
	if($frequency): $output  .= '<sub>'.$frequency.'</sub>'; endif;
	$output  .= '</div>';
	if($show_button == 1): $output  .= '<a href="'.$button_url.'" class="btn btn-primary">'.$button_text.'</a>'; endif;
	$output  .= '</div>';
	if($list): 
		$list_bits = explode("\n", $list);
		foreach($list_bits as $item):
			$output  .= '<span>'.$item.'</span>';
		endforeach;
	endif;
	$output  .= '</div>';
		
	return $output;

}
add_shortcode( 'pricing_box', 'pricing_box_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "pricing_box",
		"name"		=> __("Pricing Box", "frogsthemes"),
		"class"		=> "",
		"icon"      => "case-study",
		"description" 	=> __("Styled pricing box", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Title", "frogsthemes"),
				"param_name" => "title"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Currency Symbol", "frogsthemes"),
				"param_name" => "currency_symbol",
				"value" => __("$", "frogsthemes")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Currency Symbol Position", "frogsthemes"),
				"param_name" => "symbol_position",
				"value" => array("Before" => "before", "After" => "after"),
				"description" => __("Choose whether the currency symbol displays before or after the price.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Price", "frogsthemes"),
				"param_name" => "price"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Frequency", "frogsthemes"),
				"param_name" => "frequency",
				"value" => __("/mo", "frogsthemes")
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Button?", "frogsthemes"),
				"param_name" => "show_button",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the button.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button URL", "frogsthemes"),
				"param_name" => "button_url"
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button Text", "frogsthemes"),
				"param_name" => "button_text"
			),
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("List of Features", "frogsthemes"),
				"param_name" => "list",
				"description" => __("Add 1 feature per line.", "frogsthemes")
			),
			
		)
	));
	endif;



?>