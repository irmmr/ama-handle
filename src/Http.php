<?php
/**
 * The http class.
 * The http handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Http\Header;
use Irmmr\Handle\Http\Redirect;

/**
 * Class Http
 * @package Irmmr\Handle
 */
class Http
{
    /**
     * Create header class.
     *
     * @return Header
     */
    public static function header(): Header {
        return new Header();
    }

    /**
     * Create redirect class.
     *
     * @return Redirect
     */
    public static function redirect(): Redirect {
        return new Redirect();
    }
}