<?php

namespace App\Controller;

use App\Cart\Cart;
use App\Entity\Address;
use App\Entity\User;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/addresses/add", name="app_account_addresses_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */ $user = $this->getUser();
            $address->setUser($user);

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            $this->addFlash('success', 'Votre nouvelle adresse a été ajouté avec succès !');

            if ($cart->get()) {
                return $this->redirectToRoute('app_order');
            } else {
                return $this->redirectToRoute('app_account_addresses');
            }
        }

        return $this->render('account/manage_address.html.twig', [
            'addressForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/addresses/edit/{id}", name="app_account_addresses_edit")
     */
    public function edit(
        Request $request,
        int $id
    ): Response
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if (!$address || ($address->getUser() !== $this->getUser())) {
            return $this->redirectToRoute('app_account_addresses');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', 'Vous avez modifé votre adresse avec succès !');

            return $this->redirectToRoute('app_account_addresses');
        }

        return $this->render('account/manage_address.html.twig', [
            'addressForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/addresses/remove/{id}", name="app_account_addresses_remove")
     */
    public function remove(int $id): RedirectResponse
    {
        $address = $this->entityManager->getRepository(Address::class)->findOneBy(['id' => $id]);

        if ($address && ($address->getUser() === $this->getUser())) {
            $this->entityManager->remove($address);

            $this->entityManager->flush();
        }

        $this->addFlash('success', 'Adresse supprimée avec succès !');

        return $this->redirectToRoute('app_account_addresses');
    }
}
