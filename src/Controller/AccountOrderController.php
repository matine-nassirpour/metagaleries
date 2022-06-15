<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account/orders", name="app_account_")
 */
class AccountOrderController extends AbstractController
{
    /**
     * @Route("", name="orders")
     */
    public function index(OrderRepository $orderRepository): Response
    {
        /** @var User $user */ $user = $this->getUser();
        $orders = $orderRepository->findPaidOrders($user);

        return $this->render('account/order.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/account/order/show/{reference}", name="order_show")
     */
    public function show(
        OrderRepository $orderRepository,
        string $reference
    ): Response
    {
        $order = $orderRepository->findOneBy(['reference' => $reference]);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_orders');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order
        ]);
    }
}
