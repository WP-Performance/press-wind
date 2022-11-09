<?php

function getConfig()
{
  // default values
  $default = include './default.php';
  // theme values
  $global = include '../config/global.php';
  return array_replace_recursive($global, $default);
}
