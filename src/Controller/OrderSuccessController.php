<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\Order;
use App\Mailjet\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/order/success/{stripeSessionId}", name="app_order_success")
     */
    public function index(string $stripeSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneBy(['stripeSessionId' => $stripeSessionId]);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if ($order->getStatus() === 0) {
            $cart->removeCart();

            $order->setStatus(1);

            $this->entityManager->flush();

            $mailer = new Mailer();

            $mailer->send(
                $order->getUser()->getEmail(),
                $order->getUser()->getLastName(),
                'Meta Galeries - Nouvelle commande',
                'Commande N° ' . $order->getReference(),
                'Bonjour, votre commande a bien été enregistrée.<br />Merci pour votre commande.'
            );
        }

        return $this->render('order/success.html.twig', [
            'order' => $order
        ]);
    }
}
