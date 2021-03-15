<?php

namespace App\Controller;

use App\Entity\PrivateChallenge;
use App\Entity\StudentGroup;
use App\Entity\ThymioChallenge;
use App\Form\PrivateChallengeFileType;
use App\Form\PrivateChallengeType;
use App\Form\ThymioChallengeType;
use App\Repository\PrivateChallengeRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\MailerService;
use App\Service\SecurizerRoles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
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
     * @Route("/{id}", name="private_challenge_show", methods={"GET","POST"})
     * @param Request $request
     * @param PrivateChallenge $privateChallenge
     * @param SecurizerRoles $securizerRoles
     * @param NotifierInterface $notifier
     * @param MailerService $mailerService
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function show(Request $request,PrivateChallenge $privateChallenge, SecurizerRoles $securizerRoles, NotifierInterface $notifier, MailerService $mailerService, StudentGroupRepository $studentGroupRepository): Response
    {
        $upload = new PrivateChallenge();
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $form = $this->createForm(PrivateChallengeFileType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($securizerRoles->isGranted($this->getUser(), 'ROLE_STUDENT_GROUP')){
                $file = $upload->getFile();
                $verifExtension = $mailerService->verifExtension($file->getClientOriginalExtension());
                if(!($verifExtension)){
                    $notifier->send(new Notification("Le fichier doit etre un fichier scratch", ['browser']));
                    return $this->render('private_challenge/show.html.twig', [
                        'private_challenge' => $privateChallenge, 'form' => $form->createView(),
                    ]);
                }
                $fileName =md5(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $upload->setFile($fileName);
                $mailerService->sendFile($studentGroup->getNickname(), $studentGroup->getTeacher()->getMail(), $privateChallenge->getId(), '../public/uploads/'.$fileName);
                $entityManager = $this->getDoctrine()->getManager();
                unlink('../public/uploads/'.$fileName);
                $entityManager->flush();
            }
        }
        return $this->render('private_challenge/show.html.twig', [
            'private_challenge' => $privateChallenge,
            'form' => $form->createView(),
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