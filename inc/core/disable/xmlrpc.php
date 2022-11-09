<?php

namespace PressWind\inc\core\disable\xmlrpc;

require_once dirname(__FILE__) . '/../index.php';


// Redirects all feeds to home page.
function disable_feeds(): void
{
  wp_redirect(site_url());
}

function init()
{
  $config = getConfig();
  if ($config['disable']['xmlrpc']) {
    // Disable XML RPC for security.
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter('xmlrpc_methods', '__return_false');
    // Removes Really Simple Discovery link.
    remove_action('wp_head', 'rsd_link');
  }
}

init();
