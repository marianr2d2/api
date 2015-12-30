<?php

namespace Lib\Db;

abstract class DbAbstract extends \Lib\Db\DbSingleton implements \Lib\Db\DbInterface {
    protected $config;
    protected $dbh;
    
    protected function loadConf() {
        $class = get_called_class();
        $classParts = preg_split("#\\\#", $class);
        $class = array_pop($classParts);
        global $config;
        
        if (array_key_exists(strtolower($class), $config)) {
            $this->config = $config[strtolower($class)];
        } else {
            throw new \Slim\Exception\Stop('Could not find configuration values for ' . $class);
        }
    }
    
    
    protected function loadDbh(\Lib\Db\DbInterface $dbh) {
        $this->dbh = $dbh;
    }
    
}