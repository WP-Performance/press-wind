<?php

/**
 * return config global
 * @return array
 */
function getConfig()
{
  // default values
  $default = include './default.php';
  // theme values
  $global = include '../../config/global.php';
  // override default value
  return array_replace_recursive($default, $global);
}
