<?php

namespace Rkulik\Config\FileParser;

/**
 * Interface FileParserInterface
 * @package Rkulik\Config\FileParser
 */
interface FileParserInterface
{
    /**
     * @param string $file
     * @return array
     */
    public function parse(string $file): array;
}
