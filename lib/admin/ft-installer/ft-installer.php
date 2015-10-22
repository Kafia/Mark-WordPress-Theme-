<?php

/*

FrogsThemes.com - FT Installer

*/

// get theme name
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$themename = preg_replace("/\W/", "", strtolower($themename) );

// when theme activated, it updates the option and redirects to the FT Installer page
function my_theme_activate() {
	header("Location: admin.php?page=ftinstaller");
}
wp_register_theme_activation_hook($themename, 'my_theme_activate');

// when theme deactivated, it removes the option
function my_theme_deactivate() {
	// code to execute on theme deactivation
}
wp_register_theme_deactivation_hook($themename, 'my_theme_deactivate');

function wp_register_theme_activation_hook($code, $function) {
	$optionKey="theme_is_activated_" . $code;
	if(!get_option($optionKey)) {
		call_user_func($function);
		update_option($optionKey , 1);
	}
}
function wp_register_theme_deactivation_hook($code, $function) {
	 $GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;
	 $fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');
	 add_action("switch_theme", $fn);
}

// import css and js files
function ft_installer_scripts() { 
	if(isset($_GET['page'])&&($_GET['page']=='ftinstaller')){	
		wp_enqueue_style('admin-style', ADMIN_ASSETS_DIRECTORY .'css/admin-style.css');
	}
}
add_action('admin_init', 'ft_installer_scripts');

// check if uploads folder exists and pemrissions are set to write
function fticheckuploads(){

	$upload_dir = wp_upload_dir();
	
	if(is_dir($upload_dir['basedir']) && !is_writable($upload_dir['basedir'])):
	
		return true;
	
	elseif(!is_dir($upload_dir['basedir'])):
		
		return true;
	
	else:
		
		return false;
		
	endif;
}

// Get the id of a page by its name
function ft_installer_get_page_id($page_name){
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."' AND post_type='page'");
	return $page_name;
}

function fti_createmenus(){
				
	// delete current menu if exists
	$term = get_term_by('slug', 'top-nav', 'nav_menu');
	wp_delete_term($term->term_id, 'nav_menu');
	global $wpdb;
	$nav = $wpdb->query("DELETE FROM $wpdb->posts WHERE post_type='nav_menu_item'");
	
	// check if term exists
	if(term_exists('Top Navigation', 'nav_menu')):
	
	
	else: // if 'Top Nav' is not already set, add it
		
		wp_insert_term(
		  'Top Navigation', // the term 
		  'nav_menu', // the taxonomy
		  array(
			'description'=> 'Top Navigation menu',
			'slug' => 'top-nav'
		  )
		);
	
	endif;
	
	// now get a list of all pages
	$args = array(
		'child_of' => 0,
		'sort_order' => 'ASC',
		'sort_column' => 'menu_order',
		'hierarchical' => 1,
		'parent' => -1,
		'post_type' => 'page',
		'post_status' => 'publish'
	);
	
	$pages = get_pages($args);
	
	$nav_menu_array = array();
	
	// loop through pages and add them to the custom menu
	foreach ($pages as $pagg):
		
		if($pagg->post_name!='sample-page'): // don't add sample page to menu
		
			// add page as nav_menu_item to posts
			$post = array(
			  'menu_order' => $pagg->menu_order, //If new post is a page, sets the order should it appear in the tabs.
			  'comment_status' => 'closed', // 'closed' means no comments.
			  'ping_status' => 'closed', // 'closed' means pingbacks or trackbacks turned off
			  'post_author' => $user_ID,
			  'post_date' => date('Y-m-d H:i:s'), //The time post was made.
			  'post_date_gmt' => date('Y-m-d H:i:s'), //The time post was made, in GMT.
			  'post_name' => $pagg->post_name, // The name (slug) for your post
			  'post_parent' => $pagg->post_parent, //Sets the parent of the new post.
			  'post_status' => 'publish', //Set the status of the new post. 
			  'post_title' => $pagg->post_title, //The title of your post.
			  'post_type' => 'nav_menu_item' //You may want to insert a regular post, page, link, a menu item or some custom post type
			);
			$nav_menu_id = wp_insert_post($post); // add new nav_menu_item
			
			// add to array of nav menus
			//$nav_menu_array[] = $nav_menu_id;
			$nav_menu_array[] = array('nav_menu_id' => $nav_menu_id, 'page_id' => $pagg->ID, 'post_name' => $pagg->post_name, 'post_parent' => $pagg->post_parent);
			
			wp_set_object_terms($nav_menu_id, 'top-nav', 'nav_menu'); // set a relationship between the nav_menu_itme and the menu
		
		endif;
	
	endforeach;
	
	// loop through nav_menu_array and add post meta to
	foreach ($nav_menu_array as $nav_menu_array_item):
		
		global $wpdb;
		$posts_db_name = $wpdb->prefix . "posts";
		
		// get parent post ID
		$parent_name = $wpdb->get_row("SELECT * FROM ".$posts_db_name." WHERE ID='".$nav_menu_array_item['post_parent']."'");
		$parent_nav_ID = $wpdb->get_row("SELECT ID FROM ".$posts_db_name." WHERE post_name='".$parent_name->post_name."' AND post_type='nav_menu_item'");
		
		$wpdb->query("
			UPDATE ".$posts_db_name." 
			SET post_parent = '".$parent_nav_ID->ID."' 
			WHERE ID = '".$nav_menu_array_item['nav_menu_id']."'
			");
		
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_sidebar_align', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_dynamic_sidebar', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_enable_sidebar', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_type', 'custom', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_menu_item_parent', $parent_nav_ID->ID, true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_object_id', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_object', 'custom', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_target', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_classes', 'a:1:{i:0;s:0:"";}', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_xfn', '', true);
		add_post_meta($nav_menu_array_item['nav_menu_id'], '_menu_item_url', get_permalink($nav_menu_array_item['page_id']), true);
	
	endforeach;
	
	// set menu we created to be in the placeholder for the theme...
	$table_db_name = $wpdb->prefix . "terms";
	$rows = $wpdb->get_results("SELECT * FROM $table_db_name where name='Top Navigation'",ARRAY_A);
	$menu_ids = array();
	
	foreach($rows as $row):
		
		$menu_ids[$row["name"]] = $row["term_id"];
	
	endforeach;
	
	set_theme_mod( 'nav_menu_locations', array_map( 'absint', array( 'top-nav' => $menu_ids['Top Navigation']) ) );

}

function fti_themeoptions(){
				
	// default options array
	$optionval = 'a:30:{s:17:"ft_custom_favicon";s:0:"";s:6:"ft_rss";s:0:"";s:13:"ft_custom_css";s:0:"";s:12:"ft_custom_js";s:0:"";s:19:"ft_show_breadcrumbs";s:1:"1";s:22:"ft_application_form_id";s:4:"1884";s:14:"ft_custom_logo";s:0:"";s:14:"ft_header_text";s:21:"Add your text here...";s:15:"ft_header_phone";s:13:"01234 567 890";s:19:"ft_footer_copyright";s:20:"© 2014 RemovalsPro.";s:15:"ft_hide_ft_link";b:0;s:13:"ft_blog_style";s:7:"masonry";s:19:"ft_show_share_links";s:1:"1";s:14:"ft_show_author";s:1:"1";s:17:"ft_show_next_prev";s:1:"1";s:21:"ft_show_related_posts";s:1:"1";s:15:"ft_slider_speed";s:3:"600";s:15:"ft_slider_pause";s:4:"7000";s:20:"ft_slider_auto_start";s:1:"1";s:14:"ft_slider_loop";s:1:"1";s:11:"ft_facebook";s:19:"http://facebook.com";s:10:"ft_twitter";s:18:"http://twitter.com";s:14:"ft_google_plus";s:22:"http://plus.google.com";s:11:"ft_linkedin";s:19:"http://linkedin.com";s:12:"ft_pinterest";s:20:"http://pinterest.com";s:10:"ft_youtube";s:18:"http://youtube.com";s:12:"consumer_key";s:0:"";s:15:"consumer_secret";s:0:"";s:12:"access_token";s:0:"";s:19:"access_token_secret";s:0:"";}';
	
	global $wpdb;
	$wpdb->query("UPDATE $wpdb->options SET option_value='".$optionval."' WHERE option_name = 'removals_pro'");
	
	// set pages so home-page and blog are set correctly
	update_option('show_on_front', 'page');
	update_option('page_for_posts', ft_installer_get_page_id('blog'));
	update_option('page_on_front', ft_installer_get_page_id('home'));

}

function fti_widgets(){

	// set widgets to sidebars
	$sidebars = get_option("sidebars_widgets");
	$sidebars["blog-widget-area"] = array("search-2", "recent-posts-2", "recent-comments-2", "archives-2");
	$sidebars["page-widget-area"] = array ("search-3", "recent-posts-3", "twitterwidget-2");
	$sidebars["footer-widget-area"] = array ("text-2", "twitterwidget-3", "nav_menu-2", "recent-posts-4");
	
	update_option("sidebars_widgets",$sidebars);
	
	// widget_archives
	$widget_archives = get_option("widget_archives");
	$widget_archives[2] = array("title" => "", "count" => "0", "dropdown" => "0");
	$widget_archives["_multiwidget"] = 1;
	update_option("widget_archives",$widget_archives);
	
	// widget_nav_menu
	$widget_nav_menu = get_option("widget_nav_menu");
	$widget_nav_menu[2] = array("title" => "Browse", "nav_menu" => "180");
	$widget_nav_menu["_multiwidget"] = 1;
	update_option("widget_nav_menu",$widget_nav_menu);
	
	// widget_recent-comments
	$widget_recent_comments = get_option("widget_recent-comments");
	$widget_recent_comments[2] = array("title" => "", "number" => "5");
	$widget_recent_comments["_multiwidget"] = 1;
	update_option("widget_recent_comments",$widget_recent_comments);
	
	// widget_recent-posts
	$widget_recent_posts = get_option("widget_recent-posts");
	$widget_recent_posts[2] = array("title" => "", "number" => "5");
	$widget_recent_posts[3] = array("title" => "", "number" => "5");
	$widget_recent_posts[4] = array("title" => "Recent Posts", "number" => "5");
	$widget_recent_posts["_multiwidget"] = 1;
	update_option("widget_recent_posts",$widget_recent_posts);

	// widget_search
	$widget_search = get_option("widget_search");
	$widget_search[2] = array("title" => "");
	$widget_search[3] = array("title" => "");
	$widget_search["_multiwidget"] = 1;
	update_option("widget_search",$widget_search);
	
	// widget_text
	$widget_text = get_option("widget_text");
	$widget_text[2] = array("title" => "Contact Us", "text" => "<a href=\"mailto:email@address.com\">email@domain.com</a>

Address line 1,
Address line 2,
Address line 3,
Address line 4,
Address line 

Phone: 01234 567 890");
	$widget_text["_multiwidget"] = 1;
	update_option("widget_text",$widget_text);	
	
}

function fti_importcontent(){

	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	
	require_once ABSPATH . 'wp-admin/includes/import.php';
	
	$importer_error = false;
	
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	
		if ( file_exists( $class_wp_importer ) )
		{
			require_once($class_wp_importer);
		}
		else
		{
			$importer_error = true;
		}
	}
	
	if ( !class_exists( 'WP_Import' ) ) {
		$class_wp_import = TEMPLATEPATH . '/lib/admin/ft-installer/importer/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) )
			require_once($class_wp_import);
		else
			$importerError = true;
	}
	
	if($importer_error)
	{
		die("Error in import :(");
	}
	else
	{
		if ( class_exists( 'WP_Import' )) 
		{
			include_once('importer/class.frogsthemes-importer.php');
		}
	
		if(!is_file(TEMPLATEPATH."/lib/admin/ft-installer/frogsthemes_content.xml"))
		{
			echo "The XML file containing the dummy content is not available or could not be read in <pre>".TEMPLATEPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your themes folder: frogsthemes_content.xml) manually <a href='/wp-admin/import.php'>here.</a>";
		}
		else
		{
			$wp_import = new frogsthemes_import();
			$wp_import->fetch_attachments = true;
			$wp_import->import(TEMPLATEPATH."/lib/admin/ft-installer/frogsthemes_content.xml");
			$wp_import->saveOptions();
		}
	}
}

function fti_sliders(){
	
	// delete all current home banners
	global $wpdb;
	$homebanners = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_type='ft-banner'");
	
	foreach($homebanners as $banner):
		
		wp_delete_post($banner->ID, true);
		
	endforeach;
	
	if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
	
	require_once ABSPATH . 'wp-admin/includes/import.php';
	
	$importer_error = false;
	
	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	
		if ( file_exists( $class_wp_importer ) )
		{
			require_once($class_wp_importer);
		}
		else
		{
			$importer_error = true;
		}
	}
	
	if ( !class_exists( 'WP_Import' ) ) {
		$class_wp_import = TEMPLATEPATH . '/lib/admin/ft-installer/importer/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) )
			require_once($class_wp_import);
		else
			$importerError = true;
	}
	
	if($importer_error)
	{
		die("Error in import :(");
	}
	else
	{
		if ( class_exists( 'WP_Import' )) 
		{
			include_once('importer/class.frogsthemes-importer.php');
		}
	
		if(!is_file(TEMPLATEPATH."/lib/admin/ft-installer/frogsthemes_banners.xml"))
		{
			echo "The XML file containing the dummy content is not available or could not be read in <pre>".TEMPLATEPATH."</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn't work please use the wordpress importer and import the XML file (should be located in your themes folder: frogsthemes_content.xml) manually <a href='/wp-admin/import.php'>here.</a>";
		}
		else
		{
			$wp_import = new frogsthemes_import();
			$wp_import->fetch_attachments = true;
			$wp_import->import(TEMPLATEPATH."/lib/admin/ft-installer/frogsthemes_banners.xml");
			$wp_import->saveOptions();
		}
	}
}

function frogsthemes_installer() {
	$url = get_admin_url()."admin.php?page=ftinstaller"; 
	?>
	<script type="text/javascript">
	
	jQuery(document).ready(function()
	{
		jQuery('.togglecont').slideUp(); // have options boxes closed as default
		
		<?php if($_GET["step"]=="createmenus"): ?>
		jQuery('.fti-currentinstall-step1 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step1 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="themeoptions"): ?>
		jQuery('.fti-currentinstall-step2 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step2 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="sliders"): ?>
		jQuery('.fti-currentinstall-step3 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step3 h3').addClass('active');
		<?php endif; ?>
		<?php if($_GET["step"]=="widgets"): ?>
		jQuery('.fti-currentinstall-step4 .togglecont').slideToggle('slow');
		jQuery('.fti-currentinstall-step4 h3').addClass('active');
		<?php endif; ?>
		
		// opening and closing of options boxes on admin page
		jQuery('.fti-currentinstall-steps h3').click(function()
		{
			if(jQuery(this).next('.togglecont').css('display')=='none')
			{	
				jQuery(this).addClass('active');
			}
			else
			{	
				jQuery(this).removeClass('active');
			}
			jQuery(this).next('.togglecont').slideToggle('slow');
		});	
	});	
	
	</script>
	<div id="of_container">
		<div id="header">
			<div class="logo">
				<h2><a href="http://www.frogsthemes.com" target="_blank">FrogsThemes.com</a></h2>
			</div>
			<div class="version">
				Theme Installer<br /><span>Version 1.0.0</span>
			</div>
			<div class="clear"></div>
        </div>
		<div id="ft-installer">
			<?php 
			if(isset($_GET["step"])) :
			
				if($_GET["step"]=="importcontent") : 
	   
					$complete_message = "Content is imported!";
					
					fti_themeoptions();
					fti_importcontent();
					fti_themeoptions();
					fti_createmenus();
					//fti_sliders();
					fti_widgets();
					
				endif;
				
				if($_GET["step"]=="createmenus") : 
					
					$complete_message_1 = true;
					
					fti_createmenus();
					
				endif;
				
				if($_GET["step"]=="themeoptions") : 
					
					$complete_message_2 = true;
					
					fti_themeoptions();
					
				endif;
				
				if($_GET["step"]=="sliders") : 
	   
					$complete_message_3 = true;
					
					fti_sliders();
				
				endif;
		 
				if($_GET["step"]=="widgets") : 
					
					$complete_message_4 = true;
					
					fti_widgets();
					
				endif;
				
			endif; ?>
	
				
			<?php 
			if(fticheckuploads()): 
			
				?>
				
				<div class="fti-error">
				
				<h2>Before we begin!</h2>
				
					<p>We've noticed that your <a href="http://codex.wordpress.org/Settings_Media_SubPanel" target="_blank">uploads folder</a> isn't writeable. You need to change the permissions to '755'. Once complete come back and refresh this page.</p>
					<p class="smaller">---</p>
					<p class="smaller"><strong>I have no idea how to do this!</strong><br />
					That's ok we promise it's easy and shouldn't take you very long at all. WordPress shows you how to do it, simply visit <a href="http://codex.wordpress.org/Changing_File_Permissions#Using_an_FTP_Client" target="_blank">this page</a> and scroll down the page to the section 'Using an FTP Client'. Once complete come back to this page and refresh the page.</p>
				
				</div>
				
				<?php
			
			else: ?>
				
				<div class="fti-installationtype">
					
					<h2>Pick your installation type</h2>
					
					<div class="fti-newinstall">
						<a href="<?php echo $url."&amp;route=fti-newinstall"; ?>"<?php if($_GET['route']=='fti-newinstall'): echo ' class="selected"'; endif; ?><?php if($_GET['route']=='fti-currentinstall'): echo ' class="oppselected"'; endif; ?>>
						<span>I'm installing this theme on a brand new website</span>
						Choose this installation type if this 
						website is a brand new website with
						a fresh installation of WordPress.
						</a>
					</div>
					
					<div class="fti-currentinstall">
						<a href="<?php echo $url."&amp;route=fti-currentinstall"; ?>"<?php if($_GET['route']=='fti-currentinstall'): echo ' class="selected"'; endif; ?><?php if($_GET['route']=='fti-newinstall'): echo ' class="oppselected"'; endif; ?>>
						<span>I'm installing this theme on my existing website</span>
						Choose this installation type if this 
						website already has live content like 
						pages, posts and comments.
						</a>
					</div>
					
				</div>
				
				<?php if(!$_GET['route']): ?>
				<div class="fti-intro">
				
					<h1>Welcome to the FrogsThemes Theme installer</h1>
					
					<p>The installer is the perfect solution for everybody who's in a hurry and doesn't have time to read the docs or wait for support. With a few clicks your new theme will be installed and looking great. There are a few things you need to consider before using this installer. Each section has it's own explanation, useful links and warnings. Please read them carefully before clicking on any buttons.</p>
					<p><br /><strong>First, please choose an installation type above to start installing...</strong></p>
				
				</div>
				<?php endif; ?>
				
				<?php if($_GET['route']=='fti-newinstall'): ?>
				
					<div class="fti-intro">
						<h1>Our famous 1-click installer</h1>
						
						<p>Setup your brand new WordPress website with just a click of a button. Just click the green button below and let our famous 1-click installer do all the hard work. The installer will import dummy content, setup your theme options, build your custom menus, set your widgets and create some homepage banners. Once it has finished feel free to look around the options in the left column and delete the dummy data once you're more familiar with the theme.</p>
					</div>
					
					<div class="fti-newinstall-steps">
					
						<?php if(get_option("fti_content_added")): ?>
						
							<div class="success">Your website has been setup successfully.</div>
						
						<?php else: ?>
						
							<div class="fti-newinstall-step1">
								<div class="fti-stage-importcontent">
									<div class="fti-1clickdiv">
										<div class="fti-1clickdivinner">
											<a href="<?php echo $url."&amp;route=fti-newinstall&amp;step=importcontent"; ?>" class="fti-button" onclick="return confirm('Are you sure you wish to continue and import dummy content to your site?');">Install this theme in 1-click</a>
										</div>
									</div>
									<div class="fti-information">
										<h2>Important Information</h2>
										<p>Do not use this installer if you already have an active website. Instead click on the other tab above and install the elements separately. </p>
									</div>
								</div>
							</div>
					
						<?php endif; ?>
					
					</div>
				
				<?php endif; ?>
				
				<?php if($_GET['route']=='fti-currentinstall'): ?>
				<div class="fti-currentinstall-steps">
					<div class="fti-currentinstall-step1">
						<div class="fti-stage-createmenus">
							
							<h3><a href="#" onclick="javascript:return false;">Step 1 - Custom Menus</a></h3>
							
							<div class="togglecont">
								
								<p>This step will create custom menus from the heirarchy of pages on your site. You'll be able to rearrange the order of the menu items, remove and add menu items easily by clicking <a href="<?php echo get_admin_url()."nav-menus.php"; ?>">APPEARANCE > MENUS</a>.</p>
								
								<?php if($complete_message_1!=''): ?>
								<div class="success">Custom menus are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=createmenus"; ?>" class="fti-button" onclick="return confirm('Click OK to create. Any changes to the custom menus will be lost!');">Create menus from pages!</a>
									</div>
								</div>
								<?php endif; ?>
							
							</div>
							
						</div>
					</div>
					<div class="fti-currentinstall-step2">
						<div class="fti-stage-themeoptions">
							<h3><a href="#" onclick="javascript:return false;">Step 2 - Theme Options</a></h3>

							<div class="togglecont">
								
								<p>This step sets the default options for the theme found under '<a href="<?php echo get_admin_url()."admin.php?page=frogsthemes"; ?>">Theme Options</a>'.
								<br />It can be run at any time, but will reset any changes you have made.
								<br /><strong>Note:</strong> You may need to select your front page and posts page under 'front page displays' on the page <a href="<?php echo get_admin_url()."options-reading.php"; ?>">SETTINGS -> READING</a></p>
								
								<?php if($complete_message_2!=''): ?>
								<div class="success">Theme options are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=themeoptions"; ?>" class="fti-button" onclick="return confirm('Click OK to reset. Any theme settings will be lost!');">Set theme option defaults!</a>
									</div>
								</div>
								<?php endif; ?>
								
							</div>
							
						</div>
					</div>
                  <div class="fti-currentinstall-step3">
						<div class="fti-stage-sliders">
							<h3><a href="#" onclick="javascript:return false;">Step 3 - Home Banners</a></h3>
							
							<div class="togglecont">
							
								<p>This step will generate dummy sliders for the home page for this theme under '<a href="<?php echo get_admin_url()."edit.php?post_type=ft-banner"; ?>">Home Banners</a>'.
								<br />It can be run at any time, but will reset any changes you have made.</p>
								
								<?php if($complete_message_3!=''): ?>
								<div class="success">Home banners are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=sliders"; ?>" class="fti-button" onclick="return confirm('Click OK to reset. Any custom slides added will be lost!');">Create dummy sliders for home page!</a>
									</div>
								</div>
								<?php endif; ?>
							
							</div>
							
						</div>
					</div>
					<div class="fti-currentinstall-step4">
						<div class="fti-stage-widgets">
							<h3><a href="#" onclick="javascript:return false;">Step 4 - Widgets</a></h3>
							
							<div class="togglecont">
								
								<p>This step creates and places widgets in designated spots around the site for you.
								<br />Running this will archive any current widgets you have.</p>
								
								<?php if($complete_message_4!=''): ?>
								<div class="success">Widgets are set!</div>
								<?php else: ?>
								<div class="fti-1clickdiv">
									<div class="fti-1clickdivinner">
										<a href="<?php echo $url."&amp;route=fti-currentinstall&amp;step=widgets"; ?>" class="fti-button" onclick="return confirm('Click OK to reset. Any widgets already placed added will be lost!');">Set dummy widgets for widget areas!</a>
									</div>
								</div>
								<?php endif; ?>
								
							</div>
							
						</div>
					</div>
					<div class="fti-currentinstall-step5">
						<div class="fti-stage-thumbnails">
							<h3 class="fti-last"><a href="#" onclick="javascript:return false;">Step 5 - Image Regeneration</a></h3>
							
							<div class="togglecont">
							
								<p>You may need to resize your images to fit into the theme. For this we advise you install and run the Regenerate Thumbnails plugin, which can be <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">found here</a>.</p>
							
							</div>
							
						</div>
					</div>
					<br />&nbsp;
					<div class="fti-information">
						<h2>Important Information</h2>
						<p>The installer has been split into 4 separate steps to allow ultimate control over what you will install. Each step is voluntary and is designed to help you get the theme setup in as little time as possible. You can work through and install each step or choose which steps to install, it's completely up to you.</p>
					</div>
				<?php endif; ?>
				<?php endif; // fticheckuploads() ?>
			</div>
		</div>
		<?php 
	} 
?>