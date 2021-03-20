<?php

namespace App\Service;


use Spatie\Browsershot\Browsershot;
use Twig\Environment;

class DocumentGenerator
{

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generatePdf(string $template, array $parameters): string
    {
        $html = $this->twig->render($template,$parameters);

        return Browsershot::html($html)
            ->format('A4')
            ->margins(10,10,10,10)
            ->pdf();
    }

}