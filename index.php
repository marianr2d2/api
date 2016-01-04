<?php

    //http://docs.slimframework.com/routing/helpers/
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require 'Slim/Slim.php';
    \Slim\Slim::registerAutoloader();
    require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
    
    
    // Set the current mode
    $app = new \Slim\Slim($config);

    $db = Lib\Db\Wrapper\MySql::getInstance();
    //var_dump($db->test());
    var_dump($db->fetchAll("SELECT * from test"));
    var_dump($db->fetchOne("SELECT val FROM test where id = ?", array(1)));
    $res = $db->query("INSERT INTO test (val) VALUES(?)", array(uniqid()));

    // Only invoked if mode is "development"
    $app->configureMode('development', function () use ($app) {
        $app->config(array(
            'log.enabled' => true,
            'debug' => true
        ));
    });

    // Only invoked if mode is "production"
    $app->configureMode('production', function () use ($app) {
        $app->config(array(
            'log.enabled' => false,
            'debug' => false
        ));
    });
    
    
    /*
     * Suppose you wanted to authenticate the current user against a given role 
     * for a specific route. You could use some closure magic like this:
     * 
     * $authenticateForRole = function ( $role = 'member' ) {
            return function () use ( $role ) {
                $user = User::fetchFromDatabaseSomehow();
                if ( $user->belongsToRole($role) === false ) {
                    $app = \Slim\Slim::getInstance();
                    $app->flash('error', 'Login required');
                    $app->redirect('/login');
                }
            };
        };
        $app = new \Slim\Slim();
        $app->get('/foo', $authenticateForRole('admin'), function () {
            //Display admin control panel
        });
     */
    
    $app->get('/hello/:name', function ($name) use ($app) {
        //var_dump($app->getLog()->getEnabled());
        $app->response->headers->set('Content-Type', 'application/json');
        echo json_encode($name);
    });
    
    $app->run();

