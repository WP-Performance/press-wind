<?php

namespace PressWindStarter\Inc;

/**
 * load custom css for login page
 *
 * @throws \Exception
 */
function login_assets(): void
{
    if (
        file_exists(dirname(__FILE__) . '/../admin/assets/css/custom-login.css')
        && class_exists('PressWind\PWAsset')
    ) {
        \PressWind\PWAsset::add(
            handle: 'custom-login-assets',
            src: get_stylesheet_directory_uri() . '/admin/assets/css/custom-login.css'
        )->dependencies(['login'])->toLogin();
    }
}
add_action('init', __NAMESPACE__ . '\login_assets');
