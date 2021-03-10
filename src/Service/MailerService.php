<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Constraints\File;
use Twig\Environment;
use App\Entity\UserGuest;
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

    public function sendFile(string $groupName, string $to, string $numDefi, String $filePath): void
    {
        try {
            $email = (new Email())
                ->from('DixFix.Thymio@gmail.com')
                ->to($to)
                ->subject("Dix'Fi de Thymio groupe ".$groupName."")
                ->text("Vous trouverez ci-joint un fichier pour le defi : ".$numDefi." du goupe : ".$groupName)
                ->attachFromPath($filePath);

            $this->mailer->send($email);
        } catch (TransportException $e) {
            print $e->getMessage()."\n";
            throw $e;
        }
    }

    public function verifExtension(String $extension): bool
    {
        if($extension === "sb3"){
            return true;
        }
        return false;
    }
}