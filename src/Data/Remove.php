<?php
/**
 * The data remove class.
 * This class is try to remove some data and strings.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Remove
 * @package Irmmr\Handle\Data
 */
class Remove
{
    /**
     * Remove some data from string.
     * @param string $data
     * @param string ...$filter
     * @return string
     */
    public function str(string $data, string ...$filter): string {
        if (empty($data)) {
            return $data;
        }
        foreach ($filter as $dig) {
            $data = str_replace($dig, '', $data);
        }
        return $data;
    }

    /**
     * Remove data using format.
     * @param string $data
     * @param string ...$formats
     * @return string
     */
    public function strFormat(string $data, string ...$formats): string {
        if (empty($data) || empty($formats)) {
            return $data;
        }
        foreach ($formats as $format) {
            $data = preg_replace($format, '', $data);
        }
        return $data;
    }

    /**
     * Array remove data.
     * @param array $data
     * @param string ...$keys
     * @return array
     */
    public function arr(array $data, string ...$keys): array {
        if (empty($data) || empty($keys)) {
            return $data;
        }
        return array_filter($data, function ($key, $value) use ($keys) {
            $check = is_string($key) ? $key : $value;
            return !in_array($check, $keys);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Array remove data by format.
     * @param array $data
     * @param string ...$formats
     * @return array
     */
    public function arrFormat(array $data, string ...$formats): array {
        if (empty($data) || empty($formats)) {
            return $data;
        }
        return array_filter($data, function ($key, $value) use ($formats) {
            $check = is_string($key) ? $key : $value;
            foreach ($formats as $format) {
                if (preg_match($format, $check)) {
                    return false;
                }
            }
            return true;
        }, ARRAY_FILTER_USE_BOTH);
    }
}