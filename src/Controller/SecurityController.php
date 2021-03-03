<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @param Session $session
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils, Session $session): Response
    {
        if ($this->getUser()) {
            $session->set('id_user', $this->getUser()->getUsername());
             return $this->redirectToRoute('home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     * @param Session $session
     */
    public function logout(Session $session)
    {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
