<?php

namespace Rkulik\Config;

use Rkulik\Config\Exceptions\ClassNotFoundException;
use Rkulik\Config\Exceptions\FileNotFoundException;
use Rkulik\Config\FileParser\FileParserInterface;

/**
 * Class ConfigFactory
 * @package Rkulik\Config
 *
 * @author René Kulik <rene@kulik.io>
 */
class ConfigFactory
{
    private const PARSER_NAMESPACE = 'Rkulik\Config\FileParser\\';

    /**
     * @param string $file
     * @param FileParserInterface|null $fileParser
     * @return Config
     * @throws ClassNotFoundException
     * @throws FileNotFoundException
     */
    public function make(string $file, FileParserInterface $fileParser = null): Config
    {
        if (!\is_file($file)) {
            throw new FileNotFoundException(\sprintf('File "%s" not found', $file));
        }

        if ($fileParser) {
            return new Config($fileParser->parse($file));
        }

        $className = self::PARSER_NAMESPACE . \ucfirst(\pathinfo($file, PATHINFO_EXTENSION));

        if (!\class_exists($className)) {
            throw new ClassNotFoundException(\sprintf('Class "%s" not found', $className));
        }

        /** @var FileParserInterface $fileParser */
        $fileParser = new $className();

        return new Config($fileParser->parse($file));
    }
}
