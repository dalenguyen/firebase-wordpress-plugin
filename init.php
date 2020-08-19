<?php
/**
 * The initation loader for Firebase, and the main plugin file.
 *
 * @category     WordPress_Plugin
 * @package      integrate-firebase
 * @author       dalenguyen
 * @license      GPL-2.0+
 * @link         https://github.com/dalenguyen/firebase-wordpress-plugin
 *
 * Plugin Name:  Integrate Firebase
 * Plugin URI:   https://github.com/dalenguyen/firebase-wordpress-plugin
 * Description:  Integrate Firebase is a plugin that helps to integrate Firebase features to WordPress
 * Author:       dalenguyen
 * Author URI:   http://dalenguyen.me
 * Contributors: Dale Nguyen (@dalenguyen)
 *
 * Version:      0.7.0
 *
 * Text Domain:  integrate-firebase
 *
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * https://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

/**
 * *********************************************************************
 *               You should not edit the code below
 *               (or any code in the included files)
 *               or things might explode!
 * ***********************************************************************
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('FIREBASE_WP_VERSION', '0.7.0');
define('FIREBASE_WP__MINIMUM_WP_VERSION', '4.0.0');
define('FIREBASE_WP__PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once FIREBASE_WP__PLUGIN_DIR . 'includes/class.firebase.php';
add_action('init', array('Firebase', 'init'));

require_once FIREBASE_WP__PLUGIN_DIR . 'includes/class.shortcodes.php';
add_action('init', array('Firebase_Shortcode', 'init'));

// Load plugins files
if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once FIREBASE_WP__PLUGIN_DIR . 'includes/class.firebase-admin.php';
    add_action('init', array('Firebase_Admin', 'init'));
}
