<?php

namespace Lib\Db\Adapter;

class Pdo implements \Lib\Db\DbInterface {
    
    protected $pdo;
    
    public function __construct($config) {
        $this->connect($config);
    }
    
    protected function connect($config) {
        if (defined('PDO::ATTR_DRIVER_NAME') && defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
            $dsn = 'mysql:dbname=' . $config['database'] . ';host=' . $config['hostname'] . '';
            try  {
                // Read settings from config, set UTF8
                $this->pdo = new PDO($dsn, $config['username'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                var_dump($this->pdo);
                // We can now log any exceptions on Fatal error. 
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Disable emulation of prepared statements, use REAL prepared statements instead.
                $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (PDOException $e)  {
                echo 'Error connecting to PDO db.';
            }
        } else {
            echo 'PDO unavailable';
        }
    }
    
}