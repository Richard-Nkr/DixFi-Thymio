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

    /**
     * @ORM\ManyToOne(targetEntity=StudentGroup::class, inversedBy="Status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupStatus;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGroupStatus(): ?StudentGroup
    {
        return $this->groupStatus;
    }

    public function setGroupStatus(?StudentGroup $groupStatus): self
    {
        $this->groupStatus = $groupStatus;

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
}
