<?php

require_once 'AbstractFactoryInterface.php';
require_once 'ProductB1.php';
require_once 'ProductB2.php';

class AbstractFactoryProductB implements AbstractFactoryInterface
{
    public static function getInstanceProductA()
    {
        return new ProductB1;
    }


    public static function getInstanceProductB()
    {
        return new ProductB2;
    }
}