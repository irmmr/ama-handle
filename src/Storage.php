<?php
/**
 * The storage class.
 * The storage class for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Storage\Cookie;
use Irmmr\Handle\Storage\Session;

/**
 * Class Storage
 * @package Irmmr\Handle
 */
class Storage
{
    /**
     * Cookie class handler.
     *
     * @return Cookie
     */
    public static function cookie(): Cookie {
        return new Cookie();
    }

    /**
     * Session class handler.
     *
     * @param bool $autoStart
     * @return Session
     */
    public static function session(bool $autoStart = true): Session {
        return new Session($autoStart);
    }
}