<?php


namespace App\Controller;


use App\Service\BotConversation;
use App\Service\OnboardingConversation;
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
     */
    function messageAction(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Configuration for the BotMan WebDriver
        $config = [];

        // Create BotMan instance
        $botman = BotManFactory::create($config);

        // Give the bot some things to listen for.
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) {
            $bot->reply('Hello!');
        });

        // Set a fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Sorry, I did not understand.');
        });

        // Start listening
        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/", name="homepage")
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