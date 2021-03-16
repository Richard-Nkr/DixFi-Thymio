<?php

namespace App\Controller;

use App\Entity\StudentGroup;
use App\Form\StudentGroupType;
use App\Repository\ChildRepository;
use App\Repository\StatusRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\TeacherRepository;
use App\Service\CreateStudentGroup;
use App\Service\GestionPassword;
use App\Service\SortChallenges;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student/group")
 */
class StudentGroupController extends AbstractController
{
    /**
     * @Route("/", name="student_group_index", methods={"GET"})
     * @param StudentGroupRepository $studentgroupRepository
     * @param Session $session
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function index(StudentGroupRepository $studentgroupRepository, Session $session, TeacherRepository $teacherRepository): Response
    {
        return $this->render('student_group/index.html.twig', [
            'student_groups' => $studentgroupRepository->findAll(),
            'teacher'=>$this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="student_group_new", methods={"GET","POST"})
     * @param Request $request
     * @param TeacherRepository $teacherRepository
     * @param GestionPassword $gestionPassword
     * @param CreateStudentGroup $createStudentGroup
     * @return Response
     */
    public function new(Request $request, TeacherRepository $teacherRepository, GestionPassword $gestionPassword,CreateStudentGroup $createStudentGroup): Response
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
     * @Route("/block/levels", name="student_group_block_levels", methods={"GET"})
     * @param StudentGroupRepository $studentGroupRepository
     * @param SortChallenges $sortChallenges
     * @param StatusRepository $statusRepository
     * @return Response
     */
    public function blockLevels(StudentGroupRepository $studentGroupRepository, SortChallenges $sortChallenges, StatusRepository $statusRepository): Response
    {
        $studentGroup = $studentGroupRepository->findOneById($this->getUser()->getId());
        $teacher = $studentGroup->getTeacher();
        $count = 0;
        if($teacher->getProgression()==true){
            $statusList = $statusRepository->findBy(['studentGroup'=>$studentGroup,'statusInt'=>3]);
            $count = $sortChallenges->sort($statusList);
        }
        return $this->render('student_group/menu_thymio_challenges.html.twig', [
            'teacher'=>$teacher,
            'count' => $count,
        ]);
    }


    /**
     * @Route("/{id}", name="student_group_show", methods={"GET"})
     * @param StudentGroup $studentGroup
     * @param ChildRepository $childRepository
     * @return Response
     */
    public function show(StudentGroup $studentGroup, ChildRepository $childRepository): Response
    {
        $children = $childRepository->findBy(['studentGroup'=>$studentGroup]);
        return $this->render('student_group/show.html.twig', [
            'student_group' => $studentGroup,
            'children'=>$children,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_group_edit", methods={"GET","POST"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function edit(Request $request, StudentGroup $studentGroup): Response
    {
        $form = $this->createForm(StudentGroupType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_group_index');
        }

        return $this->render('student_group/edit.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_group_delete", methods={"DELETE"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function delete(Request $request, StudentGroup $studentGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_group_index');
    }
}
