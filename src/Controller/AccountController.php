<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account", name="app_")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("", name="account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/security", name="account_security")
     */
    public function security(): Response
    {
        return $this->render('account/security.html.twig');
    }

    /**
     * @Route("/security/change-password", name="change_password")
     */
    public function changePassword(): Response
    {
        return $this->render('account/change_password.html.twig');
    }
}
