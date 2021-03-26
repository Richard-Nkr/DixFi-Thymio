<?php

namespace App\Entity;

use App\Repository\HelpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HelpRepository::class)
 */
class Help
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contentHelp;


    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="helps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberHelp;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentHelp(): ?string
    {
        return $this->contentHelp;
    }

    public function setContentHelp(string $contentHelp): self
    {
        $this->contentHelp = $contentHelp;

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getNumberHelp(): ?int
    {
        return $this->numberHelp;
    }

    public function setNumberHelp(int $numberHelp): self
    {
        $this->numberHelp = $numberHelp;

        return $this;
    }
}
