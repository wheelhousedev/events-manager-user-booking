<?php
/**
 * Plugin Name:       Events Manager User Booking
 * Plugin URI:        https://github.com/wheelhousedev/events-manager-user-booking
 * Description:       An addon to events manager.
 * Version:           0.0.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tony Garand
 * Author URI:        http://tonygarand.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       event-manager
 * Domain Path:       /languages
 */


/**
 * Cannot override method because the events manager em-bookings.php is not in a class
 * cannot remove action because no function besides the pdf report in em-bookings has an action.
 *
 * Only way for custom interface seems to be to replace the file since we cannot override or remove
 *
 */

function pluginprefix_setup_file_change() {
	$file_getter = WP_PLUGIN_DIR ."/events-manager-user-booking/admin/em-bookings.php";
	$file_pointer = WP_PLUGIN_DIR ."/events-manager/admin/em-bookings.php";
	copy($file_getter, $file_pointer);
}

/**
 * Activatation hook.
 */
function pluginprefix_activate() {
	pluginprefix_setup_file_change();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'pluginprefix_activate' );


/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() {
	$file_orig = WP_PLUGIN_DIR ."/events-manager-user-booking/admin/em-bookings-orig.txt";
	$file_pointer = WP_PLUGIN_DIR ."/events-manager/admin/em-bookings.php";
	copy($file_orig, $file_pointer);
	unlink($file_orig);
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );
