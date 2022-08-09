<?php

namespace  PressWind;


require_once dirname(__FILE__) . '/inc/assets.php';

/**
 * Theme setup.
 */
function setup()
{
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', [
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ]);

  add_theme_support('post-formats', [
    'aside',
    'image',
    'video',
    'quote',
    'link',
    'gallery',
    'audio',
  ]);

  register_nav_menus(array(
    'primary'   => __('Primary Menu', 'presswind'),
    // 'secondary' => __('Secondary Menu', 'presswind')
  ));


  load_theme_textdomain('presswind', get_template_directory() . '/languages');
}

add_action('after_setup_theme', __NAMESPACE__ . '\setup');
