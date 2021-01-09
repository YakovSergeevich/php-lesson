<?php


namespace App\Repository;


use App\DTO\ProductDTO;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Exception;

class ProductRepository
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private ObjectRepository $repo;


    /**
     * ProductRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(Product::class);

    }

    public function createOrUpdate(ProductDTO $dto): Product
    {
        $this->entityManager->beginTransaction();
        $product = $this->repo->findOneBy(['sku' => $dto->sku]);
        if (!$product) {
            $product = Product::create(
                $dto->name,
                $dto->sku,
                $dto->price,
                $dto->description ,
                random_int(1,3)
            );
        } else {
            $product->update(
                $dto->name,
                $dto->sku,
                $dto->price,
                $dto->description ,
                random_int(1,3)
            );
        }

        $this->entityManager->persist($product);
        try {
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Exception $e){
            $this->entityManager->rollback();
            throw $e;
        }

        return $product;
    }

}
