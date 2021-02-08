<?php

namespace App\Entity;

use App\Repository\PublicChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicChallengeRepository::class)
 */
class PublicChallenge extends Challenge
{

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nameCorrectionPDF;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="publicChallenges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deletedAt;

    public function getNameCorrectionPDF(): ?string
    {
        return $this->nameCorrectionPDF;
    }

    public function setNameCorrectionPDF(string $nameCorrectionPDF): self
    {
        $this->nameCorrectionPDF = $nameCorrectionPDF;

        return $this;
    }



    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
