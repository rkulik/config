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

    /**
     * @param string $file
     * @return string
     */
    protected function getMockFilePath(string $file): string
    {
        return self::MOCK_DIRECTORY . DIRECTORY_SEPARATOR . $file;
    }
}
