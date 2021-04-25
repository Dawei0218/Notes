<?php

// 消息发送实现
interface MsgSender
{
    public function send();
}

class TelephoneSender implements MsgSender
{
    public function send()
    {
        return 'Telephone Sender';
    }
}

class WechatSender implements MsgSender
{
    public function send()
    {
        return 'Wechat sender';
    }
}

abstract class Notify
{
    protected $msgSender;

    public function __construct(MsgSender $msgSender)
    {
        $this->msgSender = $msgSender;
    }

    abstract public function notify();
}

class SevereNotify extends Notify
{
    public function notify()
    {
        echo $this->msgSender->send();
    }
}

class NormalNotify extends Notify
{
    public function notify()
    {
        echo $this->msgSender->send();
    }
}

$notify = new SevereNotify(new TelephoneSender);
$notify->notify();