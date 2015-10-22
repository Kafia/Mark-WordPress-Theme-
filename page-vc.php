<?php
/**
 * Template Name: Visual Composer Template
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
<?php the_content(); ?>
<?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>