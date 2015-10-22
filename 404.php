<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

get_header(); ?>
<section class="content-area bg2">
	<div class="container">
		<div class="pg404 text-center">
			<div class="text-in-bg clearfix">
				<span class="bigText"><?php _e('404', 'frogsthemes'); ?></span>
				<h2><?php _e('Sorry, this page doesn\'t exist', 'frogsthemes'); ?></h2>
			</div>
			<a href="<?php echo home_url( '/' ); ?>" class="btn btn-primary animated" data-fx="tada"><?php _e('Back to home page', 'frogsthemes'); ?></a>
		</div>
	</div>
</section>
<?php get_footer(); ?>