<?php


namespace App\Controller;



use App\Service\BotConversation;
use App\Service\BotSaveConversation;
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

        $config = [];

        $adapter = new FilesystemAdapter();
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));
        $botman->hears('(Bonjour|Coucou|Salut)', function (BotMan $bot) {
            $bot->startConversation(new BotConversation);
        });

        $botman->hears('Merci|Au revoir', function(BotMan $bot){
            $bot->reply("A bientôt, je te souhaite une belle journée et amuses-toi bien sur le site !");
        });

        $botman->fallback(function (BotMan $bot) {
            $bot->startConversation(new BotSaveConversation);
        });

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
