<?php
/**
 * The exception class
 * The main error handle for ama handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.1
 */
namespace Irmmr\Handle\App\Exception;

use Throwable;

/**
 * Class Main
 * @package Irmmr\Handle\Exception
 */
class Main extends \Exception
{
    /**
     * Main constructor.
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
    public function loadError(\Error $handler): Main {
        $this->file = $handler->getFile();
        $this->line = $handler->getLine();
        $this->code = $handler->getCode();
        $this->message = $handler->getMessage();
        return $this;
    }

    /**
     * Load for new exception.
     * @param $handler
     * @return $this
     */
    public function load($handler): Main {
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
    public function loadException(\Exception $handler): Main {
        $this->file = $handler->getFile();
        $this->line = $handler->getLine();
        $this->code = $handler->getCode();
        $this->message = $handler->getMessage();
        return $this;
    }
}