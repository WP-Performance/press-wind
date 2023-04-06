<?php

namespace PressWind\Inc\Core;


require_once(dirname(__FILE__) . '/helpers/order_manifest.php');
require_once(dirname(__FILE__) . '/helpers/get_manifest.php');

/**
 * Enqueue scripts.
 *
 */
function add_script()
{
    // for theme
    $path = get_template_directory_uri();

    if (WP_ENV !== 'development') {
        // get files name list from manifest
        $config = Helpers\get_manifest();

        if (!$config) return;
        // load others files
        $files = get_object_vars($config);
        // order files
        $ordered = Helpers\order_manifest($files);
        // loop for enqueue script
        foreach ($ordered as $key => $value) {
            wp_enqueue_script('press-wind-theme-' . $key, $path . '/dist/' . $value->file, array(), $key, true);
        }
    } else {
        // development
        wp_enqueue_script('press-wind-theme', 'http://localhost:3000/main.js', [], strtotime('now'), true);
    }
}


/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_scripts()
{
    // update script tag with module attribute
    add_filter('script_loader_tag', function ($tag, $handle, $src) {
        if (strpos($handle, 'press-wind-theme') === false) {
            return $tag;
        }
        // change the script tag by adding type="module" and return it.
        $tag = '<script type="module" crossorigin src="' . esc_url($src) . '"></script>';
        return $tag;
    }, 10, 3);

    add_action('wp_enqueue_scripts', __NAMESPACE__ . '\add_script');
}


/**
 * Register the CSS
 */
function enqueue_styles()
{
    if (!file_exists(dirname(__FILE__) . '/../../dist/manifest.json')) return;
    add_action(
        'wp_enqueue_scripts',
        function () {
            // theme path
            $path = get_template_directory_uri();

            if (WP_ENV !== 'development') {
                // get file name from manifest
                $config = Helpers\get_manifest();
                if (!$config) return;
                $files = get_object_vars($config);
                // order files
                $ordered = Helpers\order_manifest($files);
                // search css key
                foreach ($ordered as $key => $value) {
                    // only entry and css
                    if (property_exists($value, 'css') === false) continue;
                    $css = $value->css;
                    // $css is array
                    foreach ($css as $file) {
                        wp_enqueue_style(
                            'press-wind-theme-' . $key,
                            $path . '/dist/' . $file,
                            array(),
                            $key,
                            'all'
                        );
                    }
                }
            }
        }
    );
}


add_action('init', __NAMESPACE__ . '\enqueue_scripts');
add_action('init', __NAMESPACE__ . '\enqueue_styles');
