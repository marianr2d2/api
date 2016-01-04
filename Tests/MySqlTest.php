<?php
class MySqlTest extends PHPUnit_Framework_TestCase
{
    private $db;
    
    private $dummyVal;
    
    public function __construct() {
        $this->db = Lib\Db\Wrapper\MySql::getInstance();
        $this->dummyVal = uniqid();
    }

    public function testCanInstantiate() {
        $this->assertNotNull($this->db);
    }
    
    
    public function testCanInsert() {
        $result = $this->db->query("INSERT INTO test (val) VALUES(?)", array($this->dummyVal));
        $this->assertTrue($result);
    }
    
    
    public function testCanFetchOne() {
        $this->dummyVal = uniqid();
        $this->db->query("INSERT INTO test (val) VALUES(?)", array($this->dummyVal));
        $val = $this->db->fetchOne("SELECT val FROM test WHERE val LIKE ?", array($this->dummyVal));
        $this->assertEquals($this->dummyVal, $val);
    }
    
    
    public function testCanFetchAll() {
        $all = $this->db->fetchAll("SELECT * FROM test");
        $this->assertGreaterThan(1, count($all));
    }
    
    
    public function testCanFetchRow() {
        $row = $this->db->fetchRow("SELECT * FROM test ORDER BY id DESC");
        $this->assertArrayHasKey('val', $row);
    }
    
    public function testLastInsertId() {
        $howMany = $this->db->fetchOne("SELECT COUNT(*) FROM test");
        $this->assertEquals($howMany, $this->db->lastId());
    }
    

    // ...
}