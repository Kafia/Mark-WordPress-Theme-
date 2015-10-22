<?php

/**
 * Initialise widget areas
 *
 * @since 1.0
 */
 
if ( ! function_exists( 'ft_widgets_init' ) ){
	function ft_widgets_init() {
		
		// sidebar widget area for the blog
		register_sidebar( array(
			'name' => __( 'Blog Widget Area', 'frogsthemes'),
			'id' => 'blog-widget-area',
			'description' => __( 'The blog sidebar widget area', 'frogsthemes'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		) );
		
		// sidebar widget area for a page
		register_sidebar( array(
			'name' => __( 'Page Widget Area', 'frogsthemes'),
			'id' => 'page-widget-area',
			'description' => __( 'The page sidebar widget area', 'frogsthemes'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		) );
		
		
		// footer widget area
		register_sidebar( array(
			'name' => __( 'Footer Widget Area', 'frogsthemes'),
			'id' => 'footer-widget-area',
			'description' => __( 'Widget area in the footer', 'frogsthemes'),
			'before_widget' => '<aside id="%1$s" class="col-md-3 widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<p><strong class="widget-title">',
			'after_title' => '</strong></p>',
		) );
		
		// woo shop widget area
		register_sidebar( array(
			'name' => __( 'Woocommerce Shop Widget Area', 'frogsthemes'),
			'id' => 'shop-widget-area',
			'description' => __( 'Widget area for a Woocommerce shop', 'frogsthemes'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
		) );
		
		// custom sidebars
		$dynamic_active_sidebars = get_option("ft_active_sidebars");
		
		if($dynamic_active_sidebars==""):
			$dynamic_active_sidebars = array();
		endif;
		
		foreach($dynamic_active_sidebars as $widget):
				
			$temp_widget = array(  
				'name' 			=> $widget,
				'description' 	=> __( 'Dynamic sidebar', 'frogsthemes'),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h4>',
				'after_title' 	=> '</h4>',
			);
		
			register_sidebar($temp_widget);
		
		endforeach;
		
	}
}
add_action( 'widgets_init', 'ft_widgets_init' );


/**
 * Add sidebar options boxes to posts/pages
 *
 * @since 1.0
 */

if(!function_exists('ft_sidebars_add_custom_box')){
	function ft_sidebars_add_custom_box() {
		 add_meta_box('ftsidebars', __( 'FT Sidebars', 'frogsthemes'), 'ft_sidebars_custom_box','page', 'side', 'high');
		 add_meta_box('ftsidebars', __( 'FT Sidebars', 'frogsthemes'), 'ft_sidebars_custom_box','post', 'side', 'high');
		 add_meta_box('ftsidebars', __( 'FT Sidebars', 'frogsthemes'), 'ft_sidebars_custom_box','product', 'side', 'high');
	}
}
/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'ft_sidebars_add_custom_box');


/**
 * Sidebar options for posts/pages
 *
 * @since 1.0
 */

if(!function_exists('ft_sidebars_custom_box')){
	function ft_sidebars_custom_box() {
		
		//get post meta value
		global $post;
		
		$active_sidebars = array();
		$align = get_post_meta($post->ID,'_sidebar_align',true);
		$sidebar = get_post_meta($post->ID,'_dynamic_sidebar',true);
		$enable_sidebar = get_post_meta($post->ID,'_enable_sidebar',true);
		$active_sidebars = get_option("ft_active_sidebars");
		
		if($active_sidebars==''): $active_sidebars = array(); endif;
		
		$sidebar_array = '<select name="dynamic_sidebars"><option value="default">'.__("Default", "frogsthemes").'</option>';
		foreach($active_sidebars as $bar )
		{
			if($sidebar==$bar)
				$sidebar_array = $sidebar_array."<option value='{$bar}' selected>{$bar}</option>";
			else 
				$sidebar_array = $sidebar_array."<option value='{$bar}'>{$bar}</option>";
		}
		$sidebar_array =  $sidebar_array.'</select>';
	
	
		?>
		<div id="sidebar_box">
			<p>
				<label><?php _e('Sidebar Alignment', 'frogsthemes'); ?></label>
				<label for="algin_left"><?php _e('Left', 'frogsthemes'); ?></label><input type="radio" id="algin_left" name="align" value="left" <?php if($align=="left") echo "checked='checked'"; ?> />
				<label for="algin_right"><?php _e('Right', 'frogsthemes'); ?></label><input type="radio" id="algin_right" name="align" value="right" <?php if($align!="left") echo "checked='checked'"; ?>/>
			</p>
			<p>
				<label for="dynamic_sidebars"><?php _e('Dynamic Sidebars', 'frogsthemes'); ?></label>
				<?php echo  $sidebar_array; ?>
			</p>
			<p>
				<label for=""><?php _e('Enable Sidebar', 'frogsthemes'); ?></label>
				<label for="sidebar_yes"><?php _e('Yes', 'frogsthemes'); ?></label><input type="radio" id="sidebar_yes" name="enable_sidebar" value="true" <?php if($enable_sidebar=="true" || trim($enable_sidebar) =="" ) echo "checked='checked'"; ?> />
				<label for="sidebar_no"><?php _e('No', 'frogsthemes'); ?></label><input type="radio" id="sidebar_no" name="enable_sidebar" value="false" <?php if($enable_sidebar=="false") echo "checked='checked'"; ?>/>
			</p>
		</div>
		 
		<?php
	}
}


/**
 * Save sidebar options
 *
 * @since 1.0
 */

if(!function_exists('ft_sidebars_save_postdata')){
	/* when the post is saved, save the custom data */
	function ft_sidebars_save_postdata($post_id) {
			
		// do not save if this is an auto save routine
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
		
		$_POST["align"] = (!isset($_POST["align"])) ? '' : $_POST["align"];
		$_POST["dynamic_sidebars"] = (!isset($_POST["dynamic_sidebars"])) ? '' : $_POST["dynamic_sidebars"];
		$_POST["enable_sidebar"] = (!isset($_POST["enable_sidebar"])) ? '' : $_POST["enable_sidebar"];
		
		update_post_meta($post_id, "_sidebar_align", $_POST["align"]);
		update_post_meta($post_id, "_dynamic_sidebar", $_POST["dynamic_sidebars"]);
		update_post_meta($post_id, "_enable_sidebar", $_POST["enable_sidebar"]);	
	}
}
/* use save_post action to handle data entered */
add_action('save_post', 'ft_sidebars_save_postdata');


/**
 * Adds classes to content and sidebar to float left/right or make full width depending on choice from options
 *
 * @since 1.0
 */
 
if(!function_exists('ft_sidebar_float')){
	function ft_sidebar_float($section, $postid){
		
		$sidebaralign = get_post_meta($postid,'_sidebar_align',true);
	
		if($sidebaralign == 'left'):
			$sidebarfloat = ' sidebarleft';
			$contentfloat = ' contentright';
		else:
			$sidebarfloat = ' sidebarright';
			$contentfloat = ' contentleft';
		endif;
		
		if(get_post_meta($postid,'_enable_sidebar',true)=='false'): $contentwidth = ' fullwidth'; else: $contentwidth = ''; endif;
		
		if($section == 'content'):
			return $contentfloat.$contentwidth;
		else:
			return $sidebarfloat;
		endif;
	}
}


/**
 * Build sidebar
 *
 * @since 1.0
 */
 
if(!function_exists('ft_get_sidebar')){
	function ft_get_sidebar($postid, $sidebar){
		
		//check if dynamic sidebar added to page
		$dynamicsidebars = get_post_meta($postid,'_dynamic_sidebar',true);
		$enableidebars = get_post_meta($postid,'_enable_sidebar',true);
		
		if($enableidebars!='false'):
		
			echo '<div class="thesidebar col-md-3 '.ft_sidebar_float('sidebar', $postid).'"><div id="blog-sidebar">';

			// if dynamic sidebar added to page, use that
			if($dynamicsidebars!="default" && trim($dynamicsidebars)!=""):
				dynamic_sidebar($dynamicsidebars);
			elseif(is_active_sidebar($sidebar) && $enableidebars!='false'):
				dynamic_sidebar($sidebar);
			endif;
	
			echo "</div></div>";
		
		endif;
		
	}
}


/**
 * Initialise sidebar scripts
 *
 * @since 1.0
 */

if(!function_exists('sidebarmanager_add_init')){
	function sidebarmanager_add_init() 
	{   
		if(isset($_GET['page'])&&($_GET['page']=='sidebarmanager'))
		{	
			wp_enqueue_style('admin-style', ADMIN_ASSETS_DIRECTORY .'css/admin-style.css');
			wp_enqueue_style('admin-style', ADMIN_ASSETS_DIRECTORY .'css/sidebar-style.css');	
			wp_enqueue_script('jquery-ui-sortable', ADMIN_ASSETS_DIRECTORY . 'js/jquery.ui.sortable.js', array('jquery'));
		}
	}
}
add_action('admin_init', 'sidebarmanager_add_init');


/**
 * Initialise sidebar scripts
 *
 * @since 1.0
 */

if(!function_exists('frogsthemes_sidebar')){
	function frogsthemes_sidebar() 
	{	  
		if(isset($_POST["submit"])):
	
			update_option("ft_active_sidebars", $_POST["active"]);
			update_option("ft_inactive_sidebars", $_POST["inactive"]);
	
		endif;
		
		$active = get_option("ft_active_sidebars");
		$inactive = get_option("ft_inactive_sidebars");
	
		if($active==''): $active = array(); endif;
		if($inactive==''): $inactive = array(); endif;
		
		?>
		  
		<script>
		jQuery(function() {
			
			jQuery( "ul.droptrue" ).sortable({
				connectWith: "ul"
			});
	
			jQuery( "#activesidebars, #inactivesidebars" ).disableSelection();
			
			jQuery("#addsidebar").click(function(){
			
				if(jQuery.trim(jQuery("#sidebar_name").val())=="") return;
				
				jQuery("#activesidebars").prepend(" <li><span>" + jQuery("#sidebar_name").val() + "</span><input type=\"hidden\" value=\"" + jQuery("#sidebar_name").val() + "\" name=\"active[]\" /> <a href=\"#\" class=\"delete\">X</a></li>");
				jQuery("#sidebar_name").val("");
				
			});
			
			jQuery("#activesidebars").sortable({ placeholder:'sidebar-holder' ,connectWith: '#inactivesidebars' 
			,  stop: function(event, ui) { ui.item.find("input").attr("name","inactive[]"); }
			});
			jQuery("#inactivesidebars").sortable({ placeholder:'sidebar-holder' , connectWith: '#activesidebars'
			,  stop: function(event, ui) { ui.item.find("input").attr("name","active[]"); }
			 });
			
			jQuery(".delete").live("click",function(e){
				jQuery(this).parent().remove();
				e.preventDefault();
			});
			
		});
		</script>
	
		<div id="of_container">
			<div id="header">
				<div class="logo">
					<h2><a href="http://www.frogsthemes.com" target="_blank">FrogsThemes.com</a></h2>
				</div>
				<div class="version">
					<?php _e('Sidebar Manager', 'frogsthemes'); ?><br /><span>Version 1.0.0</span>
				</div>
				<div class="clear"></div>
			</div>
			<div id="ft-installer">
					
				<div class="fti-sidebars">
					
					<form method="post" action="" class="clearfix" >
					
						<div class="add-sidebar"> 
							<h2><?php _e('Welcome to the FT Sidebar Manager', 'frogsthemes'); ?></h2>
							<p><?php _e('Here you can create as many dynamic sidebars as you like. Creating new sidebars is easy:', 'frogsthemes'); ?></p>
							<ol>
								<li><?php _e('Add a sidebar using the form below by entering the name of your sidebar and clicking "Add". Click "Save Sidebars" to make the change.', 'frogsthemes'); ?></li>
								<li><?php _e('Once a sidebar has been created you can add widgets to them under <a href="'.get_admin_url().'widgets.php">Appearance -> Widgets</a>.', 'frogsthemes'); ?></li>
								<li><?php _e('Now when you go to a page or post where you want to use the sidebar and select it from the dropdown in the "FT Sidebars" options box in the right column. Once updated, your post/page will now use your dynamic sidebar instead of the default one. You also have options to change the alignment and to disable it if need be.', 'frogsthemes'); ?></li>
								<li><?php _e('To deactivate a sidebar, simply drag the sidebar from "Active Sidebars" over to the "Inactive Sidebars" section and click "Save Sidebars".', 'frogsthemes'); ?></li>
								<li><?php _e('To remove a sidebar, click the "X" next to the relevant sidebar and click "Save Sidebars"', 'frogsthemes'); ?></li>
							</ol>
							<p>&nbsp;</p>
							<h2><?php _e('Add Sidebar', 'frogsthemes'); ?></h2>
							<input id="sidebar_name" name="sidebar_name" type="text" />
							<input name="addsidebar" type="button" value="<?php _e('Add', 'frogsthemes'); ?>" id="addsidebar" class="button" /> 
						</div>
						
						<div class="sidebarcontainers">
							
							<?php if($_POST['submit']!=''): ?>
							<div class="success"><?php _e('Sidebars Updated!', 'frogsthemes'); ?></div>
							<?php endif ?>
							
							<div class="activecontainer">
							
								<h2><?php _e('Active Sidebars', 'frogsthemes'); ?></h2>
								
								<ul id="activesidebars" class='droptrue'>
									<?php 
									foreach($active as $sidebar) : 
										echo "<li><input type='hidden' name='active[]' value='".$sidebar."'/>".$sidebar." <a href='#' class='delete'>X</a></li>";  
									endforeach; 
									?>
								</ul>
							
							</div>
							
							<div class="inactivecontainer">
							
								<h2><?php _e('Inactive Sidebars', 'frogsthemes'); ?></h2>
								
								<ul id="inactivesidebars" class='droptrue'>
									<?php 
									foreach($inactive as $sidebar) : 
										echo "<li><input type='hidden' name='inactive[]' value='".$sidebar."'/>".$sidebar." <a href='#' class='delete'>X</a></li>";
									endforeach; 
									?>
								</ul>
								
							</div>
						
						</div>
						
						<input name="submit" type="submit" value="<?php _e('Save Sidebars', 'frogsthemes'); ?>" class="admin-button fti-button" />
					
					</form>
					
				</div>
			</div>
		</div>
		
		<?php 
	}
}
?>