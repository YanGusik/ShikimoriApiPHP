<?php

error_reporting(-1);
ini_set('display_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('UTC');

set_error_handler('error_handler', E_ALL);

// Don't print errors for methods deprecated in the library
function error_handler($errno): bool
{
    return $errno === E_USER_DEPRECATED;
}
