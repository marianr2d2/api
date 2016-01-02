<?php

namespace Lib\Db;

interface DbInterface {
    public function query($query, $params);
    public function fetchAll($query, $params);
    public function fetchRow($query, $params = array());
    public function fetchOne($query, $params = array());
    public function lastId();
}

