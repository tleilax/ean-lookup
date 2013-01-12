<?php
    require_once 'includes/config.inc.php';

    date_default_timezone_set('Europe/Berlin');

    spl_autoload_register(function ($class) {
        require 'classes/' . $class . '.php';
    });
    
    DB::SetConnection(DB_CONNECTION);

    function render($view, $_variables = array(), $layout = false)
    {
        extract($_variables);
        ob_start();
        require 'views/' . $view . '.php';
        $CONTENT = ob_get_clean();

        if ($layout) {
            ob_start();
            require 'views/' . $layout . '.php';
            $CONTENT = ob_get_clean();
        }

        return $CONTENT;
    }