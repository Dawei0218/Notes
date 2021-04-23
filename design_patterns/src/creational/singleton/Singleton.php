<?php

class Singleton
{
    private static $instance = NULL;

    private function __construct() {}

    public static function getInstance()
    {
        // 如果是多线程环境，你可能需要考虑线程安全
        // php是解释型语言，不需要采用饿汉式，因为你可能不会用到
        if(self::$instance === NULL)
            self::$instance = new Singleton;

        return self::$instance;
    }
}