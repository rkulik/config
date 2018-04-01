<?php

namespace Rkulik\Config\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 * @package Rkulik\Config\Tests
 *
 * @author René Kulik <rene@kulik.io>
 */
abstract class BaseTestCase extends TestCase
{
    private const MOCK_DIRECTORY = __DIR__ . DIRECTORY_SEPARATOR . 'mocks';
    protected const FILE_WHICH_IS_VALID = 'valid.php';
    protected const FILE_WHICH_THROWS_AN_EXCEPTION = 'throwsException.php';
    protected const FILE_WITH_UNSUPPORTED_EXTENSION = 'unsupportedExtension.json';
    protected const FILE_WITH_UNSUPPORTED_FORMAT = 'unsupportedFormat.php';

    /**
     * @param string $file
     * @return string
     */
    protected function getMockFilePath(string $file): string
    {
        return self::MOCK_DIRECTORY . DIRECTORY_SEPARATOR . $file;
    }
}
