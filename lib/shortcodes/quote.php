<?php

function quote_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'author' => '',
		'company' => '',
		'author_image' => ''
	), $atts));

	$width_class = '';//wpb_translateColumnWidthToSpan($width); // Determine width for our div holder
	
	$content = wpb_js_remove_wpautop($content, true);
	$image_attributes = wp_get_attachment_image_src($author_image, 'full'); // returns an array
	
	$output  = '';
	
	$output  .= '<blockquote class="customerblockquote clearfix">';
	$output  .= '<div class="inner">';
	$output  .= $content;
	$output  .= '</div>';
	$output  .= '<div class="media author">';
	if($author_image):
	$output  .= '<span class="pull-left">';
	$output  .= '<img class="media-object" src="'.$image_attributes[0].'" alt="">';
	$output  .= '</span>';
	endif;
	$output  .= '<div class="media-body">';
	$output  .= '<h4 class="media-heading">'.$author;
	$output  .= '<span>'.$company.'</span>';
	$output  .= '</h4>';
	$output  .= '</div>';
	$output  .= '</div>';
	$output  .= '</blockquote>';
	
	return $output;

}
add_shortcode( 'quote', 'quote_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "quote",
		"name"		=> __("Quote", "frogsthemes"),
		"class"		=> "",
		"icon"      => "quote",
		"description" 	=> __("Styled quote with picture and name.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textarea_html",
				"class" => "",
				"heading" => __("Content", "frogsthemes"),
				"param_name" => "content",
				"holder" => "div",
				"description" => __("Enter the content for this icon box.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Author", "frogsthemes"),
				"param_name" => "author",
				"description" => __("Author of the quote.", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Company", "frogsthemes"),
				"param_name" => "company",
				"description" => __("Company of the author.", "frogsthemes")
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => __("Author Image", "frogsthemes"),
				"param_name" => "author_image",
				"description" => __("Insert an image for the author (ideally 70 x 70px)", "frogsthemes")
			)
		)
	));
endif;
?>