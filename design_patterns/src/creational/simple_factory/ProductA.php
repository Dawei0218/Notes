<?php

require_once 'ProductInterface.php';

class ProductA implements ProductInterface
{
    public function getName()
    {
        return 'this is ProductA';
    }
}