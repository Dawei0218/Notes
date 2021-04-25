<?php

interface ITarget 
{
    public function fa();
    public function fb();
    public function fc();
}

// 因为大部分定义相同，可以直接使用继承复用代码
class Adeptee
{
    public function fa() {}
    public function fb() {}
    public function f3() {}
}

class Adeptor extends Adeptee implements ITarget
{
    public function fc()
    {
        $this->adeptee->f3();
    }
}

// 因为大部分定义不同，可以直接使用继承复用代码
class Adeptee1
{
    public function f1() {}
    public function f2() {}
    public function f3() {}
}

class Adeptor1 implements ITarget
{
    private $adeptee;

    public function __construct(Adeptee1 $adeptee)
    {
        $this->adeptee = $adeptee;
    }

    public function fa()
    {
        $this->adeptee->f1();
    }

    public function fb()
    {
        $this->adeptee->f2();
    }

    public function fc()
    {
        $this->adeptee->f3();
    }
}