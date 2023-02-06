<?php

namespace PressWind\inc\core;

function login_assets()
{
  if (file_exists(dirname(__FILE__) . '/../../admin/assets/css/custom-login.css')) {
    wp_enqueue_style(
      'custom-login-assets',
      get_template_directory_uri() . '/admin/assets/css/custom-login.css',
      array('login')
    );
  }
}
add_action('login_enqueue_scripts', __NAMESPACE__ . '\login_assets');
