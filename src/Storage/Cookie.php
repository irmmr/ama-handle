<?php
/**
 * The storage cookie class.
 * The storage cookie class for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Storage;

/**
 * Class Cookie
 * @package Irmmr\Handle\Storage
 */
class Cookie
{
    /**
     * Secure and httpOnly options.
     */
    public const HTTPONLY = 'httpOnly';
    public const SECURE = 'secure';

    /**
     * Set a cookie.
     *
     * @param string $name
     * @param string $value
     * @param int $expire
     * @param string|null $path
     * @param string $domain
     * @param array $options
     * @return bool
     */
    public function set(string $name, string $value, int $expire = 0, string $path = '', string $domain = '', array $options = []): bool {
        $httpOnly   = in_array(self::HTTPONLY, $options);
        $secure     = in_array(self::SECURE, $options);
        return setcookie($name, $value, time()+($expire*60*60), $path, $domain, $secure, $httpOnly);
    }

    /**
     * Remove a cookie.
     *
     * @param string $name
     * @param int $expire
     * @param string $path
     * @return bool
     */
    public function remove(string $name, int $expire = 0, string $path = ''): bool {
        return setcookie($name, '', time()-($expire*60*60), $path);
    }

    /**
     * Check cookie.
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool {
        return isset($_COOKIE[$name]);
    }

    /**
     * Get a cookie.
     *
     * @param string $name
     * @param string|null $default
     * @return null|string
     */
    public function get(string $name, ?string $default = null): ?string {
        return $this->has($name) ? $_COOKIE[$name] : $default;
    }

    /**
     * Evaluate cookie.
     *
     * @param string $name
     * @param string|null $value
     * @return bool
     */
    public function is(string $name, ?string $value): bool {
        return $this->get($name) == $value;
    }
}