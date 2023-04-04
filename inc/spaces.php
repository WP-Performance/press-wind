<?php

namespace PressWind\Inc;

use function PressWind\Options\getThemeOption;

/**
 * get spaces from query var or set default space
 */
function middleware_cookie()
{
  $switch_gm_spaces = get_query_var('gm_spaces', null);

  $spaces = getThemeOption('spaces');

  if (!isset($_COOKIE['gm_spaces']) || $switch_gm_spaces !== null) {

    $defaultSpace = null;
    // search space by id in query var
    if ($switch_gm_spaces !== null) {
      // get spaces with isDefault = true
      $defaultSpace = array_filter($spaces, function ($space) use ($switch_gm_spaces) {
        return $space->id === $switch_gm_spaces;
      });
    }

    // not found, get default space
    if (!$defaultSpace) {
      // get spaces with isDefault = true
      $defaultSpace = array_filter($spaces, function ($space) {
        return $space->isDefault === true;
      });
    }
    // get first element of array
    if (!empty($defaultSpace)) {
      $defaultSpace = array_values($defaultSpace)[0];
    }
    if ($defaultSpace) {
      // set cookie for 1 year
      setcookie('gm_spaces', $defaultSpace->id, time() + (86400 * 365), '/');
    }
  }

  // cookie space id exist
  if (isset($_COOKIE['gm_spaces'])) {
    $currentSpace = array_filter($spaces, function ($space) {
      return $space->id === $_COOKIE['gm_spaces'];
    });

    // if not found, get default space
    if (empty($currentSpace)) {
      $currentSpace = array_filter($spaces, function ($space) {
        return $space->isDefault === true;
      });
    }

    if (!empty($currentSpace)) {
      $currentSpace = array_values($currentSpace)[0];
    }

    if ($currentSpace) {
      // set cookie for 1 year
      setcookie('gm_spaces', $currentSpace->id, time() + (86400 * 365), '/');
    }
  }
}

add_action('template_redirect', __NAMESPACE__ . '\middleware_cookie');


/**
 * declare query vars
 */
function switch_spaces_vars($qvars)
{
  $qvars[] = 'gm_spaces';
  return $qvars;
}

add_filter('query_vars', __NAMESPACE__ . '\switch_spaces_vars');
