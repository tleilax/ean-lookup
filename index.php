<?php
    require 'bootstrap.php';

    # define root
    $trails_root = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app';
    $trails_uri = sprintf('http%s://%s%s%s',
                          isset($_SERVER['HTTPS']) ? 's' : '',
                          $_SERVER['SERVER_NAME'],
                          $_SERVER['SERVER_PORT'] == 80 ? '' : ':' . $_SERVER['SERVER_PORT'],
                          dirname($_SERVER['SCRIPT_NAME']));

    # dispatch
    $request_uri = @$_REQUEST['path'] ?: '/';

    $default_controller = 'welcome';

    $dispatcher = new Trails_Dispatcher($trails_root, $trails_uri, $default_controller);
    $dispatcher->request_uri = $request_uri;
    $dispatcher->dispatch($request_uri);