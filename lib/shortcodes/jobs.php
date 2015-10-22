<?php

function jobs_func( $atts, $content = null ) { // New function parameter $content is added!
   
	extract(shortcode_atts(array(
		'width' => '1/2',
		'el_position' => '',
		'show_departments' => ''
	), $atts));
	
	$output  = '';

	global $post;
	
	$output  .= '<div class="row">';
	
	// get all departments
	$args = array(
	  'taxonomy'     => 'department',
	  'orderby'      => 'ID',
	  'order'    	 => 'ASC',
	  'show_count'   => 0,
	  'pad_counts'   => 0,
	  'hierarchical' => 1,
	  'title_li'     => ''
	);
	$departments = get_categories($args); 
	
	$depi = 2;
	$tabi = 2;
	
	// if departments, build menu on left
	if(count($departments) > 0 && $show_departments == 1):
	
		$output  .= '<div class="col-md-3">';
		$output  .= '<ul class="nav nav-pills nav-stacked">';
		$output  .= '<li class="active"><a href="#tab1" data-toggle="tab">'.__('All', 'frogsthemes').'</a></li>';
		
		// loop through departments to create the links
		foreach ($departments as $department):
		
			$output  .= '<li><a href="#tab'.$depi.'" data-toggle="tab">'.$department->cat_name.'</a></li>';
			$depi++;
		
		endforeach;
		
		$output  .= '</ul>';
		$output  .= '</div>';
	
	endif;

	// start building table of results
	if(count($departments) > 0 && $show_departments == 1):
		$output  .= '<div class="col-md-9">';
	else:
		$output  .= '<div class="col-md-12">';
	endif;
	$output  .= '<div class="tab-content">';
	
	// get all results initially for the 'All' tab
	$jobs = get_posts(array('post_type' => 'job', 
								 'order' => 'ASC',
								 'orderby' => 'menu_order'
							  )
						  );
	
	// if jobs exist, start building the table	  
	if(count($jobs) > 0):
	
		$output  .= '<div class="tab-pane fade active in" id="tab1">';
		$output  .= '<div class="table-responsive">';
		$output  .= '<table>';
		$output  .= '<thead>';
		$output  .= '<tr>';
		$output  .= '<th>'.__('Job title', 'frogsthemes').'</th>';
		$output  .= '<th>'.__('Position', 'frogsthemes').'</th>';
		$output  .= '<th>'.__('Location', 'frogsthemes').'</th>';
		$output  .= '</tr>';
		$output  .= '</thead>';
		$output  .= '<tbody>';
		
		// loop through all jobs and display them in the table
		foreach( $jobs as $post ) : setup_postdata($post);
		
			$output  .= '<tr data-link="'.get_permalink().'">';
			$output  .= '<td>'.get_the_title().'</td>';
			if(get_post_meta($post->ID, '_wp_job_position', true)): $output  .= '<td>'.get_post_meta($post->ID, '_wp_job_position', true).'</td>'; else: $output  .= '<td>---</td>'; endif;
			if(get_post_meta($post->ID, '_wp_job_location', true)): $output  .= '<td>'.get_post_meta($post->ID, '_wp_job_location', true).'</td>'; else: $output  .= '<td>---</td>'; endif;
			$output  .= '</tr>';
		
		endforeach;
	
		$output  .= '</tbody>';
		$output  .= '</table>';
		$output  .= '</div>';
		$output  .= '</div>';
	
	endif;

	// start looping through departments to create tabs for those
	foreach ($departments as $department):	
		
		$jobs = get_posts(array('post_type' => 'job', 
									 'order' => 'ASC',
									 'orderby' => 'menu_order',
									 'department' => $department->slug
								  )
							  );
							  
		// if jobs exist, start building the table					  
		if(count($jobs) > 0):
		
			$output  .= '<div class="tab-pane fade" id="tab'.$tabi.'">';
			$output  .= '<div class="table-responsive">';
			$output  .= '<table>';
			$output  .= '<thead>';
			$output  .= '<tr>';
			$output  .= '<th>'.__('Job title', 'frogsthemes').'</th>';
			$output  .= '<th>'.__('Position', 'frogsthemes').'</th>';
			$output  .= '<th>'.__('Location', 'frogsthemes').'</th>';
			$output  .= '</tr>';
			$output  .= '</thead>';
			$output  .= '<tbody>';
			
			// loop through all jobs and display them in the table
			foreach( $jobs as $post ) : setup_postdata($post);
			
				$output  .= '<tr data-link="'.get_permalink().'">';
				$output  .= '<td>'.get_the_title().'</td>';
				if(get_post_meta($post->ID, '_wp_job_position', true)): $output  .= '<td>'.get_post_meta($post->ID, '_wp_job_position', true).'</td>'; else: $output  .= '<td>---</td>'; endif;
				if(get_post_meta($post->ID, '_wp_job_location', true)): $output  .= '<td>'.get_post_meta($post->ID, '_wp_job_location', true).'</td>'; else: $output  .= '<td>---</td>'; endif;
				$output  .= '</tr>';
			
			endforeach;
	
			$output  .= '</tbody>';
			$output  .= '</table>';
			$output  .= '</div>';
			$output  .= '</div>';
	
		endif;
	
		$tabi++;

	endforeach;
	
	$output  .= '</div>';
	$output  .= '</div>';
	$output  .= '</div>';
	
	wp_reset_query();
	
	return $output;

}
add_shortcode( 'jobs', 'jobs_func' );

if( function_exists('vc_set_as_theme') ):
	vc_map( array(
		"base"		=> "jobs",
		"name"		=> __("Jobs", "frogsthemes"),
		"class"		=> "",
		"icon"      => "jobs",
		"description" 	=> __("Display the list of jobs in various departments.", "frogsthemes"),
		"params"	=> array(
			array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __("Show Departments?", "frogsthemes"),
				"param_name" => "show_departments",
				"value" => array("" => "1"),
				"description" => __("Check this to show the menu of departments. If unchecked it will just list all available jobs in a table.", "frogsthemes")
			)
		)
	));
endif;



?>