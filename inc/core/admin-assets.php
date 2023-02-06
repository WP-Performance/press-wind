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
    $sc = [];
    $legacyIsIn = false;
    foreach ($files as $key => $value) {
      // don't include asset file like image, etc..
      if (property_exists($value, 'isEntry') === false) continue;
      // get file path ("file": "assets/main-legacy-b1d19aa8.js")
      $file = $value->file;
      // get token file from name
      $token = helpers\getTokenName($file);
      $f = ['token' => $token, 'file' => $file];
      // all files except legacy or polyfills
      if (strpos($file, 'polyfills') === false && strpos($file, 'legacy') === false) {
        $sc[] = $f;
        // insert main legacy after polyfill if already in $sc
      } else if (strpos($file, 'legacy') !== false && strpos($file, 'polyfills') === false && $legacyIsIn === true) {
        // split array into two parts
        $split1 = array_slice($sc, 0, 1, true);
        $split2 = array_slice($sc, 1, null, true);
        // add new array element at between two parts
        $sc = array_merge($split1, [1 => $f], $split2);
        // polyfill in first
      } else {
        $legacyIsIn = true;
        array_unshift($sc, $f);
      }
    }

    // loop for enqueue script
    foreach ($sc as $key => $value) {
      wp_enqueue_script('press-wind-theme-' . $value['token'], $path . '/admin/dist/' . $value['file'], ['wp-blocks', 'wp-dom'], $value['token'], true);
    }
  } else {
    // development
    wp_enqueue_script('press-wind-theme', 'http://localhost:4444/admin/main.js', ['wp-blocks', 'wp-dom'], strtotime('now'), true);
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
        // search css key
        foreach ($files as $key => $value) {
          // only entry and css
          if (property_exists($value, 'isEntry') === false || property_exists($value, 'css') === false) continue;
          $css = $value->css;
          // $css is array
          foreach ($css as $file) {
            // get token file
            $token = helpers\getTokenName($file);
            wp_enqueue_style(
              'press-wind-theme-' . $token,
              $path . '/admin/dist/' . $file,
              array(),
              $token,
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
