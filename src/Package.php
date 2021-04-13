<?php
/**
 * The package class.
 * The package handler for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Package\Import;

/**
 * Class package
 * @package Irmmr\Handle
 */
class Package
{
    /**
     * Import class loader.
     *
     * @param string ...$path
     * @return Import
     */
    public static function import(string ...$path): Import {
        return new Import(...$path);
    }
}