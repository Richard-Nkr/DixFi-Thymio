<?php

namespace App\Controller;

use App\Entity\PrivateChallenge;
use App\Entity\StudentGroup;
use App\Form\PrivateChallengeType;
use App\Repository\PrivateChallengeRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/private/challenge")
 */
class PrivateChallengeController extends AbstractController
{
    /**
     * @Route("/", name="private_challenge_index", methods={"GET"})
     * @param PrivateChallengeRepository $privateChallengeRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function index(PrivateChallengeRepository $privateChallengeRepository,StudentGroupRepository $studentGroupRepository): Response
    {
        $studentGroups= $studentGroupRepository->findOneById($this->getUser());
        $teacher= $studentGroups->getTeacher()->getId();
        return $this->render('private_challenge/index.html.twig', [
            'private_challenges' => $privateChallengeRepository->findBy(['role' => 'ROLE_PRIVATE_CHALLENGE','teacher' => $teacher]),
        ]);
    }

    /**
     * @Route("/new", name="private_challenge_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $privateChallenge = new PrivateChallenge();
        $form = $this->createForm(PrivateChallengeType::class, $privateChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($privateChallenge);
            $entityManager->flush();

            return $this->redirectToRoute('private_challenge_index');
        }

        return $this->render('private_challenge/new.html.twig', [
            'private_challenge' => $privateChallenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="private_challenge_show", methods={"GET"})
     * @param PrivateChallenge $privateChallenge
     * @return Response
     */
    public function show(PrivateChallenge $privateChallenge): Response
    {
        return $this->render('private_challenge/show.html.twig', [
            'private_challenge' => $privateChallenge,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="private_challenge_edit", methods={"GET","POST"})
     * @param Request $request
     * @param PrivateChallenge $privateChallenge
     * @return Response
     */
    public function edit(Request $request, PrivateChallenge $privateChallenge): Response
    {
        $form = $this->createForm(PrivateChallengeType::class, $privateChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('private_challenge_index');
        }

        return $this->render('private_challenge/edit.html.twig', [
            'private_challenge' => $privateChallenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="private_challenge_delete", methods={"DELETE"})
     * @param Request $request
     * @param PrivateChallenge $privateChallenge
     * @return Response
     */
    public function delete(Request $request, PrivateChallenge $privateChallenge): Response
    {
        if ($this->isCsrfTokenValid('delete'.$privateChallenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($privateChallenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('private_challenge_index');
    }
}
