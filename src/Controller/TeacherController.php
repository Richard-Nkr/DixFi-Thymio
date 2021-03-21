<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\StudentGroup;
use App\Entity\Teacher;
use App\Form\StatusType;
use App\Form\StudentGroupType;
use App\Form\TeacherType;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\CreateStudentGroup;
use App\Service\GestionPassword;
use App\Service\UpdateTeacher;
use App\Service\ValidateChallenge;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teacher", name="teacher")
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
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/new/student/group", name="new_student_group", methods={"GET","POST"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @param GestionPassword $gestionPassword
     * @param CreateStudentGroup $createStudentGroup
     * @return Response
     */
    public function newStudentGroup(Request $request, TeacherRepository $teacherRepository, GestionPassword $gestionPassword,CreateStudentGroup $createStudentGroup): Response
    {
        $studentGroup = new StudentGroup();
        $form = $this->createForm(StudentGroupType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $createStudentGroup->create($studentGroup,$teacherRepository->findOneById($this->getUser()->getId()));
            $gestionPassword->createHashPassword($studentGroup);

            $entityManager->persist($studentGroup);
            $entityManager->flush();

            return $this->redirectToRoute('child_new', ['id'=>$studentGroup->getId()]);
        }

        return $this->render('student_group/new.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form->createView(),
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
     * @Route("/show/student/group/teacher", name="show_student_group_teacher", methods={"GET"})
     * @param StudentGroupRepository $studentgroupRepository
     * @return Response
     */
    public function showStudentGroup(StudentGroupRepository $studentgroupRepository): Response
    {
        return $this->render('teacher/show_student_group.html.twig', [
            'student_groups' => $studentgroupRepository->findByTeacher($this->getUser()),
        ]);
    }

    /**
     * @Route("/edit", name="teacher_edit", methods={"GET","POST"})
     * @param Request $request
     * @param UpdateTeacher $updateTeacher
     * @param Validator $validator
     * @param TeacherRepository $teacherRepository
     * @param GestionPassword $gestionPassword
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function edit(Request $request, UpdateTeacher $updateTeacher, Validator $validator, TeacherRepository $teacherRepository, GestionPassword $gestionPassword, NotifierInterface $notifier): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $violations = $validator->listViolations($teacher);
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $notifier->send(new Notification($violation->getMessage(), ['browser']));
                }
                return $this->render('teacher/edit.html.twig', [
                    'teacher' => $teacher,
                    'form' => $form->createView(),
                ]);
            }

            $teacher2 = $teacherRepository->findOneById($this->getUser()->getId());
            $gestionPassword->createHashPassword($teacher);
            $updateTeacher->update($teacher,$teacher2);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');
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
     * @Route("/delete", name="teacher_delete", methods={"DELETE"})
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

    /**
     * @Route("/{id}/delete/student/group", name="delete_student_group", methods={"DELETE"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function deleteStudentGroup(Request $request, StudentGroup $studentGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_student_group_teacher');
    }
}
