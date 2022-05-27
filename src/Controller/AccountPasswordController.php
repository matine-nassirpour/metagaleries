<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
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
        /** @var User $user */ $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $currentPassword */ $currentPassword = $form->get('currentPassword')->getData();

            if ($passwordEncoder->isPasswordValid($user, $currentPassword)) {
                /** @var string $newPassword */ $newPassword = $form->get('newPassword')->getData();
                $user->setPassword($passwordEncoder->encodePassword($user, $newPassword));

                $this->entityManager->flush();

                $this->addFlash('success', 'Vous avez modifé votre mot de passe avec succès !');

                return $this->redirectToRoute('app_account_security');
            } else {
                $this->addFlash('danger', 'Votre mot de passe actuel est incorrect');
            }
        }

        return $this->render('account/change_password.html.twig', [
            'changePasswordForm' => $form->createView()
        ]);
    }
}
