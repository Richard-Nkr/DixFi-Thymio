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
            'thymio_challenges' => $ChallengeRepository->findByDifficulty($difficulty),
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

    /**
     * @Route("/{id}/edit", name="thymio_challenge_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @return Response
     */
    public function edit(Request $request, ThymioChallenge $thymioChallenge): Response
    {
        $form = $this->createForm(ThymioChallengeType::class, $thymioChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('thymio_challenge_index');
        }

        return $this->render('thymio_challenge/edit.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="thymio_challenge_delete", methods={"DELETE"})
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @return Response
     */
    public function delete(Request $request, ThymioChallenge $thymioChallenge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thymioChallenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($thymioChallenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('thymio_challenge_index');
    }
}
