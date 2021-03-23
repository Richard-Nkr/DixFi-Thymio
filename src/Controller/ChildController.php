<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\StudentGroup;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use App\Repository\StudentGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/child")
 */
class ChildController extends AbstractController
{
    /**
     * @Route("/", name="child_index", methods={"GET"})
     * @param ChildRepository $childRepository
     * @return Response
     */
    public function index(ChildRepository $childRepository): Response
    {
        return $this->render('child/index.html.twig', [
            'children' => $childRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/new", name="child_new", methods={"GET","POST"})
     * @param Request $request
     * @param StudentGroup $studentGroup
     * @param NotifierInterface $notifier
     * @param ChildRepository $childRepository
     * @return Response
     */
    //permet de créer une nouvelle instance de Child en fonction du studentgroup et d'afficher le nombre d'élèves affectés au groupe
    public function new(Request $request, StudentGroup $studentGroup, NotifierInterface $notifier, ChildRepository $childRepository): Response
    {
        if ($studentGroup->getTeacher()!=$this->getUser()){
            return $this->redirectToRoute('student_group_index');
        }
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $child->setGroupChild($studentGroup);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($child);
            $entityManager->flush();
            $notifier->send(new Notification("L'étudiant a bien été ajouté au groupe. Vous avez désormais ajouté ".$childRepository->findNumberChildrenByStudentGroup($studentGroup)." étudiant(s) au groupe", ['browser']));

            return $this->redirectToRoute('child_new', ['id'=>$studentGroup->getId()]);
        }

        return $this->render('child/new.html.twig', ['child' => $child, 'form' => $form->createView(), 'studentGroup'=>$studentGroup,]);
    }

    /**
     * @Route("/{id}/children", name="child_show", methods={"GET"})
     * @param StudentGroup $studentGroup
     * @param ChildRepository $childRepository
     * @return Response
     */
    public function show(StudentGroup $studentGroup, ChildRepository $childRepository, int $id, StudentGroupRepository $studentGroupRepository): Response
    {
        $children = $childRepository->findBy(['studentGroup'=>$studentGroupRepository->findOneById($id)]);
        return $this->render('child/show.html.twig', [
            'children' => $children,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="child_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Child $child
     * @return Response
     */
    public function edit(Request $request, Child $child): Response
    {
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('child_index');
        }

        return $this->render('child/edit.html.twig', [
            'child' => $child,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="child_delete", methods={"DELETE"})
     * @param Request $request
     * @param Child $child
     * @return Response
     */
    public function delete(Request $request, Child $child): Response
    {
        if ($this->isCsrfTokenValid('delete'.$child->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($child);
            $entityManager->flush();
        }

        return $this->redirectToRoute('child_index');
    }
}
