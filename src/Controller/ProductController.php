<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use App\Search\Search;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/products", name="app_products")
     */
    public function index(
        ProductRepository $productRepository,
        Request $request
    ): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->findWithSearch($search);
        } else {
            $products = $productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'searchForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/{slug}/{id}", name="app_product")
     */
    public function show(string $slug, int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy([
            'slug' => $slug,
            'id' => $id
        ]);

        if (!$product) {
            return $this->redirectToRoute('app_products');
        }

        $products = $this->entityManager->getRepository(Product::class)->findBy(['isBest' => 1]);

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }
}
