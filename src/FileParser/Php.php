<?php

namespace Rkulik\Config\FileParser;

use Exception;
use Rkulik\Config\Exceptions\FileNotFoundException;
use Rkulik\Config\Exceptions\ParseException;
use Rkulik\Config\Exceptions\UnsupportedFormatException;

/**
 * Class Php
 * @package Rkulik\Config\FileParser
 *
 * @author René Kulik <rene@kulik.io>
 */
class Php implements FileParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $file): array
    {
        if (!\is_file($file)) {
            throw new FileNotFoundException(\sprintf('File "%s" not found', $file));
        }

        try {
            $data = require $file;
        } catch (Exception $exception) {
            throw new ParseException($exception);
        }

        if (!\is_array($data)) {
            throw new UnsupportedFormatException(\sprintf('File "%s" does not return an array', $file));
        }

        return $data;
    }
}
