<?php

namespace  PressWindStarter;


if (!defined('WP_ENV')) {
    define('WP_ENV', 'development');
}


require_once dirname(__FILE__) . '/inc/gutenberg.php';
require_once dirname(__FILE__) . '/inc/acf_blocks.php';
require_once dirname(__FILE__) . '/inc/login_assets.php';


// pwa icons
if (file_exists(dirname(__FILE__) . '/inc/pwa_head.php')) {
    include dirname(__FILE__) . '/inc/pwa_head.php';
}

/**
 * Theme setup.
 */
function setup()
{
    add_theme_support('automatic-feed-links');

    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');

    load_theme_textdomain('press-wind', get_template_directory() . '/languages');
}

add_action('after_setup_theme', __NAMESPACE__ . '\setup');

/**
 * init assets front
 */
if (class_exists('PressWind\PWVite')) {

    \PressWind\PWVite::init(port: 3000, path: '');
    /**
     * init assets admin
     */
    \PressWind\PWVite::init(
        port: 4444,
        path: '/admin',
        position: 'editor',
        is_ts: false
    );
}
