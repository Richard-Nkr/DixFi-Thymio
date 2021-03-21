<?php

namespace App\Controller;

use App\Entity\Challenge;
use App\Entity\PublicChallenge;
use App\Form\ChallengeUpdateType;
use App\Form\PublicChallengeType;
use App\Repository\HelpRepository;
use App\Repository\PublicChallengeRepository;
use App\Service\DocumentGenerator;
use App\Service\PublicChallengeCreation;
use Knp\Snappy\Pdf;
use Spatie\Browsershot\Browsershot;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
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
            'publicChallenges' => $publicChallengeRepository->findAll(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="public_challenge_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Challenge $challenge
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, PublicChallenge $publicChallenge, int $id): Response
    {
        $form = $this->createForm(ChallengeUpdateType::class, $publicChallenge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicChallenge->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('public_challenge_show',[
                'id' => $id,
                'challenge' => $publicChallenge,
            ]);
        }

        return $this->render('public_challenge/edit.html.twig', [
            'challenge' => $publicChallenge,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addCorrection", name="public_challenge_addCorrection", methods={"GET","POST"})
     * @param Request $request
     * @param HelpRepository $helpRepository
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @param PublicChallenge $publicChallenge
     * @param PublicChallengeCreation $publicChallengeCreation
     * @param NotifierInterface $notifier
     * @return Response
     */
    public function addCorrection(Request $request, HelpRepository $helpRepository, PublicChallengeRepository $publicChallengeRepository, int $id, PublicChallenge $publicChallenge, PublicChallengeCreation $publicChallengeCreation, NotifierInterface $notifier): Response
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
                    'publicChallenge' => $publicChallengeCreation,
                    'form' => $form->createView(),
                ]);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicChallenge);
            $entityManager->flush();
            $publicChallenge->setSolutionPath('/images/corrections/'.$publicChallenge->getNameCorrection());
            $entityManager->flush();

            return $this->render('public_challenge/show.html.twig', [
                'publicChallenge' => $publicChallengeRepository->findOneById($id),
                'form' => $form->createView(),
                'indices' => $helpRepository->findByIdChallenge($id),
            ]);
        }

        return $this->render('public_challenge/add_correction.html.twig', [
            'publicChallenges' => $publicChallengeRepository->findOneById($id),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/create/pdf", name="public_challenge_create_pdf", methods={"GET","POST"})
     * @param Environment $twig
     * @param KernelInterface $kernel
     * @param Request $request
     * @param PublicChallenge $publicChallenge
     * @param DocumentGenerator $documentGenerator
     * @param Pdf $knp_snappy
     * @return Response
     * @throws \Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot
     */
    public function createPDF(Environment $twig, KernelInterface $kernel, Request $request,PublicChallenge $publicChallenge, DocumentGenerator $documentGenerator, Pdf $knp_snappy): Response
    {

        $vars= 'html to pdf';
        $html = $this->renderView('public_challenge/correction_pdf.html.twig', array(
            'some'  => $vars,
            'publicChallenge' =>$publicChallenge
        ));
        Browsershot::html($html)
            ->margins(10,10,10,10)
            ->showBackground()
            ->format('A4')
            ->save("../public/Uploads/correction_public_challenge.pdf");
        $projectRoot = $kernel->getProjectDir();
        return $this->file( $projectRoot."/public/Uploads/correction_public_challenge.pdf");
    }

    /**
     * @Route("/{id}/show", name="public_challenge_show", methods={"GET"})
     * @param PublicChallengeRepository $publicChallengeRepository
     * @param int $id
     * @param HelpRepository $helpRepository
     * @return Response
     */
    public function show(PublicChallengeRepository $publicChallengeRepository, int $id, HelpRepository $helpRepository): Response
    {
        return $this->render('public_challenge/show.html.twig', [
            'publicChallenge' => $publicChallengeRepository->findOneById($id),
            'indices' => $helpRepository->findByIdChallenge($id),
        ]);
    }
}
