<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\Help;
use App\Form\HelpType;
use App\Repository\ChallengeRepository;
use App\Repository\HelpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/help")
 */
class HelpController extends AbstractController
{
    /**
     * @Route("/", name="help_index", methods={"GET"})
     * @param HelpRepository $helpRepository
     * @return Response
     */
    public function index(HelpRepository $helpRepository): Response
    {
        return $this->render('help/index.html.twig', [
            'helps' => $helpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="help_list", methods={"GET"})
     * @param HelpRepository $helpRepository
     * @param int $id
     * @param ChallengeRepository $challengeRepository
     * @return Response
     */
    public function list(HelpRepository $helpRepository, int $id, ChallengeRepository  $challengeRepository): Response
    {
        return $this->render('help/list.html.twig', [
            'helps' => $helpRepository->findAll(),
            'challenge' => $challengeRepository->findOneById($id)
        ]);
    }

    /**
     * @Route("/{id}/new", name="help_new", methods={"GET","POST"})
     * @param Request $request
     * @param NotifierInterface $notifier
     * @param HelpRepository $helpRepository
     * @param ChallengeRepository $challengeRepository
     * @param Challenge $challenge
     * @param int $id
     * @return Response
     */
    public function new(Request $request,NotifierInterface $notifier,HelpRepository $helpRepository,ChallengeRepository $challengeRepository, Challenge $challenge, int $id): Response
    {
        $help = new Help();
        $form = $this->createForm(HelpType::class, $help);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($help->getNumberHelp() == sizeof($helpRepository->findByIdChallenge($id))+1){
                $entityManager = $this->getDoctrine()->getManager();
                $challenge = $challengeRepository->findOneById($id);
                $help->setChallenge($challenge);
                $entityManager->persist($help);
                $entityManager->flush();

                return $this->redirectToRoute('challenge_show_my_challenge');
            }else{
                $notifier->send(new Notification("Le numéro d'indice n'est pas cohérent ", ['browser']));
                return $this->render('help/new.html.twig', ['help' => $help, 'helps' => $helpRepository->findByIdChallenge($id), 'form' => $form->createView(),]);
            }
        }
        return $this->render('help/new.html.twig', ['help' => $help, 'helps' => $helpRepository->findByIdChallenge($id), 'form' => $form->createView(),]);
    }

    /**
     * @Route("/{id}", name="help_show", methods={"GET"})
     * @param Help $help
     * @return Response
     */
    public function show(Help $help): Response
    {
        return $this->render('help/show.html.twig', [
            'help' => $help,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="help_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Help $help
     * @return Response
     */
    public function edit(Request $request, Help $help): Response
    {
        $form = $this->createForm(HelpType::class, $help);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('help_list',['id'=>$help->getChallenge()->getId()]);
        }

        return $this->render('help/edit.html.twig', [
            'help' => $help,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="help_delete", methods={"DELETE"})
     * @param Request $request
     * @param Help $help
     * @return Response
     */
    public function delete(Request $request, Help $help): Response
    {
        if ($this->isCsrfTokenValid('delete' . $help->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($help);
            $entityManager->flush();
        }
        return $this->redirectToRoute('challenge_show_my_challenge');
    }
}
