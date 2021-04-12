<?php
/**
 * The method class.
 * The method handler for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Method\Get;
use Irmmr\Handle\Method\Post;

/**
 * Class Method
 * @package Irmmr\Handle
 */
class Method
{
    /**
     * Get the method code.
     */
    const POST  = 101;
    const GET   = 102;

    /**
     * Create a get method class.
     *
     * @return Get
     */
    public static function get(): Get {
        return new Get();
    }

    /**
     * Create a post method class.
     *
     * @return Post
     */
    public static function post(): Post {
        return new Post();
    }

    /**
     * Get the method type.
     *
     * @return string
     */
    public static function type(): string {
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }

    /**
     * Check for method type.
     *
     * @param int $code
     * @return bool
     */
    public static function isType(int $code): bool {
        return (
            !empty(self::type()) &&
            (($code == self::GET && self::type() == 'GET') ||
                ($code == self::POST && self::type() == 'POST'))
        );
    }
}