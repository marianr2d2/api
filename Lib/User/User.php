<?php

namespace Lib\User;


class User implements \SplSubject {
    
    protected $observers = array();
    
    protected $db = null;
    
    public function __construct(\Lib\Db\DbAbstract $db) {
        $this->db = $db;
    }
    
    
    public function attach(\SplObserver $observer) {
        $this->observers[] = $observer;
    }
    
    public function detach(\SplObserver $observer) {
        $key = array_search($observer, $this->observers, true);
        if($key){
            unset($this->observers[$key]);
        }
    }
    
    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
    
    public function register($email, $password, $settings = []) {
        
        if (is_null($this->db)) {
            throw new \Exception('DB not connected.');
            return false;
        }
        
        if ($this->emailExists($email)) {
            throw new \Exception('Email already registered.');
            return false;
        }
        
        try {
            return $this->addUser($email, $password, $settings);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
        
    }
    
    
    protected function emailExists($email) {
        $result = $this->db->fetchOne('SELECT id FROM `USERS` where email = ?', [$email]);
        return is_null($result) ? FALSE : TRUE;
    }
    
    
    protected function addUser($email, $password, $settings = []) {
        
        //Bcrypt given password
        $encryptedPw = password_hash($password, PASSWORD_DEFAULT);
        
        //Insert user
        $query = $this->db->query('INSERT INTO `USERS`(email, password) VALUES (?, ?)', [$email, $encryptedPw]);
        $idUser = $this->db->lastId();
        
        if (!$query) {
            throw new \Exception('Could not add user.');
            return false;
        }
        
        //Insert users's settings
        if (!empty($settings)) {
            $query = $this->db->query('INSERT INTO `USERS`(genre, name) VALUES (?,?)', [$settings]);
            $idUserSettings = $this->db->lastId();
            
            if (!$query) {
                throw new \Exception('Could not add user settings.');
                return false;
            }
        }
        
        if (is_numeric($idUserSettings) && is_numeric($idUser)) {
            $query = $this->db->query('INSERT INTO `USERS_USER_SETTINGS` VALUES(?,?)', [$idUserSettings, $idUser]);
            if (!$query) {
                throw new \Exception('Could not insert user settings reference.');
                return false;
            }
        }
        
        return true;
        
    }
    
}
