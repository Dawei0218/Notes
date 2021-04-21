<?php

require_once 'AbstractFactoryInterface.php';
require_once 'ProductA1.php';
require_once 'ProductB1.php';

class AbstractFactoryProductA implements AbstractFactoryInterface
{
    public static function getInstanceProductA()
    {
        return new ProductA1;
    }


    public static function getInstanceProductB()
    {
        return new ProductB1;
    }
}