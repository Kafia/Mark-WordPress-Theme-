<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

$postspage_id = get_option('page_for_posts');
$authID = get_the_author_meta( 'ID' );

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
<?php if(rwmb_meta('_wp_show_title_section')=='1'): ?>
<header class="main-header clearfix">
	<div class="container">
		<p class="page-title pull-left"><?php echo get_the_title($postspage_id); ?></p>
		<?php 
		// breadcrumb trail
		if(of_get_option('ft_show_breadcrumbs')==1):
			$bc = array('before'	=>	'<div class="breadcrumb pull-right">',
						'after'		=>	'</div>');
			breadcrumb_trail($bc);
		endif; 
		?>
	</div>
</header>
<?php endif; ?>
<section class="content-area bg1">
	<div class="container">
		<div class="row">
			<div class="col-md-9<?php if(function_exists("ft_sidebar_float")): echo ft_sidebar_float('content', $post->ID); endif; ?>">
				<div id="blog-list" class="clearfix">
					<article class="blog-item item-bigger">
						<?php
						// display different header depending on post format
						$format = get_post_format();
						switch($format):
						
							case 'image':
								?>
								<?php if(has_post_thumbnail()): ?>
								<div class="blog-thumbnail">
									<?php the_post_thumbnail('post-inner'); ?>
								</div>
								<?php endif; ?>
								<?php
							break;
							
							case 'gallery':
								// get any images attached to the post
								if(rwmb_meta('_wp_post_gallery')):
									$images = rwmb_meta( '_wp_post_gallery', 'type=plupload_image' ); 
									if(count($images) > 0):
										?>
                                    <div class="flexslider std-slider center-controls" data-smooth="true" data-itemwidth="870" data-animation="<?php if(of_get_option('ft_slider_transition')): echo of_get_option('ft_slider_transition'); else: echo 'fade'; endif; ?>" data-loop="<?php if(of_get_option('ft_slider_loop')=='1'): echo 'true'; else: echo 'false'; endif; ?>" data-animspeed="<?php if(of_get_option('ft_slider_speed')): echo of_get_option('ft_slider_speed'); else: echo '600'; endif; ?>" data-speed="<?php if(of_get_option('ft_slider_pause')): echo of_get_option('ft_slider_pause'); else: echo '7000'; endif; ?>" data-dircontrols="true" data-slideshow="<?php if(of_get_option('ft_slider_auto_start')=='1'): echo 'true'; else: echo 'false'; endif; ?>">
                                        <ul class="slides">
                                            <?php
                                            // loop through all images in gallery and display them
                                            foreach ( $images as $image ):
                                                $image_url = wp_get_attachment_image_src( $image['ID'], 'post-inner');
                                                ?><li><img src="<?php echo $image_url[0]; ?>" alt="<?php echo $image['alt']; ?>" /></li><?php
                                            endforeach;
                                            ?>
                                        </ul>
                                        <ul class="flex-direction-nav">
                                            <li><a class="flex-prev" href="#"> </a></li>
                                            <li><a class="flex-next" href="#"> </a></li>
                                        </ul>
                                    </div>
										<?php
									endif;
								endif;
								
							break;
							
							case 'video':
								if(get_post_meta($post->ID, '_wp_video_code', true)): ?>
								<div class="responsiveVideo">
									<?php echo get_post_meta($post->ID, '_wp_video_code', true); ?>
								</div><!-- block -->
								<?php endif;
							break;
							
							case 'audio':
								if(get_post_meta($post->ID, '_wp_audio_code', true)): ?>
								<div class="responsiveVideo">
									<?php echo get_post_meta($post->ID, '_wp_audio_code', true); ?>
								</div><!-- block -->
								<?php endif;
							break;
							
						endswitch;
						?>
						<div class="innerMargin">
							<div class="entry-meta">
								<span class="entry-date"><?php the_time( get_option('date_format') ); ?></span>
								<span class="cat-links"><?php _e('In', 'frogsthemes'); ?> <?php
								// get categories post is in
								$post_categories = wp_get_post_categories($post->ID);
								$cats = array();
								$i = 0;
								foreach($post_categories as $c):
									$cat = get_category( $c );
									if($i>0): echo ', '; endif;
									echo '<a href="'.get_category_link($cat->cat_ID).'">'.$cat->name.'</a>';
									$i++;
								endforeach;
								?></span>
								<span class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e('By', 'frogsthemes'); ?> <?php the_author_meta( 'display_name' ); ?></a></span>
								<span class="entry-comments"><a href="<?php comments_link(); ?>"><?php $comments_number = get_comments_number('0', '1', '%'); printf( _n( '%d Comment', '%d Comments', $comments_number, 'frogsthemes' ), $comments_number ); ?></a></span>
							</div>
							<?php 
							// for link and quote, show the link or quote in the content
							switch($format):
							
								case 'link':
									?><h1><a href="<?php echo get_post_meta($post->ID, '_wp_link', true); ?>" target="_blank"><?php the_title(); ?></a></h1><?php
									the_content();
								break;
								
								case 'quote':
									?>
									<h1><?php the_title(); ?></h1>
									<div class="entry-title">
                                    <blockquote>
                                        <?php if(get_post_meta($post->ID, '_wp_quote', true)): ?><?php echo nl2br(get_post_meta($post->ID, '_wp_quote', true)); endif; ?>
                                        <span class="author">— <?php if(get_post_meta($post->ID, '_wp_quote_by', true)): ?><?php echo get_post_meta($post->ID, '_wp_quote_by', true); endif; ?></span>
                                    </blockquote>
                                </div>
									<?php
								break;
								
								default:
									
									?><h1><?php the_title(); ?></h1><?php
									the_content();
								
								break;
							
							endswitch;
							?>
							<?php
							// tags attached to post
							$posttags = get_the_tags();
							if ($posttags):
								echo '<br /><div class="widget wp_widget_tag_cloud">';
								foreach($posttags as $tag):
									echo '<a href="'.get_tag_link($tag->term_id).'" class="btn btn-default btn-sm">'.$tag->name.'</a>'; 
								endforeach;
								echo '</div>';
							endif;
							?>
							<?php
							// share links if checked to show
							if(of_get_option('ft_show_share_links')==1): ?>
							<br />
    						<hr class="clearboth" />
							<div class="table-content">
								<div class="table-row">
									<div class="table-cell">
										<h1 class="widget-title"><?php _e('Share this story', 'frogsthemes'); ?></h1>
									</div>
									<div class="table-cell">
										<ul class="socialIcons bigIcons type2 pull-right">
											<li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
											<li><a href="http://twitter.com/share?text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
											<li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Google+"><i class="fa fa-google-plus"></i></a></li>
											<li><a href="http://pinterest.com/pin/create/link/?url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
                         <?php endif; ?>
                         <?php
							// author details if checked to show
							if(of_get_option('ft_show_author')==1): ?>
							<hr />
							<br />
                         <div class="media stdbox">
								<a class="pull-left" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_id() , 70 ); ?></a>
								<div class="media-body">
									<h4 class="media-heading"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name', $authID ); ?></a></h4>
									<p><?php echo nl2br(get_the_author_meta( 'user_description', $authID )); ?></p>
								</div>
							</div>
                         <?php endif; ?>
						</div>
					</article>
					<!-- / blog-item -->
					<?php
					// next/previous links
					if(of_get_option('ft_show_next_prev')==1): ?>
					<div class="row navigation-blog-outer">
						<div class="col-md-6 col-xs-6 text-left">
							<div class="navigation-blog"><?php previous_post_link('&larr; %link'); ?></div>
						</div>
						<div class="col-md-6 col-xs-6 text-right">
							<div class="navigation-blog"><?php next_post_link('%link &rarr;'); ?></div>
						</div>
						<div class="clearfix visible-sm visible-xs"></div>
					</div>
					<?php endif; ?>
					<?php
					// related posts
					if(of_get_option('ft_show_related_posts')==1): ?>
					<hr />
					<br />
					<?php ft_related_posts(); ?>
                  <?php endif; ?>
					
                  <?php comments_template( '', true ); // comments template include ?>
				</div>
				<!-- / blog-list -->
			</div>
			<?php if(function_exists("ft_get_sidebar")): ft_get_sidebar($post->ID, 'blog-widget-area'); endif ?>
		</div>
	</div>
</section>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>