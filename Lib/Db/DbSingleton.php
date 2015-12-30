<?php

namespace Lib\Db;

class DbSingleton {
    private static $instances = array();
    protected function __construct() {}
    protected function __clone() {}
    public function __wakeup()
    {
        throw new \Slim\Exception\Stop("Cannot unserialize singleton");
    }
    
    
    public static function getInstance()
    {
        $cls = get_called_class();
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }
}
