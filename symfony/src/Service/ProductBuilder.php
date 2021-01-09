<?php


namespace App\Service;


use App\DTO\ProductDTO;

class ProductBuilder
{
    private const COLUMN_SKU = 0;
    private const COLUMN_DESCRIPTION = 3;
    private const COLUMN_NAME = 1;
    private const COLUMN_PRICE = 2;

    public function build(array $productDetails): ProductDTO
    {
        $dto = new ProductDTO();
        $dto->sku = $productDetails[self::COLUMN_SKU] ?: 'Без SKU';
        $dto->name = $productDetails[self::COLUMN_NAME] ?: 'Без Name';
        $dto->price = $productDetails[self::COLUMN_PRICE] ?: 'Без price';
        $dto->description = $productDetails[self::COLUMN_DESCRIPTION] ?: 'Без desc';

        return $dto;
    }
}