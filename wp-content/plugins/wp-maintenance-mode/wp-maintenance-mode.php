<?php

/**
 * WP Maintenance Mode
 *
 * Plugin Name: WP Maintenance Mode
 * Plugin URI: https://webpremiere.de/
 * Description: Adds a splash page to your site that lets visitors know your site is down for maintenance.
 * Version: 3.0.5
 * Author: Axel Nitzschner
 * Author URI: https://webpremiere.de/
 * GitHub Plugin URI: https://github.com/anito/wp-maintenance-mode
 * GitHub Branch: master
 * Text Domain: wp-maintenance-mode
 * License: GPL-2.0+
 * Domain Path: /languages
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

/**
 * DEFINE PATHS
 */
define('WEBPR_MM__PATH', plugin_dir_path(__FILE__));
define('WEBPR_MM__CLASSES_PATH', WEBPR_MM__PATH . 'includes/classes/');
define('WEBPR_MM__FUNCTIONS_PATH', WEBPR_MM__PATH . 'includes/functions/');
define('WEBPR_MM__LANGUAGES_PATH', basename(WEBPR_MM__PATH) . '/languages/');
define('WEBPR_MM__VIEWS_PATH', WEBPR_MM__PATH . 'views/');
define('WEBPR_MM__CSS_PATH', WEBPR_MM__PATH . 'assets/css/');

/**
 * DEFINE URLS
 */
define('WEBPR_MM__URL', plugin_dir_url(__FILE__));
define('WEBPR_MM__JS_URL', WEBPR_MM__URL . 'assets/js/');
define('WEBPR_MM__CSS_URL', WEBPR_MM__URL . 'assets/css/');
define('WEBPR_MM__IMAGES_URL', WEBPR_MM__URL . 'assets/images/');
define('WEBPR_MM__AUTHOR', '?source=wpplugin&medium=wpmaintenance');

/**
 * OTHER DEFINES
 */
define('WEBPR_MM__ASSETS_SUFFIX', (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min');

/**
 * FUNCTIONS
 */
require_once WEBPR_MM__FUNCTIONS_PATH . 'helpers.php';
if (is_multisite() && !function_exists('is_plugin_active_for_network')) {
  require_once ABSPATH . '/wp-admin/includes/plugin.php';
}

/**
 * FRONTEND
 */
require_once WEBPR_MM__CLASSES_PATH . 'wp-maintenance-mode-shortcodes.php';
require_once WEBPR_MM__CLASSES_PATH . 'wp-maintenance-mode.php';
register_activation_hook(__FILE__, array('WP_Maintenance_Mode', 'activate'));
register_deactivation_hook(__FILE__, array('WP_Maintenance_Mode', 'deactivate'));

add_action('plugins_loaded', array('WP_Maintenance_Mode', 'get_instance'));

/**
 * DASHBOARD
 */
if (is_admin()) {
  require_once WEBPR_MM__CLASSES_PATH . 'wp-maintenance-mode-admin.php';
  add_action('plugins_loaded', array('WP_Maintenance_Mode_Admin', 'get_instance'));
}
