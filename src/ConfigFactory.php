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
     * @var FileParserInterface
     */
    private $fileParser;

    /**
     * @param FileParserInterface $fileParser
     * @return ConfigFactory
     */
    public function fileParser(FileParserInterface $fileParser): ConfigFactory
    {
        $this->fileParser = $fileParser;

        return $this;
    }

    /**
     * @param string $file
     * @return Config
     * @throws ClassNotFoundException
     * @throws FileNotFoundException
     */
    public function make(string $file): Config
    {
        if (!\is_file($file)) {
            throw new FileNotFoundException(\sprintf('File "%s" not found', $file));
        }

        if ($this->fileParser) {
            $config = new Config($this->fileParser->parse($file));
            $this->resetFileParser();

            return $config;
        }

        $className = self::PARSER_NAMESPACE . \ucfirst(\pathinfo($file, PATHINFO_EXTENSION));

        if (!\class_exists($className)) {
            throw new ClassNotFoundException(\sprintf('Class "%s" not found', $className));
        }

        /** @var FileParserInterface $fileParser */
        $fileParser = new $className();

        return new Config($fileParser->parse($file));
    }

    /**
     *
     */
    private function resetFileParser(): void
    {
        $this->fileParser = null;
    }
}
