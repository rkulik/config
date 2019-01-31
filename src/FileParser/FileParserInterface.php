<?php

namespace Rkulik\Config\FileParser;

/**
 * Interface FileParserInterface
 * @package Rkulik\Config\FileParser
 *
 * @author René Kulik <rene@kulik.io>
 */
interface FileParserInterface
{
    /**
     * @param string $file
     * @return array
     */
    public function parse(string $file): array;
}
