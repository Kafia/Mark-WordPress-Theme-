<?php
/**
 * The Header for our theme.
 *
 * @package WordPress
 * @subpackage FrogsThemes
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php wp_title(''); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/lib/assets/css/animate.css">
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/lib/assets/css/bootstrap.css">
<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
<script type="text/javascript">
	jQuery.noConflict();
</script>
<style>
.navbar-brand{
margin-right:0;
padding-right:0;

}
</style>
</head>
<body <?php body_class('withAnimation'); ?>>
<div id="boxedWrapper">
<!-- navbar -->
<nav class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container">
       
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" class="pull-right" href="<?php echo home_url( '/' ); ?>">
			<?php if(of_get_option('ft_custom_logo') != ''): ?>
				<img src="<?php echo of_get_option('ft_custom_logo') ?>" alt="<?php bloginfo( 'name' ); ?>" />
			<?php else: ?>
				<?php bloginfo( 'name' ); ?>
			<?php endif; ?>
			</a>
		</div>
		<div class="navbar-collapse collapse">
            <form action="<?php echo home_url( '/' ); ?>" method="get" class="pull-right header-search" role="form" style="display:none;">
          
            </form>
           
            <?php wp_nav_menu( array('theme_location' => 'top-nav', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'depth' => '3', 'echo' => 1, 'fallback_cb' => false)); // top-nav menu ?>
        </div>
	</div>
</nav>
<!-- / navbar -->