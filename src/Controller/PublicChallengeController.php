<?php

namespace App\Controller;

use App\Entity\PublicChallenge;
use App\Entity\ThymioChallenge;
use App\Form\PublicChallengeType;
use App\Repository\PublicChallengeRepository;
use App\Service\DocumentGenerator;
use App\Service\PublicChallengeCreation;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Twig\Environment;

/**
 * @Route("/public/challenge")
 */
class PublicChallengeController extends AbstractController
{
    /**
     * @Route("/", name="public_challenge_index", methods={"GET"})
     * @param PublicChallengeRepository $publicChallengeRepository
     * @return Response
     */
    public function index(PublicChallengeRepository $publicChallengeRepository): Response
    {
        return $this->render('public_challenge/index.html.twig', [
            'public_challenges' => $publicChallengeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/addCorrection", name="public_challenge_addCorrection", methods={"GET","POST"})
     * @param Request $request
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @param PublicChallenge $publicChallenge
     * @param PublicChallengeCreation $publicChallengeCreation
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function addCorrection(Request $request, PublicChallengeRepository $publicChallengeRepository, int $id, PublicChallenge $publicChallenge, PublicChallengeCreation $publicChallengeCreation, NotifierInterface $notifier): Response
    {
        $publicChallenge = $publicChallengeRepository->findOneById($id);
        $form = $this->createForm(PublicChallengeType::class, $publicChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $publicChallenge->getFileCorrection();
            $verifExtension = $publicChallengeCreation->verifExtension($file->getClientOriginalExtension());

            if(!($verifExtension)){
                $notifier->send(new Notification("Le fichier doit etre un fichier jpg/jpeg/png", ['browser']));
                return $this->render('public_challenge/add_correction.html.twig', [
                    'public_challenge' => $publicChallengeCreation,
                    'form' => $form->createView(),
                ]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicChallenge);
            $entityManager->flush();
            $publicChallenge->setSolutionPath('/images/corrections/'.$publicChallenge->getNameCorrection());
            $entityManager->flush();

            return $this->render('public_challenge/show.html.twig', [
                'public_challenge' => $publicChallengeRepository->findOneById($id),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('public_challenge/add_correction.html.twig', [
            'public_challenges' => $publicChallengeRepository->findOneById($id),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/create/pdf", name="public_challenge_create_pdf", methods={"GET","POST"})
     * @param Environment $twig
     * @param Request $request
     * @param PublicChallenge $publicChallenge
     * @param DocumentGenerator $documentGenerator
     * @param Pdf $knp_snappy
     * @return Response
     */
    public function createPDF(Environment $twig, Request $request,PublicChallenge $publicChallenge, DocumentGenerator $documentGenerator, Pdf $knp_snappy): Response
    {

        $vars= 'html to pdf';
        $html = $this->renderView('public_challenge/correction_pdf.html.twig', array(
            'some'  => $vars,
            'public_challenge' =>$publicChallenge
        ));
        $response= new Response();

        $pdf= $response->setContent($knp_snappy->getOutputFromHtml($html,array('orientation' => 'Portrait', 'enable-local-file-access' => true, 'encoding' => 'UTF-8')));

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-disposition', 'filename="mon_fichier.pdf"');

        return $response;
    }

    /**
     * @Route("/{id}/show", name="public_challenge_show", methods={"GET"})
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @return Response
     */
    public function show(PublicChallengeRepository $publicChallengeRepository, int $id): Response
    {
        return $this->render('public_challenge/show.html.twig', [
            'public_challenge' => $publicChallengeRepository->findOneById($id),
        ]);
    }

}
