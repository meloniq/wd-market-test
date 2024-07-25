<?php
/**
 * Plugin Name:       WD Market (Test Task)
 * Plugin URI:        https://wdmarket.com
 * Description:       Recrutation task for WD Market.
 *
 * Requires at least: 6.5
 * Requires PHP:      8.0
 * Version:           1.0
 *
 * Author:            WD Market
 * Author URI:        https://wdmarket.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wd-market-test
 *
 * Requires Plugins:  woocommerce
 *
 * @package           meloniq
 */

namespace WDMarket\TestTask;

// If this file is accessed directly, then abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WDM_TT_TD', 'wd-market-test' );
define( 'WDM_TT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Include the autoloader so we can dynamically include the rest of the classes.
require_once trailingslashit( dirname( __FILE__ ) ) . 'vendor/autoload.php';

/**
 * Setup Plugin data.
 *
 * @return void
 */
function setup() {
	global $wd_market_test;

	// If WooCommerce is not active, then abort.
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	$wd_market_test['registration'] = new Registration();
	$wd_market_test['edit-profile'] = new EditProfile();
}
add_action( 'after_setup_theme', 'WDMarket\TestTask\setup' );


/**
 * Load Text-Domain.
 *
 * @return void
 */
function load_textdomain() {
	load_plugin_textdomain( WDM_TT_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'WDMarket\TestTask\load_textdomain' );
