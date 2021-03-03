<?php


namespace App\Controller;


use App\Entity\Challenge;
use App\Repository\ChallengeRepository;
use App\Service\BotConversation;
use BotMan\BotMan\Cache\SymfonyCache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;


class BotController extends AbstractController{


    /**
     * @Route("/message", name="message")
     * @param ChallengeRepository $challengeRepository
     * @param Challenge $challenge
     * @return Response
     */
    function messageAction(ChallengeRepository $challengeRepository, Challenge $challenge): Response
    {
        $config = [];

        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $adapter = new FilesystemAdapter();

        $botman = BotManFactory::create($config, new SymfonyCache($adapter));

        $botman->hears('indice', function($bot){
            $bot->startConversation(new BotConversation);
        });

        $botman->hears('non', function ($bot) {

            $bot->reply('Ok bon courage ! Ecris le mot "indice" si tu as besoin de mon aide !');
        });

        $botman->hears('oui', function ($bot) {

            $bot->startConversation(new BotConversation);

        });

        $botman->fallback(function($bot) {
            $bot->reply("Désolé, je n'ai pas compris ton message...");
        });

        $botman->listen();

    }

    /**
     * @Route("/bot", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('public_challenge/show.html.twig');
    }

    /**
     * @Route("/chatframe", name="chatframe")
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('fragments/chat_frame.html.twig');
    }

}