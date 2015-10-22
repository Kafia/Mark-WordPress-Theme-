<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>

						<li<?php if(has_post_thumbnail()): ?> class="imagepost"<?php endif; ?>>
                        	<?php if(has_post_thumbnail()): ?>
                            <span class="post_img">
                            <?php echo ft_avail_label($post->ID); ?>
                            	<a class="borderimg" href="<?php the_permalink(); ?>"><?php the_post_thumbnail('post-outer'); ?></a>
                            </span>
                            <?php endif; ?>
                            <div class="post_rht">
                            	<strong><?php echo ft_listing_price(); ?></strong>
                                <span><?php the_title(); ?><em><?php echo implode(', ', ft_get_listing_terms($post->ID, 'listing-locations')); ?></em></span>
                                <?php the_excerpt(); ?>
                                <cite>
                                	<a href="<?php the_permalink(); ?>"><?php _e('More details', 'real-estate-pro'); ?></a>
                                	<a href="<?php the_permalink(); ?>"><?php echo ft_listing_photo_num($post->ID); ?></a>
                                	<a href="<?php the_permalink(); ?>#contactform" class="no_bg"><?php _e('Arrange viewing', 'real-estate-pro'); ?></a>
                                </cite>
                            </div>
                            <div class="clear"></div>
                        </li>