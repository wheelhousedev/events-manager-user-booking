<?php
/**
 * Plugin Name:       Events Manager User Booking
 * Plugin URI:        https://example.com/plugins/the-basics/
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


global $EMUB;
$EMUB = new Events_Manager_User_Booking;

class Events_Manager_User_Booking {

    private $textdomain = "EMUB";
    private $required_plugins = array('events-manager','events-manager-pro');
    function have_required_plugins() {
        if (empty($this->required_plugins))
            return true;
        $active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }
        foreach ($this->required_plugins as $key => $required) {
            $required = (!is_numeric($key)) ? "{$key}/{$required}.php" : "{$required}/{$required}.php";
            if (!in_array($required, $active_plugins) && !array_key_exists($required, $active_plugins))
                return false;
        }
        return true;
    }

    function __construct() {
        if (!$this->have_required_plugins())
            return;
		load_plugin_textdomain($this->textdomain, false, dirname(plugin_basename(__FILE__)) . '/languages');
		$file_pointer = WP_PLUGIN_DIR ."/admin/em-bookings.php";
		if (!unlink($file_pointer)) {
			echo ("$file_pointer cannot be deleted due to an error");
		}
		else {
			echo ("$file_pointer has been deleted");
		}
	}
}
//Admin Files
if( is_admin() ){
	include('admin/em-bookings.php');
}
