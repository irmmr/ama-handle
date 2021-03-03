<?php
/**
 * The data class.
 * The main data class uses for all data managing and clean data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Data\DataCheck;
use Irmmr\Handle\Data\DataCleaner;
use Irmmr\Handle\Data\DataCompare;
use Irmmr\Handle\Data\DataConvert;
use Irmmr\Handle\Data\DataJson;
use Irmmr\Handle\Data\DataRand;
use Irmmr\Handle\Data\DataRemove;
use Irmmr\Handle\Data\DataSerialize;

/**
 * Class Data
 * @package Irmmr\Handle
 */
class Data
{
    /**
     * Clean data.
     * @return DataCleaner
     */
    public static function clean(): DataCleaner {
        return new DataCleaner();
    }

    /**
     * Clean compare.
     * @return DataCompare
     */
    public static function compare(): DataCompare {
        return new DataCompare();
    }

    /**
     * Clean check.
     * @return DataCheck
     */
    public static function check(): DataCheck {
        return new DataCheck();
    }

    /**
     * Clean convert.
     * @return DataConvert
     */
    public static function convert(): DataConvert {
        return new DataConvert();
    }

    /**
     * Random data.
     * @return DataRand
     */
    public static function rand(): DataRand {
        return new DataRand();
    }

    /**
     * Serialize data.
     * @return DataSerialize
     */
    public static function serialize(): DataSerialize {
        return new DataSerialize();
    }

    /**
     * Json data.
     * @return DataJson
     */
    public static function json(): DataJson {
        return new DataJson();
    }

    /**
     * Remove data.
     * @return DataRemove
     */
    public static function remove(): DataRemove {
        return new DataRemove();
    }
}