<?php

abstract class Template
{
    public function templateMethod()
    {
        $this->method1();
        $this->method2();
    }

    abstract public function method1();
    abstract public function method2();
}

class Concrete extends Template
{
    public function method1()
    {
        echo 1;
    }

    public function method2()
    {
        echo 2;
    }
}

$concrete = new Concrete;
$concrete->templateMethod();