<?php

namespace PressWind\Options;


/**
 * get all values
 */
function getThemeOptions()
{
  $options = get_option("gm_theme_options_settings");
  $options = $options ? $options : '{}';
  $o = json_decode($options);
  return $o;
}

/**
 * get value by name
 * @param string $name
 */
function getThemeOption(string $name)
{
  $options = get_option("gm_theme_options_settings");
  $options = $options ? $options : '{}';
  $o = json_decode($options);
  if (isset($o->$name)) {
    return $o->$name;
  }
  return null;
}
