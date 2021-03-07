<?php


namespace App\Controller;



use App\Repository\HelpRepository;
use App\Service\BotConversation;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BotController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     * @return Response
     */
    function messageAction(): Response
    {
        $config = [];

        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $adapter = new FilesystemAdapter();

        $botman = BotManFactory::create($config, new SymfonyCache($adapter));

        $botman->hears('indice', function($bot){
            $bot->startConversation(new BotConversation());
        });

        $botman->hears('non', function ($bot) {

            $bot->reply('Ok bon courage ! Ecris le mot "indice" si tu as besoin de mon aide !');
        });

        $botman->fallback(function($bot) {
            $bot->reply("Désolé, je n'ai pas compris ton message...");
        });

        $botman->listen();

        return new Response();
    }

    /**
     * @Route("/chatframe", name="chatframe")
     * @param Request $request
     * @return Response
     */
    public function chatframeAction(Request $request): Response
    {
        return $this->render('fragments/chat_frame.html.twig');
    }
}