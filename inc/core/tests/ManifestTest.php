<?php

declare(strict_types=1);

require_once(dirname(__FILE__) . '/../helpers/getManifest.php');
require_once(dirname(__FILE__) . '/../helpers/orderManifest.php');
require_once(dirname(__FILE__) . '/../helpers/getTokenName.php');

use PHPUnit\Framework\TestCase;
use function PressWind\Inc\Core\Helpers\getManifest;

final class ManifestTest extends TestCase
{
    public function testGetToken(): void
    {
        $config = getManifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $token = PressWind\Inc\Core\Helpers\getTokenName($files['main-legacy.js']->file);
        $this->assertSame('fe2da1bc', $token);

        $token = PressWind\Inc\Core\Helpers\getTokenName($files['main.js']->file);
        $this->assertSame('8331d2aa', $token);
    }

    public function testKeepEntry(): void
    {
        $config = getManifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $cleaned = PressWind\Inc\Core\Helpers\keepEntries($files);
        foreach ($cleaned as $key => $value) {
            $this->assertSame(true, $value->isEntry);
        }
    }

    public function testGetLegacyAndPolyfill(): void
    {
        $config = getManifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $results = PressWind\Inc\Core\Helpers\moveLegacyAndPolyfill($files);

        $this->assertNotSame(false, strpos($results['polyfill']->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results['polyfill']->src, 'legacy'));
        $this->assertSame(false, strpos($results['legacy']->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results['legacy']->src, 'legacy'));
    }

    public function testOrderManifest(): void
    {
        // $stack = [];
        $config = getManifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $results = PressWind\Inc\Core\Helpers\orderManifest($files);

        foreach ($results as $key => $value) {
            $this->assertSame(true, $value->isEntry);
        }

        $k = array_keys($results);

        $this->assertNotSame(false, strpos($results[$k[count($k) - 2]]->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results[$k[count($k) - 2]]->src, 'legacy'));
        $this->assertSame(false, strpos($results[$k[count($k) - 1]]->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results[$k[count($k) - 1]]->src, 'legacy'));
    }
}
