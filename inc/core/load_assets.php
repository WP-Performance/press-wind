<?php

namespace PressWind\Inc\Core;

require_once dirname(__FILE__) . '/helpers/get_manifest.php';
require_once dirname(__FILE__) . '/helpers/get_token_name.php';
require_once dirname(__FILE__) . '/helpers/order_manifest.php';

/**
 * get last segment in theme path for use in public path
 */
function get_last_path($path)
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
 * get path after wp-content
 */
function get_wp_path($path)
{
  // split path from wp-content
  $_path_ = explode('wp-content', $path);

  return count($_path_) > 0 ? $_path_[1] : '';
}

/**
 * Enqueue scripts.
 */
function add_script($slug, $path, $port, $is_admin, $is_ts = false)
{
  // for theme
  $public_path = get_template_directory_uri();
  $dirPath = get_last_path($path);

  if (WP_ENV !== 'development') {
    // get files name list from manifest
    $config = Helpers\get_manifest(substr($dirPath, 1) . '/dist/manifest.json');

    if (!$config) {
      return;
    }
    // load others files
    $files = get_object_vars($config);
    // order files
    $ordered = Helpers\order_manifest($files);

    // loop for enqueue script
    foreach ($ordered as $key => $value) {
      wp_enqueue_script($slug . '-' . $key, $public_path . $dirPath . '/dist/' . $value->file, [], $key, true);
    }
  } else {
    // development
    wp_enqueue_script($slug, 'https://localhost:' . $port . '/wp-content' . get_wp_path($path) . '/main' . ($is_ts ? '.ts' : '.js'), [], strtotime('now'), true);
  }
}

/**
 * Register the JavaScript for the public-facing side of the site.
 */
function enqueue_scripts($slug, $path, $port, $is_admin, $is_ts = false)
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

  add_action($is_admin ? 'enqueue_block_editor_assets' : 'wp_enqueue_scripts', function () use ($slug, $path, $port, $is_admin, $is_ts) {
    namespace\add_script($slug, $path, $port, $is_admin, $is_ts);
  });
}

/**
 * Register the CSS
 */
function enqueue_styles($slug, $path, $is_admin)
{
  if (!file_exists($path . '/dist/manifest.json')) {
    return;
  }
  add_action(
    ($is_admin ? 'admin' : 'wp') . '_enqueue_scripts',
    function () use ($slug, $path) {
      // theme path
      $public_path = get_template_directory_uri();
      $dirPath = get_last_path($path);

      if (WP_ENV !== 'development') {
        // get file name from manifest
        $config = Helpers\get_manifest(substr($dirPath, 1) . '/dist/manifest.json');
        if (!$config) {
          return;
        }
        $files = get_object_vars($config);
        // order files
        $ordered = Helpers\order_manifest($files);
        // search css key
        foreach ($ordered as $key => $value) {
          // only entry and css
          if (property_exists($value, 'css') === false) {
            continue;
          }
          $css = $value->css;
          // $css is array
          foreach ($css as $file) {
            // get token file
            $token = Helpers\get_token_name($file);
            wp_enqueue_style(
              $slug . '-' . $key,
              $public_path . $dirPath . '/dist/' . $file,
              [],
              $key,
              'all'
            );
          }
        }
      }
    }
  );
}

/**
 * Load assets
 * @param string $slug - unique slug
 * @param string $path - path for main file ex: dirname(__FILE__) for root them from function.php
 * @param string $port - port for development
 * @param bool $is_admin - if true, load only for admin
 * @param bool $is_ts - if true, load .ts instead of .js
 */
function load_assets($slug, $path, $port = '4444', $is_admin = false, $is_ts = false)
{
  namespace\enqueue_scripts($slug, $path, $port, $is_admin, $is_ts);
  namespace\enqueue_styles($slug, $path, $is_admin);
}
