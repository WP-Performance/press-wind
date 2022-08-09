<?php

namespace PressWind\inc\Gutenberg;

require_once(dirname(__FILE__) . '/pattern.php');

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

  // remove template support
  remove_theme_support('block-templates');
}


add_action('init', __NAMESPACE__ . '\setup');
