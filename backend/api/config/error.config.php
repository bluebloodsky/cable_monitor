<?php
/**
 * Created by PhpStorm.
 * User: libgcc
 * Date: 2017/11/21
 * Time: 16:43
 */

function gWarningHandler($errno, $errstr, $errfile, $errline, array $errcontext) {
   throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('gWarningHandler', E_WARNING);

$gCmuPostStatus = 210;
