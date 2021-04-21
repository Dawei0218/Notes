<?php

require_once 'FactoryProductA.php';
require_once 'FactoryProductB.php';

$obj = FactoryProductA::getInstance();
echo $obj->getName();

$obj = FactoryProductB::getInstance();
echo $obj->getName();