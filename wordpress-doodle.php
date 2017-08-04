<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://woocommerce.db-dzine.com
 * @since             1.0.0
 * @package           Wordpress_Doodle
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress Doodle
 * Plugin URI:        http://woocommerce.db-dzine.com
 * Description:       Easy Doodle Wordpress Plugin
 * Version:           1.0.1
 * Author:            DB-Dzine
 * Author URI:        http://www.db-dzine.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-doodle
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wordpress-doodle-activator.php
 */
function activate_Wordpress_Doodle() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-doodle-activator.php';
	$Wordpress_Doodle_Activator = new Wordpress_Doodle_Activator();
	$Wordpress_Doodle_Activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wordpress-doodle-deactivator.php
 */
function deactivate_Wordpress_Doodle() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-doodle-deactivator.php';
	Wordpress_Doodle_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Wordpress_Doodle' );
register_deactivation_hook( __FILE__, 'deactivate_Wordpress_Doodle' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-doodle.php';

/**
 * Run the Plugin
 * @author Daniel Barenkamp
 * @version 1.0.0
 * @since   1.0.0
 * @link    http://woocommerce.db-dzine.com
 */
function run_Wordpress_Doodle() {

	$plugin = new Wordpress_Doodle();
	$plugin->run();

}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// Load the TGM init if it exists
if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/tgm/tgm-init.php' ) ) {
    require_once plugin_dir_path( __FILE__ ) . 'admin/tgm/tgm-init.php';
}

if ( is_plugin_active('redux-framework/redux-framework.php')) {
	run_Wordpress_Doodle();
} else {
	add_action( 'admin_notices', 'Wordpress_Doodle_Not_Installed' );
}

function Wordpress_Doodle_Not_Installed()
{
	?>
    <div class="error">
      <p><?php _e( 'Wordpress Doodle requires the free Redux Framework plugin. Please install or activate them before!', 'wordpress-doodle'); ?></p>
    </div>
    <?php
}
