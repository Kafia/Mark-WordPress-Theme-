<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>
<footer>
	<?php if ( is_active_sidebar( 'footer-widget-area' )) : ?>
	
	<?php endif; ?>
	<div class="container postfooter">
		<div class="row">
			
			<aside class="col-md-6 widget col-xs-12">
				<ul class="socialIcons pull-left">
					<?php if(of_get_option('ft_facebook')): ?><li><a href="<?php echo of_get_option('ft_facebook'); ?>" target="_blank" data-toggle="tooltip" title="Facebook"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
					<?php if(of_get_option('ft_twitter')): ?><li><a href="<?php echo of_get_option('ft_twitter'); ?>" target="_blank" data-toggle="tooltip" title="Twitter"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
					<?php if(of_get_option('ft_google_plus')): ?><li><a href="<?php echo of_get_option('ft_google_plus'); ?>" target="_blank" data-toggle="tooltip" title="Google+"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
					<?php if(of_get_option('ft_linkedin')): ?><li><a href="<?php echo of_get_option('ft_linkedin'); ?>" target="_blank" data-toggle="tooltip" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li><?php endif; ?>
					<?php if(of_get_option('ft_pinterest')): ?><li><a href="<?php echo of_get_option('ft_pinterest'); ?>" target="_blank" data-toggle="tooltip" title="Pinterest"><i class="fa fa-pinterest"></i></a></li><?php endif; ?>
					<?php if(of_get_option('ft_youtube')): ?><li><a href="<?php echo of_get_option('ft_youtube'); ?>" target="_blank" data-toggle="tooltip" title="YouTube"><i class="fa fa-youtube"></i></a></li><?php endif; ?>
				</ul>
			</aside>
			<aside class="col-md-6 col-xs-12 widget">
			<!--	<p><?php if(of_get_option('ft_footer_copyright')): echo of_get_option('ft_footer_copyright'); else: ?>&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('title'); ?><?php endif; ?><?php if(of_get_option('ft_hide_ft_link')=='0'): ?>, Handcrafted by <a href="http://www.frogsthemes.com" data-toggle="tooltip" title="Premium WordPress Themes">FrogsThemes.com</a><?php endif; ?></p> -->
<p class="pull-right"><a href="http://architects-register.org.uk/architect/083622B"><img src="http://mark.teamsutlej.com/wp-content/uploads/2015/10/arb-logo-yl.png" width="50px" /><a>
<a href="https://members.architecture.com/custom/bespoke/directory/dir_details.asp?id=80523&type=I&dir=3">
<img src="http://mark.teamsutlej.com/wp-content/uploads/2015/10/RIBA-Logo-inverted.gif" width="80px" padding-right: 20px; />
</a>
</p>
			</aside>
		</div>
	</div>
</footer>
</div><!-- / boxedWrapper -->
<a href="#" id="toTop"><i class="fa fa-angle-up"></i></a>
<?php wp_footer(); ?>
</body>
</html>