<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\ThymioChallenge;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/status")
 */
class StatusController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('status/index.html.twig', [
            'controller_name' => 'StatusController',
        ]);
    }

    /**
     * @Route("/{id}/add/comment", name="add_comment", methods={"GET","POST"})
     * @param Request $request
     * @param StatusRepository $statusRepository
     * @param Status $status
     * @param TeacherRepository $teacherRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function addComment(Request $request,StatusRepository $statusRepository, Status $status, TeacherRepository $teacherRepository, StudentGroupRepository $studentGroupRepository): Response
    {

        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        return $this->render('status/form_comment.html.twig', [
            'soloStatus' => $status,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/create", name="status_create", methods={"GET","POST"})
     * @param Request $request
     * @param ThymioChallenge $thymioChallenge
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function create(Request $request, ThymioChallenge $thymioChallenge, StudentGroupRepository $studentGroupRepository): Response
    {
        $status = new Status();
        $entityManager = $this->getDoctrine()->getManager();
        $status->setChallenge($thymioChallenge);
        $status->setStudentGroup($studentGroupRepository->findOneById($this->getUser()->getId()));

        $entityManager->persist($status);
        $entityManager->flush();
        return $this->redirectToRoute('thymio_challenge_show', [
            'id' => $thymioChallenge->getId()
        ]);
    }
}
