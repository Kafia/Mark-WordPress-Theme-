(function($){

	jQuery(document).ready(function() {
	
		jQuery('#page_template').change(function() {
			
			// show home page options on home page template
			jQuery('#home_options').toggle(jQuery(this).val() == 'tpl-home.php');

			// hide boxes if one of those templates
			jQuery('#page_options, #sponsor_options, #banner_options').toggle(jQuery(this).val() != 'tpl-home.php' && jQuery(this).val() != 'tpl-account.php' && jQuery(this).val() != 'tpl-dashboard.php' && jQuery(this).val() != 'tpl-no-left-sidebar.php');
			
		}).change();
		
	});

})(jQuery);