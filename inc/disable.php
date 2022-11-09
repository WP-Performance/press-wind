<?php

namespace PressWind\inc\disable;

/*
 * Source from https://github.com/vinkla/headache
 * i use code separately because the plugin remove gutenberg code and i added a * code for remove comment in admin
 */


/**
 * comment line if you want enable things
 */
add_action('init', function () {

  // Remove language dropdown on login screen.
  add_filter('login_display_language_dropdown', '__return_false');

  // Removes WordPress version.
  remove_action('wp_head', 'wp_generator');

  // Removes generated icons.
  remove_action('wp_head', 'wp_site_icon', 99);

  // Removes shortlink tag from <head>.
  remove_action('wp_head', 'wp_shortlink_wp_head', 10);

  // Removes shortlink tag from HTML headers.
  remove_action('template_redirect', 'wp_shortlink_header', 11);

  // Removes wlwmanifest.xml.
  remove_action('wp_head', 'wlwmanifest_link');

  // Removes meta rel=dns-prefetch href=//s.w.org
  remove_action('wp_head', 'wp_resource_hints', 2);

  // Removes relational links for the posts.
  remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

  // Removes REST API link tag from <head>.
  remove_action('wp_head', 'rest_output_link_wp_head', 10);

  // Removes REST API link tag from HTML headers.
  remove_action('template_redirect', 'rest_output_link_header', 11);

  // Removes JPEG compression.
  add_filter('jpeg_quality', function () {
    return 100;
  }, 10, 2);

  // Update login page image link URL.
  add_filter('login_headerurl', function () {
    return home_url();
  });

  // Update login page link title.
  add_filter('login_headertext', function () {
    return get_bloginfo('name');
  });

  // remove svg duotone if you don't use it
  remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
});
