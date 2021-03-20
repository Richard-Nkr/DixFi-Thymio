<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Session $session
     * @return Response
     */
    public function index(Session $session): Response
    {
        if ($this->getUser()!=null){
            $name = $this->getUser()->getNickname();
        }
        else{
            $name = "";
        }
        return $this->render('home/index.html.twig', [
            'name' => $name,
        ]);
    }

}
