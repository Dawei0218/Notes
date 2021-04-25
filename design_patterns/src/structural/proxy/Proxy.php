<?php

interface User
{
    public function registry();
    public function login();
}

// 实现一个注册和登录功能
class UserService implements User
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

// 增加上报时间对每个api
// 可以在registry和login进行统计start和end时间
// 以上方案对代码侵入性太高
class Metrics
{
    public function recordRequest($time) 
    { 
        /** 上报指标，省略代码 */
        return true;
    }
}

// 采用代理模式 + 委托
// 如果抽象出接口，就只用继承parent::xxx
// 如果类特别多就会特别麻烦，所以引入动态代理
class UserProxy implements User
{
    private $userService;
    private $metrics;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->metrics = new Metrics;
    }

    public function registry()
    {
        $start = time();
        $data = $this->userService->registry();
        $end = time();

        $this->metrics->recordRequest($end - $start);

        return $data;
    }

    public function login()
    {
        $start = time();
        $data = $this->userService->login();
        $end = time();

        $this->metrics->recordRequest($end - $start);

        return $data;
    }
}