<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'astra-theme-css' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION


add_filter('wp_handle_upload', 'convert_to_webp_on_upload');

function convert_to_webp_on_upload($upload) {
    $file_path = $upload['file'];
    $file_info = pathinfo($file_path);
    $extension = strtolower($file_info['extension']);

    $allowed_types = ['jpg', 'jpeg', 'png'];
    if (!in_array($extension, $allowed_types)) {
        return $upload; // Skip if not JPG or PNG
    }

    // Load image
    $image = wp_get_image_editor($file_path);
    if (is_wp_error($image)) {
        return $upload; // Skip on error
    }

    // Define new WebP file path
    $webp_path = $file_info['dirname'] . '/' . $file_info['filename'] . '.webp';

    // Save as WebP
    $image->set_quality(85);
    $saved = $image->save($webp_path, 'image/webp');

    if (!is_wp_error($saved)) {
        // Optional: delete original file (uncomment if desired)
        // unlink($file_path);

        // Replace original file info with WebP
        $upload['file'] = $webp_path;
        $upload['type'] = 'image/webp';
        $upload['url']  = str_replace($file_info['basename'], $file_info['filename'] . '.webp', $upload['url']);
    }

    return $upload;
}
