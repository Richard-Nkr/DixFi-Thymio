<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * MailerService constructor.
     *
     * @param MailerInterface       $mailer
     * @param Environment   $twig
     */
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $to
     * @param string $id
     * @throws TransportExceptionInterface
     */
    public function sendId(string $to, string $id): void
    {
        try {
            $email = (new Email())
                ->from("DixFix.Thymio@gmail.com")
                ->to($to)
                ->subject("Identifiant Dix'Fi de Thymio")
                ->text('Votre identifiant de connexion est : '.$id.'');

            $this->mailer->send($email);
        } catch (TransportException $e) {
            print $e->getMessage()."\n";
            throw $e;
        }

    }

    /**
     * @param string $groupName
     * @param string $to
     * @param string $numDefi
     * @param String $filePath
     * @throws TransportExceptionInterface
     */
    public function sendFile(string $groupName, string $to, string $numDefi, String $filePath): void
    {
        try {
            $email = (new Email())
                ->from('DixFix.Thymio@gmail.com')
                ->to($to)
                ->subject("Dix'Fi de Thymio groupe ".$groupName."")
                ->text("Vous trouverez ci-joint un fichier pour le defi : ".$numDefi." du groupe : ".$groupName)
                ->attachFromPath($filePath);

            $this->mailer->send($email);
        } catch (TransportException $e) {
            print $e->getMessage()."\n";
            throw $e;
        }
    }

    public function sendMessage(String $mail, String $message, MailerInterface $mailer){
        $message = (new Email())
            ->from($mail)
            ->to('dixfix.thymio@gmail.com')
            ->subject('Vous avez reçu un mail du formulaire de contact')
            ->text('Mail de : '.$mail.\PHP_EOL.
                $message,
                'text/plain');
        $mailer->send($message);
    }


    public function verifExtension(String $extension): bool
    {
        if($extension === "sb3"){
            return true;
        }
        return false;
    }
}