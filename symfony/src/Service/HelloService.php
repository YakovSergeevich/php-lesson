<?php

namespace App\Service;

use App\Command\HelloSendConsumer;
use Mgid\KafkaBundle\DependencyInjection\Traits\ProducerTrait;

class HelloService
{
    use ProducerTrait;

    /**
     * @param array $data
     */
    public function send(array $data): void
    {
        $this->producer->send(HelloSendConsumer::QUEUE_NAME, $data);
    }
}