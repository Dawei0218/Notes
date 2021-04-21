<?php

require_once 'FactoryInterface.php';
require_once 'ProductB.php';

class FactoryProductB implements FactoryInterface
{
    public static function getInstance()
    {
        return new ProductB;
    }
}