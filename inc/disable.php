<?php

namespace PressWind\inc\disable;

/*
 * Source from https://github.com/vinkla/headache
 * i use code separately because the plugin remove gutenberg code and i added a * code for remove comment in admin
 */

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
function remove_jpeg_compression(): int
{
  return 100;
}

add_filter('jpeg_quality', __NAMESPACE__ . '\remove_jpeg_compression', 10, 2);

// Update login page image link URL.
function login_url(): string
{
  return home_url();
}

add_filter('login_headerurl', __NAMESPACE__ . '\login_url');

// Update login page link title.
function login_title(): string
{
  return get_bloginfo('name');
}

add_filter('login_headertext', __NAMESPACE__ . '\login_title');
