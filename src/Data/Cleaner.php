<?php
/**
 * The data cleaner class.
 * This class is a container that load all actions for clean data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Cleaner
 * @package Irmmr\Handle\Data
 */
class Cleaner
{
    /**
     * Data cleaner modes.
     */
    public const SLASH = 'slash';
    public const ENTRY = 'htmlEntry';
    public const SPEC = 'htmlSpecial';
    public const STRIP = 'htmlStrip';
    public const BASE = 'base';

    /**
     * Clean slashes data string.
     *
     * @param string $data
     * @return string
     */
    public function slash(string $data): string {
        return addslashes($data);
    }

    /**
     * Clean html entries data string.
     *
     * @param string $data
     * @return string
     */
    public function htmlEntry(string $data): string {
        return htmlentities($data);
    }

    /**
     * Clean html special data string.
     *
     * @param string $data
     * @return string
     */
    public function htmlSpecial(string $data): string {
        return htmlspecialchars($data);
    }

    /**
     * Clean html strip tags data string.
     *
     * @param string $data
     * @return string
     */
    public function htmlStrip(string $data): string {
        return strip_tags($data);
    }

    /**
     * Clean base data string.
     *
     * @param string $data
     * @return string
     */
    public function base(string $data): string {
        return $this->slash(
            $this->htmlEntry(
                $this->htmlSpecial($data)
            )
        );
    }

    /**
     * Clean data using custom function.
     *
     * @param string $data
     * @param string ...$func
     * @return string
     */
    public function func(string $data, string ...$func): string {
        foreach ($func as $f) {
            if (function_exists($f)) {
                $data = call_user_func($f, $data);
            }
        }
        return $data;
    }

    /**
     * Main cleaner method for all settings.
     *
     * @param string $data
     * @param array $type
     * @param array|null $aps
     * @return string
     */
    public function do(string $data, array $type, ?array $aps = null): string {
        if (empty($type)) {
            return '';
        }
        foreach ($type as $t) {
            $t = trim($t);
            if (method_exists($this, $t)) {
                $data = $this->$t($data);
            }
        }
        if (!is_null($aps) && !empty($aps)) {
            foreach ($aps as $a) {
                $a = trim($a);
                if (function_exists($a)) {
                    $data = call_user_func($a, $data);
                }
            }
        }
        return $data;
    }
}