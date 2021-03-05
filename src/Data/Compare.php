<?php
/**
 * The data compare class.
 * This class is a container that load all actions for compare data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Compare
 * @package Irmmr\Handle\Data
 */
class Compare
{
    /**
     * Compare data length using domain.
     * @param string $data
     * @param int|null $min
     * @param int|null $max
     * @return bool
     */
    public function lenDomain(string $data, ?int $min = null, ?int $max = null): bool {
        $length = strlen($data);
        if (!is_null($min) && !is_null($max)) {
            return $length >= $min && $length <= $max;
        } elseif (!is_null($min)) {
            return $length >= $min;
        } elseif (!is_null($max)) {
            return $length <= $max;
        }
        return false;
    }

    /**
     * Compare data length.
     * @param string $data
     * @param int $size
     * @return bool
     */
    public function lenIs(string $data, int $size): bool {
        return strlen($data) == $size;
    }

    /**
     * Compare data is action.
     * @param string $data
     * @param string $str
     * @return bool
     */
    public function is(string $data, string $str): bool {
        return $data == $str;
    }
}