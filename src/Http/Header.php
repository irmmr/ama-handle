<?php
/**
 * The http header class.
 * The http header class for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Http;

/**
 * Class Header
 * @package Irmmr\Handle\Http
 */
class Header
{
    /**
     * Header check modes.
     */
    public const FULL_MODE = 'full';
    public const NAME_MODE = 'name';

    /**
     * Check for header sent.
     * @param string|null $file
     * @param int|null $line
     * @return bool
     */
    public function sent(?string &$file = null, ?int &$line = null): bool {
        return headers_sent($file, $line);
    }

    /**
     * Set header with value.
     * @param string $header
     * @param string|null $value
     * @param bool $replace
     * @param int|null $response
     */
    public function set(string $header, ?string $value = null, bool $replace = true, ?int $response = null): void {
        if (!is_null($value)) {
            $header .= ": $value";
        }
        header($header, $replace, $response);
    }

    /**
     * Remove a header or all headers.
     * @param string|null $name
     */
    public function remove(?string $name = null): void {
        header_remove($name);
    }

    /**
     * The full list of headers.
     * @return array
     */
    public function list(): array {
        $headers = headers_list();
        if (empty($headers)) {
            return [];
        }
        $collect = [];
        foreach ($headers as $head) {
            if (preg_match('/(\w+): (\w+)/', $head)) {
                $spl = explode(':', $head, 2);
                $name = str_replace(' ', '', $spl[0]);
                $value = trim($spl[1]);
                $collect[$name] = $value;
                continue;
            }
            $collect[] = trim($head);
        }
        return $collect;
    }

    /**
     * Check for header exists.
     * @param string $name
     * @param string $type
     * @return bool
     */
    public function has(string $name, string $type = self::NAME_MODE): bool {
        if ($type == self::NAME_MODE) {
            return array_key_exists($name, $this->list());
        } elseif ($type == self::FULL_MODE) {
            return in_array($name, $this->list());
        }
        return false;
    }

    /**
     * Get a header value.
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public function get(string $name, ?string $default = null): ?string {
        return $this->has($name) ? $this->list()[$name] : $default;
    }
}