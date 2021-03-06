<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Service\YoutubeDeveloperKeyGenerator;
use Exception;
use Google_Client;
use Google_Service_YouTube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Challenge;
use App\Entity\User;
use App\Entity\ThymioChallenge;
use App\Form\ThymioChallengeType;

use App\Repository\StatusRepository;

use App\Repository\StudentGroupRepository;
use App\Repository\ThymioChallengeRepository;
use App\Repository\ChallengeRepository;
use App\Service\DocumentGenerator;

use App\Service\HandleStatus;
use App\Service\SecurizerRoles;
use App\Services\MailerService;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/youtube")
 */
class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="youtube_index", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        $client = new Google_Client();
        $key = (new \App\Service\YoutubeDeveloperKeyGenerator)->DeveloperKeyGenerator();
        $client->setDeveloperKey($key);
        $youtube = new Google_Service_YouTube($client);
        $yt = new Youtube();
        $form = $this->createForm(YoutubeType::class, $yt);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form['request']->getData();
            $response = $youtube->search->listSearch('id,snippet', ['q' => 'Thymio '.$search, 'maxResults' => "5", 'type' => 'video']);
            return $this->render('youtube/index.html.twig', [
                'form' => $form->createView(),
                'videos' => $response['items'],
            ]);
        }
        return $this->render('youtube/index.html.twig', [
            'form' => $form->createView(),
            'videos' => '',
        ]);
    }

}