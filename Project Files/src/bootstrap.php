<?php
define('APP_ROOT', dirname(__FILE__, 2));                // Root directory

require APP_ROOT . '/src/functions.php';
require APP_ROOT . '/config/config.php';
// require APP_ROOT . '/vendor/autoload.php';            //Autoloader replaces spl_autoload_register once Composer is installed

if (DEV === false) {
    set_exception_handler('handle_exception');           // Set exception handler
    set_error_handler('handle_error');                   // Set error handler
    register_shutdown_function('handle_shutdown');       // Set shutdown handler
}

spl_autoload_register(function($class)                   // Set autoload function
{
    $path = APP_ROOT . '/src/classes/';                  // Path to class definitions
    require $path . $class . '.php';                     // Include class definition
});

$cms = new CMS($dsn, $username, $password);
unset($dsn, $username, $password);

$session = $cms->getSession();
