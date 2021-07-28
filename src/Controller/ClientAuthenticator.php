<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ClientType;
use App\Services\Sendmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ClientAuthenticator extends AbstractController
{

    public function __construct()
    {
    }


    /**
     * @Route("/connexion", name="app_login_client")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/student/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
        ]);
    }


    /**
     * @Route("/deconnexion", name="app_logout_client")
     */
    public function logout()
    {
        // return $this->redirectToRoute('app_login_client');
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
