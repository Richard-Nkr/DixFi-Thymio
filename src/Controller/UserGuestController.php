<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserGuestUpdateType;
use App\Form\UserType;
use App\Service\GestionPassword;
use App\Service\SecurizerRoles;
use App\Service\CreateChat;
use App\Repository\TeacherRepository;
use App\Repository\UserGuestRepository;
use App\Repository\UserRepository;
use App\Service\TeacherUserGuest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

/**
 * @Route("/user/guest")
 */
class UserGuestController extends AbstractController
{
    /**
     * @Route("/", name="user_guest_index", methods={"GET"})
     * @param UserGuestRepository $userGuestRepository
     * @return Response
     */
    public function index(UserGuestRepository $userGuestRepository): Response
    {
        return $this->render('user_guest/index.html.twig', [
            'user_guests' => $userGuestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_guest_new", methods={"GET","POST"})
     * @param Request $request
<<<<<<< HEAD
     * @param TeacherUserGuest $teacherUserGuest
=======
     * @param SecurizerRoles $securizerRoles
     * @param NotifierInterface $notifier
     * @param TeacherUserGuest $teacherUserguest
     * @param CreateChat $createChat
     * @param GestionPassword $createPassword
>>>>>>> develop
     * @return Response
     */
    public function new(Request $request, SecurizerRoles $securizerRoles, NotifierInterface $notifier, TeacherUserGuest $teacherUserguest, CreateChat $createChat, GestionPassword $gestionPassword): Response
    {
        $userguest = new UserGuest();
        $form = $this->createForm(UserGuestType::class, $userguest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $gestionPassword->createHashPassword($userguest);
            if ($securizerRoles->isGranted($userguest, 'ROLE_TEACHER')){
                $userguest = $teacherUserguest->makeTeacher($userguest);
            }
            $entityManager->persist($userguest);
<<<<<<< HEAD
            $entityManager->flush();
            if ($userguest->getRole()=="teacher") {
                $chat = new Chat();
                $chat->setTeacher($userguest);
                $entityManager = $this->getDoctrine()->getManager();
                $userguest->setChat($chat);
                $entityManager->persist($chat);
                $entityManager->persist($userguest);
                $entityManager->flush();
=======
            if ($securizerRoles->isGranted($userguest, 'ROLE_TEACHER')) {
                $entityManager->persist($createChat->create($userguest));
>>>>>>> develop
            }
            $entityManager->flush();
            $notifier->send(new Notification("Afin de pouvoir vous connecter, enregistrez l'identifiant suivant ".$userguest->getId()."", ['browser']));
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user_guest/new.html.twig', [
            'user_guest' => $userguest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_guest_show", methods={"GET"})
     * @param UserGuest $userGuest
     * @return Response
     */
    public function show(UserGuest $userGuest): Response
    {
        return $this->render('user_guest/show.html.twig', [
            'user_guest' => $userGuest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_guest_edit", methods={"GET","POST"})
     * @param Request $request
     * @param UserGuest $userGuest
     * @return Response
     */
    public function edit(Request $request, UserGuest $userGuest): Response
    {
        $form = $this->createForm(UserGuestUpdateType::class, $userGuest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_guest_index');
        }

        return $this->render('user_guest/edit.html.twig', [
            'user_guest' => $userGuest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_guest_delete", methods={"DELETE"})
     * @param Request $request
     * @param UserGuest $userGuest
     * @return Response
     */
    public function delete(Request $request, UserGuest $userGuest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userGuest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $userGuest->setDeletedAt(new \DateTime());
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_guest_index');
    }
}
