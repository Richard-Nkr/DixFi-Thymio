<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;
use App\Repository\ThymioChallengeRepository;
use App\Repository\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/thymio/challenge")
 */
class ThymioChallengeController extends AbstractController
{
    /**
     * @Route("/{difficulty}", name="thymio_challenge_index", methods={"GET"})
     * @param ChallengeRepository $ChallengeRepository
     * @param String $difficulty
     * @return Response
     */
    public function index(ChallengeRepository $ChallengeRepository, String $difficulty): Response
    {
        return $this->render('thymio_challenge/index.html.twig', [
            'thymio_challenges' => $ChallengeRepository->findBy(['role' => 'ROLE_THYMIO','difficulty' => $difficulty]),
        ]);
    }

    /**
     * @Route("/{id}/show", name="thymio_challenge_show", methods={"GET"})
     * @param ThymioChallenge $thymioChallenge
     * @return Response
     */
    public function show(ThymioChallenge $thymioChallenge): Response
    {
        return $this->render('thymio_challenge/show.html.twig', [
            'thymio_challenge' => $thymioChallenge,
        ]);
    }

}
