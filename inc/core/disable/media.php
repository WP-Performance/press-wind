<?php

namespace PressWind\inc\core\disable\media;

require_once dirname(__FILE__) . '/../index.php';


// Redirects all feeds to home page.
function disable_feeds(): void
{
  wp_redirect(site_url());
}

function init()
{
  $config = getConfig();
  if ($config['disable']['media']) {
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
  }
}

init();
