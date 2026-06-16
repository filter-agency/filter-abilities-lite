<?php
/**
 * Plugin Name: Filter Abilities
 * Plugin URI: https://github.com/filter-agency/filter-abilities-lite
 * Description: Exposes core WordPress content, media, taxonomy, migration, site health, and block editing abilities over MCP.
 * Version: 1.8.1
 * Author: Filter
 * Author URI: https://filter.agency
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Text Domain: filter-abilities
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FILTER_ABILITIES_VERSION', '1.8.1' );
define( 'FILTER_ABILITIES_PATH', plugin_dir_path( __FILE__ ) );
define( 'FILTER_ABILITIES_FILE', __FILE__ );
define( 'FILTER_ABILITIES_BUILD_EDITION', 'lite' );
define( 'FILTER_ABILITIES_BUILD_FEATURES', [
	'content-management',
	'site-health',
	'taxonomy-management',
	'media-management',
	'migration',
	'block-editing',
] );

// Strauss-prefixed dependencies (StellarWP Telemetry, di52, etc.).
if ( file_exists( FILTER_ABILITIES_PATH . 'vendor-prefixed/autoload.php' ) ) {
	require_once FILTER_ABILITIES_PATH . 'vendor-prefixed/autoload.php';
}

require_once FILTER_ABILITIES_PATH . 'includes/class-telemetry.php';
require_once FILTER_ABILITIES_PATH . 'includes/class-telemetry-modals.php';
add_action( 'plugins_loaded', [ 'Filter_Abilities_Telemetry', 'bootstrap' ] );
add_action( 'plugins_loaded', [ 'Filter_Abilities_Telemetry_Modals', 'bootstrap' ] );

register_activation_hook( __FILE__, function (): void {
	Filter_Abilities_Telemetry::send_event( 'activated' );
} );
register_deactivation_hook( __FILE__, function (): void {
	Filter_Abilities_Telemetry::send_event( 'deactivated' );
} );

add_action( 'plugins_loaded', function () {
	// Abilities API requires WordPress 6.9+.
	if ( ! class_exists( 'WP_Ability' ) ) {
		return;
	}

	require_once FILTER_ABILITIES_PATH . 'includes/class-mcp-ability.php';
	require_once FILTER_ABILITIES_PATH . 'includes/modules/class-module-base.php';
	require_once FILTER_ABILITIES_PATH . 'includes/class-filter-abilities.php';

	Filter_Abilities::instance();
}, 20 );
