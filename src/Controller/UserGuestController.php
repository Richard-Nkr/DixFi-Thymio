<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserType;
use App\Services\MailerService;
use App\Services\MessageService;
use App\GestionHeritage\TeacherUserGuest;
use App\Repository\UserGuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

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
     * @param MailerService $mailerService
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function new(Request $request, TeacherUserGuest $teacherUserGuest,
                        MailerService $mailerService, NotifierInterface $notifier): Response
    {
        $userguest = new UserGuest();
        $form = $this->createForm(UserGuestType::class, $userguest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userguest->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $pass = password_hash($userguest->getPassword(), PASSWORD_DEFAULT);
            $userguest->setPassword($pass);
            if ($userguest->getRole() == "teacher") {
                $userguest = $teacherUserGuest->makeTeacher($userguest);
            }
            $entityManager->persist($userguest);
            $entityManager->flush();
            $mail = $userguest->getMail();
            $id = $userguest->getId();
            if ($userguest->getRole() == "teacher") {
                $chat = new Chat();
                $chat->setTeacher($userguest);
                $entityManager = $this->getDoctrine()->getManager();
                $userguest->setChat($chat);
                $entityManager->persist($chat);
                $entityManager->persist($userguest);
                $entityManager->flush();
            }
            $mailerService->sendId(
                ''.$mail,
                ''.$id
            );
            $notifier->send(new Notification("Un mail vous a été envoyé avec votre identifiant. Veuillez le consulter
            afin de vous connecter.", ['browser']));

            return $this->redirectToRoute('user_connexion');
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
        $form = $this->createForm(UserGuestType::class, $userGuest);
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
            $entityManager->remove($userGuest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_guest_index');
    }
}
