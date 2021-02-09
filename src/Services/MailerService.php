<?php

namespace App\Services;

use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
     * @param string $subject
     * @param string $from
     * @param string $to
     * @param string $template
     * @param array $parameters
     * @throws TransportExceptionInterface
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
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

    public function sendFile(string $subject, string $from, string $to, string $text, string $filePath): void
    {
        try {
            $email = (new Email())
                ->from($from)
                ->to($to)
                ->subject("Dix'Fi de Thymio groupe ....")
                ->text("Vous trouverez ci-joint un fichier pour le defi ....")
                ->attachFromPath(''.$filePath.'');

            $this->mailer->send($email);
        } catch (TransportException $e) {
            print $e->getMessage()."\n";
            throw $e;
        }

    }
}