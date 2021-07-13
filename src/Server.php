<?php
/**
 * The server class.
 * The server handler for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

/**
 * Class Server
 * @package Irmmr\Handle
 */
class Server
{
    /**
     * Get the server ip.
     *
     * @return string
     */
    public static function ip(): string {
        return $_SERVER['SERVER_ADDR'] ?? '';
    }

    /**
     * Get server port.
     *
     * @return string
     */
    public static function port(): string {
        return $_SERVER['SERVER_PORT'] ?? '';
    }
}