<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\ThymioChallenge;
use App\Repository\StudentGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/status")
 */
class StatusController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('status/index.html.twig', [
            'controller_name' => 'StatusController',
        ]);
    }

    /**
     * @Route("/{id}/create", name="status_create", methods={"GET","POST"})
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function create(Request $request, ThymioChallenge $thymioChallenge, StudentGroupRepository $studentGroupRepository): Response
    {
        $status = new Status();
        $entityManager = $this->getDoctrine()->getManager();
        $status->setChallenge($thymioChallenge);
        $status->setStudentGroup($studentGroupRepository->findOneById($this->getUser()->getId()));

        $entityManager->persist($status);
        $entityManager->flush();
        return $this->render('thymio_challenge/show.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'status' => $status,
        ]);
    }
}
