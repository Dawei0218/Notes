<?php

require_once 'ProductA.php';
require_once 'ProductB.php';

class ProductFactory
{
    public static function getInstance($name)
    {
        $instance = NULL;
        switch ($name) {
            case 'A':
                $instance = new ProductA;
                break;
            
            case 'B':
                $instance = new ProductB;
                break;
        }

        return $instance;
    }
}