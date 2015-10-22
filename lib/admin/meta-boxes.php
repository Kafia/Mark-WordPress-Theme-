<?php

/**
 * Add listing meta boxes
 *
 */

add_action( 'admin_init', 'ft_register_meta_boxes' );

if ( ! function_exists( 'ft_register_meta_boxes' ) ) {
	function ft_register_meta_boxes()
	{
		if ( !class_exists( 'RW_Meta_Box' ) )
			return;
		
		$meta_boxes = array();
		
		// post options
		$meta_boxes[] = array(
		
			'id' 		  => 'post_options',
			'title'		  => __('Post Format Options', 'frogsthemes'),
			'pages'		  => array('post'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(
				array(
					'name' => __( 'Gallery', 'frogsthemes' ),
					'desc' => __( 'If you have selected the image gallery post format you can create a gallery to display on your post here. It will create a nicely styled sliding image gallery for you.', 'frogsthemes' ),
					'id'   => "_wp_post_gallery",
					'type' => 'image_advanced'
				),
				array(
					'name' => __( 'Video Embed Code', 'frogsthemes' ),
					'desc' => __( 'You can add the video embed code (YouTube/Vimeo etc) that will be shown for this post.', 'frogsthemes' ),
					'id'   => "_wp_video_code",
					'type' => 'textarea'
				),
				array(
					'name' => __( 'Link URL', 'frogsthemes' ),
					'desc' => __( 'For a link post format, add the URL that the post should link to.', 'frogsthemes' ),
					'id'   => "_wp_link",
					'type' => 'text'
				),
				array(
					'name' => __( 'Quote', 'frogsthemes' ),
					'desc' => __( 'For quote post formats, add the quote here.', 'frogsthemes' ),
					'id'   => "_wp_quote",
					'type' => 'textarea'
				),
				array(
					'name' => __( 'Quote Author', 'frogsthemes' ),
					'desc' => __( 'And who the quote was by (if you like).', 'frogsthemes' ),
					'id'   => "_wp_quote_by",
					'type' => 'text'
				),
				array(
					'name' => __( 'Audio Embed Code', 'frogsthemes' ),
					'desc' => __( 'You can add the audio embed code that will be shown for this post.', 'frogsthemes' ),
					'id'   => "_wp_audio_code",
					'type' => 'textarea'
				)
			)
		);
		
		// page options
		$meta_boxes[] = array(
		
			'id' 		  => 'page_options',
			'title'		  => __('Title Options', 'frogsthemes'),
			'pages'		  => array('page','post','job'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Show Title Section?', 'frogsthemes' ),
					'id'   => "_wp_show_title_section",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the bar at the top with the title and breadcrumb section.', 'frogsthemes' ),
					'std'  => 1
				)
			)
		);
		
		// portfolio options
		$meta_boxes[] = array(
		
			'id' 		  => 'portfolio_options',
			'title'		  => __('Portfolio Options', 'frogsthemes'),
			'pages'		  => array('portfolio'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Show Title Section?', 'frogsthemes' ),
					'id'   => "_wp_show_title_section",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the bar at the top with the title and breadcrumb section.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Show Next/Previous Item Links?', 'frogsthemes' ),
					'id'   => "_wp_show_next_prev",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the links to the next/previous items.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Show Share Links?', 'frogsthemes' ),
					'id'   => "_wp_show_social_share",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the share links for Twitter/Facebook etc.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Show Related Items?', 'frogsthemes' ),
					'id'   => "_wp_show_related_section",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the related portfolio items section which pulls in the 4 latest items from the same categories as the one being viewed.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Related Projects Title', 'frogsthemes' ),
					'id'   => "_wp_related_title",
					'type' => 'text',
					'desc' => __( 'Title for the related projects section.', 'frogsthemes' ),
					'std'  => __( 'Related Projects', 'frogsthemes' )
				)
			)
		);
		
		// banner options
		$meta_boxes[] = array(
		
			'id' 		  => 'banner_options',
			'title'		  => __('Banner Options', 'frogsthemes'),
			'pages'		  => array('banner'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Banner Image', 'frogsthemes' ),
					'desc' => __( 'Select an image for the background of this banner. It will be set to fill the space.', 'frogsthemes' ),
					'id'   => "_wp_banner_image",
					'type' => 'image_advanced',
					'max_file_uploads' => 1
				),
				array(
					'name' => __( 'Title', 'frogsthemes' ),
					'id'   => "_wp_title",
					'type' => 'text'
				),
				array(
					'name' => __( 'Sub Title', 'frogsthemes' ),
					'id'   => "_wp_sub_title",
					'type' => 'text'
				),
				array(
					'name' => __( 'Show Button 1?', 'frogsthemes' ),
					'id'   => "_wp_show_button_1",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the left button that is available for use.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Button 1 Text', 'frogsthemes' ),
					'id'   => "_wp_button_1_text",
					'type' => 'text'
				),
				array(
					'name' => __( 'Button 1 URL', 'frogsthemes' ),
					'id'   => "_wp_button_1_url",
					'type' => 'text'
				),
				array(
					'name' => __( 'Show Button 2?', 'frogsthemes' ),
					'id'   => "_wp_show_button_2",
					'type' => 'checkbox',
					'desc' => __( 'Checking this will show the left button that is available for use.', 'frogsthemes' ),
					'std'  => 1
				),
				array(
					'name' => __( 'Button 2 Text', 'frogsthemes' ),
					'id'   => "_wp_button_2_text",
					'type' => 'text'
				),
				array(
					'name' => __( 'Button 2 URL', 'frogsthemes' ),
					'id'   => "_wp_button_2_url",
					'type' => 'text'
				)
			)
		);
		
		// testimonial options
		$meta_boxes[] = array(
		
			'id' 		  => 'testimonial_options',
			'title'		  => __('Testimonial Options', 'frogsthemes'),
			'pages'		  => array('testimonial'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Testimonial By', 'frogsthemes' ),
					'id'   => "_wp_testimonial_by",
					'type' => 'text',
					'desc' => __( 'Add the name of the person or company making the testimonial.', 'frogsthemes' )
				)
			)
		);
		
		// staff options
		$meta_boxes[] = array(
		
			'id' 		  => 'staff_options',
			'title'		  => __('Staff Options', 'frogsthemes'),
			'pages'		  => array('staff'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Staff Image', 'frogsthemes' ),
					'desc' => __( 'Add an image for this membe off staff (will be cropped to 270 x 280px).', 'frogsthemes' ),
					'id'   => "_wp_staff_image",
					'type' => 'image_advanced',
					'max_file_uploads' => 1
				),
				array(
					'name' => __( 'Staff Position', 'frogsthemes' ),
					'id'   => "_wp_staff_position",
					'type' => 'text'
				),
				array(
					'name' => __( 'Facebook URL', 'frogsthemes' ),
					'id'   => "_wp_staff_facebook",
					'type' => 'text'
				),
				array(
					'name' => __( 'Twitter URL', 'frogsthemes' ),
					'id'   => "_wp_staff_twitter",
					'type' => 'text'
				),
				array(
					'name' => __( 'LinkedIn URL', 'frogsthemes' ),
					'id'   => "_wp_staff_linkedin",
					'type' => 'text'
				)
			)
		);
		
		// job options
		$meta_boxes[] = array(
		
			'id' 		  => 'job_options',
			'title'		  => __('Job Options', 'frogsthemes'),
			'pages'		  => array('job'),
			'context'	  => 'normal',
			'priority'	  => 'high',
			'fields'	  => array(    		
				array(
					'name' => __( 'Position', 'frogsthemes' ),
					'id'   => "_wp_job_position",
					'type' => 'text'
				),
				array(
					'name' => __( 'Location', 'frogsthemes' ),
					'id'   => "_wp_job_location",
					'type' => 'text'
				),
				array(
					'name' => __( 'Reference', 'frogsthemes' ),
					'id'   => "_wp_job_reference",
					'type' => 'text'
				),
				array(
					'name' => __( 'Salary', 'frogsthemes' ),
					'id'   => "_wp_job_salary",
					'type' => 'text'
				),
				array(
					'name' => __( 'Published Date', 'frogsthemes' ),
					'id'   => "_wp_job_published",
					'type' => 'date'
				),
				array(
					'name' => __( 'Closing Date', 'frogsthemes' ),
					'id'   => "_wp_job_closing",
					'type' => 'date'
				),
			)
		);
		
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}