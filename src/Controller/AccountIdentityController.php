<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangeNameType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountIdentityController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/security/change-name", name="app_account_change_name")
     */
    public function changeName(Request $request): Response
    {
        /** @var User $user */ $user = $this->getUser();
        $form = $this->createForm(ChangeNameType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();

            $this->addFlash('success', 'Vous avez modifié votre compte avec succès !');

            return $this->redirectToRoute('app_account_security');
        }

        return $this->render('account/change_name.html.twig', [
            'changeNameForm' => $form->createView()
        ]);
    }
}
