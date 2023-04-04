<?php

namespace PressWind\Options;


require_once(dirname(__FILE__) . '/admin_options_assets.php');
require_once(dirname(__FILE__) . '/get_options.php');

/**
 * options page html template
 */
function options_page()
{
  echo '<div id="gm-options-app"></div>';
}

/**
 * register options page
 */
function register_options_page()
{
  add_options_page('Theme options', 'Theme options', 'manage_options', 'gm-theme-options', __NAMESPACE__ . '\options_page');
}

add_action('admin_menu', __NAMESPACE__ . '\register_options_page');


/**
 * get languages from polylang
 */
function get_gm_theme_options_languages()
{
  if (function_exists('pll_the_languages')) {
    echo json_encode(\pll_the_languages(['raw' => 1, 'echo' => 0, 'hide_if_empty' => 0]));
  }
  wp_die();
}
add_action('wp_ajax_get_gm_theme_options_languages', __NAMESPACE__ . '\get_gm_theme_options_languages');

/**
 * save values
 */
function save_gm_theme_options_settings()
{
  $data = sanitize_text_field($_POST['data']);
  // clean data /\\"/g
  $data = preg_replace('/\\\\/', '', $data);

  // update value
  if ($data) {
    update_option("gm_theme_options_settings", $data);
  }
  // return new value
  echo (get_option("gm_theme_options_settings"));

  wp_die();
}

add_action('wp_ajax_save_gm_theme_options_settings', __NAMESPACE__ . '\save_gm_theme_options_settings');



/**
 * get values
 */
function get_gm_theme_options_settings()
{
  $options = get_option("gm_theme_options_settings");
  $options = $options ? $options : '{}';
  // return value
  echo $options;
  wp_die();
}

add_action('wp_ajax_get_gm_theme_options_settings', __NAMESPACE__ . '\get_gm_theme_options_settings');


/**
 * init assets for options page
 */
initAssets('gm-options', dirname(__FILE__) . '/app');
