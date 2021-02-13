<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;
use App\Repository\StudentGroupRepository;
use App\Repository\ThymioChallengeRepository;
use App\Repository\ChallengeRepository;
use App\Service\SecurizerRoles;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
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
            'thymio_challenges' => $ChallengeRepository->findByDifficulty($difficulty)
        ]);
    }

    /**
     * @Route("/{id}/show", name="thymio_challenge_show", methods={"GET", "POST"})
     * @param Request $request
     * @param SecurizerRoles $securizerRoles
     * @param ThymioChallenge $thymioChallenge
     * @param Session $session
     * @param MailerService $mailerService
     * @param StudentGroupRepository $studentGroupRepository
     * @param int $id
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function show(Request $request,SecurizerRoles $securizerRoles, ThymioChallenge $thymioChallenge, Session $session, MailerService $mailerService, StudentGroupRepository $studentGroupRepository, int $id, NotifierInterface $notifier): Response
    {
        $upload = new ThymioChallenge();
        $form = $this->createForm(ThymioChallengeType::class, $upload);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($securizerRoles->isGranted($this->getUser(), 'ROLE_STUDENT_GROUP')){
                $file = $upload->getFile();
                //verification que le fichier est bien un fichier sb3
                $verifExtension = $mailerService->verifExtension($file->getClientOriginalExtension());

                if(!($verifExtension)){
                    $notifier->send(new Notification("Le fichier doit etre un fichier scratch", ['browser']));
                    return $this->render('thymio_challenge/show.html.twig', [
                        'thymio_challenge' => $thymioChallenge,
                        'form' => $form->createView(),
                    ]);
                }

                $fileName =md5(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->move($this->getParameter('upload_directory'), $fileName);
                $upload->setFile($fileName);
                $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
                $groupName = $studentGroup->getNickname();
                $teacherMail= $studentGroup->getTeacher()->getMail();
                $numDefi = $id;
                $mailerService->sendFile(
                    $groupName,
                    $teacherMail,
                    $numDefi,
                    '../public/uploads/'.$fileName
                );
                unlink('../public/uploads/'.$fileName);
            }
        }

        return $this->render('thymio_challenge/show.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'form' => $form->createView(),
        ]);
    }

}
