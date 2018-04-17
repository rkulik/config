<?php

namespace Rkulik\Config\Tests;

use Rkulik\Config\Config;

/**
 * Class ConfigTest
 * @package Rkulik\Config\Tests
 *
 * @author René Kulik <rene@kulik.io>
 */
class ConfigTest extends BaseTestCase
{
    /**
     * @var Config
     */
    private $config;

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->config = new Config($this->getData());
    }

    /**
     *
     */
    public function testSet(): void
    {
        // Set first level data
        $key = 'key';
        $this->assertArrayNotHasKey($key, $this->config->all());
        $this->config->set($key, 'Hello, data!');
        $this->assertArrayHasKey($key, $this->config->all());

        // Set new multidimensional data
        $multidimensionalKey = 'multidimensional.key';
        $this->assertArrayNotHasKey('multidimensional', $this->config->all());
        $this->config->set($multidimensionalKey, 'Hello, multidimensional data!');

        $array = $this->config->all();
        foreach (\explode('.', $multidimensionalKey) as $segment) {
            $this->assertArrayHasKey($segment, $array);
            $array = $array[$segment];
        }
    }

    /**
     *
     */
    public function testGet(): void
    {
        // Get first level data
        foreach ($this->getData() as $key => $value) {
            $configValue = $this->config->get($key);
            $this->assertSame($value, $configValue);
        }

        // Get non existing data
        $this->assertEquals(null, $this->config->get('nonExistingKey'));

        // Get multidimensional data
        $this->assertEquals('value', $this->config->get('multi.dimensional.key'));

        // Get non existing multidimensional data
        $this->assertEquals(null, $this->config->get('multi.dimensional.non.existing.key'));
    }

    /**
     *
     */
    public function testHas(): void
    {
        // Has first level data
        foreach (\array_keys($this->getData()) as $key) {
            $this->assertTrue($this->config->has($key));
        }

        // Has multidimensional data
        $this->assertTrue($this->config->has('multi.dimensional.key'));

        // Does not have non existing first level data
        $this->assertFalse($this->config->has('nonExistingKey'));

        // Does not have non existing multidimensional data
        $this->assertFalse($this->config->has('non.existing.key'));
    }

    /**
     *
     */
    public function testUnset(): void
    {
        $data = $this->getData();
        $this->assertSame($data, $this->config->all());

        // Unset first level key
        $this->config->unset('foo');
        unset($data['foo']);
        $this->assertSame($data, $this->config->all());

        // Unset multidimensional key
        $this->config->unset('multi.dimensional');
        unset($data['multi']['dimensional']);
        $this->assertSame($data, $this->config->all());

        // Unset non existing multidimensional key
        $this->config->unset('multi.dimensional.non.existing.key');
        $this->assertSame($data, $this->config->all());
    }

    /**
     *
     */
    public function testAll(): void
    {
        $data = $this->getData();
        $this->assertSame($data, $this->config->all());
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        return [
            'foo' => 'bar',
            'baz' => 1,
            0 => [],
            'qux' => true,
            'multi' => [
                'dimensional' => [
                    'key' => 'value',
                ],
            ],
        ];
    }
}
