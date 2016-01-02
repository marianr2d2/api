<?php

namespace Lib\Db\Wrapper;

//class MySql extends \Lib\Db\DbSingleton implements \Lib\Db\DbInterface {
class MySql extends \Lib\Db\DbAbstract {
    
    public function __construct() {
        try {
            $this->loadConf();
        } catch (\Slim\Exception\Stop $e) {
            echo $e->getMessage();
        }
        
        $pdo = new \Lib\Db\Adapter\PdoEngine($this->config);
        $this->loadDbh($pdo);
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

