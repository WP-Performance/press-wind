<?php

namespace PressWind\Options;

require_once(dirname(__FILE__) . '/../inc/core/helpers/getManifest.php');
require_once(dirname(__FILE__) . '/../inc/core/helpers/getTokenName.php');

use PressWind\inc\core\helpers;

/**
 * get last segment in theme path
 */
function getLastPath($path)
{
  $public_path = get_template_directory_uri();
  // last segment in public path
  $last_segment = explode('/', $public_path);
  $last_segment = end($last_segment);
  // split path from last segment
  $path = explode($last_segment, $path);
  $path = count($path) > 0 ? $path[1] : '';
  return $path;
}

/**
 * get path from wp-content
 */
function getWPPath($path)
{
  // split path from wp-content
  $_path_ = explode('wp-content', $path);
  return count($_path_) > 0 ? $_path_[1] : '';
}

/**
 * Enqueue scripts.
 *
 */
function add_admin_script($slug, $path)
{
  // for theme
  $public_path = get_template_directory_uri();
  $dirPath = getLastPath($path);

  if (WP_ENV !== 'development') {
    // get files name list from manifest
    $config = helpers\getManifest(substr($dirPath, 1) . '/dist/manifest.json');

    if (!$config) return;
    // load others files
    $files = get_object_vars($config);
    // order files
    $ordered = helpers\orderManifest($files);

    // loop for enqueue script
    foreach ($ordered as $key => $value) {
      wp_enqueue_script($slug . '-' . $key, $public_path . $dirPath . '/dist/' . $value->file, ['wp-blocks', 'wp-dom'], $key, true);
    }
  } else {

    // development
    wp_enqueue_script($slug, 'http://localhost:8888/wp-content' . getWPPath($path) . '/main.js', ['wp-blocks', 'wp-dom'], strtotime('now'), true);
  }
}


/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_admin_scripts($slug, $path)
{
  // update script tag with module attribute
  add_filter('script_loader_tag', function ($tag, $handle, $src) use ($slug) {
    if (strpos($handle, $slug) === false) {
      return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" crossorigin src="' . esc_url($src) . '"></script>';
    return $tag;
  }, 10, 3);

  add_action('admin_enqueue_scripts', function () use ($slug, $path) {
    namespace\add_admin_script($slug, $path);
  });
}


/**
 * Register the CSS
 */
function enqueue_admin_styles($slug, $path)
{
  if (!file_exists($path . '/dist/manifest.json')) return;
  add_action(
    'admin_enqueue_scripts',
    function () use ($slug, $path) {
      // theme path
      $public_path = get_template_directory_uri();
      $dirPath = getLastPath($path);

      if (WP_ENV !== 'development') {
        // get file name from manifest
        $config = helpers\getManifest(substr($dirPath, 1) . '/dist/manifest.json');
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
              $slug . '-' . $key,
              $public_path . $dirPath . '/dist/' . $file,
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

function initAssets($slug, $path)
{
  namespace\enqueue_admin_scripts($slug, $path);
  namespace\enqueue_admin_styles($slug, $path);
}
