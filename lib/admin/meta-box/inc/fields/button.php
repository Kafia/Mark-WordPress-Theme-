<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Button_Field' ) )
{
	class RWMB_Button_Field
	{
		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			return sprintf(
				'<a href="#" id="%s" class="button hide-if-no-js">%s</a><script type="text/javascript">
					jQuery("#property_customer_alert_options .button").unbind("click").click(function(event) {
						
						event.preventDefault();
                   	event.stopPropagation();
						
						var data = {
							action: "my_action",
							email: jQuery(this).attr("id"),
							id: '.$_GET['post'].'
						};
						
						var getmodelurl = "'.get_bloginfo('wpurl').'/wp-admin/admin-ajax.php";
					
						jQuery.post(getmodelurl, data, function(response) {
							
						});	
						
						jQuery(this).hide();
						
						jQuery(this).unbind();
						
					});
					
					</script>',
				$field['id'],
				$field['std']
			);
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field['std'] = $field['std'] ? $field['std'] : __( 'Click me', 'boa' );
			return $field;
		}
	}
}
