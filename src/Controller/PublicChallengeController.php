<?php

namespace App\Controller;

use App\Entity\PublicChallenge;
use App\Form\PublicChallengeType;
use App\Repository\PublicChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/public/challenge")
 */
class PublicChallengeController extends AbstractController
{
    /**
     * @Route("/", name="public_challenge_index", methods={"GET"})
     * @param PublicChallengeRepository $publicChallengeRepository
     * @return Response
     */
    public function index(PublicChallengeRepository $publicChallengeRepository): Response
    {
        return $this->render('public_challenge/index.html.twig', [
            'public_challenges' => $publicChallengeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/addCorrection", name="public_challenge_addCorrection", methods={"GET","POST"})
     * @param Request $request
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @param PublicChallenge $publicChallenge
     * @return Response
     */
    public function addCorrection(Request $request, PublicChallengeRepository $publicChallengeRepository, int $id, PublicChallenge $publicChallenge): Response
    {
        $publicChallenge = $publicChallengeRepository->findOneById($id);
        $form = $this->createForm(PublicChallengeType::class, $publicChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicChallenge);
            $entityManager->flush();

            return $this->render('public_challenge/show.html.twig', [
                'public_challenge' => $publicChallengeRepository->findOneById($id),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('public_challenge/add_correction.html.twig', [
            'public_challenges' => $publicChallengeRepository->findOneById($id),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="public_challenge_show", methods={"GET"})
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @return Response
     */
    public function show(PublicChallengeRepository $publicChallengeRepository, int $id): Response
    {
        return $this->render('public_challenge/show.html.twig', [
            'public_challenge' => $publicChallengeRepository->findOneById($id),
        ]);
    }

}
