<?php

namespace PressWind\inc\Gutenberg\Pattern;


add_action(
  'init',
  function () {
    // add category for theme patterns
    register_block_pattern_category('press-wind/press-wind-patterns', array('label' => __('Press Wind', 'press-wind')));
    // add theme support for the core-block-patterns
    // add_theme_support('core-block-patterns');

    // or remove the theme support for the core-block-patterns
    remove_theme_support('core-block-patterns');
  }
);

/**
 * Remove default categories
 */
function unregister_category()
{
  unregister_block_pattern_category('buttons');
  unregister_block_pattern_category('query');
  unregister_block_pattern_category('header');
  unregister_block_pattern_category('footer');
}

add_action('init', __NAMESPACE__ . '\unregister_category');
