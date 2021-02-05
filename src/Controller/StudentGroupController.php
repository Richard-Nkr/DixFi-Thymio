<?php

namespace App\Controller;

use App\Entity\StudentGroup;
use App\Form\StudentGroupType;
use App\Repository\GroupRepository;
use App\Repository\StudentGroupRepository;
use App\Repository\UserRepository;
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
     * @return Response
     */
    public function index(StudentGroupRepository $studentgroupRepository): Response
    {
        return $this->render('student_group/index.html.twig', [
            'student_groups' => $studentgroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="student_group_new", methods={"GET","POST"})
     * @param Request $request
     * @param Session $session
     * @param UserRepository $userRepository
     * @return Response
     */
    public function new(Request $request, Session $session, UserRepository $userRepository): Response
    {
        $studentGroup = new StudentGroup();
        $form = $this->createForm(StudentGroupType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $pass = password_hash($studentGroup->getPassword(), PASSWORD_DEFAULT);
            $studentGroup->setPassword($pass);
            $studentGroup->setCreatedAt(new \DateTime('now'));
            $studentGroup->setRole("group");
            $studentGroup->setCountSucceed(0);
            var_dump($session->get('user'));
            $studentGroup->setTeacher($userRepository->findOneById($session->get('user')->getId()));
            $studentGroup->setChat($userRepository->findOneById($session->get('user')->getId())->getChat());
            $entityManager->persist($studentGroup);
            $entityManager->flush();

            return $this->redirectToRoute('student_group_index');
        }

        return $this->render('student_group/new.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="student_group_show", methods={"GET"})
     * @param StudentGroup $studentGroup
     * @return Response
     */
    public function show(StudentGroup $studentGroup): Response
    {
        return $this->render('student_group/show.html.twig', [
            'student_group' => $studentGroup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_group_edit", methods={"GET","POST"})
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