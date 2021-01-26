<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Teacher;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/chat")
 */
class ChatController extends AbstractController
{
    /**
     * @Route("/", name="chat_index", methods={"GET"})
     * @param ChatRepository $chatRepository
     * @return Response
     */
    public function index(ChatRepository $chatRepository): Response
    {
        return $this->render('chat/index.html.twig', [
            'chats' => $chatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="chat_new", methods={"GET","POST"})
     * @param Teacher $teacher
     * @return Response
     */
    public function new(Teacher $teacher): Response
    {
        $chat = new Chat();
        $chat->setTeacher($teacher);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($chat);
            $entityManager->flush();
            $teacher->setChat($chat);

            return $this->redirectToRoute('teacher_index');
        }
/**
        return $this->render('chat/new.html.twig', [
            'chat' => $chat,
            'form' => $form->createView(),
        ]); **/


    /**
     * @Route("/{id}", name="chat_show", methods={"GET"})
     */
    public function show(Chat $chat): Response
    {
        return $this->render('chat/show.html.twig', [
            'chat' => $chat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="chat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chat $chat): Response
    {
        $form = $this->createForm(ChatType::class, $chat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chat_index');
        }

        return $this->render('chat/edit.html.twig', [
            'chat' => $chat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="chat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Chat $chat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('chat_index');
    }
}
