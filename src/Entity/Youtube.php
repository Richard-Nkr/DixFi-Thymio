<?php

namespace App\Entity;

use App\Repository\ThymioChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YoutubeRepository::class)
 */
class Youtube
{

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $request;

    public function getRequest()
    {
        return $this->request;
    }


}