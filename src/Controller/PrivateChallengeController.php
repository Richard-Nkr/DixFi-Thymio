<?php

namespace App\Controller;

use App\Entity\PrivateChallenge;
use App\Form\ChallengeUpdateType;
use App\Form\PrivateChallengeFileType;
use App\Repository\HelpRepository;
use App\Repository\PrivateChallengeRepository;
use App\Repository\StudentGroupRepository;
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
            'privateChallenges' => $privateChallengeRepository->findBy(['role' => 'ROLE_PRIVATE_CHALLENGE','teacher' => $teacher]),
        ]);
    }

    /**
     * @Route("/{id}", name="private_challenge_show", methods={"GET","POST"})
     * @param Request $request
     * @param PrivateChallenge $privateChallenge
     * @param HelpRepository $helpRepository
     * @param SecurizerRoles $securizerRoles
     * @param NotifierInterface $notifier
     * @param MailerService $mailerService
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    //affiche les privateChallenges et permet au groupe étudiant d'envoyer leur fichier à leur professeur
    public function show(Request $request,PrivateChallenge $privateChallenge, HelpRepository $helpRepository, SecurizerRoles $securizerRoles, NotifierInterface $notifier, MailerService $mailerService, StudentGroupRepository $studentGroupRepository): Response
    {
        $upload = new PrivateChallenge();
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $form = $this->createForm(PrivateChallengeFileType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($securizerRoles->isGranted($this->getUser(), 'ROLE_STUDENT_GROUP')){
                $file = $upload->getFile();
                $verifExtension = $mailerService->verifExtension($file->getClientOriginalExtension());
                //vérifie si l'extension du fichier correspond à un fichier .sb3
                if(!($verifExtension)){
                    $notifier->send(new Notification("Le fichier doit etre un fichier scratch", ['browser']));
                    return $this->render('private_challenge/show.html.twig', [
                        'privateChallenge' => $privateChallenge, 'form' => $form->createView(),
                        'indices' => $helpRepository->findByIdChallenge($privateChallenge->getId()),
                    ]);
                }
                $fileName =md5(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $upload->setFile($fileName);
                $mailerService->sendFile($studentGroup->getNickname(), $studentGroup->getTeacher()->getMail(), $privateChallenge->getId(), '../public/Uploads/'.$fileName);
                unlink('../public/Uploads/'.$fileName);
                $this->getDoctrine()->getManager()->flush();
            }
        }
        return $this->render('private_challenge/show.html.twig', [
            'privateChallenge' => $privateChallenge,
            'indices' => $helpRepository->findByIdChallenge($privateChallenge->getId()),
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}/view/teacher", name="private_challenge_view_teacher", methods={"GET"})
     * @param PrivateChallengeRepository $privateChallengeRepository
     * @param int $id
     * @param HelpRepository $helpRepository
     * @return Response
     */
    //
    public function viewTeacher(PrivateChallengeRepository $privateChallengeRepository, int $id, HelpRepository $helpRepository): Response
    {
        return $this->render('private_challenge/view_teacher.html.twig', [
            'privateChallenge' => $privateChallengeRepository->findOneById($id),
            'indices' => $helpRepository->findByIdChallenge($id),
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
        $form = $this->createForm(ChallengeUpdateType::class, $privateChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $privateChallenge->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('private_challenge_index');
        }

        return $this->render('private_challenge/edit.html.twig', [
            'challenge' => $privateChallenge,
            'form' => $form->createView(),
        ]);
    }

}
