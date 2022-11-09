<?php

namespace PressWind\inc\core\disable\oembed;

require_once dirname(__FILE__) . '/../index.php';


// Redirects all feeds to home page.
function disable_feeds(): void
{
  wp_redirect(site_url());
}

function init()
{
  $config = getConfig();
  if ($config['disable']['oembed']) {
    // Removes oEmbeds.
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
    remove_action('wp_head', 'wp_oembed_add_host_js');
  }
}

init();
