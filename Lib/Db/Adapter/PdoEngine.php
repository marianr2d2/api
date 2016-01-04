<?php

namespace Lib\Db\Adapter;

class PdoEngine implements \Lib\Db\DbInterface {
    
    protected $pdo;
    
    public function __construct($config) {
        $this->connect($config);
    }
    
    protected function connect($settings) {
        if (defined('\PDO::ATTR_DRIVER_NAME')) {
            $emulate_prepares_below_version = '5.1.17';

            $dsndefaults = array_fill_keys(['host', 'port', 'unix_socket', 'dbname', 'charset'], null);
            $dsnarr = array_intersect_key($settings, $dsndefaults);
            $dsnarr += $dsndefaults;

            // connection options I like
            $options = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            );

            // connection charset handling for old php versions
            if ($dsnarr['charset'] and version_compare(PHP_VERSION, '5.3.6', '<')) {
                $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES '.$dsnarr['charset'];
            }
            $dsnpairs = array();
            foreach ($dsnarr as $k => $v) {
                if ($v===null) continue;
                $dsnpairs[] = "{$k}={$v}";
            }

            $dsn = 'mysql:'.implode(';', $dsnpairs);
            $dbh = new \PDO($dsn, $settings['user'], $settings['pass'], $options);

            // Set prepared statement emulation depending on server version
            $serverversion = $dbh->getAttribute(\PDO::ATTR_SERVER_VERSION);
            $emulate_prepares = (version_compare($serverversion, $emulate_prepares_below_version, '<'));
            $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, $emulate_prepares);

            $this->pdo = $dbh;
        } else {
            echo 'PDO unavailable';
        }
    }
    
    public function query($query, $params = array()) {
        try {
            $sth = $this->pdo->prepare($query);
            return $sth->execute($params);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
    public function fetchAll($query, $params = array()) {
        try {
            $sth = $this->pdo->prepare($query);
            $sth->execute($params);
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function fetchRow($query, $params = array()) {
        $result = $this->fetchAll($query, $params);
        return isset($result[0]) ? $result[0] : array();
    }
    
    
    public function fetchOne($query, $params = array()) {
        $sth = $this->pdo->prepare($query);
        $sth->execute($params);
        $result = $sth->fetch(\PDO::FETCH_NUM);
        return isset($result[0]) ? $result[0] : NULL;
    }
    
    public function lastId() {
        return $this->pdo->lastInsertId();
    }

    
}