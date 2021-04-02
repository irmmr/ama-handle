<?php
/**
 * The config file.
 * This file using for set main variables and some configs
 * for user and is a important file for ama handle.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.4
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
// main path
define('AMA_HANDLE_PATH', __DIR__);
// get version
$version = @file_get_contents(AMA_HANDLE_PATH . '/version');
define('AMA_HANDLE_VERSION', $version !== false && !empty($version) ? $version : 'unknown');
// php support version
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
 * The main variables.
 * ----------------------------------------
 * This variables uses in main actions and partial
 * action for handle.
 */
$maConfig = require __DIR__ . '/config/main.php';
define('AMA_HANDLE_CONF', $maConfig);
