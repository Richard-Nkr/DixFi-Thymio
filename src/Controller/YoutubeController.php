<?php

namespace App\Controller;

use App\Form\YoutubeType;
use App\Entity\Youtube;
use App\Service\YoutubeDeveloperKeyGenerator;
use Google_Client;
use Google_Service_YouTube;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/youtube")
 */
class YoutubeController extends AbstractController
{
    /**
     * @Route("/", name="youtube_index", methods={"GET", "POST"})
     * @param Request $request
     * @param Google_Client $client
     * @param YoutubeDeveloperKeyGenerator $youtubeDeveloperKeyGenerator
     * @param Youtube $yt
     * @return Response
     */
    public function show(Request $request, Google_Client $client, YoutubeDeveloperKeyGenerator $youtubeDeveloperKeyGenerator): Response
    {
        $key = $youtubeDeveloperKeyGenerator->DeveloperKeyGenerator();
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