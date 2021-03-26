<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\GestionPassword;
use App\Service\MailerService;
use App\Service\SecurizerRoles;
use App\Service\TeacherGenerator;
use App\Service\Validator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_guest_new", methods={"GET","POST"})
     * @param Request $request
     * @param MailerService $mailerService
     * @param Validator $validator
     * @param SecurizerRoles $securizerRoles
     * @param NotifierInterface $notifier
     * @param TeacherGenerator $teacherGenerator
     * @param GestionPassword $gestionPassword
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function newUserGuest(Request $request, MailerService $mailerService, Validator $validator, SecurizerRoles $securizerRoles, NotifierInterface $notifier, TeacherGenerator $teacherGenerator, GestionPassword $gestionPassword): Response
    {
        $userguest = new UserGuest();
        $form = $this->createForm(UserGuestType::class, $userguest);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $violations = $validator->listViolations($userguest);
            if (0 !== count($violations)) {
                foreach ($violations as $violation) {
                    $notifier->send(new Notification($violation->getMessage(), ['browser']));
                }
                return $this->render('user_guest/new.html.twig', ['user_guest' => $userguest, 'form' => $form->createView(),]);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $gestionPassword->createHashPassword($userguest);
            if ($securizerRoles->isGranted($userguest, 'ROLE_TEACHER')) {
                $userguest = $teacherGenerator->generate($userguest);
            }
            $entityManager->persist($userguest);
            $entityManager->flush();
            $mailerService->sendId('' . $userguest->getMail(), '' . $userguest->getId());
            $notifier->send(new Notification("Un mail vous a été envoyé avec votre identifiant. Veuillez le consulter afin de vous connecter.", ['browser']));
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user_guest/new.html.twig', ['user_guest' => $userguest, 'form' => $form->createView(),]);
    }


    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
