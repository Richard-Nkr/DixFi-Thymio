<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Form\ChallengeType;
use App\Repository\PrivateChallengeRepository;
use App\Repository\PublicChallengeRepository;
use App\Repository\TeacherRepository;
use App\Service\CreatePrivateChallenge;
use App\Service\PublicChallengeCreation;
use App\Repository\ChallengeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/challenge")
 */
class ChallengeController extends AbstractController
{
    /**
     * @Route("/", name="challenge_index", methods={"GET"})
     * @param ChallengeRepository $challengeRepository
     * @return Response
     */
    public function index(ChallengeRepository $challengeRepository): Response
    {
        return $this->render( 'challenge/index.html.twig', [
            'challenges' => $challengeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/show/my/challenge", name="challenge_show_my_challenge", methods={"GET"})
     * @param PrivateChallengeRepository $privateChallengeRepository
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    //va permettre d'afficher tous les challenge qui correspondent à un teacher
    public function showMyChallenge(PrivateChallengeRepository $privateChallengeRepository, PublicChallengeRepository $publicChallengeRepository): Response
    {
        return $this->render('challenge/show_my_challenge.html.twig', [
            'public_challenges' => $publicChallengeRepository->findBy(['teacher'=>$this->getUser()]),
            'private_challenges' => $privateChallengeRepository->findBy(['teacher'=>$this->getUser()]),
        ]);

    }

    /**
     * @Route("/new", name="challenge_new", methods={"GET","POST"})
     * @param Request $request
     * @param PublicChallengeCreation $publicChallengeCreation
     * @param CreatePrivateChallenge $createPrivateChallenge
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    //permet de créer un challenge privé ou bien public selon le choix de l'utilisateur
    public function new(Request $request, PublicChallengeCreation $publicChallengeCreation, CreatePrivateChallenge $createPrivateChallenge, TeacherRepository $teacherRepository): Response
    {
        $challenge = new Challenge();
        $form = $this->createForm(ChallengeType::class, $challenge);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $teacher = $teacherRepository->findOneById($this->getUser()->getId());
                if ($challenge->getRole() == "ROLE_PUBLIC_CHALLENGE") {
                    $challenge = $publicChallengeCreation->makePublicChallenge($challenge, $teacher);
                } else {
                    $challenge = $createPrivateChallenge->makePrivateChallenge($challenge, $teacher);
                }
                $entityManager->persist($challenge);
                $entityManager->flush();

                return $this->redirectToRoute('challenge_show_my_challenge');
            }


        return $this->render('challenge/new.html.twig', [
            'challenge' => $challenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="challenge_show", methods={"GET"})
     * @param Challenge $challenge
     * @return Response
     */
    public function show(Challenge $challenge): Response
    {
        return $this->render('challenge/show.html.twig', [
            'challenge' => $challenge,
        ]);
    }


    /**
     * @Route("/{id}", name="challenge_delete", methods={"DELETE"})
     * @param Request $request
     * @param Challenge $challenge
     * @return Response
     */
    public function delete(Request $request, Challenge $challenge): Response
    {
        if ($this->isCsrfTokenValid('delete' . $challenge->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($challenge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('challenge_show_my_challenge');
    }
}
