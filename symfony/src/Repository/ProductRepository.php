<?php


namespace App\Repository;


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
    public function __construct(
        EntityManagerInterface $entityManager

    )
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(Product::class);

    }


    public function addArray(array $array)
    {
    foreach ($array as $item) {
        $product = Product::create(isset($item[1]) ? $item[1] : 'Без названия',  isset($item[0]) ? $item[0] : 00000,
                isset($item[2]) ? (float)$item[2] : 0, isset($item[3]) ? $item[3] : 'Без описания', random_int(1, 3));

        if (!$product) {
                throw new Exception('Что то пошло не так', 400);
            }
            $this->entityManager->persist($product);
        }
        $this->entityManager->flush();

        return true;
    }

}
