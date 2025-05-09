<?php
/**
 * Plugin Name:       Sam Newsletter
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sam-newsletter
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_sam_newsletter_block_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', 'create_block_sam_newsletter_block_init' );



// Define plugin constants
define('SAM_NEWSLETTER_VERSION', '1.0.0');
define('SAM_NEWSLETTER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SAM_NEWSLETTER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoload classes
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'SAM_Newsletter_') === 0) {
        $file_name = 'class-' . strtolower(str_replace('_', '-', substr($class_name, 15))) . '.php';
        require_once SAM_NEWSLETTER_PLUGIN_DIR . 'includes/' . $file_name;
    }
});

// Register activation and deactivation hooks
register_activation_hook(__FILE__, ['SAM_Newsletter_Database', 'activate']);
register_deactivation_hook(__FILE__, ['SAM_Newsletter_Database', 'deactivate']);

// Initialize the plugin
if (class_exists('SAM_Newsletter')) {
    $sam_newsletter = new SAM_Newsletter();
}

class SAM_Newsletter {
    public function __construct() {
        $this->init();
    }

    private function init() {
        // Load dependencies
        require_once SAM_NEWSLETTER_PLUGIN_DIR . 'includes/class-database.php';
        require_once SAM_NEWSLETTER_PLUGIN_DIR . 'includes/class-admin.php';
        require_once SAM_NEWSLETTER_PLUGIN_DIR . 'includes/class-ajax.php';

        // Initialize components
        new SAM_Newsletter_Database();
        new SAM_Newsletter_Admin();
        new SAM_Newsletter_Ajax();

        // Register hooks
        add_action('init', [$this, 'register_blocks']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function register_blocks() {
        register_block_type(SAM_NEWSLETTER_PLUGIN_DIR . 'blocks/newsletter');
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'sam-newsletter-frontend',
            SAM_NEWSLETTER_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            SAM_NEWSLETTER_VERSION
        );

        wp_enqueue_script(
            'sam-newsletter-frontend',
            SAM_NEWSLETTER_PLUGIN_URL . 'assets/js/frontend.js',
            ['jquery'],
            SAM_NEWSLETTER_VERSION,
            true
        );

        wp_localize_script(
            'sam-newsletter-frontend',
            'samNewsletterFrontend',
            [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('sam_newsletter_nonce'),
            ]
        );
    }

    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_sam-newsletter' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'sam-newsletter-admin',
            SAM_NEWSLETTER_PLUGIN_URL . 'assets/css/admin.css',
            [],
            SAM_NEWSLETTER_VERSION
        );

        wp_enqueue_script(
            'sam-newsletter-admin',
            SAM_NEWSLETTER_PLUGIN_URL . 'assets/js/admin.js',
            ['jquery'],
            SAM_NEWSLETTER_VERSION,
            true
        );

        wp_localize_script(
            'sam-newsletter-admin',
            'samNewsletterAdmin',
            [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('sam_newsletter_admin_nonce'),
            ]
        );
    }
}



