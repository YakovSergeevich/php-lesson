<?php

namespace App\Consumer;


use App\Repository\ProductRepository;
use Mgid\KafkaBundle\Command\Consumer;

class ProductCreateConsumer extends Consumer
{
    public const QUEUE_NAME = 'product_create_queue';
    /**
     * @var ProductRepository
     */
    private ProductRepository $repo;


    public function setRepository(ProductRepository $productRepository): void
    {
        $this->repo = $productRepository;
    }

    public function onMessage(array $data): void
    {

        $dto = unserialize($data[0]);
        $product = $this->repo->createOrUpdate($dto);

        print_r($product);
    }
}