<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;


/**
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/index", name="contact_index")
     * @param Request $request
     * @param MailerInterface $mailer
     * @param NotifierInterface $notifier
     * @param MailerService $mailerService
     * @return RedirectResponse|Response
     */
    //permet à un utilisateur anonyme d'envoyer un mail à l'équipe Thymio
    public function index(Request $request, MailerInterface $mailer, NotifierInterface $notifier, MailerService $mailerService)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            //utilisation de la fonction sendMessage du Service MailerService
            $mailerService->sendMessage($contactFormData['email'],$contactFormData['message'],$mailer);
            $notifier->send(new Notification("Votre message a été envoyé!", ['browser']));
            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }

}