<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?>
						<form action="<?php echo home_url( '/' ); ?>" method="get" role="search" class="search-form">
							<input type="search" name="s" class="form-control" placeholder="<?php _e('Search the blog', 'frogsthemes'); ?>">
							<input type="submit" value="<?php _e('Search', 'frogsthemes'); ?>">
						</form>