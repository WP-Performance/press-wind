<?php

namespace PressWind\inc\core;

require_once(dirname(__FILE__) . '/helpers/getManifest.php');
require_once(dirname(__FILE__) . '/helpers/getTokenName.php');

/**
 * Enqueue scripts.
 *
 */
function add_admin_script()
{
  // for theme
  $path = get_template_directory_uri();

  if (WP_ENV !== 'development') {
    // get files name list from manifest
    $config = helpers\getManifest('admin/dist/manifest.json');

    if (!$config) return;
    // load others files
    $files = get_object_vars($config);
    // order files
    $ordered = helpers\orderManifest($files);

    // loop for enqueue script
    foreach ($ordered as $key => $value) {
      wp_enqueue_script('press-wind-theme-' . $key, $path . '/admin/dist/' . $value->file, ['wp-blocks', 'wp-dom'], $key, true);
    }
  } else {
    // development
    wp_enqueue_script('press-wind-theme', 'https://localhost:4444/admin/main.js', ['wp-blocks', 'wp-dom'], strtotime('now'), true);
  }
}


/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_admin_scripts()
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

  add_action('enqueue_block_editor_assets', __NAMESPACE__ . '\add_admin_script');
}


/**
 * Register the CSS
 */
function enqueue_admin_styles()
{
  if (!file_exists(dirname(__FILE__) . '/../../admin/dist/manifest.json')) return;
  add_action(
    'admin_enqueue_scripts',
    function () {
      // theme path
      $path = get_template_directory_uri();

      if (WP_ENV !== 'development') {
        // get file name from manifest
        $config = helpers\getManifest('admin/dist/manifest.json');
        if (!$config) return;
        $files = get_object_vars($config);
        // order files
        $ordered = helpers\orderManifest($files);
        // search css key
        foreach ($ordered as $key => $value) {
          // only entry and css
          if (property_exists($value, 'css') === false) continue;
          $css = $value->css;
          // $css is array
          foreach ($css as $file) {
            // get token file
            $token = helpers\getTokenName($file);
            wp_enqueue_style(
              'press-wind-theme-' . $key,
              $path . '/admin/dist/' . $file,
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




add_action('init', __NAMESPACE__ . '\enqueue_admin_scripts');
add_action('init', __NAMESPACE__ . '\enqueue_admin_styles');
