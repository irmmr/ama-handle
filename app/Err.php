<?php
/**
 * The error class.
 * The error handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.3
 */
namespace Irmmr\Handle\App;

use Error;
use Exception;
use Irmmr\Handle\App\Exception\Main;
use PDOException;

/**
 * Class Err
 * @package Irmmr\Handle
 */
class Err
{
    /**
     * Callbacks array for error using.
     * @var array|null
     */
    private static ?array $callbacks = [];

    /**
     * Error code and tags.
     */
    // not any error handle.

    /**
     * Create an ama error exception from main exception.
     * @param Exception $error
     * @return Main
     */
    public static function exp(Exception $error): Main {
        $ama = new Main($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadException($error);
    }

    /**
     * Create a ama handler error.
     * @param Error $error
     * @return Main
     */
    public static function error(Error $error): Main {
        $ama = new Main($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadError($error);
    }

    /**
     * Create a ama handler custom.
     * @param $error
     * @return Main
     */
    public static function custom($error): Main {
        $ama = new Main($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->load($error);
    }

    /**
     * Create an ama database error exception from pdo exception.
     * @param PDOException $error
     * @return Main
     */
    public static function expDbPdo(PDOException $error): Main {
        return new Main($error->getMessage(), $error->getCode(), $error->getPrevious());
    }

    /**
     * Listen to the errors by user.
     * @param string $owner
     * @param callable $callback
     */
    public static function listen(string $owner, callable $callback): void {
        self::$callbacks[$owner] = $callback;
    }

    /**
     * Call and error handling for own script.
     * @param $error
     * @param string $owner
     */
    public static function call($error, string $owner): void {
        if (!array_key_exists($owner, self::$callbacks)) {
            return;
        }
        $act = self::$callbacks[$owner];
        // listen to all ama-handle errors
        if ($error instanceof \Error) {
            call_user_func($act, self::error($error));
        } elseif ($error instanceof \Exception) {
            call_user_func($act, self::exp($error));
        } elseif ($error instanceof \PDOException) {
            call_user_func($act, self::expDbPdo($error));
        } else {
            call_user_func($act, null);
        }
    }
}