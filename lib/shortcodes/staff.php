<?php

function staff_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'staff_exclude' => ''
	), $atts));

	$output  = '';
	
	global $post;

	if($staff_exclude): $exclude = $staff_exclude; else: $exclude = ''; endif;

	$staff = get_posts(array('post_type' => 'staff', 
								 'order' => 'ASC',
								 'orderby' => 'menu_order',
								 'exclude' => $exclude
							  )
						  );
						  
	if(count($staff) > 0):

	//$output  .= '<div class="row">';
	
	foreach( $staff as $post ) : setup_postdata($post);
	
	$output  .= '<div class="col-md-3 col-sm-6">';
	$output  .= '<div class="personBox">';
	
	if(rwmb_meta('_wp_staff_image', $post->ID)):
		$images = rwmb_meta( '_wp_staff_image', 'type=plupload_image', $post->ID ); 
		if(count($images) > 0):
			foreach ( $images as $image ):
				$image_url = wp_get_attachment_image_src( $image['ID'], 'staff');
				$output  .= '<img src="'.$image_url[0].'" alt="'.$image['alt'].'" />';
			endforeach;
		endif;
	endif;
	
	$output  .= '<h4>'.get_the_title();
	if(get_post_meta( $post->ID, '_wp_staff_position', true)): $output  .= '<span>'.get_post_meta( $post->ID, '_wp_staff_position', true).'</span>'; endif;
	$output  .= '</h4>';
	if(get_post_meta( $post->ID, '_wp_staff_facebook', true) || get_post_meta( $post->ID, '_wp_staff_twitter', true) || get_post_meta( $post->ID, '_wp_staff_linkedin', true)): 
	$output  .= '<hr>';
	$output  .= '<ul class="socialNormal list-inline">';
	if(get_post_meta( $post->ID, '_wp_staff_facebook', true)): $output  .= '<li><a href="'.get_post_meta( $post->ID, '_wp_staff_facebook', true).'" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook-square"></i></a></li>'; endif;
	if(get_post_meta( $post->ID, '_wp_staff_twitter', true)): $output  .= '<li><a href="'.get_post_meta( $post->ID, '_wp_staff_twitter', true).'" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>'; endif;
	if(get_post_meta( $post->ID, '_wp_staff_linkedin', true)): $output  .= '<li><a href="'.get_post_meta( $post->ID, '_wp_staff_linkedin', true).'" data-toggle="tooltip" title="LinkedIn"><i class="fa fa-linkedin-square"></i></a></li>'; endif;
	$output  .= '</ul>';
	endif;
	$output  .= '</div>';
	$output  .= '</div>';
	
	endforeach;
	
	wp_reset_query();
	
	//$output  .= '</div>';
	
	endif;
	
	return $output;

}
add_shortcode( 'staff', 'staff_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "staff",
		"name"		=> __("Staff", "frogsthemes"),
		"class"		=> "",
		"icon"      => "staff",
		"description" 	=> __("Display the staff members", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Exclude", "frogsthemes"),
				"param_name" => "staff_exclude",
				"description" => __("Add a comma separated list of IDs of staff you wish to exclude (e.g. 2,43,65).", "frogsthemes")
			)
		)
	));
	endif;



?>