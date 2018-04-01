<?php

namespace Rkulik\Config\Tests\FileParser;

use Rkulik\Config\FileParser\Php;
use Rkulik\Config\Tests\BaseTestCase;

/**
 * Class PhpTest
 * @package Rkulik\Config\Tests\FileParser
 *
 * @author René Kulik <rene@kulik.io>
 */
class PhpTest extends BaseTestCase
{
    /**
     * @var Php
     */
    private $php;

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->php = new Php();
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\FileNotFoundException
     */
    public function testParseFailsByFileNotFound(): void
    {
        $this->php->parse('nonExistingFile');
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\ParseException
     */
    public function testParseFailsByParse(): void
    {
        $this->php->parse($this->getMockFilePath(self::FILE_WHICH_THROWS_AN_EXCEPTION));
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\UnsupportedFormatException
     */
    public function testParseFailsByUnsupportedFormat(): void
    {
        $this->php->parse($this->getMockFilePath(self::FILE_WITH_UNSUPPORTED_FORMAT));
    }

    /**
     * @throws \Rkulik\Config\Exceptions\FileNotFoundException
     * @throws \Rkulik\Config\Exceptions\ParseException
     * @throws \Rkulik\Config\Exceptions\UnsupportedFormatException
     */
    public function testParseReturnsArray(): void
    {
        $file = $this->getMockFilePath(self::FILE_WHICH_IS_VALID);
        $data = require $file;

        $response = $this->php->parse($file);

        $this->assertInternalType('array', $response);
        $this->assertSame($data, $response);
    }
}
