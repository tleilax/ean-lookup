<?php
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Berlin');
    session_start();

    require_once 'includes/config.inc.php';

    # load trails
    require_once 'vendor/trails/lib/trails.php';
    require_once 'vendor/flexi/lib/flexi.php';

    // Register auto loader
    spl_autoload_register(function ($class) {
        if (strpos($class, 'GoogleApi') === 0) {
            require 'vendor/google-api/src/' . str_replace('\\', '/', $class) . '.php';
        } else {
            require 'classes/' . $class . '.php';
        }
    });
    
    DB::SetConnection(DB_CONNECTION);
