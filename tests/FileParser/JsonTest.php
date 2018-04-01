<?php

namespace Rkulik\Config\Tests\FileParser;

use Rkulik\Config\FileParser\Json;
use Rkulik\Config\Tests\BaseTestCase;

/**
 * Class JsonTest
 * @package Rkulik\Config\Tests\FileParser
 *
 * @author René Kulik <rene@kulik.io>
 */
class JsonTest extends BaseTestCase
{
    /**
     * @var Json
     */
    private $json;

    /**
     *
     */
    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->json = new Json();
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\FileNotFoundException
     */
    public function testParseFailsByFileNotFound(): void
    {
        $this->json->parse('nonExistingFile');
    }

    /**
     * @expectedException \Rkulik\Config\Exceptions\ParseException
     */
    public function testParseFailsByParse(): void
    {
        $this->json->parse($this->getMockFilePath(self::JSON_FILE_WITH_JSON_SYNTAX_ERROR));
    }

    /**
     * @throws \Rkulik\Config\Exceptions\FileNotFoundException
     * @throws \Rkulik\Config\Exceptions\ParseException
     */
    public function testParseReturnsArray(): void
    {
        $file = $this->getMockFilePath(self::JSON_FILE_WHICH_IS_VALID);
        $data = \json_decode(\file_get_contents($file), true);

        $response = $this->json->parse($file);

        $this->assertInternalType('array', $response);
        $this->assertSame($data, $response);
    }
}
