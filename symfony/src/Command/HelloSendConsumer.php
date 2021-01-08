<?php

namespace App\Command;


use Mgid\KafkaBundle\Command\Consumer;

class HelloSendConsumer extends Consumer
{
    public const QUEUE_NAME = 'greeting';


    protected function onMessage(array $data): void
    {
        print_r($data);
    }
}