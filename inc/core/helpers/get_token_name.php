<?php

namespace PressWind\Inc\Core\Helpers;

function get_token_name($key)
{
    // get token file
    // model $key assets/main-legacy-fe2da1bc.js
    $k = explode('-', $key);
    $token = $key;
    // ex: $k[1] | $k[2] = fe2da1bc.js
    if (array_key_exists(1, $k)) {
        // take key 1 or 2
        $t = array_key_exists(2, $k) ? explode('.', $k[2]) : explode('.', $k[1]);
        // ex: $kt[0] = fe2da1bc
        if (array_key_exists(0, $t)) {
            $token = $t[0];
        }
    }

    return $token;
}
