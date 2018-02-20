<?php

namespace Rkulik\Config\Tests;

use PHPUnit\Framework\TestCase;
use Rkulik\Config\Config;
use Rkulik\Config\ConfigFactory;
use Rkulik\Config\FileParser\FileParserInterface;

/**
 * Class ConfigFactoryTest
 * @package Rkulik\Config\Test
 *
 * @author René Kulik <rene@kulik.io>
 */
class ConfigFactoryTest extends TestCase
{
    private const MOCK_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . 'mocks' . DIRECTORY_SEPARATOR;

    /**
     * @var ConfigFactory
     */
    private $factory;

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->factory = new ConfigFactory();
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\FileNotFoundException
     */
    public function testMakeFailsByFileNotFound(): void
    {
        $this->factory->make('nonExistingFile');
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\ClassNotFoundException
     */
    public function testMakeFailsByClassNotFound(): void
    {
        $this->factory->make(self::MOCK_DIRECTORY . 'unsupportedExtension.json');
    }

    /**
     * @throws \Rkulik\Config\Exceptions\ClassNotFoundException
     * @throws \Rkulik\Config\Exceptions\FileNotFoundException
     */
    public function testMakeReturnsConfig(): void
    {
        $this->assertInstanceOf(Config::class, $this->factory->make(self::MOCK_DIRECTORY . 'validConfig.php'));
    }

    /**
     * @throws \ReflectionException
     * @throws \Rkulik\Config\Exceptions\ClassNotFoundException
     * @throws \Rkulik\Config\Exceptions\FileNotFoundException
     */
    public function testMakeReturnsConfigUsingCustomerParser(): void
    {
        /** @var FileParserInterface|\PHPUnit_Framework_MockObject_MockObject $parser */
        $parser = $this->createMock(FileParserInterface::class);

        $file = self::MOCK_DIRECTORY . 'validConfig.php';
        $data = require $file;

        $parser->expects($this->once())
            ->method('parse')
            ->with($this->equalTo($file))
            ->will($this->returnValue($data));

        $this->assertInstanceOf(Config::class, $this->factory->fileParser($parser)->make($file));
    }
}
