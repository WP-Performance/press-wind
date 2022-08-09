<?php

namespace PressWind\inc\disable;

/*
 * Source from https://github.com/vinkla/headache
 * i use code separately because the plugin remove gutenberg code and i added a * code for remove comment in admin
 */

// Redirects all feeds to home page.
function disable_feeds(): void
{
  wp_redirect(site_url());
}

// Disables feeds.
add_action('do_feed', __NAMESPACE__ . '\disable_feeds', 1);
add_action('do_feed_rdf', __NAMESPACE__ . '\disable_feeds', 1);
add_action('do_feed_rss', __NAMESPACE__ . '\disable_feeds', 1);
add_action('do_feed_rss2', __NAMESPACE__ . '\disable_feeds', 1);
add_action('do_feed_atom', __NAMESPACE__ . '\disable_feeds', 1);

// Disables comments feeds.
add_action('do_feed_rss2_comments', __NAMESPACE__ . '\disable_feeds', 1);
add_action('do_feed_atom_comments', __NAMESPACE__ . '\disable_feeds', 1);

// Disable comments.
add_action('admin_init', function () {
  // Redirect any user trying to access comments page
  global $pagenow;

  if ($pagenow === 'edit-comments.php') {
    wp_redirect(admin_url());
    exit;
  }
  // Remove comments metabox from dashboard
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  // Disable support for comments and trackbacks in post types
  foreach (get_post_types() as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
});
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
// Remove comments page in menu
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});
// Remove comments links from admin bar
add_action('init', function () {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', __NAMESPACE__ . '\wp_admin_bar_comments_menu', 60);
  }
});

add_filter('feed_links_show_comments_feed', '__return_false');




// Remove language dropdown on login screen.
add_filter('login_display_language_dropdown', '__return_false');

// Disable XML RPC for security.
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', '__return_false');

// Removes WordPress version.
remove_action('wp_head', 'wp_generator');

// Removes generated icons.
remove_action('wp_head', 'wp_site_icon', 99);

// Removes shortlink tag from <head>.
remove_action('wp_head', 'wp_shortlink_wp_head', 10);

// Removes shortlink tag from HTML headers.
remove_action('template_redirect', 'wp_shortlink_header', 11);

// Removes Really Simple Discovery link.
remove_action('wp_head', 'rsd_link');

// Removes RSS feed links.
remove_action('wp_head', 'feed_links', 2);

// Removes all extra RSS feed links.
remove_action('wp_head', 'feed_links_extra', 3);

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

// Removes emojis.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

// Removes oEmbeds.
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'wp_oembed_add_host_js');

// Disable default users API endpoints for security.
// https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
function disable_rest_endpoints(array $endpoints): array
{
  if (!is_user_logged_in()) {
    if (isset($endpoints['/wp/v2/users'])) {
      unset($endpoints['/wp/v2/users']);
    }

    if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
      unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
    }
  }

  return $endpoints;
}

add_filter('rest_endpoints', __NAMESPACE__ . '\disable_rest_endpoints');

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



// Removes the SVG Filters that are mostly if not only used in Full Site Editing/Gutenberg
// Detailed discussion at: https://github.com/WordPress/gutenberg/issues/36834
function remove_svg_filters(): void
{
  remove_action('wp_body_open', 'gutenberg_global_styles_render_svg_filters');
  remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}

add_action('init', __NAMESPACE__ . '\remove_svg_filters');


// Disabled attachment media pages.
function disable_media_pages(): void
{
  if (is_attachment()) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
  }
}

add_filter('template_redirect', __NAMESPACE__ . '\disable_media_pages');
add_filter('redirect_canonical', __NAMESPACE__ . '\disable_media_pages', 0);

// Disabled attachment media page links.
function attachment_link(string $url, int $id): string
{
  if ($attachment_url = wp_get_attachment_url($id)) {
    return $attachment_url;
  }

  return $url;
}

add_filter('attachment_link', __NAMESPACE__ . '\attachment_link', 10, 2);
