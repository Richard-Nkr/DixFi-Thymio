<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/about_us" )
 */
class AboutUsController extends AbstractController
{
    /**
     * @Route("/information", name="information", methods={"GET"}))
     * @param Session $session
     * @return Response
     */
    public function information(Session $session): Response
    {
        return $this->render('about_us/information.html.twig');
    }
}