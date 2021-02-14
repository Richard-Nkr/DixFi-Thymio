<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\DateFormatter;
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
     * @param TeacherRepository $teacherRepository
     * @return Response
     */
    public function edit(Request $request, TeacherRepository $teacherRepository): Response
    {
        $teacher = $teacherRepository->findOneById($this->getUser()->getId());
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
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
