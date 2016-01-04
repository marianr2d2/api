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
            throw new \Exception('Could not find configuration values for ' . $class);
        }
    }
    
    
    protected function loadDbh(\Lib\Db\DbInterface $dbh) {
        $this->dbh = $dbh;
    }
    
    public function query($query, $params = array()) {
        return $this->dbh->query($query, $params);
    }
    
    public function fetchAll($query, $params = array()) {
        return $this->dbh->fetchAll($query, $params);
    }
    
    public function fetchRow($query, $params = array()) {
        return $this->dbh->fetchRow($query, $params);
    }
    
    public function fetchOne($query, $params = array()) {
        return $this->dbh->fetchOne($query, $params);
    }

    public function lastId() {
        return $this->dbh->lastId();
    }
    
    
    
}