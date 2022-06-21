<?php

namespace App\Controller;

use App\Entity\ForgotPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use App\Mailjet\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ForgotPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/forgot-password", name="app_forgot_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $request->get('email')]);

            if ($user) {
                $forgotPassword = new ForgotPassword();

                $forgotPassword->setUser($user);
                $forgotPassword->setToken(uniqid());
                $forgotPassword->setCreatedAt(new \DateTimeImmutable());

                $this->entityManager->persist($forgotPassword);
                $this->entityManager->flush();

                $mailer = new Mailer();

                $url = $this->generateUrl('app_reset_password', [
                    'token' => $forgotPassword->getToken()
                ]);

                $content = 'Bonjour ' . $user->getLastName() . ',<br />Vous avez demandé à réinitialiser votre mot de passe.<br />';
                $content .= 'Veuillez cliquer sur le lien suivant pour mettre à jour votre mot de passe : <a href="'.$url.'">Réinitialiser mon mot de passe</a><br /><br />';
                $content .= 'Ce lien expire dans 30 minutes.';

                $mailer->send(
                    $user->getEmail(),
                    $user->getFullName(),
                    'Meta Galeries - Assistance mot de passe',
                    'Demande de réinitialisation de votre mot de passe !',
                    $content
                );

                $this->addFlash('success', 'Un email avec le lien de réinitialisation de votre mot de passe vient de vous être envoyé.');
            } else {
                $this->addFlash('danger', 'Nous sommes désolés. Nous n\'avons pas pu vous identifier compte tenu des informations fournies.');
            }
        }

        return $this->render('security/forgot_password.html.twig');
    }

    /**
     * @Route("/reset-password/{token}", name="app_reset_password")
     */
    public function resetPassword(
        string $token,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response
    {
        $forgotPassword = $this->entityManager->getRepository(ForgotPassword::class)->findOneBy(['token' => $token]);

        if (!$forgotPassword) {
            return $this->redirectToRoute('app_forgot_password');
        }

        $now = new \DateTimeImmutable();

        if ($now > $forgotPassword->getCreatedAt()->add(new \DateInterval('PT30M'))) {
            $this->addFlash('danger', 'Votre demande de modification de mot de passe a été expiré.');

            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $newPassword */ $newPassword = $form->get('newPassword')->getData();
            $user = $forgotPassword->getUser();

            $user->setPassword($passwordEncoder->encodePassword($user, $newPassword));

            $this->entityManager->flush();

            $this->addFlash('success', 'Vous avez modifé votre mot de passe avec succès !');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
            'resetPasswordForm' => $form->createView()
        ]);
    }
}
