<?php
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Berlin');

    // require_once 'vendor/luniki/trails/lib/trails.php';
    // require_once 'vendor/luniki/flexi-templates/lib/flexi.php';
    require_once 'vendor/gabordemooij/redbean/rb.php';
    require_once 'vendor/autoload.php';
#    require_once 'vendor/password-compat/lib/password.php';


    // Register auto loader
    spl_autoload_register(function ($class) {
        if (file_exists('classes/' . $class . '.php')) {
            require 'classes/' . $class . '.php';
        }
    });

    session_start();
    
    require_once 'includes/config.inc.php';
    require_once 'includes/functions.php';

