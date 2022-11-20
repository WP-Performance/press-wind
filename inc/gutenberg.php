<?php

namespace PressWind\inc\Gutenberg;


/**
 * gutenberg settings
 */
function setup()
{
  // add css style for editor admin
  add_theme_support('editor-styles');
  add_editor_style('style-editor.css');

  // add default block style
  add_theme_support('wp-block-styles');

  // responsive embed
  add_theme_support('responsive-embeds');


  /** PATTERNS SECTION */

  // add category for theme patterns
  register_block_pattern_category('press-wind/press-wind-patterns', array('label' => __('Press Wind', 'press-wind')));
  // add theme support for the core-block-patterns
  // add_theme_support('core-block-patterns');

  // or remove the theme support for the core-block-patterns
  remove_theme_support('core-block-patterns');

  // remove remote patterns
  add_filter('should_load_remote_block_patterns', '__return_false');

  // unregister_block_pattern_category('buttons');
  // unregister_block_pattern_category('query');
  // unregister_block_pattern_category('header');
  // unregister_block_pattern_category('footer');
}


add_action('init', __NAMESPACE__ . '\setup');
