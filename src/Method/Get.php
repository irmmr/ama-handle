<?php
/**
 * The get method class.
 * The get method handler.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Method;

/**
 * Class Get
 * @package Irmmr\Handle\Method
 */
class Get
{
    /**
     * Check for post method existing.
     * @param string ...$name
     * @return bool
     */
    public function has(string ...$name): bool {
        if (empty($name)) {
            return false;
        }
        foreach ($name as $n) {
            if (!isset($_GET[$n])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get a post method content.
     * @param string $name
     * @param string|null $default
     * @return null|string
     */
    public function get(string $name, ?string $default = null) : ?string {
        return $this->has($name) ? $_GET[$name] : $default;
    }

    /**
     * Unset a get method.
     * @param string $name
     */
    public function unset(string $name) : void {
        if ($this->has($name)) {
            unset($_GET[$name]);
        }
    }

    /**
     * Check param value.
     * @param string $name
     * @param string|null $value
     * @return bool
     */
    public function is(string $name, ?string $value) : bool {
        return $this->get($name) == $value;
    }
}