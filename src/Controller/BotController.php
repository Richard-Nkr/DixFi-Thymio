<?php


namespace App\Controller;



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
     * @param Request $request
     * @return Response
     */
    function messageAction(Request $request)
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        // Configuration for the BotMan WebDriver
        $config = [];

        // Create BotMan instance
        $botman = BotManFactory::create($config);

        // Give the bot some things to listen for.
        $botman->hears('(Bonjour|Coucou|Salut)', function (BotMan $bot) {
            $bot->reply("Je suis là pour t'aider. Faisons connaissance");
            $bot->typesAndWaits(1);
            $bot->ask("Comment t'appelles-tu?", function($answer, $bot){
                $bot->reply('Welcome '.$answer->getText());
            });
        });

        $botman->hears('Merci|Au revoir', function(BotMan $bot){
            $bot->reply("A bientôt!");
        });

        // Set a fallback
        $botman->fallback(function (BotMan $bot) {
            $bot->reply('Je parle très mal français, ma spécialité est le langage de programmation.. Peux-tu répéter?');
        });

        // Start listening
        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return mixed
     */
    public function indexAction(Request $request)
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/chatframe", name="chatframe")
     * @param Request $request
     * @return mixed
     */
    public function chatframeAction(Request $request)
    {
        return $this->render('fragments/chat_frame.html.twig');
    }
}
