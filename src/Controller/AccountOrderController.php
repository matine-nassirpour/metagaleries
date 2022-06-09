<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    /**
     * @Route("/account/orders", name="app_account_orders")
     */
    public function index(OrderRepository $orderRepository): Response
    {
        /** @var User $user */ $user = $this->getUser();
        $orders = $orderRepository->findPaidOrders($user);

        return $this->render('account/order.html.twig', [
            'orders' => $orders
        ]);
    }
}
