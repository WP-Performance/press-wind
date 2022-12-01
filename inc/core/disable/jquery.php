<?php

namespace PressWind\inc\core\disable\jquery;

require_once dirname(__FILE__) . '/../index.php';

/**
 * Completely Remove jQuery From WordPress if not admin and is not connected
 */
function removeJquery()
{
  if ($GLOBALS['pagenow'] !== 'wp-login.php' && !is_admin() && !is_user_logged_in()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', false);
  }
}


function remove_jquery_migrate($scripts)
{

  if (!is_admin() && isset($scripts->registered['jquery'])) {

    $script = $scripts->registered['jquery'];

    if ($script->deps) {
      $script->deps = array_diff($script->deps, array('jquery-migrate'));
    }
  }
}


function init()
{
  $config = getConfig();
  if ($config['disable']['jquery'] === true) {
    add_action('init', __NAMESPACE__ . '\removeJquery');
    add_action('wp_default_scripts', __NAMESPACE__ . '\remove_jquery_migrate');
  }
}

init();
