<?php

namespace App\Entity;

use App\Repository\YoutubeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=YoutubeRepository::class)
 */
class Youtube
{
    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $request;

    public function getRequest()
    {
        return $this->request;
    }


}