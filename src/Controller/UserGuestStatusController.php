<?php

namespace App\Controller;

use App\Entity\ThymioChallenge;
use App\Entity\UserGuestStatus;
use App\Repository\UserGuestRepository;
use App\Service\HandleStatus;
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
     * @param ThymioChallenge $thymioChallenge
     * @param UserGuestRepository $userGuestRepository
     * @param HandleStatus $handleStatus
     * @return Response
     */
    public function create(ThymioChallenge $thymioChallenge, UserGuestRepository $userGuestRepository, HandleStatus $handleStatus): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $userGuestStatus = $handleStatus->createStatusUserGuest(new UserGuestStatus(),$thymioChallenge,$userGuestRepository->findOneById($this->getUser()->getId()));
        $entityManager->persist($userGuestStatus);
        $entityManager->flush();
        return $this->redirectToRoute('thymio_challenge_show_user_guest', [
            'id' => $thymioChallenge->getId(),
        ]);
    }
}
