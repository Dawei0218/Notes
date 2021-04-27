<?php

// 被观察者者
interface ObservableImpl
{
    public function register(ObserverImlp $observer);
    public function notifyObservers();
}

// 有变动进行通知
class Observable implements ObservableImpl
{
    public $observers;

    public function register(ObserverImlp $observer)
    {
        $this->observers[] = $observer;
    }

    public function notifyObservers()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }
}

// 观察者
interface ObserverImlp
{
    public function update();
}

class Observer implements ObserverImlp
{
    public function update()
    {
        echo '变更通知';
    }
}

$observable = new Observable;
$observable->register(new Observer);
$observable->notifyObservers();