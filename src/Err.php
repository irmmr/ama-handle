<?php
/**
 * The error class.
 * The error handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle;

use Irmmr\Handle\Exception\AMADbException;
use Irmmr\Handle\Exception\AMAException;

/**
 * Class Err
 * @package Irmmr\Handle
 */
class Err
{
    /**
     * Error code and tags.
     */
    public const DATABASE = 'database';
    public const MAILER = 'mailer';

    /**
     * Create an ama error exception from main exception.
     * @param \Exception $error
     * @return AMAException
     */
    public static function exp(\Exception $error): AMAException {
        $ama = new AMAException($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadException($error);
    }

    /**
     * Create a ama handler error.
     * @param \Error $error
     * @return AMAException
     */
    public static function error(\Error $error): AMAException {
        $ama = new AMAException($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadError($error);
    }

    /**
     * Create an ama database error exception from main exception.
     * @param \Exception $error
     * @return AMADbException
     */
    public static function expDb(\Exception $error): AMADbException {
        $ama = new AMADbException($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadException($error);
    }

    /**
     * Create an ama database error exception from pdo exception.
     * @param \PDOException $error
     * @return AMADbException
     */
    public static function expDbPdo(\PDOException $error): AMADbException {
        return new AMADbException($error->getMessage(), $error->getCode(), $error->getPrevious());
    }

    /**
     * Add logger for an exception error.
     * @param \Exception $error
     * @param string $name
     * @param string $own
     * @param int $level
     */
    public static function expLog(\Exception $error, string $name, string $own = 'Unknown', int $level = 0): void {
        $date = date('[Y-m-d H:i:s]');
        $logg = $date . " [C:{$error->getCode()}] [L:{$level}] ({$own}) ({$error->getFile()}#{$error->getLine()}) " . $error->getMessage();
        $logg = trim(str_replace(PHP_EOL, '', $logg));
        @file_put_contents(AMA_HANDLE_PATH . "/logs/{$name}.txt", $logg.PHP_EOL, FILE_APPEND);
    }

    /**
     * Log error to custom logger.
     * @param string $error
     * @param string $name
     * @param int $code
     * @param string $own
     * @param int $level
     * @param string|null $file
     * @param int|null $line
     */
    public static function log(string $error, string $name, int $code = 0, string $own = 'Unknown', int $level = 0, ?string $file = null, ?int $line = null): void {
        $lineExp = 'No line';
        if (!is_null($file) && !is_null($line)) {
            $lineExp = "{$file}#{$line}";
        }
        $date  = date('[Y-m-d H:i:s]');
        $logg = $date . " [C:{$code}] [L:{$level}] ({$own}) ({$lineExp}) " . $error;
        $logg = trim(str_replace(PHP_EOL, '', $logg));
        @file_put_contents(AMA_HANDLE_PATH . "/logs/{$name}.txt", $logg.PHP_EOL, FILE_APPEND);
    }
}