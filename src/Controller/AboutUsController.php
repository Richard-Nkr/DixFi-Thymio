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
     * @return Response
     */
    //permet d'afficher le template avec les infos sur l'équipe Thymio
    public function information(): Response
    {
        return $this->render('about_us/information.html.twig');
    }
}