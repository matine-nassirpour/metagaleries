<?php

namespace App\Controller;

use App\Cart\Cart;
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
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getCart()
        ]);
    }

    /**
     * @Route("/increase/product/{id}", name="increase_product")
     */
    public function increase(Cart $cart, int $id): RedirectResponse
    {
        $cart->increase($id);

        return $this->redirectToRoute('app_cart');
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
     * @Route("/remove/product/{id}", name="remove_product")
     */
    public function removeFromCart(Cart $cart, int $id): RedirectResponse
    {
        $cart->removeProduct($id);

        return $this->redirectToRoute('app_cart');
    }

    /**
     * @Route("/decrease/product/{id}", name="decrease_product")
     */
    public function decrease(Cart $cart, int $id): RedirectResponse
    {
        $cart->decrease($id);

        return $this->redirectToRoute('app_cart');
    }
}
