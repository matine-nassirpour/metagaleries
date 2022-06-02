<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="app_stripe_create_session")
     */
    public function index(
        EntityManagerInterface $entityManager,
        string $reference
    ): JsonResponse
    {
        Stripe::setApiKey('sk_test_51L5uvnDbDyAwt1rEMuXQkPHCRRStYXaTdp7L6PiVZeYAa46FdzQRmqoo9PGDRAfAijHHqwjlrVZ50VWbZMC3Rzyz00hmcdLnHn');

        $YOUR_DOMAIN = 'https://127.0.0.1:8000';
        $product_for_stripe = [];

        $order = $entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $productObject = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());

            $product_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN."/build/uploads/products/".$productObject->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        return new JsonResponse(['id' => $checkout_session->id]);
    }
}
