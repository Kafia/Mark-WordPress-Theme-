<?php

function latest_news_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'title' => '',
		'sub_title' => '',
		'button_text' => '',
		'button_url' => '',
		'show_button' => ''
	), $atts));

	$output  = '';
	
	global $post;
	
	// get recent posts
	$args = array('post_type' => 'post',
				 	'posts_per_page' => 3,
				 	'caller_get_posts' => 1);

	$posts = new wp_query($args); 
   
	// if posts exist
	if($posts->have_posts()):
		
		$output  .= '<section class="content-area">';
		$output  .= '<div class="container newscontainer">';
		$output  .= '<div class="row">';
		
		$output  .= '<div class="col-md-3 col-sm-6">';
		$output  .= '<header class="page-header text-left">';
		if($title): $output  .= '<h3>'.$title.'</h3>'; endif;
		if($sub_title): $output  .= '<p>'.$sub_title.'</p>'; endif;
		if($show_button == 1): $output  .= '<a href="'.$button_url.'" class="btn btn-default">'.$button_text.'</a>'; endif;
		$output  .= '</header>';
		$output  .= '</div>';
		
		// loop through and display them
		while( $posts->have_posts() ):
		
			$posts->the_post();
			$format = get_post_format(get_the_ID());
			
			$output  .= '<div class="col-md-3 col-sm-6">';
			// if video post
			if($format == 'video'):
				$output  .= '<article class="blog-item format-video">';
			else:
				$output  .= '<article class="blog-item">';
			endif;
			
			// if gallery format post
			if($format == 'gallery'):
				if(rwmb_meta('_wp_post_gallery')):
					$images = rwmb_meta( '_wp_post_gallery', 'type=plupload_image' ); 
					if(count($images) > 0):
						$output  .= '<div class="flexslider std-slider center-controls" data-animation="fade" data-loop="true" data-animspeed="600" data-dircontrols="true">';
						$output  .= '<ul class="slides">';
						// loop through all images in gallery and display them
						foreach ( $images as $image ):
							// masonry or list image size
							if(of_get_option('ft_blog_style')=='masonry'):
								$image_url = wp_get_attachment_image_src( $image['ID'], 'masonry');
							else:
								$image_url = wp_get_attachment_image_src( $image['ID'], 'post-inner');
							endif;
							$output  .= '<li><a href="'.get_permalink().'"><img src="'.$image_url[0].'" alt="'.$image['alt'].'" /></a></li>';
						endforeach;
						$output  .= '</ul>';
						$output  .= '</div>';
					endif;
				endif;
			else:
				if(has_post_thumbnail()):
					$output  .= '<div class="blog-thumbnail">';
					$output  .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail(get_the_ID(), 'related').'</a>';
					$output  .= '</div>';
				endif;
			endif;
			
			$output  .= '<div class="entry-meta">';
			$output  .= '<span class="entry-date">December 3, 2013</span>';
			$output  .= '<span class="entry-comments"><a href="'.get_comments_link().'">';
			$comments_number = get_comments_number('0', '1', '%'); 
			$output  .= sprintf( _n( '%d Comment', '%d Comments', $comments_number, 'frogsthemes' ), $comments_number );
			$output  .= '</a></span>';
			$output  .= '</div>';
			$output  .= '<h4 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h4>';
			$output  .= '<p>';
			$output  .= get_the_excerpt();
			$output  .= '</p>';
			$output  .= '</article>';
			$output  .= '</div>';
		
		endwhile;
		
		$output  .= '</div>';
		$output  .= '</div>';
		$output  .= '</section>';

	endif;
	
	wp_reset_query();

	return $output;

}
add_shortcode( 'latest_news', 'latest_news_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "latest_news",
		"name"		=> __("Latest News", "frogsthemes"),
		"class"		=> "",
		"icon"      => "latest_news",
		"description" 	=> __("Pulls out the latest 3 news articles from the blog.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Title", "frogsthemes"),
				"param_name" => "title",
				"value" => __("Fresh news and updates", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Sub Title", "frogsthemes"),
				"param_name" => "sub_title",
				"value" => __("Latest from our blog", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button Text", "frogsthemes"),
				"param_name" => "button_text",
				"value" => __("View All Posts", "frogsthemes")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button URL", "frogsthemes"),
				"param_name" => "button_url",
				"value" => ""
			),
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Button?", "frogsthemes"),
				"param_name" => "show_button",
				"value" => array("" => "1"),
				"description" => __("Check this box to show the button.", "frogsthemes")
			),
		)
	));
endif;



?>