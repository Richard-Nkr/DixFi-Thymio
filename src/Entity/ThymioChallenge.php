<?php

namespace App\Entity;

use App\Repository\ThymioChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThymioChallengeRepository::class)
 */
class ThymioChallenge extends Challenge
{

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pathVideo;

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPathVideo(): ?string
    {
        return $this->pathVideo;
    }

    public function setPathVideo(string $pathVideo): self
    {
        $this->pathVideo = $pathVideo;

        return $this;
    }



}
