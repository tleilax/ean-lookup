<?php
    error_reporting(E_ALL);

    # define root
    $trails_root = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app';
    $trails_uri = sprintf('http%s://%s%s%s',
                          isset($_SERVER['HTTPS']) ? 's' : '',
                          $_SERVER['SERVER_NAME'],
                          $_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT'],
                          $_SERVER['SCRIPT_NAME']);

    # load trails
    # require_once $trails_root . '/../vendor/trails/trails-unabridged.php';
    require_once $trails_root . '/../vendor/trails/lib/trails.php';


    # load flexi
    require_once $trails_root . '/../vendor/flexi/lib/flexi.php';

    # dispatch
    $request_uri = @$_SERVER['PATH_INFO'] ?: '/';

    $default_controller = 'welcome';

    $dispatcher = new Trails_Dispatcher($trails_root, $trails_uri, $default_controller);
    $dispatcher->dispatch($request_uri);