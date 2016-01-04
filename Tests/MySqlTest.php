<?php
class MySqlTest extends PHPUnit_Framework_TestCase
{
    // ...

    public function testCanInstantiate()
    {
        
        
        // Arrange
        $db = Lib\Db\Wrapper\MySql::getInstance();

        // Act
        $val = $db->fetchOne("SELECT val FROM test where id = ?", array(1));

        // Assert
        $this->assertEquals(1, $val);
    }

    // ...
}