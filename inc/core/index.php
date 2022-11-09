<?php
// no namespace here, it's voluntary
/**
 * return config global
 * @return array
 */
function getConfig()
{
  // default values
  $default = include dirname(__FILE__) . '/default.php';
  // theme values
  $global = include dirname(__FILE__) . '/../../config/global.php';
  // override default value
  return array_replace_recursive($default, $global);
}
