<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\User;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="app_order")
     */
    public function index(Cart $cart, Request $request): Response
    {
        /** @var User $user */ $user = $this->getUser();

        if (!$user->getAddresses()->getValues()) {
            return $this->redirectToRoute('app_account_addresses_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('order/index.html.twig', [
            'orderForm' => $form->createView(),
            'cart' => $cart->getCart()
        ]);
    }
}
