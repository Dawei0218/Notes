<?php

require_once 'FactoryInterface.php';
require_once 'ProductA.php';

class FactoryProductA
{
    public static function getInstance()
    {
        return new ProductA;
    }
}