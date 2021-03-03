<?php
/**
 * The exception class
 * The main error handle for ama handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Exception;

use Carbon\Exceptions\Exception;
use Throwable;

/**
 * Class AMAException
 * @package Irmmr\Handle\Exception
 */
class AMAException extends \Exception
{
    /**
     * AMAException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Load an error for new exception.
     * @param \Error $handler
     * @return $this
     */
    public function loadError(\Error $handler): AMAException {
        $this->file = $handler->getFile();
        $this->line = $handler->getLine();
        $this->code = $handler->getCode();
        $this->message = $handler->getMessage();
        return $this;
    }

    /**
     * Load an exception for new exception.
     * @param \Exception $handler
     * @return $this
     */
    public function loadException(\Exception $handler): AMAException {
        $this->file = $handler->getFile();
        $this->line = $handler->getLine();
        $this->code = $handler->getCode();
        $this->message = $handler->getMessage();
        return $this;
    }

    /**
     * Add log error for the database error.
     * @param string $name
     * @param string $own
     */
    protected function logger(string $name, string $own): void {
        $date = date('[Y-m-d H:i:s]');
        @file_put_contents(AMA_HANDLE_PATH . "/logs/{$name}.txt", $date . " [C:{$this->getCode()}] [L:0] ({$own}) ({$this->getFile()}#{$this->getLine()}) " . $this->getMessage() . PHP_EOL, FILE_APPEND);
    }

    /**
     * The main system errors.
     * @param string $own
     */
    public function addLog(string $own = 'Unknown'): void {
        $this->logger('error', $own);
    }
}