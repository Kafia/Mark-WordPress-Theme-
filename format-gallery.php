<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>
					<article class="blog-item item-bigger format-gallery">
						<div class="blog-thumbnail">
							<?php
							// get any images attached to the post
							if(rwmb_meta('_wp_post_gallery')):
								$images = rwmb_meta( '_wp_post_gallery', 'type=plupload_image' ); 
								if(count($images) > 0):
									?>
								<div class="flexslider std-slider center-controls" data-smooth="false" data-animation="<?php if(of_get_option('ft_slider_transition')): echo of_get_option('ft_slider_transition'); else: echo 'fade'; endif; ?>" data-loop="<?php if(of_get_option('ft_slider_loop')=='1'): echo 'true'; else: echo 'false'; endif; ?>" data-animspeed="<?php if(of_get_option('ft_slider_speed')): echo of_get_option('ft_slider_speed'); else: echo '600'; endif; ?>" data-speed="<?php if(of_get_option('ft_slider_pause')): echo of_get_option('ft_slider_pause'); else: echo '7000'; endif; ?>" data-dircontrols="true" data-slideshow="<?php if(of_get_option('ft_slider_auto_start')=='1'): echo 'true'; else: echo 'false'; endif; ?>">
									<ul class="slides">
										<?php
										// loop through all images in gallery and display them
										foreach ( $images as $image ):
											// masonry or list image size
											if(of_get_option('ft_blog_style')=='masonry'):
												$image_url = wp_get_attachment_image_src( $image['ID'], 'masonry');
											else:
												$image_url = wp_get_attachment_image_src( $image['ID'], 'post-inner');
											endif;
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
							?>
						</div>
						<div class="innerMargin">
							<div class="entry-meta">
								<span class="entry-date"><?php the_time( get_option('date_format') ); ?></span>
								<?php
								// if blog is list style
								if(of_get_option('ft_blog_style')!='masonry'):
								?>
								<span class="cat-links"><?php _e('In', 'frogsthemes'); ?> <?php
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
								<span class="by-author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta( 'display_name' ); ?></a></span>
								<?php endif; ?>
								<span class="entry-comments"><a href="<?php comments_link(); ?>"><?php $comments_number = get_comments_number('0', '1', '%'); printf( _n( '%d Comment', '%d Comments', $comments_number, 'frogsthemes' ), $comments_number ); ?></a></span>
							</div>
							<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="readMore"><?php _e('Continue reading &rarr;', 'frogsthemes'); ?></a>
						</div>
					</article>