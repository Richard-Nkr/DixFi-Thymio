<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 * @ORM\HasLifecycleCallbacks()
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
    private $studentGroup;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="status")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $submitted_at;



    /**
     * @ORM\PrePersist
     */
    public function setStartedAtValue(): void
    {
        $this->startedAt = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setStatusIntValue(): void
    {
        $this->statusInt = 1;
    }

    /**
     * @ORM\PrePersist
     */
    public function setNeedHelpValue(): void
    {
        $this->needHelp = false;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCountHelpValue(): void
    {
        $this->countHelp = 0;
    }

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

    public function getNeedHelp(): ?bool
    {
        return $this->needHelp;
    }

    public function setNeedHelp(bool $needHelp): self
    {
        $this->needHelp = $needHelp;

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

    public function getStudentGroup(): ?StudentGroup
    {
        return $this->studentGroup;
    }

    public function setStudentGroup(?StudentGroup $studentGroup): self
    {
        $this->studentGroup = $studentGroup;

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

    public function getSubmittedAt(): ?\DateTimeInterface
    {
        return $this->submitted_at;
    }

    public function setSubmittedAt(?\DateTimeInterface $submitted_at): self
    {
        $this->submitted_at = $submitted_at;

        return $this;
    }
}
