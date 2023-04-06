<?php

declare(strict_types=1);

require_once dirname(__FILE__) . '/../helpers/get_manifest.php';
require_once dirname(__FILE__) . '/../helpers/order_manifest.php';
require_once dirname(__FILE__) . '/../helpers/get_token_name.php';

use PHPUnit\Framework\TestCase;

use function PressWind\Inc\Core\Helpers\get_manifest;

final class ManifestTest extends TestCase
{
    /**
     * @test
     */
    public function getToken(): void
    {
        $config = get_manifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $token = PressWind\Inc\Core\Helpers\get_token_name($files['main-legacy.js']->file);
        $this->assertSame('fe2da1bc', $token);

        $token = PressWind\Inc\Core\Helpers\get_token_name($files['main.js']->file);
        $this->assertSame('8331d2aa', $token);
    }

    /**
     * @test
     */
    public function keepEntry(): void
    {
        $config = get_manifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $cleaned = PressWind\Inc\Core\Helpers\keepEntries($files);
        foreach ($cleaned as $key => $value) {
            $this->assertSame(true, $value->isEntry);
        }
    }

    /**
     * @test
     */
    public function getLegacyAndPolyfill(): void
    {
        $config = get_manifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $results = PressWind\Inc\Core\Helpers\moveLegacyAndPolyfill($files);

        $this->assertNotSame(false, strpos($results['polyfill']->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results['polyfill']->src, 'legacy'));
        $this->assertSame(false, strpos($results['legacy']->src, 'polyfills'));
        $this->assertNotSame(false, strpos($results['legacy']->src, 'legacy'));
    }

    /**
     * @test
     */
    public function orderManifest(): void
    {
        // $stack = [];
        $config = get_manifest('/inc/core/tests/manifest.json');
        $files = get_object_vars($config);

        $results = PressWind\Inc\Core\Helpers\order_manifest($files);

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
