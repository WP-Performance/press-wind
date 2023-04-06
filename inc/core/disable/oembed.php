<?php

namespace PressWind\Inc\Core\Disable;

require_once dirname(__FILE__) . '/../index.php';

function init_disable_oembed()
{
    $config = get_config();
    if ($config['disable']['oembed']) {
        // Removes oEmbeds.
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }
}

init_disable_oembed();
