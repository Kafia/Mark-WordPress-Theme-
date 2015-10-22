<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

get_header(); ?>

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
<?php if(rwmb_meta('_wp_show_next_prev')=='1' || rwmb_meta('_wp_show_social_share')=='1'): ?>
<section class="content-area bg1">
	<div class="container">
		<div class="portfolioNav">
			<div class="row">
				<div class="col-md-6">
					<?php if(rwmb_meta('_wp_show_next_prev')=='1'): ?>
                  <?php previous_post_link( '<div class="btn btn-default">%link</div>', __('&larr; Prev project', 'frogsthemes')); ?>
                  <?php next_post_link( '<div class="btn btn-default">%link</div>', __('Next project &rarr;', 'frogsthemes')); ?>
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<?php if(rwmb_meta('_wp_show_social_share')=='1'): ?>
					<ul class="socialIcons bigIcons type2 pull-right">
						<li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="http://twitter.com/share?text=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li><a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Google+"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="http://pinterest.com/pin/create/link/?url=<?php the_permalink(); ?>" data-toggle="tooltip" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php the_content(); ?>
<?php if(rwmb_meta('_wp_show_related_section') == 1): ?>
<section class="content-area bg2">
	<div class="container">
		<?php if(rwmb_meta('_wp_related_title')): ?>
		<header class="page-header text-center">
			<h2 class="page-title"><?php echo rwmb_meta('_wp_related_title'); ?></h2>
		</header>
		<?php endif; ?>
		<?php
		global $post;
		// get categories for portfolio item
		$cats = get_the_terms( $post->ID, 'portfolio-category' );
        
		// if it has categories
		if ( $cats && ! is_wp_error( $cats ) ) : 
    
			$cats_array = array();
        
			// loop through and add each category id to an array
			foreach ( $cats as $cat ):
				$cats_array[] = $cat->term_id;
			endforeach;
            
			// get latest 4 portfolio items that are in one of those categories, exclusing the id of the current one
			$args = array('tax_query' => array(
								array(
									'taxonomy' => 'portfolio-category',
									'field' => 'id',
									'terms' => $cats_array,
									'operator' => 'IN'
								)
							),
							'post_type' => 'portfolio',
                         'post__not_in' => array($post->ID),
                         'posts_per_page' => 4,
                         'caller_get_posts' => 1);
        
			$related_posts = new wp_query($args); 
           
			// if other items in the cateogies exist
			if($related_posts->have_posts()):
              ?><div id="galleryContainer" class="clearfix withSpaces col-4"><?php
                
				// loop through and display them
				while( $related_posts->have_posts() ):
                    
					$related_posts->the_post();
					?>
					<div class="galleryItem identity web">
						<article class="portfolio-item">
							<?php if(has_post_thumbnail()): ?>
							<div class="portfolio-thumbnail">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('related'); ?></a>
								<a href="<?php the_permalink(); ?>" class="overlay-img"><span class="overlay-ico"><i class="fa fa-plus"></i></span></a>
							</div>
							<?php endif; ?>
							<?php
							// find and display categories of portfolio items
							$categories = get_the_terms( get_the_ID(), 'portfolio-category' );
							if ($categories && ! is_wp_error($categories )):
							?>
							<div class="entry-meta">
								<span class="cat-links"><?php
								$cat_list = array();
								foreach ( $categories as $category ):
									$cat_list[] = $category->name;
								endforeach;
								echo join( ", ", $cat_list ); ?></span>
							</div>
							<?php endif; ?>
							<h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</article>
					</div>
					<?php
				endwhile;  
				?></div><?php        
			endif;
			wp_reset_query();  
		endif;
		?>
	</div>
</section>
<!-- / section -->
<?php endif; ?>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>