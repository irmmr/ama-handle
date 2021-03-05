<?php
/**
 * The error class.
 * The error handle for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.2
 */
namespace Irmmr\Handle\App;

use Irmmr\Handle\App\Exception\Database;
use Irmmr\Handle\App\Exception\Main;

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
     * @return Main
     */
    public static function exp(\Exception $error): Main {
        $ama = new Main($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadException($error);
    }

    /**
     * Create a ama handler error.
     * @param \Error $error
     * @return Main
     */
    public static function error(\Error $error): Main {
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
     * Create an ama database error exception from main exception.
     * @param \Exception $error
     * @return Database
     */
    public static function expDb(\Exception $error): Database {
        $ama = new Database($error->getMessage(), $error->getCode(), $error->getPrevious());
        return $ama->loadException($error);
    }

    /**
     * Create an ama database error exception from pdo exception.
     * @param \PDOException $error
     * @return Database
     */
    public static function expDbPdo(\PDOException $error): Database {
        return new Database($error->getMessage(), $error->getCode(), $error->getPrevious());
    }

    /**
     * Add logger for an exception error.
     * @param $error
     * @param string $name
     * @param string $own
     * @param int $level
     */
    public static function expLog($error, string $name, string $own = 'Unknown', int $level = 0): void {
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

    /**
     * Ama error stopper.
     * @param string $message
     * @param int $code
     * @param string $file
     * @param int $line
     * @param int $level
     */
    public static function stop(string $message, int $code, string $file, int $line, int $level): void {
        $page = Theme::get('error-normal');
        // Add error if we are in dev mode
        if (AMA_HANDLE_CONF['dev']) {
            $text = @file($file);
            $arr = array_slice($text, 0, $line);
            if (array_key_exists($line, $text)) {
                $arr[] = str_replace(PHP_EOL, '', $text[$line]);
            }
            $coder = count($text) >= $line ? implode('', $arr) : '';
            $page = Theme::get('error-handler', [
                'msg' => $message,
                'code' => $code,
                'file' => $file,
                'line' => $line,
                'level' => $level,
                'date' => date('Y-m-d H:i:s'),
                'text' => $coder
            ]);
        }
        // Stop all actions and die!
        die($page);
    }
}