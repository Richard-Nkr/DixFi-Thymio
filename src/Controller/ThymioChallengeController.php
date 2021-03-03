<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\User;
use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;

use App\Repository\StatusRepository;

use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Repository\ThymioChallengeRepository;
use App\Repository\ChallengeRepository;
use App\Service\DocumentGenerator;
use App\Service\HandleStatus;
use App\Service\SecurizerRoles;
use App\Services\MailerService;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Spatie\Browsershot\Browsershot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;


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
     * @param Environment $twig
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @param DocumentGenerator $documentGenerator
     * @param Pdf $knp_snappy
     * @return Response
     */
    public function createPDF(Environment $twig, Request $request,ThymioChallenge $thymioChallenge, DocumentGenerator $documentGenerator, Pdf $knp_snappy): Response
    {

        $vars= 'html to pdf';
        $html = $this->renderView('thymio_challenge/solution_pdf.html.twig', array(
            'some'  => $vars,
            'thymio_challenge' =>$thymioChallenge
        ));
        $response= new Response();

        $pdf= $response->setContent($knp_snappy->getOutputFromHtml($html,array('orientation' => 'Portrait', 'enable-local-file-access' => true, 'encoding' => 'UTF-8')));

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename="mon_fichier.pdf"');

        return $response;
    }


    /**
     * @Route("/{id}/show", name="thymio_challenge_show", methods={"GET", "POST"})
     * @param Request $request
     * @param HandleStatus $handleStatus
     * @param SecurizerRoles $securizerRoles
     * @param StatusRepository $statusRepository
     * @param ThymioChallenge $thymioChallenge
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
     * @Route("/activate/deblocage", name="thymio_challenge_activate_deblocage", methods={"POST","GET"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function activateDeblocage(Request $request,TeacherRepository $teacherRepository)
    {
        if (($request->getMethod() == 'POST')){
            $teacher = $teacherRepository->findOneById($this->getUser()->getId());
            $teacher->setProgression(true);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('thymio_challenge/activate_deblocage.html.twig', [
            'teacher' => $teacherRepository->findOneById($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/desactivate/deblocage", name="thymio_challenge_desactivate_deblocage", methods={"POST","GET"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function desactivateDeblocage(Request $request,TeacherRepository $teacherRepository)
    {
        if (($request->getMethod() == 'POST')){
            $teacher = $teacherRepository->findOneById($this->getUser()->getId());
            $teacher->setProgression(false);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('thymio_challenge/desactivate_deblocage.html.twig', [
            'teacher' => $teacherRepository->findOneById($this->getUser()->getId()),
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
