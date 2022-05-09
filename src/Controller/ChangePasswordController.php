<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/account/security/change-password", name="app_change_password")
     */
    public function changePassword(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newPassword = $form->get('newPassword')->getData();
                $user->setPassword($passwordEncoder->encodePassword($user, $newPassword));

                $this->entityManager->flush();

                return $this->redirectToRoute('app_account_security');
            }
        }

        return $this->render('account/change_password.html.twig', [
            'changePasswordForm' => $form->createView()
        ]);
    }
}
