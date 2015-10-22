<?php

// define constants
define('FT_THEME_VERSION', '1.0.3');
define('FT_DIR', get_template_directory());
define('FT_TEMPLATE_URL', get_template_directory_uri());
define('FT_METABOX_URL', FT_TEMPLATE_URL . '/lib/admin/meta-box');
define('FT_METABOX_DIR', FT_DIR . '/lib/admin/meta-box');
define('ADMIN_ASSETS_DIRECTORY', get_bloginfo('template_directory') . '/lib/admin/assets/');
define('OPTIONS_FRAMEWORK_URL', get_bloginfo('template_directory') . '/lib/admin/options-framework/');
define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/lib/admin/options-framework/');

// initialise scripts
include TEMPLATEPATH . '/lib/init.php';
include TEMPLATEPATH . '/lib/framework/general.php';
include TEMPLATEPATH . '/lib/functions/ft-functions.php';
include TEMPLATEPATH . '/lib/functions/gf-placeholder.php';

// breadcrumb trail class
include TEMPLATEPATH . '/lib/framework/breadcrumbs.class.php';

// custom columns class
include TEMPLATEPATH . '/lib/framework/custom-columns.class.php';

// meta-box framework
include TEMPLATEPATH . '/lib/admin/meta-box/meta-box.php';

// custom post types
include TEMPLATEPATH . '/lib/framework/portfolio.php';
include TEMPLATEPATH . '/lib/framework/testimonials.php';
include TEMPLATEPATH . '/lib/framework/staff.php';
include TEMPLATEPATH . '/lib/framework/jobs.php';
include TEMPLATEPATH . '/lib/framework/banners.php';

// custom meta boxes
include TEMPLATEPATH . '/lib/admin/meta-boxes.php';

// banner ordering
include TEMPLATEPATH . '/lib/admin/ordering/ordering.php';

// options framework
include TEMPLATEPATH . '/lib/admin/options-framework-init.php';
include TEMPLATEPATH . '/lib/admin/options-framework/options-framework.php';

// VC init and custom shortcodes
require_once dirname( __FILE__ ) . '/wpbakery/class-tgm-plugin-activation.php';
include TEMPLATEPATH . '/lib/shortcodes/visual-composer.php';
include TEMPLATEPATH . '/lib/shortcodes/icon-box.php';
include TEMPLATEPATH . '/lib/shortcodes/banner.php';
include TEMPLATEPATH . '/lib/shortcodes/progress-bar.php';
include TEMPLATEPATH . '/lib/shortcodes/staff.php';
include TEMPLATEPATH . '/lib/shortcodes/map.php';
include TEMPLATEPATH . '/lib/shortcodes/jobs.php';
include TEMPLATEPATH . '/lib/shortcodes/pricing-box.php';
include TEMPLATEPATH . '/lib/shortcodes/portfolio.php';
include TEMPLATEPATH . '/lib/shortcodes/recent-projects.php';
include TEMPLATEPATH . '/lib/shortcodes/latest-news.php';
include TEMPLATEPATH . '/lib/shortcodes/home-banners.php';
include TEMPLATEPATH . '/lib/shortcodes/quote.php';
include TEMPLATEPATH . '/lib/shortcodes/form-map.php';

// FT Sidebar Manager
include TEMPLATEPATH . '/lib/admin/sidebar-manager/sidebar-manager.php';

// FT 1-click Installer
include TEMPLATEPATH . '/lib/admin/ft-installer/ft-installer.php';

// Widgets
include TEMPLATEPATH . '/lib/widgets/widget-twitter.php';