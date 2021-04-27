<?php

interface Strategy
{
    public function do();
}

class StrategyA implements Strategy
{
    public function do()
    {
        return 'A';
    }
}

class StrategyB implements Strategy
{
    public function do()
    {
        return 'B';
    }
}

class Factory
{
    public static function getInstance($type)
    {
        if($type == 'A') 
            return new StrategyA;
        else
            return new StrategyB;
    }
}

echo Factory::getInstance('A')->do();
echo Factory::getInstance('B')->do();