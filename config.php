<?php

    $config = array(
        'mode' => 'development',
        //'log.writer' => new \Slim\LogWriter(fopen('log.txt', 'w+')),
        //'log.level' => \Slim\Log::DEBUG,
        
        //MySQL Credentials
        'mysql' => array(  'host' => 'localhost',
                            'user' => 'root',
                            'pass' => '',
                            'dbname' => 'api',
                            'charset' => 'UTF8'
                        ),
        
    );
