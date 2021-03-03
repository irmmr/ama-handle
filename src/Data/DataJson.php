<?php
/**
 * The data json class.
 * This data json manage for handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class DataJson
 * @package Irmmr\Handle\Data
 */
class DataJson
{
    /**
     * Encode data.
     * @param array $data
     * @return string
     */
    public function encode(array $data): string {
        return json_encode($data);
    }

    /**
     * Decode data.
     * @param string $data
     * @param bool $associative
     * @return array
     */
    public function decode(string $data, $associative = false): array {
        return $this->verify($data) ? json_decode($data, $associative) : [];
    }

    /**
     * Verify data.
     * @param string $data
     * @param bool $associative
     * @return bool
     */
    public function verify(string $data, bool $associative = false): bool {
        json_decode($data, $associative);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}