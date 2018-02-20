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
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $key
     */
    public function unset(string $key): void
    {
        unset($this->data[$key]);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->data;
    }
}
