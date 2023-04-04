<?php

namespace PressWind\Inc\Core\Helpers;

require_once(dirname(__FILE__) . '/getTokenName.php');

function orderManifest($manifest)
{
  // remove no entry
  $cleaned = keepEntries($manifest);

  // ordered
  $ordered = moveLegacyAndPolyfill($cleaned);

  $orderedWithToken = [];
  // add token
  foreach ($ordered['ordered'] as $key => $value) {
    if ($value === null) continue;
    $token = is_string($value) ? getTokenName($value) : getTokenName($value->file);
    $orderedWithToken[$token] = $value;
  }

  return $orderedWithToken;
}


/**
 * move polyfill and legacy at the end of array
 */
function moveLegacyAndPolyfill($manifest)
{
  $legacy = null;
  $polyfill = null;
  $cleaned = [];
  foreach ($manifest as $key => $value) {
    // polyfill
    if (strpos($value->src, 'polyfills') > 0 && strpos($value->src, 'legacy') > 0) {
      $polyfill = $value;
      // legacy
    } elseif (strpos($value->src, 'polyfills') === false && strpos($value->src, 'legacy') > 0) {
      $legacy = $value;
    } else {
      $cleaned[] = $value;
    }
  }
  return [
    'legacy' => $legacy,
    'polyfill' => $polyfill,
    'cleaned' => $cleaned,
    // polyfill before legacy
    'ordered' => array_merge($cleaned, [$polyfill, $legacy])
  ];
}



/**
 * remove value without isEntry
 */
function keepEntries($manifest)
{
  $clean = [];
  foreach ($manifest as $key => $value) {
    if (property_exists($value, 'isEntry') === true) {
      $clean[] = $value;
    }
  }
  return $clean;
}
