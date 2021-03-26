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
    //fonction appelée dès que le bot est démarré
    function messageAction(Request $request): Response
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

        $config = [];

        $adapter = new FilesystemAdapter();
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));

        //le bot démarre une conversation lorsqu'il entend Bonjour, Salut ou coucou
        $botman->hears('(Bonjour|Coucou|Salut)', function (BotMan $bot) {
            $bot->startConversation(new BotConversation);
        });

        //le bot clôt la conversation lorsqu'il entend un merci ou un au revoir
        $botman->hears('Merci|Au revoir', function(BotMan $bot){
            $bot->reply("A bientôt, je te souhaite une belle journée et amuses-toi bien sur le site !");
        });


        //le bot lance une nouvelle conversation lorsqu'il ne comprend pas la réponse de l'utilisateur afin d'essayer de lui proposer des liens tout de même
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
    //le bot agit sur la page index du site
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
