<?php
class DB
{
    protected static $connections = array();

    public static function SetConnection($scope, $uri = null)
    {
        if ($uri === null) {
            $uri   = $scope;
            $scope = 'default';
        }

        extract(parse_url($uri));
        $pdo_str = sprintf('%s:host=%s;dbname=%s',
                           $scheme, $host, basename($path));
        self::$connections[$scope] = new PDO($pdo_str, $user, $pass);
    }
    
    public static function Get($scope = 'default')
    {
        return self::$connections[$scope];
    }
}