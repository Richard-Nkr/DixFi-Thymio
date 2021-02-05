<?php

namespace App\Controller;


use App\Entity\Chat;
use App\Entity\Teacher;
use App\Entity\User;
use App\Form\TeacherType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{


    /**
     * @Route("/connexion", name="user_connexion", methods={"GET", "POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param Session $session
     * @return Response
     */
    public function connexion(Request $request, UserRepository $userRepository, Session $session): Response
    {
        //en cas de connexion ouverte
        if ($session->has('user')) {

            //on la referme, afin de pouvoir initier une nouvelle connexion
            $session->remove('user');
        }

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id= $user->getId();
            //on récupère le code crypté
            $passHash = $userRepository->findOneById($id)->getPassword() ?? "pas d'utilisateur";
            //cette méthode vérifie que le mot de passe saisie et le hash correspondent
            $password = password_verify($user->getPassword(), $passHash);
            if ($password) {
                $user = $userRepository->findOneById($id);
                //on ouvre la connexion
                $session->set('user', $user);
                $session->set('role',$user->getRole());
                return $this->redirectToRoute('user_index', [
                    'user' => $user
                ]);
            }

            return $this->render('user/connexion.html.twig', [
                'form' => $form->createView(),
                'message' => "Connexion refusée"
            ]);
        }
        return $this->render('user/connexion.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/deconnexion", name="user_deconnexion", methods={"GET", "POST"})
     * @param Request $request
     * @param UserRepository $userRepository
     * @param Session $session
     * @return Response
     */
    public function deconnexion(Request $request, UserRepository $userRepository, Session $session): Response
    {
        //en cas de connexion ouverte
        if ($session->has('user')) {

            //on la referme, afin de pouvoir initier une nouvelle connexion
            $session->remove('user');
        }
        return $this->redirectToRoute('user_index');
    }

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
     * @Route("/show", name="user_show", methods={"GET"})

     * @param Session $session
     * @return Response
     */
    public function show(Session $session): Response
    {
        if ($session->get('role')=="teacher") {
            return $this->render('teacher/show.html.twig', [
                'teacher' => $session->get('user'),

            ]);
        }else{
            return $this->render('student_group/show.html.twig', [
                'student_group' => $session->get('user'),

            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
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
