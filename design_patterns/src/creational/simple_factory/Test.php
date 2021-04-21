<?php

require_once 'ProductFactory.php';

$product = ProductFactory::getInstance('A');
echo $product->getName();

$product = ProductFactory::getInstance('A');
echo $product->getName();