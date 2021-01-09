<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\ProductQueueProducer;
use Elastica\Response;
use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ApiProductController extends AbstractController
{


    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    /**
     * @var PaginatedFinderInterface
     */
    private PaginatedFinderInterface $finder;
    /**
     * @var ProductQueueProducer
     */
    private ProductQueueProducer $helloService;

    public function __construct
    (
        PaginatedFinderInterface $finder,
        ProductRepository $productRepository,
        ProductQueueProducer $helloService

    )
    {
        $this->finder = $finder;
        $this->productRepository = $productRepository;
        $this->helloService = $helloService;
    }

    /**
     * @Route(
     *     "/api/product/search",
     *     name="product_search",
     *     methods={"POST"}
     *     )
     * @param Request $request
     * @return JsonResponse
     */

    public function search(Request $request): JsonResponse
    {
        $str = $request->getContent();
        $results = $this->finder->find($str);
        return $this->json($results);
    }

}
