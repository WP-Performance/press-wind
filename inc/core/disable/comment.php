<?php

namespace PressWind\inc\core\disable\comment;

require_once dirname(__FILE__) . '/../index.php';

function init()
{
  $config = getConfig();
  if ($config['disable']['comment']) {

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

    // remove comment admin bar
    function remove_comments()
    {
      global $wp_admin_bar;
      $wp_admin_bar->remove_menu('comments');
    }
    add_action('wp_before_admin_bar_render', __NAMESPACE__ . '\remove_comments');

    // remove settings menu discussion
    add_action(
      'admin_menu',
      function () {
        // Remove Settings -> Discussion
        remove_submenu_page('options-general.php', 'options-discussion.php');
      }
    );

    // Disables comments feeds.
    add_filter('feed_links_show_comments_feed', '__return_false');
    add_action('do_feed_rss2_comments', __NAMESPACE__ . '\disable_feeds', 1);
    add_action('do_feed_atom_comments', __NAMESPACE__ . '\disable_feeds', 1);
  }
}

init();
