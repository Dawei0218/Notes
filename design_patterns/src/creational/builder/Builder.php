<?php

class Config
{
    private $addr;
    private $port;
    private $passwd;

    public function __construct(Builder $builder)
    {
        $this->addr = $builder->addr;
        $this->port = $builder->port;
        $this->passwd = $builder->passwd;
    }

    public function getAddr()
    {
        return $this->addr;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPasswd()
    {
        return $this->passwd;
    }
}

class Builder
{
    public $addr;
    public $port;
    public $passwd;

    public function setAddr($addr)
    {
        $this->addr = $addr;
        return $this;
    }

    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }

    public function setPasswd($passwd)
    {
        $this->passwd = $passwd;
        return $this;
    }
}

$builder = new Builder;
$builder->setAddr('addr test')->setPort('port test')->setPasswd('passwd test');
$config = new Config($builder);
echo $config->getAddr() . PHP_EOL;
echo $config->getPort() . PHP_EOL;
echo $config->getPasswd() . PHP_EOL;