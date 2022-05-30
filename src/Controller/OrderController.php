<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\User;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order", name="app_")
 */
class OrderController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("", name="order")
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

        return $this->render('order/index.html.twig', [
            'orderForm' => $form->createView(),
            'cart' => $cart->getCart()
        ]);
    }

    /**
     * @Route("/summary", name="order_summary", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();

            /** @var User $user */ $user = $this->getUser();
            $date = new \DateTimeImmutable();
            /** @var Carrier $carrier */ $carrier = $form->get('carriers')->getData();
            /** @var Address $address */ $address = $form->get('addresses')->getData();

            $addressContent = $address->getFullName();
            $addressContent .= '<br />' . $address->getPhone();
            $addressContent .= '<br />' . $address->getAddress();
            $addressContent .= '<br />' . $address->getZipCode() . ' ' . $address->getCity();
            $addressContent .= '<br />' . $address->getCountry();

            $order->setUser($user);
            $order->setCreatedAt($date);
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order->setDelivery($addressContent);
            $order->setIsPaid(false);

            $this->entityManager->persist($order);

            foreach ($cart->getCart() as $product) {
                $orderDetails = new OrderDetails();

                $orderDetails->setUserOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotalPrice($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderDetails);
            }

            // $this->entityManager->flush();

            return $this->render('order/passed.html.twig', [
                'cart' => $cart->getCart(),
                'carrier' => $carrier,
                'address' => $address
            ]);
        }

        return $this->redirectToRoute('app_cart');
    }
}
