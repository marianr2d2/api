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
}

