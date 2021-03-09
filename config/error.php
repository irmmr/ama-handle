<?php
/**
 * The error config file.
 * This file return all error configs.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.1
 */

return [
    // Error handler configs
    'error' => [
        // Error handler status
        'active' => true,
        // Error levels that must support by handler
        'levels' => E_ALL,
    ],
    // Exception handler configs
    'exception' => [
        // Exception handler status
        'active' => true,
    ]
];
