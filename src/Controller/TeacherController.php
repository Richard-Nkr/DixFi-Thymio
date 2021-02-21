<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Teacher;
use App\Form\StatusType;
use App\Form\TeacherType;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\ValidateChallenge;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="teacher_index", methods={"GET"})
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/index.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }


    /**
     * @Route("/show", name="teacher_show", methods={"GET"})
     * @param TeacherRepository $teacherRepository
     * @return Response
     */


    public function show(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/show.html.twig', [
            'teacher' => $teacherRepository->findOneById($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="teacher_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function edit(Request $request, Teacher $teacher): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/list/groups/to/validate", name="list_groups_to_validate", methods={"GET","POST"})
     * @param Request $request
     * @param StatusRepository $statusRepository
     * @param TeacherRepository $teacherRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listGroupsToValidate(Request $request, StatusRepository $statusRepository, TeacherRepository $teacherRepository, StudentGroupRepository $studentGroupRepository): Response
    {
        $teacher = $teacherRepository->findOneById($this->getUser()->getId());
        $studentgroups = $studentGroupRepository->findByTeacher($teacher);

        $status = new Status();
        $form = $this->createForm(StatusType::class, $status);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $statusToSend = $statusRepository->findOneById($status->getId());
            $statusToSend->setComment($status->getComment());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('list_groups_to_validate');
        }
        return $this->render('teacher/validation_groups.html.twig', [
            'teacher' => $teacher,
            'studentgroups' => $studentgroups,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/list/groups/progress", name="list_groups_progress", methods={"GET","POST"})
     * @param TeacherRepository $teacherRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @return Response
     */
    public function listGroupsInProgress(TeacherRepository $teacherRepository, StudentGroupRepository $studentGroupRepository): Response
    {
        $teacher = $teacherRepository->findOneById($this->getUser()->getId());
        $studentgroups = $studentGroupRepository->findByTeacher($teacher);
        return $this->render('teacher/progression_groups.html.twig', [
            'teacher' => $teacher,
            'studentgroups' => $studentgroups,
        ]);
    }



    /**
     * @Route("/{id}/delete/validate", name="delete_validation", methods={"POST"})
     * @param Status $status
     * @param ValidateChallenge $validateChallenge
     * @return Response
     */
    public function deleteValidation(Status $status, ValidateChallenge $validateChallenge): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $validateChallenge->handleStudentGroup($status, false);
        $validateChallenge->handleStatus($status, false);
        $entityManager->flush();

        return $this->redirectToRoute('list_groups_progress');
    }

    /**
     * @Route("/{id}/validate", name="validate", methods={"POST"})
     * @param Status $status
     * @param ValidateChallenge $validateChallenge
     * @return Response
     */
    public function validate(Status $status, ValidateChallenge $validateChallenge): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $validateChallenge->handleStudentGroup($status, true);
        $validateChallenge->handleStatus($status, true);
        $entityManager->flush();

        return $this->redirectToRoute('list_groups_to_validate');
    }

    /**
     * @Route("/{id}", name="teacher_delete", methods={"DELETE"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function delete(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('delete' . $teacher->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($teacher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('teacher_index');
    }
}
