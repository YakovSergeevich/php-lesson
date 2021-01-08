<?php

namespace App\Command;


use App\Repository\ProductRepository;
use Mgid\KafkaBundle\Command\Consumer;

class HelloSendConsumer extends Consumer
{
    public const QUEUE_NAME = 'hello_send_greeting';
    /**
     * @var ProductRepository
     */
    private ProductRepository $repo;


    public function setRepository(ProductRepository $productRepository): void
    {
        $this->repo = $productRepository;
    }

    protected function onMessage(array $data): void
    {

        $this->repo->addArray($data);
    }
}