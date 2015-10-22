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
		<p class="page-title pull-left"><?php _e('Jobs', 'frogsthemes'); ?></p>
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
			<div class="col-md-8">
				<h1><?php the_title(); ?></h1>
				<?php
				if($_GET['apply']=='1' && of_get_option('ft_application_form_id')):
					echo do_shortcode( '[contact-form-7 id="'.of_get_option('ft_application_form_id').'" title="Applicaton Form"]' );
				else:
					the_content();
					if(of_get_option('ft_application_form_id')): ?><p><a href="<?php the_permalink(); ?>?apply=1&amp;ref=<?php echo $post->ID; ?>" class="btn btn-primary btn-lg"><?php _e('Apply for this job', 'frogsthemes'); ?></a></p><?php endif;
				endif;
				?>
			</div>
			<div class="col-md-4">
				<?php
				// if not on apply page, show button
				if(!$_GET['apply']):
					if(of_get_option('ft_application_form_id')): ?><p><a href="<?php the_permalink(); ?>?apply=1&amp;ref=<?php echo $post->ID; ?>" class="btn btn-primary btn-lg"><?php _e('Apply for this job', 'frogsthemes'); ?></a></p><?php endif;
				else:
					?><p><a href="<?php the_permalink(); ?>" class="btn btn-primary btn-lg"><?php _e('Back to job details', 'frogsthemes'); ?></a></p><?php
				endif;
				?>
       	 		<div class="spacer" data-height="70"></div>
        		<dl>
        			<?php if(get_post_meta($post->ID, '_wp_job_reference', true)): ?>
					<dt><?php _e('Reference', 'frogsthemes'); ?></dt>
					<dd><?php echo get_post_meta($post->ID, '_wp_job_reference', true); ?></dd>
					<?php endif; ?>
            
           		<?php if(get_post_meta($post->ID, '_wp_job_salary', true)): ?>
					<dt><?php _e('Salary', 'frogsthemes'); ?></dt>
					<dd><?php echo get_post_meta($post->ID, '_wp_job_salary', true); ?></dd>
					<?php endif; ?>
            
           		<?php if(get_post_meta($post->ID, '_wp_job_position', true)): ?>
					<dt><?php _e('Position', 'frogsthemes'); ?></dt>
					<dd><?php echo get_post_meta($post->ID, '_wp_job_position', true); ?></dd>
					<?php endif; ?>
            
           		<?php if(get_post_meta($post->ID, '_wp_job_location', true)): ?>
					<dt><?php _e('Location', 'frogsthemes'); ?></dt>
					<dd><?php echo get_post_meta($post->ID, '_wp_job_location', true); ?></dd>
					<?php endif; ?>
            		
                  <?php
					$terms = get_the_terms( $post->ID, 'department' );
					if ( $terms && ! is_wp_error( $terms ) ) : 
						?><dt><?php _e('Department', 'frogsthemes'); ?></dt><?php
						?><dd><?php
						$depertments = array();
						foreach ( $terms as $term ):
							$depertments[] = $term->name;
						endforeach;
						echo join( ", ", $depertments );
						?></dd><?php
					endif; ?>
            
					<?php if(get_post_meta($post->ID, '_wp_job_published', true)): ?>
					<dt><?php _e('Published', 'frogsthemes'); ?></dt>
					<dd><?php echo date(get_option('date_format'), strtotime(get_post_meta($post->ID, '_wp_job_published', true))); ?></dd>
					<?php endif; ?>
            
					<?php if(get_post_meta($post->ID, '_wp_job_closing', true)): ?>
					<dt><?php _e('Closing date', 'frogsthemes'); ?></dt>
					<dd><?php echo date(get_option('date_format'), strtotime(get_post_meta($post->ID, '_wp_job_closing', true))); ?></dd>
					<?php endif; ?>
				</dl>
			</div>
		</div>
	</div>
</section>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>