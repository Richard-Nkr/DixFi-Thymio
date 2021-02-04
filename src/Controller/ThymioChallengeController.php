<?php

namespace App\Controller;

use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;
use App\Repository\ThymioChallengeRepository;
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
     * @Route("/", name="thymio_challenge_index", methods={"GET"})
     */
    public function index(ThymioChallengeRepository $thymioChallengeRepository): Response
    {
        return $this->render('thymio_challenge/index.html.twig', [
            'thymio_challenges' => $thymioChallengeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="thymio_challenge_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $thymioChallenge = new ThymioChallenge();
        $form = $this->createForm(ThymioChallengeType::class, $thymioChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($thymioChallenge);
            $entityManager->flush();

            return $this->redirectToRoute('thymio_challenge_index');
        }

        return $this->render('thymio_challenge/new.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="thymio_challenge_show", methods={"GET"})
     */
    public function show(ThymioChallenge $thymioChallenge): Response
    {
        return $this->render('thymio_challenge/show.html.twig', [
            'thymio_challenge' => $thymioChallenge,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="thymio_challenge_edit", methods={"GET","POST"})
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
