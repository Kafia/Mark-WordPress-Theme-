<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>
					<article class="blog-item item-bigger">
						<?php if(has_post_thumbnail()): ?>
						<div class="blog-thumbnail">
							<?php
							// masonry or list image size
							if(of_get_option('ft_blog_style')=='masonry'):
							?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('masonry'); ?></a>
							<?php else: ?>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-inner'); ?></a>
							<?php endif; ?>
						</div>
						<?php endif; ?>
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