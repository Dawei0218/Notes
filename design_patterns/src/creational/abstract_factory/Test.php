<?php

require_once 'AbstractFactoryProductA.php';
require_once 'AbstractFactoryProductB.php';

echo AbstractFactoryProductA::getInstanceProductA()->getName();
echo AbstractFactoryProductA::getInstanceProductB()->getName();

echo AbstractFactoryProductB::getInstanceProductA()->getName();
echo AbstractFactoryProductB::getInstanceProductB()->getName();

