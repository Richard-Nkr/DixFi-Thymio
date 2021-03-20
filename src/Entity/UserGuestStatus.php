<?php

namespace App\Entity;

use App\Repository\UserGuestStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserGuestStatusRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class UserGuestStatus
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
     * @ORM\Column(type="datetime")
     */
    private $startedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=UserGuest::class, inversedBy="UserGuestStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userGuest;

    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="userGuestStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $challenge;



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


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

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

    public function getUserGuest(): ?UserGuest
    {
        return $this->userGuest;
    }

    public function setUserGuest(?UserGuest $userGuest): self
    {
        $this->userGuest = $userGuest;

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
