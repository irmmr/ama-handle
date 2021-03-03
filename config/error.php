<?php
/**
 * The error config file.
 * This file return all error configs.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */

return [
    // Error reporting
    'report' => E_ALL,
    // Error display errors
    'display' => true,
    // Error handler configs
    'error' => [
        // Error handler status
        'active' => true,
        // Error handler logger status
        'logger' => true,
        // Error levels that must support by handler
        'levels' => E_ALL,
        // Error stop status
        'stop' => true,
    ],
    // Exception handler configs
    'exception' => [
        // Exception handler status
        'active' => true,
        // Exception handler logger status
        'logger' => true,
        // Exception stop status
        'stop' => true,
    ]
];
