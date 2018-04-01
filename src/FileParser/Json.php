<?php

namespace Rkulik\Config\FileParser;

use Rkulik\Config\Exceptions\FileNotFoundException;
use Rkulik\Config\Exceptions\ParseException;

/**
 * Class Json
 * @package Rkulik\Config\FileParser
 *
 * @author René Kulik <rene@kulik.io>
 */
class Json implements FileParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $file): array
    {
        if (!\is_file($file)) {
            throw new FileNotFoundException(\sprintf('File "%s" not found', $file));
        }

        $data = \json_decode(\file_get_contents($file), true);

        if (\json_last_error() !== JSON_ERROR_NONE) {
            throw new ParseException(
                \function_exists('json_last_error_msg')
                    ? \json_last_error_msg()
                    : \sprintf('Error while parsing "%s"', $file)
            );
        }

        return $data;
    }
}
