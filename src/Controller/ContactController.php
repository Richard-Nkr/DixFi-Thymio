<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;
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
     * @return RedirectResponse|Response
     * @throws TransportExceptionInterface
     */
    public function index(Request $request, MailerInterface $mailer, NotifierInterface $notifier)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('dixfix.thymio@gmail.com')
                ->subject('Vous avez reçu un mail du formulaire de contact')
                ->text('Mail de : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);
            $notifier->send(new Notification("Votre message a été envoyé!", ['browser']));

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }

}