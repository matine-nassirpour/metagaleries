<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function add(int $id): void
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
}
