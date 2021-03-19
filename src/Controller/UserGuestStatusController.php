<?php

namespace App\Controller;

use App\Entity\ThymioChallenge;
use App\Entity\UserGuestStatus;
use App\Repository\UserGuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserGuestStatusController extends AbstractController
{
    /**
     * @Route("/user/guest/status", name="user_guest_status")
     */
    public function index(): Response
    {
        return $this->render('user_guest_status/index.html.twig', [
            'controller_name' => 'UserGuestStatusController',
        ]);
    }

    /**
     * @Route("/{id}/create", name="user_guest_status_create", methods={"GET","POST"})
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @param UserGuestRepository $userGuestRepository
     * @return Response
     */
    public function create(Request $request, ThymioChallenge $thymioChallenge, UserGuestRepository $userGuestRepository): Response
    {
        $userGuestStatus = new UserGuestStatus();
        $entityManager = $this->getDoctrine()->getManager();
        $userGuestStatus->setChallenge($thymioChallenge);
        $userGuestStatus->setUserGuest($userGuestRepository->findOneById($this->getUser()->getId()));
        $entityManager->persist($userGuestStatus);
        $entityManager->flush();
        return $this->redirectToRoute('thymio_challenge_show', [
            'id' => $thymioChallenge->getId()
        ]);
    }
}
