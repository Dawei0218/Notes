<?php

// 静态代理如果类特别多，会带来很多重复的工作，还需要重新测试
// 所以引入动态代理

class UserService
{
    public function registry()
    {
        return 'this is registry of the UserService';
    }

    public function login()
    {
        return 'this is login of the UserService';
    }
}

class Metrics
{
    public function recordRequest($time) 
    {
        echo $time;
        /** 上报指标，省略代码 */
        return true;
    }
}

class DynamicProxy
{
    private $metrics;
    private $object;

    public function __construct(Metrics $metrics)
    {
        $this->metrics = $metrics;
    }

    public function createProxy($object)
    {
        $this->object = $object;
    }

    public function __call($method, $arguments)
    {
        $ref = new ReflectionClass($this->object);
        
        if(!$ref->hasMethod($method))
            throw new Error('method not exist');

        $reflectionMethod = $ref->getMethod($method);

        $start = time();
        echo $reflectionMethod->invokeArgs($this->object, $arguments);
        $end = time();

        $this->metrics->recordRequest($end - $start);
    }
}

$proxy = new DynamicProxy(new Metrics);
$proxy->createProxy(new UserService);
$proxy->login();