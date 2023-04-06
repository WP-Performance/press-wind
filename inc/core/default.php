<?php

namespace PressWind\Inc\Core;

/**
 * default value for settings
 */
return [
    // directory target for assets generated
    'iconsDir' => 'public',
    // logo source for generate icons
    'source' => './assets/media/icon.svg',
    'manifest' => [
        'appName' => 'PressWind',
        'appShortName' => 'PressWind',
        'appDescription' => 'Starter theme WordPress, Tailwind, ViteJS',
        'background' => '#fff',
        'theme_color' => 'rgb(190, 24, 93)',
        'lang' => 'fr-FR',
        'preferRelatedApplications' => false,
        'pixel_art' => false,
        'loadManifestWithCredentials' => false,
        'manifestMaskable' => false,
        'icons' => [
            'favicons' => true,
            'android' => true,
            'appleIcon' => true,
            'appleStartup' => false,
            'coast' => false,
            'yandex' => false,
            'windows' => false,
        ],
    ],
    'disable' => [
        // disable rss links
        'rss' => true,
        // remove all comments views
        'comment' => true,
        // disable emojis
        'emoji' => true,
        // media page
        'media' => true,
        // disable oembed
        'oembed' => true,
        // disable xmlrpc
        'xmlrpc' => true,
        // disble rest user endpoint
        'rest_user' => true,
        // disable jquery
        'jquery' => true,
    ],
];
