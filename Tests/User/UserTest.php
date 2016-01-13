<?php
class UserTest extends PHPUnit_Framework_TestCase
{
    
    private $user;
    
    public function __construct() {
        $db = Lib\Db\Wrapper\MySql::getInstance();
        $this->user = new Lib\User\User($db);
    }
    
    public function testUser() {
        $this->assertNotNull($this->user);
    }
    
    public function testException() {
        try {
            $this->user->register('asd', 'test');
        }

        catch (InvalidArgumentException $expected) {
            return;
        }

        $this->fail('An expected exception has not been raised.');
    }
    
    // ...
}