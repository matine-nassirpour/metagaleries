<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Mailjet\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailAddress = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);

            if (!$emailAddress) {
                /** @var string $password */ $password = $form->get('password')->getData();
                $user->setPassword($passwordEncoder->encodePassword($user, $password));

                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mailer = new Mailer();

                $mailer->send(
                    $user->getEmail(),
                    $user->getLastName(),
                    'Meta Galeries - Bienvenue à bord !',
                    'Bienvenue à bord !',
                    'Bonjour, votre compte Meta Galeries a bien été créé.<br /> Veuillez simplement vous connecter en cliquant sur le lien ci-dessous.'
                );

                $this->addFlash('success', 'Votre compte a bien été créé. Vous pouvez dès à présent vous connecter à votre compte.');
            } else {
                $this->addFlash('danger', 'Il existe déjà un compte avec cette adresse e-mail !');
            }

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
