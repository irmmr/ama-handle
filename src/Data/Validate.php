<?php
/**
 * The data validate class.
 * The data validate manage for handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Validate
 * @package Irmmr\Handle\Data
 */
class Validate
{
    /**
     * Check link.
     *
     * @param string $str
     * @return bool
     */
    public function link(string $str): bool {
        return filter_var($str, FILTER_VALIDATE_URL);
    }

    /**
     * Check email.
     *
     * @param string $str
     * @return bool
     */
    public function email(string $str): bool {
        return filter_var($str, FILTER_VALIDATE_EMAIL);
    }
}