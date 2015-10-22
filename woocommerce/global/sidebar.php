<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(function_exists("ft_get_sidebar")): ft_get_sidebar(get_the_ID(), 'shop-widget-area'); endif; ?>