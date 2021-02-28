<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\GestionPassword;
use App\Service\ValidateChallenge;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
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
     * @Route("/edit", name="teacher_edit", methods={"GET","POST"})
     * @param Request $request
     * @param NotifierInterface $notifier
     * @param GestionPassword $gestionPassword
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function edit(Request $request, TeacherRepository $teacherRepository, GestionPassword $gestionPassword, NotifierInterface $notifier): Response
    {
        $teacher = $teacherRepository->findOneById($this->getUser()->getId());
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //Début validation des champs
            $validator = new Validator();
            $violations = $validator->PassWordValidator($teacher);
            $violations->addAll($validator->FieldsValidator(($teacher)));
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $notifier->send(new Notification($violation->getMessage(), ['browser']));
                }
                return $this->render('teacher/edit.html.twig', [
                    'teacher' => $teacher,
                    'form' => $form->createView(),
                ]);
            }
            //fin

            $gestionPassword->createHashPassword($teacher);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("{purpose}/list/groups", name="list_groups", methods={"GET"})
     * @param StatusRepository $statusRepository
     * @param TeacherRepository $teacherRepository
     * @param StudentGroupRepository $studentGroupRepository
     * @param String $purpose
     * @return Response
     */
    public function listGroups(StatusRepository $statusRepository, TeacherRepository $teacherRepository, StudentGroupRepository $studentGroupRepository, String $purpose): Response
    {
        $teacher = $teacherRepository->findOneById($this->getUser()->getId());
        $studentgroups = $studentGroupRepository->findByTeacher($teacher);
        if ($purpose=="validation") {
            return $this->render('teacher/validation_groups.html.twig', [
                'teacher' => $teacher,
                'studentgroups' => $studentgroups,
            ]);
        }elseif ($purpose=="progress"){
            return $this->render('teacher/progression_groups.html.twig', [
                'teacher' => $teacher,
                'studentgroups' => $studentgroups,
            ]);
        }
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
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup,'statusInt' => 2]);
        return $this->render('teacher/list_challenges.html.twig', [
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
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup,'statusInt' => 3]);
        return $this->render('teacher/list_challenges_validated.html.twig', [
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
        $status = $statusRepository->findBy(['studentGroup' => $studentGroup,'statusInt' => [1,2]]);
        return $this->render('teacher/list_challenges_progress.html.twig', [
            'status' => $status,
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
        $validateChallenge->handleStudentGroup($status,false);
        $validateChallenge->handleStatus($status,false);
        $entityManager->flush();

        return $this->redirectToRoute('list_groups', ['purpose'=>'progress']);
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
        $validateChallenge->handleStudentGroup($status,true);
        $validateChallenge->handleStatus($status,true);
        $entityManager->flush();

        return $this->redirectToRoute('list_groups', ['purpose'=>'validation']);
    }

    /**
     * @Route("/delete", name="teacher_delete", methods={"DELETE"})
     * @param Request $request
     * @param Teacher $teacher
     * @return Response
     */
    public function delete(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($teacher);
            $entityManager->flush();
        }
        return $this->redirectToRoute('teacher_index');
    }
}
