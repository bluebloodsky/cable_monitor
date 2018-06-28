<?php
/**
 * Define some constants
 */
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("API" , ROOT . "api" . DS);
define("VENDORDIR", ROOT . "vendor" . DS);
/**
 * Include autoload file
 */

if (file_exists(VENDORDIR . "autoload.php")) {
    require_once VENDORDIR . "autoload.php";
} else {
    die("<pre>Run 'composer.phar install' in root dir</pre>");
}

/**
 * Include getData file
 */
require API . 'src' . DS . 'getData.php';
