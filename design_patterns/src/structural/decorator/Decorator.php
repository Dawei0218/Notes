<?php

// 装饰器是功能增强，比如对读写io接口增加一个带buffer的读写
// 代理模式是功能不想关的功能

interface IA
{
    public function f();
}

class A implements IA
{
    public function f()
    {
        // 简单逻辑
    }
}

class ADecortor implements IA
{
    private $ia;

    public function __construct(IA $ia)
    {
        $this->ia = $ia;
    }

    public function f()
    {
        // 功能增强代码
        $this->ia->f();
        // 功能增强代码
    }
}