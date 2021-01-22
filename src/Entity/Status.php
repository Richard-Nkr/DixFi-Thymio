<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idGroup;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChallenge;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusInt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $countHelp;

    /**
     * @ORM\Column(type="boolean")
     */
    private $needHelp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdGroup(): ?int
    {
        return $this->idGroup;
    }

    public function setIdGroup(int $idGroup): self
    {
        $this->idGroup = $idGroup;

        return $this;
    }

    public function getIdChallenge(): ?int
    {
        return $this->idChallenge;
    }

    public function setIdChallenge(int $idChallenge): self
    {
        $this->idChallenge = $idChallenge;

        return $this;
    }

    public function getStatusInt(): ?int
    {
        return $this->statusInt;
    }

    public function setStatusInt(int $statusInt): self
    {
        $this->statusInt = $statusInt;

        return $this;
    }

    public function getCountHelp(): ?int
    {
        return $this->countHelp;
    }

    public function setCountHelp(?int $countHelp): self
    {
        $this->countHelp = $countHelp;

        return $this;
    }

    public function getNeedHelpBoolean(): ?bool
    {
        return $this->needHelpBoolean;
    }

    public function setNeedHelpBoolean(bool $needHelpBoolean): self
    {
        $this->needHelpBoolean = $needHelpBoolean;

        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }
}
