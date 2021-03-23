<?php

namespace App\Service;


use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class DocumentGenerator
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generatePdf(string $html): void
    {
        $options = new Options();
        //permet d'afficher le pdf et les images correctement
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        // Mettre la taille du PDF
        $dompdf->setPaper('A4');
        // Créer le pdf à partir du html
        $dompdf->render();
        // envoie le pdf vers le Browser
        $dompdf->stream();;
    }

}