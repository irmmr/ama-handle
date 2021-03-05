<?php
/**
 * The data convert class.
 * This class is a container that load all actions for convert data.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Data;

/**
 * Class Convert
 * @package Irmmr\Handle\Data
 */
class Convert
{
    /**
     * Set uppercase data.
     * @param string $data
     * @return string
     */
    public function upper(string $data): string {
        return strtoupper($data);
    }

    /**
     * Set lowercase data.
     * @param string $data
     * @return string
     */
    public function lower(string $data): string {
        return strtolower($data);
    }

    /**
     * Set uc first data.
     * @param string $data
     * @return string
     */
    public function ucf(string $data): string {
        return ucfirst($data);
    }
}