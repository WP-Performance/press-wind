<?php

namespace  PressWind;

use function PressWind\Inc\Core\load_assets;

if (!defined('WP_ENV')) {
  define('WP_ENV', 'development');
}

// include core files (don't touch this files !)
require_once dirname(__FILE__) . '/inc/core/core.php';

// inc, you can modify this files like you want
require_once dirname(__FILE__) . '/inc/disable.php';
require_once dirname(__FILE__) . '/inc/gutenberg.php';

// pwa icons injected in head
if (file_exists(dirname(__FILE__) . '/inc/pwa_head.php')) {
  include dirname(__FILE__) . '/inc/pwa_head.php';
}

/**
 * Theme setup.
 */
function setup()
{
  add_theme_support('automatic-feed-links');

  add_theme_support('title-tag');

  add_theme_support('post-thumbnails');

  // add_theme_support('html5', [
  //   'comment-form',
  //   'comment-list',
  //   'gallery',
  //   'caption',
  // ]);

  // add_theme_support('post-formats', [
  //   'aside',
  //   'image',
  //   'video',
  //   'quote',
  //   'link',
  //   'gallery',
  //   'audio',
  // ]);

  // register_nav_menus(array(
  // 'primary'   => __('Primary Menu', 'press-wind'),
  // 'secondary' => __('Secondary Menu', 'press-wind')
  // ));

  load_theme_textdomain('press-wind', get_template_directory() . '/languages');
}

add_action('after_setup_theme', __NAMESPACE__ . '\setup');

/**
 * init assets front
 */
load_assets('press-wind', dirname(__FILE__) . '', '3000');
/**
 * init assets admin
 */
load_assets('press-wind-admin', dirname(__FILE__) . '/admin', '4444', true);
