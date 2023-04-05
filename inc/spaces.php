<?php

namespace PressWind\Inc;

use function PressWind\Options\getThemeOption;


// class Spaces singleton
class Spaces
{
  private static $instance = null;

  /**
   * spaces from options
   * @var array
   */
  private $spaces = null;

  /**
   * current space
   */
  public static $currentSpace = null;

  private function __construct()
  {
    $this->spaces = getThemeOption('spaces');
  }

  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new Spaces();
    }

    return self::$instance;
  }

  /**
   * get spaces from query var or set default space
   */
  function middleware_cookie()
  {
    $switch_gm_spaces = get_query_var('gm_spaces', null);

    if (!isset($_COOKIE['gm_spaces']) || $switch_gm_spaces !== null) {

      $defaultSpace = null;
      // search space by id in query var
      if ($switch_gm_spaces !== null) {
        // get spaces with isDefault = true
        $defaultSpace = array_filter($this->spaces, function ($space) use ($switch_gm_spaces) {
          return $space->id === $switch_gm_spaces;
        });
      }

      // not found, get default space
      if (!$defaultSpace) {
        // get spaces with isDefault = true
        $defaultSpace = array_filter($this->spaces, function ($space) {
          return $space->isDefault === true;
        });
      }
      // get first element of array
      if (!empty($defaultSpace)) {
        $defaultSpace = array_values($defaultSpace)[0];
      }
      if ($defaultSpace) {
        self::$currentSpace = $defaultSpace;
        // set cookie for 1 year
        return setcookie('gm_spaces', $defaultSpace->id, time() + (86400 * 365), '/');
      }
    }

    // cookie space id exist
    if (isset($_COOKIE['gm_spaces'])) {
      $currentSpace = array_filter($this->spaces, function ($space) {
        return $space->id === $_COOKIE['gm_spaces'];
      });

      // if not found, get default space
      if (empty($currentSpace)) {
        $currentSpace = array_filter($this->spaces, function ($space) {
          return $space->isDefault === true;
        });
      }

      if (!empty($currentSpace)) {
        $currentSpace = array_values($currentSpace)[0];
      }

      if ($currentSpace) {
        self::$currentSpace = $currentSpace;
        // set cookie for 1 year
        setcookie('gm_spaces', $currentSpace->id, time() + (86400 * 365), '/');
      }
    }
  }

  /**
   * declare query vars
   */
  function switch_spaces_vars($qvars)
  {
    $qvars[] = 'gm_spaces';
    return $qvars;
  }


  function api_get_spaces()
  {
    $spaces = getThemeOption('spaces');
    return $spaces;
  }


  function spaces_switcher()
  {
    $lang = 'fr';
    if (function_exists('pll_current_language')) {
      $lang = \pll_current_language();
    }

    echo '<ul>';
    // get current url without query string
    $currentUrl = strtok(get_site_url() . $_SERVER['REQUEST_URI'], '?');
    foreach ($this->spaces as $space) {
      echo '<li><a href="' . $currentUrl . '?gm_spaces=' . $space->id . '" class="' . (self::$currentSpace->id === $space->id ? 'current-space' : '') . '">' . $space->{'name_' . $lang} . '</a></li>';
    }
    echo '</ul>';
  }
}


// init spaces
$_spaces = Spaces::getInstance();

/**
 * add middleware for spaces
 */
add_action('template_redirect', [$_spaces, 'middleware_cookie']);
add_filter('query_vars', [$_spaces, 'switch_spaces_vars']);

/**
 * add rest api route for spaces
 */
add_action('rest_api_init', function () use ($_spaces) {
  register_rest_route('patrimonia/v1', '/spaces', array(
    'methods' => 'GET',
    'callback' => [$_spaces, 'api_get_spaces'],
    'permission_callback' => function () {
      // return true;
      return current_user_can('edit_posts');
    }
  ));
});

/**
 * add shortcode for spaces switcher
 */
add_shortcode('spaces_switcher', [$_spaces,  'spaces_switcher']);
