<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/user_guide" )
 */
class UserGuideController extends AbstractController
{
    /**
     * @Route("/aide", name="aide", methods={"GET"}))
     * @return Response
     */
    public function information(): Response
    {
        return $this->render('user_guide/aide.html.twig');
    }
}