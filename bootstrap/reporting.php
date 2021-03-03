<?php
/**
 * The error file.
 * This file load and append all errors settings for handler errors.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
use Irmmr\Handle\Err;

/**
 * ----------------------------------------
 * Error & Exceptions handlers.
 * ----------------------------------------
 * The error handler tries for log all errors
 * and block some actions for increase site's
 * security.
 */
// Report all errors on system
error_reporting(AMA_HANDLE_ERR_REPORT);

// Define system to show errors
ini_set('display_errors', AMA_HANDLE_ERR_DISPLAY ? 1 : 0);

// Error handler
if (AMA_HANDLE_ERR['active']) {
    set_error_handler(function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) {
            return;
        }
        if (AMA_HANDLE_ERR['logger']) {
            Err::log($message, 'error', 0, 'Handler', $severity, $file, $line);
        }
        if (AMA_HANDLE_ERR['stop']) {
            // Stop page
            \Irmmr\Handle\App\Error::stop($message, 0, $file, $line, $severity);
        }
    }, AMA_HANDLE_ERR['levels']);
}

// Exception handler
if (AMA_HANDLE_EXP['active']) {
    set_exception_handler(function ($exception) {
        $err = Err::error($exception);
        if (AMA_HANDLE_EXP['logger']) {
            $err->addLog('ExpHandler');
        }
        if (AMA_HANDLE_EXP['stop']) {
            // Stop page
            \Irmmr\Handle\App\Error::stop($err->getMessage(), $err->getCode(), $err->getFile(), $err->getLine(), 0);
        }
    });
}

