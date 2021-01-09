<?php

namespace App\Service;

use App\Consumer\ProductCreateConsumer;
use App\DTO\ProductDTO;
use Mgid\KafkaBundle\DependencyInjection\Traits\ProducerTrait;

class ProductQueueProducer
{
    use ProducerTrait;

    public function createProduct(ProductDTO $dto): void
    {
        $this->producer->send(ProductCreateConsumer::QUEUE_NAME, [serialize($dto)]);
    }
}