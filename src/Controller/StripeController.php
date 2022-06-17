<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/order/create-session/{reference}", name="app_stripe_create_session")
     */
    public function index(
        EntityManagerInterface $entityManager,
        string $reference
    ): JsonResponse
    {
        Stripe::setApiKey('sk_test_51L5uvnDbDyAwt1rEMuXQkPHCRRStYXaTdp7L6PiVZeYAa46FdzQRmqoo9PGDRAfAijHHqwjlrVZ50VWbZMC3Rzyz00hmcdLnHn');

        $YOUR_DOMAIN = 'https://127.0.0.1:8000';
        $product_for_stripe = [];

        /** @var Order $order */
        $order = $entityManager->getRepository(Order::class)->findOneBy(['reference' => $reference]);

        foreach ($order->getOrderDetails()->getValues() as $product) {
            // @phpstan-ignore-next-line
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

        $product_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

        /** @var User $user */ $user = $this->getUser();

        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $product_for_stripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/order/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/order/cancel/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);

        $entityManager->flush();

        return new JsonResponse(['id' => $checkout_session->id]);
    }
}
