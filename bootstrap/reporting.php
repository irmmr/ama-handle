<?php
/**
 * The error file.
 * This file load and append all errors settings for handler errors.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.1
 */

/**
 * ----------------------------------------
 * Error & Exceptions handlers.
 * ----------------------------------------
 * The error handler tries for log all errors
 * and block some actions for increase site's
 * security.
 */

// Error handler
if (AMA_HANDLE_ERR['active']) {
    set_error_handler(function ($severity, $message, $file, $line) {
        if (!(error_reporting() & $severity)) {
            return;
        }
        Irmmr\Handle\App\Err::log(
            $message,
            'error',
            0,
            'Handler',
            $severity,
            $file,
            $line
        );
    }, AMA_HANDLE_ERR['levels']);
}

// Exception handler
if (AMA_HANDLE_EXP['active']) {
    set_exception_handler(function ($exception) {
        Irmmr\Handle\App\Err::error($exception)->addLog('ExpHandler');
    });
}

