<?php

namespace App\Cart;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private SessionInterface $session;
    private EntityManagerInterface $entityManager;

    public function __construct(
        SessionInterface $session,
        EntityManagerInterface $entityManager
    )
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function increase(int $id): void
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->session->get('cart');
    }

    /**
     * @return mixed
     */
    public function removeCart()
    {
        return $this->session->remove('cart');
    }

    /**
     * @return mixed
     */
    public function removeProduct(int $id)
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    /**
     * @return mixed
     */
    public function decrease(int $id)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $this->session->set('cart', $cart);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCart(): array
    {
        $cart = [];

        if ($this->get()) {
            foreach ((array) $this->get() as $id => $quantity) {
                $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

                if (!$product) {
                    $this->removeProduct($id);

                    continue;
                }

                $cart[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        return $cart;
    }
}
