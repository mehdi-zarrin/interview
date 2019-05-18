<?php

class SingletonTest
{
    private static $instance;
    private function __construct()
    {
    }

    public static function getInstance() {
        if(empty(self::$instance)) {
            self::$instance = new SingletonTest();
        }

        return self::$instance;
    }
}

$config = SingletonTest::getInstance();
$config2 = SingletonTest::getInstance();
var_dump($config);
var_dump($config2);