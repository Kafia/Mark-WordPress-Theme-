<?php

/*
*
* Author: FrogsThemes
* File: Custom functions
*
*
*/



/**
 * Builds pagination
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_pagination' ) ) {
	function ft_pagination($total_pages){
		
		//global $wp_query;  
  
		//$total_pages = $wp_query->max_num_pages;  
		
		$paginationHTML = '';
		
		if($total_pages > 1){  
		  
			$current_page = max(1, get_query_var('paged'));  

			$paginationHTML .= '<div class="col-md-6 col-md-pull-3">';
			
			$big = 99999999;
			
			$paginationHTML .= paginate_links(array(  
				'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' 		=> 'page/%#%',  
				'current' 		=> $current_page,  
				'total' 		=> $total_pages,  
				'type' 			=> 'list',  
				'prev_next' 	=> false,
				'prev_text'	=> '&laquo;',
				'next_text'	=> '&raquo;'
			));  
			
			$paginationHTML .= '</div>';
			
		}
		
		return $paginationHTML;
		
	}
}


/**
 * Template for comments and pingbacks.
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_comment' ) ){
	function ft_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
			?>
			<li id="comment-<?php comment_ID(); ?>">
				<div class="oneComment">
					<div class="media stdbox">
						<a class="pull-left" href="<?php echo get_comment_author_url(); ?>"><?php echo get_avatar( $comment, 70 ); ?></a>
						<div class="media-body">
							<h5 class="media-heading"><?php printf( __( '%s'), sprintf( '%s', get_comment_author_link() ) ); ?></h5>
							<?php if ( $comment->comment_approved == '0' ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'frogsthemes'); ?></em><br />
							<?php endif; ?>
							<?php comment_text(); ?>
							<div class="entry-meta">
								<span class="entry-date"><?php comment_date(get_option('date_format'));  ?> <?php _e('at', 'frogsthemes'); ?> <?php comment_date('g:ia');  ?></span>
								<span class="entry-reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
							</div>
						</div>
					</div>
				</div>
          	<?php
				
			break;
			case 'pingback'  :
			case 'trackback' :
	
			break;
		endswitch;
	}
}


/**
 * Custom comment form
 *
 * @since 1.0
 */

if ( ! function_exists( 'comment_form_ft' ) ){
	function comment_form_ft( $args = array(), $post_id = null ) {
		global $id;
	
		if ( null === $post_id )
			$post_id = $id;
		else
			$id = $post_id;
	
		$commenter = wp_get_current_commenter();
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';
	
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
						'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
						'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>'
		);
	
		$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
		$defaults = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'must_log_in'          => '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
			'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
			'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
			'id_form'              => 'commentform',
			'id_submit'            => 'submit',
			'title_reply'          => __( 'Leave a Reply' ),
			'title_reply_to'       => __( 'Leave a Reply to %s' ),
			'cancel_reply_link'    => __( 'Cancel reply' ),
			'label_submit'         => __( 'Post Comment' ),
		);
	
		$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
	
		?>
			<?php if ( comments_open( $post_id ) ) : ?>
				<?php do_action( 'comment_form_before' ); ?>
				<div id="respond">
					<h2 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h2>
					<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
						<?php echo $args['must_log_in']; ?>
						<?php do_action( 'comment_form_must_log_in_after' ); ?>
					<?php else : ?>
						<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
							<?php do_action( 'comment_form_top' ); ?>
							   <?php if ( is_user_logged_in() ) : ?>
                                <?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
                                <?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
                                <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                            <?php else : ?>
                                <p><?php echo $args['comment_notes_before']; ?></p>
                                <?php
                                do_action( 'comment_form_before_fields' );
                                foreach ( (array) $args['fields'] as $name => $field ) {
                                    echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
                                }
                                do_action( 'comment_form_after_fields' );
                                ?>
                                <?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
                            <?php endif; ?>
                            <input name="submit" class="btn btn-primary" type="submit" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>" />
                            <?php comment_id_fields( $post_id ); ?>
                            <p class="fieldsmarked"><?php echo $args['comment_notes_after']; ?></p>
							<?php do_action( 'comment_form', $post_id ); ?>
						</form>
					<?php endif; ?>
				</div><!-- #respond -->
				<?php do_action( 'comment_form_after' ); ?>
			<?php else : ?>
				<?php do_action( 'comment_form_comments_closed' ); ?>
			<?php endif; ?>
		<?php
	}
}


/**
 * Related posts
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_related_posts' ) ){
	function ft_related_posts() {

		$orig_post = $post;  
		global $post;  
		$tags = wp_get_post_tags($post->ID);  
		  
		if($tags): 
			$tag_ids = array();  
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;  
			$args=array(  
			'tag__in' => $tag_ids,  
			'post__not_in' => array($post->ID),  
			'posts_per_page'=>3, // Number of related posts to display.  
			'caller_get_posts'=>1  
			);  
			  
			$my_query = new wp_query( $args );
			
			if($my_query->have_posts()): ?>
            		<header class="page-header text-center">
						<h1 class="page-title"><?php _e('Related Posts', 'frogsthemes'); ?></h1>
					</header>
					<div class="row">
						<?php 
						while($my_query->have_posts()):
						$my_query->the_post(); 
						$format = get_post_format( $post_id );
						?>
						<div class="col-md-4">
							<article class="blog-item<?php if($format == 'video'): echo ' format-video'; endif; ?>">
								<?php
								// gallery format
								if($format == 'gallery' && rwmb_meta('_wp_post_gallery')):
									$images = rwmb_meta( '_wp_post_gallery', 'type=plupload_image' ); 
									if(count($images) > 0):
										?>
										<div class="blog-thumbnail">
											<div class="flexslider std-slider center-controls" data-smooth="true" data-height="160" data-itemwidth="270" data-animation="<?php if(of_get_option('ft_slider_transition')): echo of_get_option('ft_slider_transition'); else: echo 'fade'; endif; ?>" data-loop="<?php if(of_get_option('ft_slider_loop')=='1'): echo 'true'; else: echo 'false'; endif; ?>" data-animspeed="<?php if(of_get_option('ft_slider_speed')): echo of_get_option('ft_slider_speed'); else: echo '600'; endif; ?>" data-speed="<?php if(of_get_option('ft_slider_pause')): echo of_get_option('ft_slider_pause'); else: echo '7000'; endif; ?>" data-dircontrols="true" data-slideshow="<?php if(of_get_option('ft_slider_auto_start')=='1'): echo 'true'; else: echo 'false'; endif; ?>">
												<ul class="slides">
													<?php
													// loop through all images in gallery and display them
													foreach ( $images as $image ):
														$image_url = wp_get_attachment_image_src( $image['ID'], 'related');
														?><li><img src="<?php echo $image_url[0]; ?>" alt="<?php echo $image['alt']; ?>" /></li><?php
													endforeach;
													?>
												</ul>
												<ul class="flex-direction-nav">
													<li><a class="flex-prev" href="#"> </a></li>
													<li><a class="flex-next" href="#"> </a></li>
												</ul>
											</div>
										</div>
										<?php
									endif;
								else:
								if(has_post_thumbnail()): ?>
								<div class="blog-thumbnail">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('related'); ?></a>
								</div><?php 
								endif;
								endif; ?>
								<div class="entry-meta">
									<span class="entry-date"><?php the_time( get_option('date_format') ); ?></span>
									<span class="entry-comments"><a href="<?php comments_link(); ?>"><?php $comments_number = get_comments_number('0', '1', '%'); printf( _n( '%d Comment', '%d Comments', $comments_number, 'frogsthemes' ), $comments_number ); ?></a></span>
								</div>
								<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							</article>
							<!-- / blog-item -->
						</div>
						<?php endwhile; ?>
					</div>
			<?php endif;
		endif;
		$post = $orig_post;  
		wp_reset_query();  
		
	}
}


/**
 * Get author name
 *
 * @since 1.0
 */

if ( ! function_exists( 'ft_get_author_meta' ) ){
	function ft_get_author_meta($metatoget) {

		global $wp_query;
		$curauth = $wp_query->get_queried_object();
		$authormeta = get_the_author_meta( $metatoget, $curauth->ID );
		
		return $authormeta;

	}
}


// Override img caption shortcode to fix 10px issue.
add_filter('img_caption_shortcode', 'fix_img_caption_shortcode', 10, 3);

function fix_img_caption_shortcode($val, $attr, $content = null) {
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => '',
        'width' => '',
        'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) ) return $val;

    return '<div id="' . $id . '" class="wp-caption ' . esc_attr($align) . '" style="width: ' . (0 + (int) $width) . 'px">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

?>