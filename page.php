<?php
/**
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

get_header(); 
?>
<?php while ( have_posts() ) : the_post(); ?>
<?php if(rwmb_meta('_wp_show_title_section')=='1'): ?>
<header class="main-header clearfix">
	<div class="container">
		<p class="page-title pull-left"><?php echo get_the_title(); ?></p>
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
						<?php if(has_post_thumbnail()): ?>
						<div class="blog-thumbnail">
							<?php the_post_thumbnail('post-inner'); ?>
						</div>
						<?php endif; ?>
						<div class="innerMargin"> 
							<?php the_content();
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
						</div>
					</article>
					<!-- / blog-item -->
					<?php comments_template( '', true ); // comments template include ?>
				</div>
				<!-- / blog-list -->
			</div>
			<?php if(function_exists("ft_get_sidebar")): ft_get_sidebar($post->ID, 'page-widget-area'); endif ?>
		</div>
	</div>
</section>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>