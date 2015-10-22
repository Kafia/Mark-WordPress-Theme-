<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>
					<article class="blog-item item-bigger format-quote">
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
							<div class="entry-title">
								<blockquote>
									<a href="<?php the_permalink(); ?>"><?php if(get_post_meta($post->ID, '_wp_quote', true)): ?><?php echo nl2br(get_post_meta($post->ID, '_wp_quote', true)); endif; ?>
									<span class="author">— <?php if(get_post_meta($post->ID, '_wp_quote_by', true)): ?><?php echo get_post_meta($post->ID, '_wp_quote_by', true); endif; ?></span></a>
								</blockquote>
							</div>
						</div>
					</article>