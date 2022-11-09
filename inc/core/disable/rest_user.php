<?php

namespace PressWind\inc\core\disable\RestUser;

require_once dirname(__FILE__) . '/../index.php';


// Redirects all feeds to home page.
function disable_feeds(): void
{
  wp_redirect(site_url());
}

function init()
{
  $config = getConfig();
  if ($config['disable']['rest_user']) {
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
  }
}

init();
