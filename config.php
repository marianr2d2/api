<?php

    $config = array(
        'mode' => 'development',
        'log.writer' => new \Slim\LogWriter(fopen('log.txt', 'w+')),
        'log.level' => \Slim\Log::DEBUG,
        
        //MySQL Credentials
        'mysql' => array(  'hostname' => 'localhost',
                            'username' => 'root',
                            'password' => '',
                            'database' => 'api',
                        ),
        
    );
