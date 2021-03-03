<?php
/**
 * The exception class
 * The main error handle for ama handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Exception;

use Throwable;

/**
 * Class AMAException
 * @package Irmmr\Handle\Exception
 */
class AMADbException extends AMAException
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
     * Add log about database connections.
     * @param string $own
     */
    public function addLog(string $own = 'Unknown'): void {
        $this->logger('database', $own);
    }
}