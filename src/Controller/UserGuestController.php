<?php

namespace App\Controller;

use App\Entity\UserGuest;
use App\Form\UserGuestUpdateType;
use App\Repository\UserGuestRepository;
use App\Service\GestionPassword;
use App\Service\UpdateUserGuest;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'name' => $this->getUser()->getNickname(),
        ]);
    }


    /**
     * @Route("/show", name="user_guest_show", methods={"GET"})
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('user_guest/show.html.twig', [
            'user_guest' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/edit", name="user_guest_edit", methods={"GET","POST"})
     * @param Request $request
     * @param UpdateUserGuest $updateUserGuest
     * @param UserGuestRepository $userGuestRepository
     * @param Validator $validator
     * @param GestionPassword $gestionPassword
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function edit(Request $request, UpdateUserGuest $updateUserGuest, UserGuestRepository $userGuestRepository, Validator $validator, GestionPassword $gestionPassword, NotifierInterface $notifier): Response
    {
        $userGuest = new UserGuest();
        $form = $this->createForm(UserGuestUpdateType::class, $userGuest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $violations = $validator->listViolations($userGuest);
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $notifier->send(new Notification($violation->getMessage(), ['browser']));
                }
                return $this->render('user_guest/edit.html.twig', [
                    'user_guest' => $userGuest,
                    'form' => $form->createView(),
                ]);
            }
            $userGuest2 = $userGuestRepository->findOneById($this->getUser()->getId());
            $gestionPassword->createHashPassword($userGuest);
            $updateUserGuest->update($userGuest,$userGuest2);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user_guest/edit.html.twig', [
            'user_guest' => $userGuest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete", name="user_guest_delete", methods={"DELETE"})
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $this->getUser()->getId(), $request->request->get('_token'))) {

                $session = $this->get('session');
                $session = new Session();
                $session->invalidate();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($this->getUser());
            $entityManager->flush();
        }
        return $this->redirectToRoute('home');
    }
}
