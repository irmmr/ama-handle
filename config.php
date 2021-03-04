<?php
/**
 * The config file.
 * This file using for set main variables and some configs
 * for user and is a important file for ama handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.1
 */

/*
 * !!DON'T CHANGE THIS FILE!!
 * If you want change your handle configs, please change
 * 'config' directory configs and do not change this file.
 */

/**
 * ----------------------------------------
 * The main variables.
 * ----------------------------------------
 * This vars handles main values for usage
 * in other classes.
 */
define('AMA_HANDLE_PATH', __DIR__);
define('AMA_HANDLE_VERSION', '1.0.1');
define('AMA_HANDLE_PHP', '7.4');

/**
 * ----------------------------------------
 * The database variables.
 * ----------------------------------------
 * This vars uses for database connection
 * and must be enter by the right way.
 */
$dbConfig = require __DIR__ . '/config/database.php';
define('AMA_HANDLE_DB', $dbConfig);

/**
 * ----------------------------------------
 * The email variables.
 * ----------------------------------------
 * This variables uses for email settings and
 * all of the connection configs.
 */
$emConfig = require __DIR__ . '/config/email.php';
define('AMA_HANDLE_EMM', $emConfig['mailer']);
define('AMA_HANDLE_EMS', $emConfig['smtp']);

/**
 * ----------------------------------------
 * The error handler variables.
 * ----------------------------------------
 * This variables uses for error handlers and
 * exception configs.
 */
$erConfig = require __DIR__ . '/config/error.php';
define('AMA_HANDLE_ERR', $erConfig['error']);
define('AMA_HANDLE_EXP', $erConfig['exception']);
define('AMA_HANDLE_ERR_DISPLAY', $erConfig['display']);
define('AMA_HANDLE_ERR_REPORT', $erConfig['report']);

/**
 * ----------------------------------------
 * The main variables.
 * ----------------------------------------
 * This variables uses in main actions and partial
 * action for handle.
 */
$maConfig = require __DIR__ . '/config/main.php';
define('AMA_HANDLE_CONF', $maConfig);

/**
 * ----------------------------------------
 * Check php version
 * ----------------------------------------
 * This base is checks in first and without
 * main functions.
 */
if (!defined('AMA_HANDLE_PHP')) {
    die("AMA Handle: the ama handle`s php version is not defined.");
}
if (version_compare(AMA_HANDLE_PHP, PHP_VERSION, '>')) {
    die("AMA Handle: your php version must be ".AMA_HANDLE_PHP." or higher version.");
}

/**
 * ----------------------------------------
 * Load reporting
 * ----------------------------------------
 * Try to load errors setting for handler errors
 * and other actions such as Exceptions and other
 * app loggers.
 */
require AMA_HANDLE_PATH . '/bootstrap/reporting.php';
