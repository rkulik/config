<?php

namespace Rkulik\Config;

/**
 * Class Config
 * @package Rkulik\Config
 *
 * @author René Kulik <rene@kulik.io>
 */
class Config
{
    /**
     * @var array
     */
    private $data;

    /**
     * Config constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param null $value
     */
    public function set(string $key, $value = null): void
    {
        $data = &$this->data;

        $keys = \explode('.', $key);

        while (\count($keys) > 1) {
            $key = \array_shift($keys);

            if (!isset($data[$key])) {
                $data[$key] = [];
            }

            $data = &$data[$key];
        }

        $data[\array_shift($keys)] = $value;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        $data = $this->data;

        foreach (\explode('.', $key) as $segment) {
            if (!isset($data[$segment])) {
                return $default;
            }

            $data = $data[$segment];
        }

        return $data;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        $data = $this->data;

        foreach (\explode('.', $key) as $segment) {
            if (!isset($data[$segment])) {
                return false;
            }

            $data = $data[$segment];
        }

        return true;
    }

    /**
     * @param string $key
     */
    public function unset(string $key): void
    {
        $data = &$this->data;

        $keys = \explode('.', $key);

        while (\count($keys) > 1) {
            $key = \array_shift($keys);

            if (!isset($data[$key])) {
                return;
            }

            $data = &$data[$key];
        }

        unset($data[\array_shift($keys)]);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
