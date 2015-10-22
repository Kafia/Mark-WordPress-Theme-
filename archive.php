<?php
/**
 * The template for displaying Archive pages.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */

$postspage_id = get_option('page_for_posts');

get_header(); ?>

<?php if ( have_posts() ) : ?>
<header class="main-header clearfix">
	<div class="container">
		<h1 class="page-title pull-left"><?php
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term):
			echo $term->name;
		elseif (is_day()):
			printf(__('Daily Archive: %s', 'frogsthemes'), get_the_date(get_option('date_format')));
		elseif (is_month()):
			printf(__('Monthly Archive: %s', 'frogsthemes'), get_the_date('F Y'));
		elseif (is_year()):
			printf(__('Yearly Archive: %s', 'frogsthemes'), get_the_date('Y'));
		elseif (is_author()):
			global $post;
			$author_id = $post->post_author;
			printf(__('Author Archive: %s', 'frogsthemes'), get_the_author_meta('display_name', $author_id));
		elseif(is_tag()):
			echo __('Tag Archive: ', 'frogsthemes'); 
			single_tag_title();
		else:
			echo __('Category Archive: ', 'frogsthemes'); 
			single_cat_title();
		endif;
		?></h1>
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
<?php
// blog as masonry or list?
if(of_get_option('ft_blog_style')=='masonry'):
?>
<section class="content-area bg2">
	<div class="container">
		<div id="blog-list" class="clearfix withMasonry">
			<?php 
			while ( have_posts() ) : the_post();
				$format = get_post_format();
				get_template_part( 'format', $format );
			endwhile; 
			?>
		</div>
		<div class="lineSeparatorMasonry clearfix"></div>
		<div class="row navigation-blog-outer">
            <div class="col-md-3 col-xs-6 text-left">
                <?php if(get_previous_posts_link()): ?><div class="btn btn-default"><?php previous_posts_link(__('&larr; Previous page', 'frogsthemes')); ?></div><?php endif; ?>
            </div>
            <div class="col-md-3 col-xs-6 col-md-push-6 text-right">
                <?php if(get_next_posts_link()): ?><div class="btn btn-default"><?php next_posts_link(__('Next page &rarr;', 'frogsthemes')); ?></div><?php endif; ?>
            </div>
            <div class="clearfix visible-sm visible-xs"></div>
            <?php /* Display navigation to next/previous pages when applicable */ ?>
            <?php echo ft_pagination($wp_query->max_num_pages); ?>
        </div>
	</div>
</section>
<?php
else: // blog as list
?>
<section class="content-area bg1">
	<div class="container">
		<div class="row">
			<div class="col-md-9<?php if(function_exists("ft_sidebar_float")): echo ft_sidebar_float('content', $postspage_id); endif; ?>">
				<div id="blog-list" class="clearfix">
					<?php 
					while ( have_posts() ) : the_post();
						$format = get_post_format();
						get_template_part( 'format', $format );
					endwhile; 
					?>
				</div>
				<div class="lineSeparatorMasonry clearfix"></div>
				<div class="row navigation-blog-outer">
					<div class="col-md-3 col-xs-6 text-left">
						<?php if(get_previous_posts_link()): ?><div class="btn btn-default"><?php previous_posts_link(__('&larr; Previous page', 'frogsthemes')); ?></div><?php endif; ?>
					</div>
					<div class="col-md-3 col-xs-6 col-md-push-6 text-right">
						<?php if(get_next_posts_link()): ?><div class="btn btn-default"><?php next_posts_link(__('Next page &rarr;', 'frogsthemes')); ?></div><?php endif; ?>
					</div>
					<div class="clearfix visible-sm visible-xs"></div>
					<?php /* Display navigation to next/previous pages when applicable */ ?>
					<?php echo ft_pagination($wp_query->max_num_pages); ?>
				</div>
			</div>
			<?php if(function_exists("ft_get_sidebar")): ft_get_sidebar($postspage_id, 'blog-widget-area'); endif ?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php endif; ?>

<?php get_footer(); ?>