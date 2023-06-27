<?php

require_once dirname(__FILE__) . '/../../helpers/get_manifest.php';
require_once dirname(__FILE__) . '/../../helpers/order_manifest.php';
require_once dirname(__FILE__) . '/../../helpers/get_token_name.php';

use function PressWind\Inc\Core\Helpers\get_manifest;


test('get token from manifest', function () {
  $config = get_manifest('/inc/core/tests/manifest.json');
  $files = get_object_vars($config);

  $token = PressWind\Inc\Core\Helpers\get_token_name($files['main-legacy.js']->file);
  expect($token)->toBe('fe2da1bc');

  $token = PressWind\Inc\Core\Helpers\get_token_name($files['main.js']->file);
  expect($token)->toBe('8331d2aa');
});


test('keep only entries', function () {
  $config = get_manifest('/inc/core/tests/manifest.json');
  $files = get_object_vars($config);

  $cleaned = PressWind\Inc\Core\Helpers\keepEntries($files);
  foreach ($cleaned as $key => $value) {
    expect($value->isEntry)->toBeTrue();
  }
});

test('get legacy and polyfill', function () {
  $config = get_manifest('/inc/core/tests/manifest.json');
  $files = get_object_vars($config);

  $results = PressWind\Inc\Core\Helpers\moveLegacyAndPolyfill($files);

  expect(strpos($results['polyfill']->src, 'polyfills'))->not->toBeFalse();
  expect(strpos($results['polyfill']->src, 'legacy'))->not->toBeFalse();
  expect(strpos($results['legacy']->src, 'polyfills'))->toBeFalse();
  expect(strpos($results['legacy']->src, 'legacy'))->not->toBeFalse();
});


test('order manifest', function () {
  // $stack = [];
  $config = get_manifest('/inc/core/tests/manifest.json');
  $files = get_object_vars($config);

  $results = PressWind\Inc\Core\Helpers\order_manifest($files);

  foreach ($results as $key => $value) {
    expect($value->isEntry)->toBeTrue();
  }

  $k = array_keys($results);

  expect(strpos($results[$k[count($k) - 2]]->src, 'polyfills'))->not->toBeFalse();
  expect(strpos($results[$k[count($k) - 2]]->src, 'legacy'))->not->toBeFalse();
  expect(strpos($results[$k[count($k) - 1]]->src, 'polyfills'))->toBeFalse();
  expect(strpos($results[$k[count($k) - 1]]->src, 'legacy'))->not->toBeFalse();
});
