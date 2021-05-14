<?php
/**
 * The data check class.
 * This class is a container that load all actions for check data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Check
 * @package Irmmr\Handle\Data
 */
class Check
{
    /**
     * Check data includes action.
     *
     * @param string $data
     * @param string ...$needle
     * @return bool
     */
    public function includes(string $data, string ...$needle): bool {
        foreach ($needle as $n) {
            if (strpos($data, $n) == false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check data startsWith action.
     *
     * @param string $data
     * @param string ...$needle
     * @return bool
     */
    public function startsWith(string $data, string ...$needle): bool {
        foreach ($needle as $n) {
            $length = strlen($needle);
            if (substr($data, 0, $length) !== $needle) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check data startsWith action.
     *
     * @param string $data
     * @param string ...$needle
     * @return bool
     */
    public function endsWith(string $data, string ...$needle): bool {
        foreach ($needle as $n) {
            $length = strlen($n);
            if ($length || substr($data, -$length) !== $needle) {
                return false;
            }
        }
        return true;
    }

    /*
     * Main data functions.
     */

    /**
     * Check data key exists for arrays.
     *
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
     * 
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