<?php

namespace Rkulik\Config\Tests;

use PHPUnit\Framework\TestCase;
use Rkulik\Config\Config;

/**
 * Class ConfigTest
 * @package Rkulik\Config\Tests
 *
 * @author René Kulik <rene@kulik.io>
 */
class ConfigTest extends TestCase
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
        $this->config = new Config($this->getData());
    }

    /**
     *
     */
    public function testSet(): void
    {
        $key = 'newKey';

        $this->assertArrayNotHasKey($key, $this->config->all());

        $this->config->set($key, 'Hello World!');

        $this->assertArrayHasKey($key, $this->config->all());
    }

    /**
     *
     */
    public function testGet(): void
    {
        foreach ($this->getData() as $key => $value) {
            $configValue = $this->config->get($key);
            $this->assertSame($value, $configValue);
        }
    }

    /**
     *
     */
    public function testHas(): void
    {
        foreach (\array_keys($this->getData()) as $key) {
            $this->assertTrue($this->config->has($key));
        }

        $this->assertFalse($this->config->has('nonExistingKey'));
    }

    /**
     *
     */
    public function testUnset(): void
    {
        $data = $this->getData();
        $this->assertSame($data, $this->config->all());

        $firstKey = \key($data);
        $this->config->unset($firstKey);
        unset($data[$firstKey]);

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
        ];
    }
}
