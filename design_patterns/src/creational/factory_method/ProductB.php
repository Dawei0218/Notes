<?php

require_once 'ProductInterface.php';

class ProductB implements ProductInterface
{
    public function getName()
    {
        return 'this is ProductB';
    }
}