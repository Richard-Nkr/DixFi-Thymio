<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;

use App\Repository\StatusRepository;

use App\Repository\StudentGroupRepository;
use App\Repository\ThymioChallengeRepository;
use App\Repository\ChallengeRepository;
use App\Service\DocumentGenerator;
use App\Service\HandleStatus;
use App\Service\SecurizerRoles;
use App\Services\MailerService;
use Spatie\Browsershot\Browsershot;
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
            'thymio_challenges' => $ChallengeRepository->findBy(['role' => 'ROLE_THYMIO','difficulty' => $difficulty]),
        ]);
    }

    /**
     * @Route("/{id}/list/state/challenges", name="list_state_challenges", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @param ThymioChallenge $thymioChallenge
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listStateChallenge(StatusRepository $statusRepository, ThymioChallenge $thymioChallenge, StudentGroupRepository $studentGroupRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $status = $statusRepository->findOneBy(['studentGroup' => $studentGroup,'challenge' => $thymioChallenge]);
        return $this->render('thymio_challenge/list_state_challenge.html.twig', [
            'status' => $status,
            'thymio_challenge' => $thymioChallenge,
        ]);
    }


    /**
     * @Route("/{id}/solution", name="thymio_challenge_solution", methods={"GET"})
     * @param ThymioChallenge $thymioChallenge
     * @return Response
     */
    public function solution(ThymioChallenge $thymioChallenge, int $id): Response
    {
        return $this->render('thymio_challenge/solution.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'solutionPath' => $thymioChallenge->getSolutionPath(),
        ]);
    }

    /**
     * @Route("/{id}/create/pdf", name="thymio_challenge_create_pdf", methods={"GET","POST"})
     * @param ThymioChallenge $thymioChallenge
     * @param DocumentGenerator $documentGenerator
     * @return Response
     */
    public function createPDF(ThymioChallenge $thymioChallenge, DocumentGenerator $documentGenerator): Response
    {

        $documentGenerator->generatePdf('thymio_challenge/solution.html.twig', ['thymio_challenge'=>$thymioChallenge]);
        //  et on l'affiche dans un   objet Response
        return $this->render('thymio_challenge/solution.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'solutionPath' => $thymioChallenge->getSolutionPath(),
        ]);
    }


    /**
     * @Route("/{id}/show", name="thymio_challenge_show", methods={"GET", "POST"})
     * @param Session $session
     * @param MailerService $mailerService
     * @param StudentGroupRepository $studentGroupRepository
     * @param int $id
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function show(Request $request, HandleStatus $handleStatus, SecurizerRoles $securizerRoles, StatusRepository $statusRepository, ThymioChallenge $thymioChallenge, Session $session, MailerService $mailerService, StudentGroupRepository $studentGroupRepository, int $id, NotifierInterface $notifier): Response
    {
        $upload = new ThymioChallenge();
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $status = $statusRepository->findOneBy(['studentGroup' => $studentGroup,'challenge' => $thymioChallenge]);
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
                        'status' => $status,
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
                $handleStatus->updateStatus($status);
                $entityManager = $this->getDoctrine()->getManager();
                unlink('../public/uploads/'.$fileName);
                $entityManager->flush();
            }
        }



        return $this->render('thymio_challenge/show.html.twig', [
            'thymio_challenge' => $thymioChallenge,
            'form' => $form->createView(),
            'status' => $status,
        ]);
    }

    /**
     * @Route("/{id}/list/challenges/not/validated", name="list_challenges_not_validated", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @param int $id
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listChallengesNotValidated(StatusRepository $statusRepository, int $id, StudentGroupRepository $studentGroupRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($id);
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup, 'statusInt' => 2]);
        return $this->render('teacher/list_challenges.html.twig', [
            'status' => $status,
        ]);
    }


    /**
     * @Route("/{id}/list/challenges/progress", name="list_challenges_progress.html.twig", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @param int $id
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listChallengesInProgress(StatusRepository $statusRepository, int $id, StudentGroupRepository $studentGroupRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($id);
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup, 'statusInt' => [1, 2]]);
        return $this->render('teacher/list_challenges_progress.html.twig', [
            'status' => $status,
        ]);
    }

    /**
     * @Route("/{id}/list/challenges/validated", name="list_challenges_validated.html.twig", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @param int $id
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listChallengesValidated(StatusRepository $statusRepository, int $id, StudentGroupRepository $studentGroupRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($id);
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup, 'statusInt' => 3]);
        return $this->render('teacher/list_challenges_validated.html.twig', [
            'status' => $status,
        ]);
    }

}
