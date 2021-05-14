<?php
/**
 * The data class.
 * The main data class uses for all data managing and clean data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Data\Check;
use Irmmr\Handle\Data\Cleaner;
use Irmmr\Handle\Data\Compare;
use Irmmr\Handle\Data\Convert;
use Irmmr\Handle\Data\Json;
use Irmmr\Handle\Data\Rand;
use Irmmr\Handle\Data\Remove;
use Irmmr\Handle\Data\Serialize;
use Irmmr\Handle\Data\Validate;

/**
 * Class Data
 * @package Irmmr\Handle
 */
class Data
{
    /**
     * Clean data.
     *
     * @return Cleaner
     */
    public static function clean(): Cleaner {
        return new Cleaner();
    }

    /**
     * Clean check.
     *
     * @return Check
     */
    public static function check(): Check {
        return new Check();
    }

    /**
     * Random data.
     *
     * @return Rand
     */
    public static function rand(): Rand {
        return new Rand();
    }

    /**
     * Serialize data.
     *
     * @return Serialize
     */
    public static function serialize(): Serialize {
        return new Serialize();
    }

    /**
     * Json data.
     *
     * @return Json
     */
    public static function json(): Json {
        return new Json();
    }

    /**
     * Remove data.
     *
     * @return Remove
     */
    public static function remove(): Remove {
        return new Remove();
    }

    /**
     * Validate data.
     *
     * @return Validate
     */
    public static function validate(): Validate {
        return new Validate();
    }
}