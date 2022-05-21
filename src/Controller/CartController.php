<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="app_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("", name="cart")
     */
    public function index(Cart $cart, ProductRepository $productRepository): Response
    {
        $cartTable = [];

        foreach ($cart->get() as $id => $quantity) {
            $cartTable[] = [
                'product' => $productRepository->findOneBy(['id' => $id]),
                'quantity' => $quantity
            ];
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartTable
        ]);
    }

    /**
     * @Route("/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart, int $id): RedirectResponse
    {
        $cart->add($id);

        return $this->redirectToRoute('app_products');
    }

    /**
     * @Route("/remove", name="remove_cart")
     */
    public function remove(Cart $cart): RedirectResponse
    {
        $cart->removeCart();

        return $this->redirectToRoute('app_products');
    }

    /**
     * @Route("/delete/product/{id}", name="remove_from_cart")
     */
    public function removeFromCart(Cart $cart, int $id): RedirectResponse
    {
        $cart->removeProduct($id);

        return $this->redirectToRoute('app_cart');
    }
}
