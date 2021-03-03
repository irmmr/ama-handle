<?php
/**
 * The data check class.
 * This class is a container that load all actions for check data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class DataCheck
 * @package Irmmr\Handle\Data
 */
class DataCheck
{
    /**
     * Check data includes action.
     * @param string $data
     * @param string $needle
     * @return bool
     */
    public function includes(string $data, string $needle): bool {
        return strpos($data, $needle) !== false;
    }

    /**
     * Check data startsWith action.
     * @param string $data
     * @param string $needle
     * @return bool
     */
    public function startsWith(string $data, string $needle): bool {
        $length = strlen($needle);
        return substr($data, 0, $length) === $needle;
    }

    /**
     * Check data startsWith action.
     * @param string $data
     * @param string $needle
     * @return bool
     */
    public function endsWith(string $data, string $needle): bool {
        $length = strlen($needle);
        if (!$length) {
            return true;
        }
        return substr($data, -$length) === $needle;
    }

    /*
     * Main data functions.
     */

    /**
     * Check data key exists for arrays.
     * @param array $data
     * @param string ...$keys
     * @return bool
     */
    public function keyExists(array $data, string ...$keys): bool {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $data)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check data item exists for arrays.
     * @param array $data
     * @param string ...$items
     * @return bool
     */
    public function itemExists(array $data, string ...$items): bool {
        foreach ($items as $item) {
            if (!in_array($item, $data)) {
                return false;
            }
        }
        return true;
    }
}