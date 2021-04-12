<?php
/**
 * The data rand class.
 * This class is makes random data for some usages.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Rand
 * @package Irmmr\Handle\Data
 */
class Rand
{
    /**
     * Make random data based on string.
     *
     * @param int $len
     * @param array ...$ranges
     * @return string
     */
    public function make(int $len, array ...$ranges): string {
        $word = [];
        foreach ($ranges as $range) {
            $word = array_merge($word, $range);
        }
        shuffle($word);
        return substr(implode($word), 0, $len);
    }

    /**
     * Get random string.
     * includes a-z + A-Z
     *
     * @param int $len
     * @return string
     */
    public function str(int $len = 10): string {
        return $this->make(
            $len,
            range('a', 'z'),
            range('A', 'Z')
        );
    }

    /**
     * Get random value.
     * includes a-z + A-Z + 0-9
     *
     * @param int $len
     * @return string
     */
    public function val(int $len = 10): string {
        return $this->make(
            $len,
            range('a', 'z'),
            range('A', 'Z'),
            range('0', '9')
        );
    }

    /**
     * Get random string.
     * includes A-Z
     *
     * @param int $len
     * @return string
     */
    public function strUpp(int $len = 10): string {
        return $this->make(
            $len,
            range('A', 'Z')
        );
    }

    /**
     * Get random string.
     * includes a-z
     *
     * @param int $len
     * @return string
     */
    public function strLow(int $len = 10): string {
        return $this->make(
            $len,
            range('a', 'z')
        );
    }

    /**
     * Get random string.
     * includes a-z
     *
     * @param int $len
     * @return string
     */
    public function strNum(int $len = 10): string {
        return $this->make(
            $len,
            range('0', '9')
        );
    }

    /**
     * Create a random number.
     *
     * @param int $digits
     * @return int
     */
    public function num(int $digits = 16): int {
        $min = (10 ** $digits) / 10;
        $max = (10 ** $digits) - 1;
        return is_int($min) && is_int($max) ? rand($min, $max) : 0;
    }

    /**
     * Create random unsigned number.
     *
     * @param int $digits
     * @return int
     */
    public function numUns(int $digits = 16): int {
        $date = getdate()[0];
        $dateLen = strlen((string) $date);
        if ($digits < $dateLen) {
            return substr($date, 0, $digits);
        } elseif ($digits == $dateLen) {
            return $date;
        }
        $number = $this->num($digits - $dateLen);
        return (int) ((string) $date . (string) $number);
    }
}