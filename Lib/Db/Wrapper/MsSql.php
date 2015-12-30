<?php

namespace Lib\Db\Wrapper;

class MsSql extends \Lib\Db\DbSingleton implements \Lib\Db\DbInterface {
    public function query($query) {
        return true;
    }
}

